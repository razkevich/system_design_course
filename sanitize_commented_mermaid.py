import re
from pathlib import Path

ROOT = Path(__file__).parent
DOCS_DIRS = [
    ROOT / 'sysdesign-website' / 'docs-en',
    ROOT / 'sysdesign-website' / 'docs',
]

def sanitize_file(path: Path) -> bool:
    text = path.read_text(encoding='utf-8')
    lines = text.splitlines()
    out = []
    i = 0
    changed = False
    while i < len(lines):
        line = lines[i]
        out.append(line)
        i += 1
        # Detect our comment block header
        if line.strip() == 'Original Mermaid code:' and i < len(lines) and lines[i].strip() == '``` mermaid':
            out.append(lines[i])
            i += 1
            # sanitize until closing fence
            while i < len(lines) and lines[i].strip() != '```':
                sanitized = lines[i].replace('<', '&lt;')
                # Normalize <br> variants to &lt;br/>
                sanitized = sanitized.replace('&lt;br>', '&lt;br/>')
                out.append(sanitized)
                if sanitized != lines[i]:
                    changed = True
                i += 1
            if i < len(lines):
                out.append(lines[i])
                i += 1
            # expect closing '-->' after fence, leave as is
    if changed:
        path.write_text('\n'.join(out) + '\n', encoding='utf-8')
    return changed

def main():
    total = 0
    for docs in DOCS_DIRS:
        for md in docs.rglob('*.md'):
            if sanitize_file(md):
                total += 1
    print(f'Sanitized {total} files')

if __name__ == '__main__':
    main()
