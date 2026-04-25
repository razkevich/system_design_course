import { useEffect, useState } from 'react';
import type { TocEntry } from '../lib/tocFromHtml';

interface Props {
  entries: TocEntry[];
}

export default function OnPageTOC({ entries }: Props) {
  const [activeId, setActiveId] = useState<string | null>(entries[0]?.id ?? null);

  useEffect(() => {
    if (entries.length === 0) return;
    const observer = new IntersectionObserver(
      (records) => {
        const visible = records
          .filter((r) => r.isIntersecting)
          .sort((a, b) => a.target.getBoundingClientRect().top - b.target.getBoundingClientRect().top);
        if (visible[0]) setActiveId(visible[0].target.id);
      },
      { rootMargin: '-80px 0px -70% 0px', threshold: 0.1 }
    );
    entries.forEach(({ id }) => {
      const el = document.getElementById(id);
      if (el) observer.observe(el);
    });
    return () => observer.disconnect();
  }, [entries]);

  if (entries.length === 0) return null;

  return (
    <nav aria-label="On this page" className="text-sm">
      <div className="text-xs font-semibold uppercase tracking-wider text-[color:var(--color-text-faint)] mb-3">
        On this page
      </div>
      <ul className="space-y-1.5 border-l border-[color:var(--color-border)]">
        {entries.map((e) => (
          <li key={e.id}>
            <a
              href={`#${e.id}`}
              className={[
                'block pl-3 py-0.5 -ml-px border-l transition-colors',
                e.depth === 3 ? 'pl-6 text-[0.85rem]' : '',
                activeId === e.id
                  ? 'text-[color:var(--color-accent)] border-[color:var(--color-accent)] font-medium'
                  : 'text-[color:var(--color-text-muted)] border-transparent hover:text-[color:var(--color-text)]',
              ].join(' ')}
            >
              {e.text}
            </a>
          </li>
        ))}
      </ul>
    </nav>
  );
}
