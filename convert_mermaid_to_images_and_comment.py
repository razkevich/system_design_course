import os
import re
from pathlib import Path

ROOT = Path(__file__).parent
DOCS_DIRS = [
    ROOT / 'sysdesign-website' / 'docs-en',
    ROOT / 'sysdesign-website' / 'docs',
]
DIAGRAMS_DIR = ROOT / 'sysdesign-website' / 'static' / 'img' / 'diagrams'

MERMAID_START_RE = re.compile(r"^```\s*mermaid\s*$")
FENCE_RE = re.compile(r"^```\s*$")

def list_available_images(base: str):
    # Return sorted list of available RU diagram images for a given base
    candidates = []
    if DIAGRAMS_DIR.exists():
        for p in DIAGRAMS_DIR.glob(f"{base}_ru_diagram_*.svg"):
            # extract trailing number for numeric sort
            m = re.search(r"_(\d+)\.svg$", p.name)
            n = int(m.group(1)) if m else 0
            candidates.append((n, p.name))
    candidates.sort(key=lambda x: x[0])
    return [name for _, name in candidates]

def process_file(path: Path):
    text = path.read_text(encoding='utf-8')
    lines = text.splitlines()
    base = path.stem  # file base name without extension
    images = list_available_images(base)
    img_index = 0

    out_lines = []
    i = 0
    in_html_comment = False
    changed = False

    while i < len(lines):
        line = lines[i]
        # track comment state
        if '<!--' in line and '-->' not in line:
            in_html_comment = True
        if '-->' in line and '<!--' not in line:
            in_html_comment = False

        if not in_html_comment and MERMAID_START_RE.match(line):
            # find block end
            j = i + 1
            while j < len(lines) and not FENCE_RE.match(lines[j]):
                j += 1
            if j >= len(lines):
                # malformed block, just emit as is
                out_lines.append(line)
                i += 1
                continue

            # Insert image if available
            if img_index < len(images):
                image_name = images[img_index]
                img_index += 1
                out_lines.append(f"![Diagram](/img/diagrams/{image_name})")
            else:
                # No image available; leave a TODO and still comment out the mermaid
                out_lines.append("<!-- TODO: diagram image missing for this Mermaid block -->")

            # Wrap mermaid block in HTML comment and tag
            out_lines.append("<!--")
            out_lines.append("Original Mermaid code:")
            out_lines.append("``` mermaid")
            # copy block contents
            for k in range(i + 1, j):
                out_lines.append(lines[k])
            out_lines.append("```")
            out_lines.append("-->")
            changed = True
            # move index past fence end
            i = j + 1
            continue

        # default passthrough
        out_lines.append(line)
        i += 1

    if changed:
        path.write_text("\n".join(out_lines) + "\n", encoding='utf-8')
        return True
    return False

def main():
    total = 0
    changed_files = []
    for docs_dir in DOCS_DIRS:
        for md in docs_dir.rglob('*.md'):
            if process_file(md):
                changed_files.append(str(md.relative_to(ROOT)))
                total += 1
    print(f"Updated {total} files")
    for f in changed_files:
        print(f" - {f}")

if __name__ == '__main__':
    main()
