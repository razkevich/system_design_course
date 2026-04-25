export interface TocEntry {
  id: string;
  text: string;
  depth: 2 | 3;
}

export function tocFromHtml(html: string): TocEntry[] {
  const re = /<h([23])\s+([^>]*?)id\s*=\s*"([^"]+)"([^>]*)>([\s\S]*?)<\/h\1>/g;
  const out: TocEntry[] = [];
  let m: RegExpExecArray | null;
  while ((m = re.exec(html)) !== null) {
    const depth = Number(m[1]) as 2 | 3;
    const id = m[3];
    const inner = m[5].replace(/<[^>]+>/g, '').replace(/\s+/g, ' ').trim();
    out.push({ id, text: inner, depth });
  }
  return out;
}
