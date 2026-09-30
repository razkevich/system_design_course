/** Prefix a root-relative path with Astro's configured base. */
export function withBase(path: string, base: string = import.meta.env.BASE_URL || '/'): string {
  if (!path.startsWith('/')) return path;
  const normalized = base.endsWith('/') ? base : `${base}/`;
  return `${normalized}${path.slice(1)}`;
}
