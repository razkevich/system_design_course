import re
from pathlib import Path

ROOT = Path(__file__).parent
DOC_DIRS = [ROOT / 'sysdesign-website' / 'docs', ROOT / 'sysdesign-website' / 'docs-en']
STATIC_IMG = ROOT / 'sysdesign-website' / 'static' / 'img'
DIAGRAMS = STATIC_IMG / 'diagrams'

# Build lookup of available image basenames -> absolute path
def collect_images():
    mapping = {}
    for base in [STATIC_IMG, DIAGRAMS]:
        if not base.exists():
            continue
        for p in base.rglob('*'):
            if p.suffix.lower() in {'.png', '.jpg', '.jpeg', '.svg', '.gif'}:
                mapping[p.name] = p
    return mapping

WIKI_IMG_RE = re.compile(r"!\[\[(?P<name>[^\]]+)\]\]")
REL_IMG_RE = re.compile(r"!\[[^\]]*\]\((?P<path>(?!https?://|/img/)[^)]+\.(?:png|jpg|jpeg|svg|gif))\)")

def replace_wiki_links(text: str, images: dict) -> tuple[str, bool]:
    changed = False
    def repl(m):
        nonlocal changed
        name = m.group('name').strip()
        fname = Path(name).name
        if fname in images:
            rel = images[fname].relative_to(STATIC_IMG)
            new = f"![{Path(fname).stem}](/img/{rel.as_posix()})"
        else:
            # leave a TODO if not found
            new = f"<!-- TODO missing image {fname} -->"
        changed = True
        return new
    new_text = WIKI_IMG_RE.sub(repl, text)
    return new_text, changed

def replace_rel_links(text: str, images: dict) -> tuple[str, bool]:
    changed = False
    def repl(m):
        nonlocal changed
        p = m.group('path')
        fname = Path(p).name
        if fname in images:
            rel = images[fname].relative_to(STATIC_IMG)
            alt_match = re.search(r"!\[([^\]]*)\]\(", m.group(0))
            alt = alt_match.group(1) if alt_match else Path(fname).stem
            changed = True
            return f"![{alt}](/img/{rel.as_posix()})"
        return m.group(0)
    new_text = REL_IMG_RE.sub(repl, text)
    return new_text, changed

def process_file(path: Path, images: dict) -> bool:
    text = path.read_text(encoding='utf-8')
    orig = text
    text, c1 = replace_wiki_links(text, images)
    text, c2 = replace_rel_links(text, images)
    if c1 or c2:
        path.write_text(text, encoding='utf-8')
        return True
    return False

def main():
    images = collect_images()
    total = 0
    for d in DOC_DIRS:
        for p in d.rglob('*.md'):
            if process_file(p, images):
                total += 1
    print(f"Updated {total} files")

if __name__ == '__main__':
    main()

