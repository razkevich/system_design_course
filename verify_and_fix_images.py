import re
from pathlib import Path

ROOT = Path(__file__).parent
DOC_DIRS = [ROOT / 'sysdesign-website' / 'docs', ROOT / 'sysdesign-website' / 'docs-en']
STATIC = ROOT / 'sysdesign-website' / 'static' / 'img'

IMG_MD_RE = re.compile(r"!\[[^\]]*\]\((?P<url>[^)]+)\)")

def load_inventory():
    files = {}
    for p in STATIC.rglob('*'):
        if p.is_file():
            files[p.name] = p
    return files

def fix_url(url: str, inventory: dict) -> tuple[str, bool]:
    # Only handle local images
    if url.startswith('http://') or url.startswith('https://'):
        return url, False
    if url.startswith('/img/'):
        rel = url[len('/img/'):]
        if (STATIC / rel).exists():
            return url, False
        # try by filename
        fname = Path(rel).name
        if fname in inventory:
            new_rel = inventory[fname].relative_to(STATIC).as_posix()
            return f"/img/{new_rel}", True
        return url, False
    # Relative path: try to rewrite to /img by filename
    fname = Path(url).name
    if fname in inventory:
        new_rel = inventory[fname].relative_to(STATIC).as_posix()
        return f"/img/{new_rel}", True
    return url, False

def process_file(path: Path, inventory: dict) -> tuple[int, int]:
    text = path.read_text(encoding='utf-8')
    changed = False
    fixes = 0
    missing = 0
    def repl(m):
        nonlocal changed, fixes, missing
        url = m.group('url')
        new_url, did = fix_url(url, inventory)
        if did:
            fixes += 1
            changed = True
            return m.group(0).replace(url, new_url)
        # check if broken /img path
        if new_url.startswith('/img/') and not (STATIC / new_url[len('/img/'):]).exists():
            missing += 1
        return m.group(0)
    new_text = IMG_MD_RE.sub(repl, text)
    if changed:
        path.write_text(new_text, encoding='utf-8')
    return fixes, missing

def main():
    inventory = load_inventory()
    total_fixed = 0
    total_missing = 0
    for d in DOC_DIRS:
        for ext in ('*.md', '*.mdx'):
            for p in d.rglob(ext):
                fixed, missing = process_file(p, inventory)
                total_fixed += fixed
                total_missing += missing
    print(f"Fixed {total_fixed} image links; remaining missing: {total_missing}")

if __name__ == '__main__':
    main()

