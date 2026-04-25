import { useEffect, useMemo, useRef, useState } from 'react';
import Fuse from 'fuse.js';
import type { SearchRecord } from '../lib/searchIndex';

export default function SearchWidget() {
  const [open, setOpen] = useState(false);
  const [q, setQ] = useState('');
  const [records, setRecords] = useState<SearchRecord[]>([]);
  const inputRef = useRef<HTMLInputElement>(null);

  useEffect(() => {
    if (!open || records.length > 0) return;
    fetch('/search-index.json').then((r) => r.json()).then(setRecords).catch(() => {});
  }, [open, records.length]);

  useEffect(() => {
    function onKey(e: KeyboardEvent) {
      if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
        e.preventDefault();
        setOpen(true);
        setTimeout(() => inputRef.current?.focus(), 50);
      }
      if (e.key === 'Escape') setOpen(false);
    }
    window.addEventListener('keydown', onKey);
    return () => window.removeEventListener('keydown', onKey);
  }, []);

  const fuse = useMemo(
    () => new Fuse(records, { keys: ['title', 'summary'], threshold: 0.4, includeScore: true }),
    [records]
  );

  const results = q.trim() ? fuse.search(q).slice(0, 8).map((r) => r.item) : [];

  return (
    <>
      <button
        onClick={() => { setOpen(true); setTimeout(() => inputRef.current?.focus(), 50); }}
        className="text-sm text-[color:var(--color-text-muted)] hover:text-[color:var(--color-text)] flex items-center gap-2 px-3 py-1.5 rounded border border-[color:var(--color-border)] hover:border-[color:var(--color-accent)] transition-colors"
        aria-label="Open search"
      >
        Search
        <kbd className="text-[0.7rem] text-[color:var(--color-text-faint)]">⌘K</kbd>
      </button>
      {open && (
        <div
          className="fixed inset-0 z-50 bg-black/40 flex items-start justify-center pt-[10vh] px-4"
          onClick={() => setOpen(false)}
        >
          <div
            className="w-full max-w-xl rounded-xl bg-[color:var(--color-bg)] border border-[color:var(--color-border)] shadow-2xl overflow-hidden"
            onClick={(e) => e.stopPropagation()}
          >
            <input
              ref={inputRef}
              type="text"
              placeholder="Search lessons…"
              value={q}
              onChange={(e) => setQ(e.target.value)}
              className="w-full px-4 py-3 bg-transparent outline-none text-[color:var(--color-text)] border-b border-[color:var(--color-border)]"
            />
            <ul className="max-h-[60vh] overflow-y-auto">
              {results.map((r) => (
                <li key={r.href}>
                  <a
                    href={r.href}
                    className="block px-4 py-3 hover:bg-[color:var(--color-bg-muted)]"
                  >
                    <div className="text-sm font-semibold text-[color:var(--color-text)]">{r.title}</div>
                    <div className="text-xs text-[color:var(--color-text-muted)] line-clamp-2">{r.summary}</div>
                  </a>
                </li>
              ))}
              {q && results.length === 0 && (
                <li className="px-4 py-3 text-sm text-[color:var(--color-text-muted)]">No matches.</li>
              )}
            </ul>
          </div>
        </div>
      )}
    </>
  );
}
