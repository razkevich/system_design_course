# Agent Guide: System Design Course Website (Docusaurus)

This repository contains a Docusaurus website for the System Design course. It serves Russian content as the default locale and an English section as a separate docs instance. This guide explains structure, conventions, scripts, and the full workflow: edit → build → deploy.

## Structure
- `sysdesign-website/` — Docusaurus project
  - `docs/` — RU docs (`*_ru.md`), plus quizzes (`.mdx`)
  - `docs-en/` — EN docs (plain `.md` without `_ru` suffix)
  - `static/img/` — all images (png/jpg/svg), shared by RU and EN
  - `static/img/diagrams/` — generated SVG diagram exports
  - `sidebars.ts` — RU sidebar
  - `sidebars-en.ts` — EN sidebar
  - `docusaurus.config.ts` — site config (RU default, EN mounted at `/en`)
- `scripts/` — operational scripts
- Root numbered folders (`1_architecture_basics`, …) — original source drop points; a sync script moves their EN files into Docusaurus

## Conventions
- RU docs use `*_ru.md` filenames and live under `sysdesign-website/docs/**`
- EN docs use `.md` filenames without `_ru` and live under `sysdesign-website/docs-en/**`
- All images referenced as absolute site paths: `/img/<file>` or `/img/diagrams/<file>.svg`
- Do not reference images relatively from documents; Docusaurus resolves `/img/...` from `sysdesign-website/static/img`
- Prefer images (SVG) for diagrams; keep original Mermaid code commented in the doc (see “Diagrams”)
- Avoid markdown formatting in H1 titles (no `**bold**`/`_italics_`/links) to keep sidebar labels clean
- Watch for MDX-sensitive tokens:
  - Use `&lt;` instead of raw `<` in prose, e.g. `&lt;5%`
  - Escape curly sets shown as literals: `\{A, B, C\}`

## Diagrams (Mermaid → SVG)
- Diagrams are embedded as images in docs and the original Mermaid code is preserved in an HTML comment for reference
- Image pattern for RU assets: `/img/diagrams/<basename>_ru_diagram_<n>.svg`
- Workflow:
  1) Insert image(s) at the right places
  2) Comment out original Mermaid block:
     - Add header `Original Mermaid code:`
     - Put the code fence as ``` mermaid and close with ```
     - Sanitize inside the comment (`<` → `&lt;`, `<br>` → `&lt;br/>`, etc.) to avoid MDX parsing

Helper scripts handle this (see Scripts).

## English docs instance
- Configured as a second docs plugin mounted at `/en`
- RU/EN navbar links:
  - RU → `/docs/intro`
  - EN → `/en/intro`
- Keep the EN sidebar in `sysdesign-website/sidebars-en.ts` aligned with RU

## Scripts
All scripts are at repo root (run with `python3` or `bash`). Package.json at root provides shortcuts.

- `scripts/deploy.sh`
  - Builds, archives, uploads, deploys, and verifies
  - Flags: `-r/--remote`, `-d/--remote-dir`, `-k/--ssh-key`, `--no-build`, `--no-verify`
  - Defaults: remote `ec2-user@www.sysdesign.online`, path `/var/www/sysdesign`

- `scripts/sync_en_and_assets_from_root.py`
  - Moves EN `.md`/`.mdx` (not `*_ru.md`) from the root numbered folders into `sysdesign-website/docs-en/<same-folder>/`
  - Moves all images (`.png/.jpg/.jpeg/.gif/.svg`) from those folders into `sysdesign-website/static/img/`
  - Overwrites if necessary and removes the originals

- `convert_mermaid_to_images_and_comment.py`
  - For EN docs, finds Mermaid fences, inserts existing images from `static/img/diagrams`, and preserves Mermaid as a commented block
  - Uses `<basename>_ru_diagram_<n>.svg` ordering when multiple blocks exist

- `sanitize_commented_mermaid.py`
  - Sanitizes HTML-like characters within commented Mermaid code blocks in EN and RU docs to avoid MDX parsing issues

- `fix_image_links.py`
  - Rewrites Obsidian-style `![[...]]` and relative `![...](file.png)` to absolute `/img/...` when an asset exists

- `verify_and_fix_images.py`
  - Validates `![](/img/...)` targets exist and auto-corrects by filename when possible

## Root package.json scripts
- `npm run start` — dev server (RU default; EN at `/en`)
- `npm run serve` — serve local production build
- `npm run build` — build production site
- `npm run deploy` — run `scripts/deploy.sh`
- `npm run sync-en` — move EN markdown/assets from root numbered folders into Docusaurus
- `npm run fix-images` — normalize and validate image links
- `npm run convert-mermaid` — convert Mermaid to images in EN docs, preserve code commented
- `npm run sanitize-mermaid` — sanitize commented Mermaid in EN+RU docs
- `npm run publish` — build then deploy

## Local development
- RU: `npm run start` → open `http://localhost:3000/docs/intro`
- EN: open `http://localhost:3000/en/intro`
- If port is busy: `npm --prefix sysdesign-website start -- --port 3334`

## Build & Test
- Production build: `npm run build`
- Local serve: `npm run serve` → `http://localhost:3000`

## Deployment
- One command: `npm run publish`
- Or manually: `bash scripts/deploy.sh [-k ~/.ssh/key.pem]`
- Remote server:
  - Uploads to `/tmp/build.tar.gz`
  - Replaces `/var/www/sysdesign` and sets `nginx:nginx`

## Content workflow
1) Add/modify RU docs in `sysdesign-website/docs/**` using `*_ru.md`
2) Add/modify EN docs in `sysdesign-website/docs-en/**` using `.md`
3) Put images in `sysdesign-website/static/img/` (or `static/img/diagrams/` for diagram exports)
4) Update `sidebars.ts` / `sidebars-en.ts` for nav
5) Run: `npm run build` → `npm run publish`

## Syncing from source folders
If EN `.md` files and media land in root numbered folders, run:
- `npm run sync-en` — moves EN `.md` to `docs-en`, moves images to `static/img`, overwrites, and removes originals
- Then run `npm run fix-images` to normalize links

## Troubleshooting
- MDX errors about `<br>` or unexpected characters: ensure problematic tokens are only inside commented Mermaid blocks and sanitized (`&lt;`, `&lt;br/>`, `\{A, B\}`)
- Missing images: verify file exists under `static/img` (or `static/img/diagrams`) and path starts with `/img/...`
- SPA routing: nginx must use `try_files $uri $uri/ $uri/index.html /index.html;`
- If dev port 3000 is busy: start with `--port` option

## Server notes
- nginx serves `/var/www/sysdesign`
- Caching headers set for static assets
- Restart nginx if config changes; otherwise static replacement is sufficient

This guide should give agents everything needed to edit content, keep diagrams and images reliable, and deploy updates quickly.

