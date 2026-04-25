import type { CollectionEntry } from 'astro:content';

export interface SearchRecord {
  title: string;
  slug: string;
  section: string;
  summary: string;
  href: string;
}

export function buildSearchIndex(lessons: CollectionEntry<'lessons'>[]): SearchRecord[] {
  return lessons.map((l) => ({
    title: l.data.title,
    slug: l.data.slug,
    section: l.data.section,
    summary: l.data.summary,
    href: `/lesson/${l.data.section}/${l.data.slug}`,
  }));
}
