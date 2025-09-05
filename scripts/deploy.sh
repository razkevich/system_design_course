#!/usr/bin/env bash
set -euo pipefail

# Build and publish the Docusaurus site to the server.
#
# Defaults are tailored for sysdesign.online. You can override via flags or env vars.
#
# Usage:
#   scripts/deploy.sh [-r user@host] [-d /remote/dir] [-k ssh_key] [--no-build] [--no-verify]
#
# Examples:
#   scripts/deploy.sh
#   scripts/deploy.sh -r ec2-user@www.sysdesign.online -d /var/www/sysdesign
#   scripts/deploy.sh -k ~/.ssh/mykey.pem --no-verify

REMOTE_DEFAULT="${REMOTE:-ec2-user@www.sysdesign.online}"
REMOTE_DIR_DEFAULT="${REMOTE_DIR:-/var/www/sysdesign}"
SSH_KEY="${SSH_KEY:-}"
DO_BUILD=1
DO_VERIFY=1
REMOTE="$REMOTE_DEFAULT"
REMOTE_DIR="$REMOTE_DIR_DEFAULT"

while [[ $# -gt 0 ]]; do
  case "$1" in
    -r|--remote)
      REMOTE="$2"; shift 2;;
    -d|--remote-dir)
      REMOTE_DIR="$2"; shift 2;;
    -k|--ssh-key)
      SSH_KEY="$2"; shift 2;;
    --no-build)
      DO_BUILD=0; shift 1;;
    --no-verify)
      DO_VERIFY=0; shift 1;;
    -h|--help)
      echo "Usage: $0 [-r user@host] [-d /remote/dir] [-k ssh_key] [--no-build] [--no-verify]"; exit 0;;
    *)
      echo "Unknown option: $1"; exit 1;;
  esac
done

SSH_OPTS=()
if [[ -n "$SSH_KEY" ]]; then
  SSH_OPTS+=("-i" "$SSH_KEY")
fi

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
REPO_ROOT="$(cd "$SCRIPT_DIR/.." && pwd)"
SITE_DIR="$REPO_ROOT/sysdesign-website"

if [[ "$DO_BUILD" -eq 1 ]]; then
  echo "[1/4] Building site..."
  (cd "$SITE_DIR" && npm run build)
else
  echo "[1/4] Skipping build (--no-build)"
fi

echo "[2/4] Creating archive..."
(cd "$SITE_DIR" && tar -czf build.tar.gz build/)

echo "[3/4] Uploading to $REMOTE:/tmp/build.tar.gz ..."
scp ${SSH_OPTS[@]+"${SSH_OPTS[@]}"} "$SITE_DIR/build.tar.gz" "$REMOTE:/tmp/" >/dev/null

echo "[4/4] Deploying on remote host ($REMOTE_DIR)..."
ssh ${SSH_OPTS[@]+"${SSH_OPTS[@]}"} "$REMOTE" "bash -lc 'set -e; cd /tmp; sudo tar -xzf build.tar.gz; sudo rm -rf \"$REMOTE_DIR\"/*; sudo mv build/* \"$REMOTE_DIR\"/; sudo chown -R nginx:nginx \"$REMOTE_DIR\"'"

if [[ "$DO_VERIFY" -eq 1 ]]; then
  echo "Verifying deployment..."
  # Basic checks; adjust or extend as needed
  curl -fsI "http://www.sysdesign.online/" | head -n 1 || true
  curl -fsI "http://www.sysdesign.online/en/intro/" | head -n 1 || true
  curl -fsI "http://www.sysdesign.online/docs/architecture_basics/what_is_architecture_system_design_ru/" | head -n 1 || true
  echo "Done."
else
  echo "Verification skipped (--no-verify)."
fi
