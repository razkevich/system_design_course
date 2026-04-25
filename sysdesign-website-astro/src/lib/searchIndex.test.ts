import { describe, expect, it } from 'vitest';
import { buildSearchIndex } from './searchIndex';

describe('buildSearchIndex', () => {
  it('emits one record per lesson with title, summary, slug, section, href', () => {
    const lessons = [
      {
        data: {
          title: 'Decomposition and Boundaries',
          slug: 'decomposition-boundaries',
          order: 3,
          section: 'architecture-basics',
          summary: 'Coupling, cohesion, bounded contexts.',
          readingMinutes: 12,
          lastUpdated: '2026-04-25',
          group: 'Core Principles',
        },
      },
    ];
    expect(buildSearchIndex(lessons as never)).toEqual([
      {
        title: 'Decomposition and Boundaries',
        slug: 'decomposition-boundaries',
        section: 'architecture-basics',
        summary: 'Coupling, cohesion, bounded contexts.',
        href: '/lesson/architecture-basics/decomposition-boundaries',
      },
    ]);
  });

  it('returns [] for empty input', () => {
    expect(buildSearchIndex([])).toEqual([]);
  });
});
