import { useState } from 'react';

export interface SidebarLesson {
  slug: string;
  title: string;
  order: number;
  group?: string;
  href: string;
}

interface Props {
  sectionTitle: string;
  sectionHref: string;
  lessons: SidebarLesson[];
  currentSlug: string;
}

export default function CourseSidebar({ sectionTitle, sectionHref, lessons, currentSlug }: Props) {
  const [open, setOpen] = useState(false);

  const groups = lessons.reduce<Record<string, SidebarLesson[]>>((acc, l) => {
    const k = l.group ?? '';
    (acc[k] ??= []).push(l);
    return acc;
  }, {});

  return (
    <>
      <button
        className="lg:hidden fixed bottom-4 right-4 z-30 rounded-full bg-[color:var(--color-accent)] text-white px-4 py-2 shadow-lg"
        onClick={() => setOpen((v) => !v)}
        aria-label="Toggle course sidebar"
      >
        {open ? 'Close' : 'Lessons'}
      </button>

      <aside
        className={[
          'lg:block lg:relative lg:bg-transparent',
          open
            ? 'fixed inset-0 z-20 bg-[color:var(--color-bg)]/95 backdrop-blur p-6 overflow-y-auto'
            : 'hidden',
        ].join(' ')}
      >
        <a href={sectionHref} className="block text-xs uppercase tracking-widest text-[color:var(--color-accent)] mb-2">
          ← Section
        </a>
        <h2 className="text-base font-semibold text-[color:var(--color-text)] mb-4">{sectionTitle}</h2>
        <nav>
          {Object.entries(groups).map(([group, items]) => (
            <div key={group} className="mb-4">
              {group && (
                <div className="text-xs font-semibold uppercase tracking-wider text-[color:var(--color-text-faint)] mb-2">
                  {group}
                </div>
              )}
              <ul className="space-y-1">
                {items.map((l) => {
                  const active = l.slug === currentSlug;
                  return (
                    <li key={l.slug}>
                      <a
                        href={l.href}
                        onClick={() => setOpen(false)}
                        className={[
                          'block rounded px-2 py-1.5 text-sm transition-colors',
                          active
                            ? 'bg-[color:var(--color-accent-soft)] text-[color:var(--color-accent)] font-medium'
                            : 'text-[color:var(--color-text-muted)] hover:bg-[color:var(--color-bg-muted)] hover:text-[color:var(--color-text)]',
                        ].join(' ')}
                      >
                        <span className="text-[color:var(--color-text-faint)] mr-2">{l.order}.</span>
                        {l.title}
                      </a>
                    </li>
                  );
                })}
              </ul>
            </div>
          ))}
        </nav>
      </aside>
    </>
  );
}
