# Section 1 End-to-End Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a polished, free, English-language Astro static site for the System Design course (Section 1 only, end-to-end) and deploy it to DigitalOcean App Platform.

**Architecture:** Astro 6 with React 19 islands, Tailwind v4, content collections (zod-validated MDX). Three page types: landing, section hub, lesson reader. Hybrid visual direction — bytebytego-ish on indexes, hellointerview-calm on lesson pages. New site at `sysdesign-website-astro/`; existing Docusaurus at `sysdesign-website/` untouched.

**Tech Stack:** Astro 6, React 19, Tailwind v4, MDX, Astro Content Collections, Fuse.js (search), pdftotext (poppler), gog CLI (Drive download), doctl (deploy).

**Spec:** `docs/superpowers/specs/2026-04-25-sysdesign-course-astro-design.md`

---

## File Structure

```
sysdesign-website-astro/
├── astro.config.mjs                    # Astro + React + Tailwind v4 + MDX
├── package.json
├── tsconfig.json
├── .gitignore                          # ignores pdfs/, node_modules, dist
├── .do/
│   └── app.yaml                        # DO App Platform spec
├── public/
│   ├── favicon.svg
│   └── images/section-1/               # reused PNGs from Docusaurus tree
├── pdfs/                               # gitignored scratch dir
├── src/
│   ├── content/
│   │   ├── config.ts                   # zod schemas for sections + lessons
│   │   ├── sections/                   # 1 file per section
│   │   │   └── architecture-basics.md
│   │   └── lessons/
│   │       └── architecture-basics/    # 8 lesson MDX files
│   ├── components/
│   │   ├── Navbar.astro
│   │   ├── Footer.astro
│   │   ├── Hero.astro
│   │   ├── CredibilityBar.astro
│   │   ├── ModuleCardsGrid.astro
│   │   ├── LessonCard.astro
│   │   ├── Callout.astro
│   │   ├── LessonHeader.astro
│   │   ├── PrevNextNav.astro
│   │   ├── ThemeToggle.tsx
│   │   ├── CourseSidebar.tsx
│   │   ├── OnPageTOC.tsx
│   │   └── SearchWidget.tsx
│   ├── layouts/
│   │   ├── BaseLayout.astro
│   │   └── LessonLayout.astro
│   ├── lib/
│   │   ├── readingTime.ts              # word-count → minutes
│   │   ├── readingTime.test.ts
│   │   ├── tocFromHtml.ts              # extract <h2>/<h3> → TOC entries
│   │   ├── tocFromHtml.test.ts
│   │   ├── searchIndex.ts              # build Fuse.js index from collections
│   │   └── searchIndex.test.ts
│   ├── pages/
│   │   ├── index.astro
│   │   ├── course.astro
│   │   ├── section/[slug].astro
│   │   └── lesson/[section]/[lesson].astro
│   └── styles/global.css               # Tailwind v4 + design tokens
└── README.md
```

**File responsibilities:**
- `src/content/config.ts` — single source of truth for content shape; zod schemas validate all MDX frontmatter.
- `src/lib/*` — pure functions, unit-tested with Vitest.
- `src/components/*.astro` — server-rendered, layout/markup only.
- `src/components/*.tsx` — React islands for interactivity (theme toggle, sidebar collapse, scroll-spy TOC, search).
- `src/layouts/*` — page chrome; lesson pages get the 3-column treatment.
- `src/pages/*` — routes; thin wrappers that fetch from collections and pass to layouts.

---

## Phase 1 — Scaffolding (Tasks 1–4)

### Task 1: Initialize Astro project with React + Tailwind v4 + MDX

**Files:**
- Create: `sysdesign-website-astro/package.json`
- Create: `sysdesign-website-astro/astro.config.mjs`
- Create: `sysdesign-website-astro/tsconfig.json`
- Create: `sysdesign-website-astro/.gitignore`

- [ ] **Step 1: Create the project directory and package.json**

```bash
mkdir -p sysdesign-website-astro
cd sysdesign-website-astro
```

Write `sysdesign-website-astro/package.json`:

```json
{
  "name": "sysdesign-website-astro",
  "type": "module",
  "version": "0.1.0",
  "private": true,
  "scripts": {
    "dev": "astro dev",
    "build": "astro build",
    "preview": "astro preview",
    "check": "astro check",
    "test": "vitest run"
  },
  "dependencies": {
    "@astrojs/check": "^0.9.8",
    "@astrojs/mdx": "^4.0.0",
    "@astrojs/react": "^5.0.3",
    "@tailwindcss/vite": "^4.2.2",
    "astro": "^6.1.5",
    "fuse.js": "^7.3.0",
    "react": "^19.2.5",
    "react-dom": "^19.2.5",
    "tailwindcss": "^4.2.2"
  },
  "devDependencies": {
    "@types/react": "^19.2.14",
    "@types/react-dom": "^19.2.3",
    "typescript": "^5.9.3",
    "vitest": "^2.1.0",
    "happy-dom": "^15.0.0"
  }
}
```

- [ ] **Step 2: Install dependencies**

```bash
cd sysdesign-website-astro && npm install
```

Expected: dependencies installed, no errors.

- [ ] **Step 3: Write astro.config.mjs**

```js
import { defineConfig } from 'astro/config';
import react from '@astrojs/react';
import mdx from '@astrojs/mdx';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  output: 'static',
  integrations: [react(), mdx()],
  vite: {
    plugins: [tailwindcss()],
  },
  markdown: {
    shikiConfig: {
      themes: { light: 'github-light', dark: 'github-dark' },
    },
  },
});
```

- [ ] **Step 4: Write tsconfig.json**

```json
{
  "extends": "astro/tsconfigs/strict",
  "include": [".astro/types.d.ts", "**/*"],
  "exclude": ["dist"],
  "compilerOptions": {
    "jsx": "react-jsx",
    "jsxImportSource": "react"
  }
}
```

- [ ] **Step 5: Write .gitignore**

```
node_modules/
dist/
.astro/
.env
.env.production
pdfs/
```

- [ ] **Step 6: Verify project initializes**

```bash
cd sysdesign-website-astro && npx astro check
```

Expected: no type errors. (No pages exist yet; check should pass.)

- [ ] **Step 7: Commit**

```bash
git add sysdesign-website-astro/package.json sysdesign-website-astro/astro.config.mjs sysdesign-website-astro/tsconfig.json sysdesign-website-astro/.gitignore sysdesign-website-astro/package-lock.json
git commit -m "scaffold Astro app for sysdesign course site"
```

---

### Task 2: Tailwind tokens and base global styles (light + dark)

**Files:**
- Create: `sysdesign-website-astro/src/styles/global.css`

- [ ] **Step 1: Write global.css with light/dark tokens**

```css
@import "tailwindcss";

@theme {
  /* base palette — light defaults, dark overrides via [data-theme="dark"] */
  --color-bg: #ffffff;
  --color-bg-elevated: #fafafa;
  --color-bg-muted: #f4f4f5;
  --color-text: #18181b;
  --color-text-muted: #52525b;
  --color-text-faint: #71717a;
  --color-border: #e4e4e7;
  --color-border-strong: #d4d4d8;

  --color-accent: #6366f1;        /* indigo-500 */
  --color-accent-hover: #4f46e5;
  --color-accent-soft: rgba(99, 102, 241, 0.08);

  --color-callout-info-bg: #eff6ff;
  --color-callout-info-border: #93c5fd;
  --color-callout-tip-bg: #ecfdf5;
  --color-callout-tip-border: #6ee7b7;
  --color-callout-warning-bg: #fffbeb;
  --color-callout-warning-border: #fcd34d;
  --color-callout-pitfall-bg: #fef2f2;
  --color-callout-pitfall-border: #fca5a5;

  --font-sans: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  --font-mono: ui-monospace, SFMono-Regular, "SF Mono", Menlo, Consolas, monospace;
}

[data-theme="dark"] {
  --color-bg: #09090b;
  --color-bg-elevated: #18181b;
  --color-bg-muted: #27272a;
  --color-text: #fafafa;
  --color-text-muted: #a1a1aa;
  --color-text-faint: #71717a;
  --color-border: #27272a;
  --color-border-strong: #3f3f46;
  --color-accent: #818cf8;
  --color-accent-hover: #a5b4fc;
  --color-accent-soft: rgba(129, 140, 248, 0.10);

  --color-callout-info-bg: rgba(59, 130, 246, 0.08);
  --color-callout-info-border: rgba(96, 165, 250, 0.4);
  --color-callout-tip-bg: rgba(16, 185, 129, 0.08);
  --color-callout-tip-border: rgba(110, 231, 183, 0.4);
  --color-callout-warning-bg: rgba(245, 158, 11, 0.08);
  --color-callout-warning-border: rgba(252, 211, 77, 0.4);
  --color-callout-pitfall-bg: rgba(239, 68, 68, 0.08);
  --color-callout-pitfall-border: rgba(252, 165, 165, 0.4);
}

html {
  background: var(--color-bg);
  color: var(--color-text);
  font-family: var(--font-sans);
  -webkit-font-smoothing: antialiased;
}

body { min-height: 100vh; }

[id] { scroll-margin-top: 80px; }

/* Prose typography for lesson body */
.prose-lesson {
  font-size: 1.0625rem;
  line-height: 1.75;
  color: var(--color-text);
  max-width: 70ch;
}
.prose-lesson h2 {
  font-size: 1.625rem;
  font-weight: 700;
  margin-top: 2.5rem;
  margin-bottom: 1rem;
  letter-spacing: -0.01em;
}
.prose-lesson h3 {
  font-size: 1.25rem;
  font-weight: 600;
  margin-top: 2rem;
  margin-bottom: 0.75rem;
}
.prose-lesson p { margin-bottom: 1.25rem; }
.prose-lesson ul, .prose-lesson ol { margin: 1rem 0 1.25rem 1.5rem; }
.prose-lesson li { margin-bottom: 0.375rem; }
.prose-lesson code {
  background: var(--color-bg-muted);
  padding: 0.125rem 0.375rem;
  border-radius: 0.25rem;
  font-family: var(--font-mono);
  font-size: 0.9em;
}
.prose-lesson pre {
  background: var(--color-bg-muted);
  padding: 1rem;
  border-radius: 0.5rem;
  overflow-x: auto;
  margin: 1.25rem 0;
}
.prose-lesson pre code { background: transparent; padding: 0; }
.prose-lesson a { color: var(--color-accent); text-decoration: underline; text-underline-offset: 0.2em; }
.prose-lesson a:hover { color: var(--color-accent-hover); }
.prose-lesson img {
  max-width: 100%;
  height: auto;
  border-radius: 0.5rem;
  border: 1px solid var(--color-border);
  margin: 1.5rem 0;
}
.prose-lesson blockquote {
  border-left: 3px solid var(--color-accent);
  padding-left: 1rem;
  color: var(--color-text-muted);
  margin: 1.25rem 0;
}
```

- [ ] **Step 2: Commit**

```bash
git add sysdesign-website-astro/src/styles/global.css
git commit -m "add Tailwind v4 tokens and prose styles for light/dark"
```

---

### Task 3: Content collections schema

**Files:**
- Create: `sysdesign-website-astro/src/content/config.ts`
- Create: `sysdesign-website-astro/src/content/sections/architecture-basics.md`

- [ ] **Step 1: Write content collection schemas**

```ts
// src/content/config.ts
import { defineCollection, z } from 'astro:content';

const sections = defineCollection({
  type: 'content',
  schema: z.object({
    slug: z.string(),
    order: z.number().int().positive(),
    title: z.string(),
    summary: z.string(),
    status: z.enum(['ready', 'coming-soon']),
  }),
});

const lessons = defineCollection({
  type: 'content',
  schema: z.object({
    title: z.string(),
    slug: z.string(),
    order: z.number().int().positive(),
    section: z.string(), // section slug
    summary: z.string(),
    readingMinutes: z.number().int().positive(),
    lastUpdated: z.string(), // ISO date "YYYY-MM-DD"
    group: z.string().optional(), // e.g. "Foundation Concepts"
  }),
});

export const collections = { sections, lessons };
```

- [ ] **Step 2: Write section meta for architecture-basics**

```md
---
slug: architecture-basics
order: 1
title: Architecture Basics
summary: The vocabulary, the trade-offs, and the mental models you'll use everywhere else in the course.
status: ready
---

# Architecture Basics

Foundations: what architecture and system design mean, why they matter for multi-tenant SaaS at high load, and the principles you'll lean on through the rest of the course.
```

- [ ] **Step 3: Verify collection types compile**

```bash
cd sysdesign-website-astro && npx astro sync && npx astro check
```

Expected: no errors. `astro sync` regenerates `.astro/types.d.ts`.

- [ ] **Step 4: Commit**

```bash
git add sysdesign-website-astro/src/content/
git commit -m "define content collection schemas for sections and lessons"
```

---

### Task 4: Set up Vitest and write tests for `readingTime`

**Files:**
- Create: `sysdesign-website-astro/vitest.config.ts`
- Create: `sysdesign-website-astro/src/lib/readingTime.ts`
- Create: `sysdesign-website-astro/src/lib/readingTime.test.ts`

- [ ] **Step 1: Write vitest.config.ts**

```ts
import { defineConfig } from 'vitest/config';

export default defineConfig({
  test: {
    environment: 'happy-dom',
    include: ['src/**/*.test.ts', 'src/**/*.test.tsx'],
  },
});
```

- [ ] **Step 2: Write the failing test**

```ts
// src/lib/readingTime.test.ts
import { describe, expect, it } from 'vitest';
import { readingMinutes } from './readingTime';

describe('readingMinutes', () => {
  it('returns at least 1 minute for very short text', () => {
    expect(readingMinutes('hello world')).toBe(1);
  });

  it('rounds up to the nearest minute at 200 wpm', () => {
    const text = Array(401).fill('word').join(' '); // 401 words / 200 = 2.005 → 3
    expect(readingMinutes(text)).toBe(3);
  });

  it('strips markdown image and link syntax before counting', () => {
    const text = '![alt](image.png) [link](https://example.com) one two three';
    expect(readingMinutes(text)).toBe(1);
  });

  it('counts only words, not punctuation', () => {
    const text = 'one, two; three. four! five?';
    expect(readingMinutes(text)).toBe(1);
  });
});
```

- [ ] **Step 3: Run test to verify it fails**

```bash
cd sysdesign-website-astro && npx vitest run src/lib/readingTime.test.ts
```

Expected: FAIL — module not found.

- [ ] **Step 4: Implement `readingMinutes`**

```ts
// src/lib/readingTime.ts
const WORDS_PER_MINUTE = 200;

export function readingMinutes(markdown: string): number {
  const stripped = markdown
    .replace(/!\[[^\]]*\]\([^)]*\)/g, ' ')   // images
    .replace(/\[([^\]]*)\]\([^)]*\)/g, '$1') // links → keep label
    .replace(/[`*_~>#-]/g, ' ');             // simple md syntax
  const words = stripped.trim().split(/\s+/).filter(Boolean).length;
  return Math.max(1, Math.ceil(words / WORDS_PER_MINUTE));
}
```

- [ ] **Step 5: Run test to verify it passes**

```bash
cd sysdesign-website-astro && npx vitest run src/lib/readingTime.test.ts
```

Expected: PASS — all 4 tests green.

- [ ] **Step 6: Commit**

```bash
git add sysdesign-website-astro/vitest.config.ts sysdesign-website-astro/src/lib/readingTime.ts sysdesign-website-astro/src/lib/readingTime.test.ts sysdesign-website-astro/package.json sysdesign-website-astro/package-lock.json
git commit -m "add readingTime util with tests"
```

---

## Phase 2 — Layout chrome and core components (Tasks 5–11)

### Task 5: BaseLayout with theme toggle wiring

**Files:**
- Create: `sysdesign-website-astro/src/layouts/BaseLayout.astro`
- Create: `sysdesign-website-astro/src/components/ThemeToggle.tsx`

- [ ] **Step 1: Write `ThemeToggle.tsx`**

```tsx
// src/components/ThemeToggle.tsx
import { useEffect, useState } from 'react';

type Theme = 'light' | 'dark';

function getInitialTheme(): Theme {
  if (typeof document === 'undefined') return 'light';
  const stored = localStorage.getItem('theme') as Theme | null;
  if (stored) return stored;
  return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

export default function ThemeToggle() {
  const [theme, setTheme] = useState<Theme>('light');

  useEffect(() => {
    const t = getInitialTheme();
    setTheme(t);
    document.documentElement.dataset.theme = t;
  }, []);

  function toggle() {
    const next: Theme = theme === 'light' ? 'dark' : 'light';
    setTheme(next);
    document.documentElement.dataset.theme = next;
    localStorage.setItem('theme', next);
  }

  return (
    <button
      onClick={toggle}
      aria-label="Toggle theme"
      className="rounded-md p-2 text-[color:var(--color-text-muted)] hover:bg-[color:var(--color-bg-muted)] hover:text-[color:var(--color-text)] transition-colors"
    >
      {theme === 'light' ? '🌙' : '☀️'}
    </button>
  );
}
```

- [ ] **Step 2: Write `BaseLayout.astro`**

```astro
---
import '../styles/global.css';

interface Props {
  title: string;
  description?: string;
}
const { title, description = 'A free system design course focused on multi-tenant SaaS at high load.' } = Astro.props;
---
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content={description} />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <title>{title}</title>
    <script is:inline>
      // Set theme before paint to avoid flash.
      (function () {
        try {
          var t = localStorage.getItem('theme');
          if (!t) t = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
          document.documentElement.dataset.theme = t;
        } catch (_) {}
      })();
    </script>
  </head>
  <body>
    <slot />
  </body>
</html>
```

- [ ] **Step 3: Verify build**

```bash
cd sysdesign-website-astro && npx astro check
```

Expected: no errors. (Pages still missing — `astro build` would fail, that's fine.)

- [ ] **Step 4: Commit**

```bash
git add sysdesign-website-astro/src/layouts/BaseLayout.astro sysdesign-website-astro/src/components/ThemeToggle.tsx
git commit -m "add BaseLayout with FOUC-safe theme toggle"
```

---

### Task 6: Navbar and Footer

**Files:**
- Create: `sysdesign-website-astro/src/components/Navbar.astro`
- Create: `sysdesign-website-astro/src/components/Footer.astro`

- [ ] **Step 1: Write `Navbar.astro`**

```astro
---
import ThemeToggle from './ThemeToggle.tsx';
---
<header class="sticky top-0 z-40 border-b border-[color:var(--color-border)] bg-[color:var(--color-bg)]/85 backdrop-blur">
  <nav class="mx-auto max-w-7xl px-4 py-3 flex items-center gap-6">
    <a href="/" class="flex items-center gap-2 shrink-0">
      <div class="w-8 h-8 rounded-lg bg-[color:var(--color-accent)] flex items-center justify-center text-white font-bold text-sm">S</div>
      <span class="font-semibold text-[color:var(--color-text)]">System Design Course</span>
    </a>
    <div class="hidden sm:flex items-center gap-5 flex-1">
      <a href="/course" class="text-sm text-[color:var(--color-text-muted)] hover:text-[color:var(--color-text)] transition-colors">Sections</a>
      <a href="/section/architecture-basics" class="text-sm text-[color:var(--color-text-muted)] hover:text-[color:var(--color-text)] transition-colors">Section 1</a>
    </div>
    <a href="https://github.com/razkevich/system_design_course" target="_blank" rel="noopener noreferrer" class="text-sm text-[color:var(--color-text-muted)] hover:text-[color:var(--color-text)] transition-colors">GitHub</a>
    <ThemeToggle client:load />
  </nav>
</header>
```

- [ ] **Step 2: Write `Footer.astro`**

```astro
---
const year = new Date().getFullYear();
---
<footer class="border-t border-[color:var(--color-border)] mt-20">
  <div class="mx-auto max-w-7xl px-4 py-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-[color:var(--color-text-muted)]">
    <div>© {year} Alex Razkevich · Free, open-source course</div>
    <div class="flex gap-6">
      <a href="/course" class="hover:text-[color:var(--color-text)] transition-colors">Course</a>
      <a href="https://github.com/razkevich/system_design_course" target="_blank" rel="noopener noreferrer" class="hover:text-[color:var(--color-text)] transition-colors">GitHub</a>
    </div>
  </div>
</footer>
```

- [ ] **Step 3: Commit**

```bash
git add sysdesign-website-astro/src/components/Navbar.astro sysdesign-website-astro/src/components/Footer.astro
git commit -m "add Navbar and Footer components"
```

---

### Task 7: Hero, CredibilityBar, ModuleCardsGrid (landing page chrome)

**Files:**
- Create: `sysdesign-website-astro/src/components/Hero.astro`
- Create: `sysdesign-website-astro/src/components/CredibilityBar.astro`
- Create: `sysdesign-website-astro/src/components/ModuleCardsGrid.astro`

- [ ] **Step 1: Write `Hero.astro`**

```astro
---
---
<section class="relative overflow-hidden">
  <div class="absolute inset-0 bg-gradient-to-br from-[color:var(--color-accent-soft)] via-transparent to-transparent pointer-events-none" aria-hidden="true"></div>
  <div class="relative mx-auto max-w-4xl px-4 py-20 sm:py-28 text-center">
    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[color:var(--color-accent)] mb-4">
      Free · Open Source · Self-Paced
    </p>
    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-[color:var(--color-text)] mb-6 tracking-tight">
      System Design for<br/>Multi-Tenant SaaS at Scale
    </h1>
    <p class="text-lg text-[color:var(--color-text-muted)] max-w-2xl mx-auto mb-3">
      A free, opinionated guide to architecting, building, and scaling modern distributed systems — with a sharp focus on multi-tenant SaaS under high load.
    </p>
    <p class="text-sm text-[color:var(--color-text-faint)] mb-10">by Alex Razkevich</p>
    <div class="flex flex-col sm:flex-row justify-center gap-3">
      <a href="/section/architecture-basics" class="px-6 py-3 rounded-lg font-semibold text-white bg-[color:var(--color-accent)] hover:bg-[color:var(--color-accent-hover)] transition-colors">Start Section 1 →</a>
      <a href="/course" class="px-6 py-3 rounded-lg font-semibold text-[color:var(--color-text)] border border-[color:var(--color-border-strong)] hover:border-[color:var(--color-accent)] transition-colors">View full course</a>
    </div>
  </div>
</section>
```

- [ ] **Step 2: Write `CredibilityBar.astro`**

```astro
---
interface Props {
  sections: number;
  lessons: number;
  hours: number;
}
const { sections, lessons, hours } = Astro.props;
---
<section class="border-y border-[color:var(--color-border)] bg-[color:var(--color-bg-elevated)]">
  <div class="mx-auto max-w-4xl px-4 py-6 grid grid-cols-3 gap-4 text-center">
    <div>
      <div class="text-2xl font-bold text-[color:var(--color-text)]">{sections}</div>
      <div class="text-xs uppercase tracking-wider text-[color:var(--color-text-muted)]">Sections</div>
    </div>
    <div>
      <div class="text-2xl font-bold text-[color:var(--color-text)]">{lessons}+</div>
      <div class="text-xs uppercase tracking-wider text-[color:var(--color-text-muted)]">Lessons</div>
    </div>
    <div>
      <div class="text-2xl font-bold text-[color:var(--color-text)]">~{hours}h</div>
      <div class="text-xs uppercase tracking-wider text-[color:var(--color-text-muted)]">Reading time</div>
    </div>
  </div>
</section>
```

- [ ] **Step 3: Write `ModuleCardsGrid.astro`**

```astro
---
import type { CollectionEntry } from 'astro:content';

interface Props {
  sections: CollectionEntry<'sections'>[];
  lessonCounts: Record<string, number>;
}
const { sections, lessonCounts } = Astro.props;
---
<section class="mx-auto max-w-6xl px-4 py-16">
  <h2 class="text-2xl sm:text-3xl font-bold text-[color:var(--color-text)] mb-2 text-center">What you'll learn</h2>
  <p class="text-[color:var(--color-text-muted)] text-center mb-10">Seven sections covering every layer of a modern SaaS platform.</p>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    {sections.map((s) => {
      const ready = s.data.status === 'ready';
      const count = lessonCounts[s.data.slug] ?? 0;
      const href = ready ? `/section/${s.data.slug}` : '#';
      return (
        <a
          href={href}
          aria-disabled={!ready}
          class:list={[
            'group rounded-xl border p-5 transition-all',
            ready
              ? 'border-[color:var(--color-border)] hover:border-[color:var(--color-accent)] hover:shadow-md bg-[color:var(--color-bg-elevated)]'
              : 'border-dashed border-[color:var(--color-border)] bg-[color:var(--color-bg-muted)] opacity-60 cursor-not-allowed pointer-events-none'
          ]}
        >
          <div class="text-xs font-semibold uppercase tracking-widest text-[color:var(--color-accent)] mb-2">Section {s.data.order}</div>
          <h3 class="text-lg font-semibold text-[color:var(--color-text)] mb-1">{s.data.title}</h3>
          <p class="text-sm text-[color:var(--color-text-muted)] mb-4 line-clamp-3">{s.data.summary}</p>
          <div class="flex items-center justify-between text-xs">
            <span class="text-[color:var(--color-text-faint)]">{count} {count === 1 ? 'lesson' : 'lessons'}</span>
            <span class="text-[color:var(--color-accent)] font-semibold">{ready ? 'READY →' : 'COMING SOON'}</span>
          </div>
        </a>
      );
    })}
  </div>
</section>
```

- [ ] **Step 4: Commit**

```bash
git add sysdesign-website-astro/src/components/Hero.astro sysdesign-website-astro/src/components/CredibilityBar.astro sysdesign-website-astro/src/components/ModuleCardsGrid.astro
git commit -m "add Hero, CredibilityBar, and ModuleCardsGrid"
```

---

### Task 8: Callout component

**Files:**
- Create: `sysdesign-website-astro/src/components/Callout.astro`

- [ ] **Step 1: Write Callout.astro**

```astro
---
type Variant = 'info' | 'tip' | 'warning' | 'pitfall';
interface Props {
  type?: Variant;
  title?: string;
}
const { type = 'info', title } = Astro.props;

const config: Record<Variant, { emoji: string; label: string; bgVar: string; borderVar: string }> = {
  info:    { emoji: 'ℹ️', label: 'Note',          bgVar: 'var(--color-callout-info-bg)',    borderVar: 'var(--color-callout-info-border)' },
  tip:     { emoji: '💡', label: 'Tip',           bgVar: 'var(--color-callout-tip-bg)',     borderVar: 'var(--color-callout-tip-border)' },
  warning: { emoji: '⚠️', label: 'Watch out',     bgVar: 'var(--color-callout-warning-bg)', borderVar: 'var(--color-callout-warning-border)' },
  pitfall: { emoji: '🕳️', label: 'Common pitfall', bgVar: 'var(--color-callout-pitfall-bg)', borderVar: 'var(--color-callout-pitfall-border)' },
};
const c = config[type];
---
<aside
  class="my-6 rounded-lg border-l-4 px-4 py-3"
  style={`background:${c.bgVar}; border-color:${c.borderVar};`}
>
  <div class="text-xs font-semibold uppercase tracking-wider mb-1 text-[color:var(--color-text)]">
    {c.emoji} {title ?? c.label}
  </div>
  <div class="text-[color:var(--color-text)] text-[0.95rem] leading-relaxed">
    <slot />
  </div>
</aside>
```

- [ ] **Step 2: Commit**

```bash
git add sysdesign-website-astro/src/components/Callout.astro
git commit -m "add Callout component (info/tip/warning/pitfall)"
```

---

### Task 9: tocFromHtml util with tests + OnPageTOC component

**Files:**
- Create: `sysdesign-website-astro/src/lib/tocFromHtml.ts`
- Create: `sysdesign-website-astro/src/lib/tocFromHtml.test.ts`
- Create: `sysdesign-website-astro/src/components/OnPageTOC.tsx`

- [ ] **Step 1: Write the failing test**

```ts
// src/lib/tocFromHtml.test.ts
import { describe, expect, it } from 'vitest';
import { tocFromHtml } from './tocFromHtml';

describe('tocFromHtml', () => {
  it('returns empty array when no headings', () => {
    expect(tocFromHtml('<p>hello</p>')).toEqual([]);
  });

  it('extracts h2 headings with id and text', () => {
    const html = '<h2 id="intro">Intro</h2><p>x</p><h2 id="more">More</h2>';
    expect(tocFromHtml(html)).toEqual([
      { id: 'intro', text: 'Intro', depth: 2 },
      { id: 'more', text: 'More', depth: 2 },
    ]);
  });

  it('extracts h3 headings with depth 3', () => {
    const html = '<h2 id="a">A</h2><h3 id="a1">A1</h3><h2 id="b">B</h2>';
    expect(tocFromHtml(html)).toEqual([
      { id: 'a', text: 'A', depth: 2 },
      { id: 'a1', text: 'A1', depth: 3 },
      { id: 'b', text: 'B', depth: 2 },
    ]);
  });

  it('skips headings without an id', () => {
    const html = '<h2 id="ok">Ok</h2><h2>NoId</h2>';
    expect(tocFromHtml(html)).toEqual([{ id: 'ok', text: 'Ok', depth: 2 }]);
  });

  it('strips inner HTML tags from heading text', () => {
    const html = '<h2 id="x">Hello <code>world</code></h2>';
    expect(tocFromHtml(html)).toEqual([{ id: 'x', text: 'Hello world', depth: 2 }]);
  });
});
```

- [ ] **Step 2: Run test (expect FAIL)**

```bash
cd sysdesign-website-astro && npx vitest run src/lib/tocFromHtml.test.ts
```

Expected: FAIL — module not found.

- [ ] **Step 3: Implement tocFromHtml**

```ts
// src/lib/tocFromHtml.ts
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
```

- [ ] **Step 4: Run test (expect PASS)**

```bash
cd sysdesign-website-astro && npx vitest run src/lib/tocFromHtml.test.ts
```

Expected: PASS — all 5 tests green.

- [ ] **Step 5: Write OnPageTOC.tsx (scroll-spy right rail)**

```tsx
// src/components/OnPageTOC.tsx
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
```

- [ ] **Step 6: Commit**

```bash
git add sysdesign-website-astro/src/lib/tocFromHtml.ts sysdesign-website-astro/src/lib/tocFromHtml.test.ts sysdesign-website-astro/src/components/OnPageTOC.tsx
git commit -m "add tocFromHtml util and OnPageTOC scroll-spy component"
```

---

### Task 10: CourseSidebar (course progress / lesson nav on lesson pages)

**Files:**
- Create: `sysdesign-website-astro/src/components/CourseSidebar.tsx`

- [ ] **Step 1: Write CourseSidebar.tsx**

```tsx
// src/components/CourseSidebar.tsx
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
```

- [ ] **Step 2: Commit**

```bash
git add sysdesign-website-astro/src/components/CourseSidebar.tsx
git commit -m "add CourseSidebar with mobile drawer toggle"
```

---

### Task 11: LessonHeader and PrevNextNav

**Files:**
- Create: `sysdesign-website-astro/src/components/LessonHeader.astro`
- Create: `sysdesign-website-astro/src/components/PrevNextNav.astro`

- [ ] **Step 1: Write LessonHeader.astro**

```astro
---
interface Props {
  title: string;
  readingMinutes: number;
  lastUpdated: string;
  sectionTitle: string;
  sectionHref: string;
  order: number;
}
const { title, readingMinutes, lastUpdated, sectionTitle, sectionHref, order } = Astro.props;
---
<header class="mb-8">
  <nav class="text-xs text-[color:var(--color-text-muted)] mb-3">
    <a href="/course" class="hover:text-[color:var(--color-text)]">Course</a>
    <span class="mx-1.5">/</span>
    <a href={sectionHref} class="hover:text-[color:var(--color-text)]">{sectionTitle}</a>
    <span class="mx-1.5">/</span>
    <span>Lesson {order}</span>
  </nav>
  <h1 class="text-3xl sm:text-4xl font-bold text-[color:var(--color-text)] tracking-tight mb-3">{title}</h1>
  <div class="text-sm text-[color:var(--color-text-faint)]">
    {readingMinutes} min read · Updated {lastUpdated}
  </div>
</header>
```

- [ ] **Step 2: Write PrevNextNav.astro**

```astro
---
interface NavLink { href: string; title: string; }
interface Props {
  prev?: NavLink;
  next?: NavLink;
}
const { prev, next } = Astro.props;
---
<nav class="mt-12 pt-8 border-t border-[color:var(--color-border)] flex flex-col sm:flex-row gap-4 justify-between">
  {prev ? (
    <a href={prev.href} class="group flex-1 rounded-lg border border-[color:var(--color-border)] p-4 hover:border-[color:var(--color-accent)] transition-colors">
      <div class="text-xs uppercase tracking-wider text-[color:var(--color-text-faint)] mb-1">← Previous</div>
      <div class="text-[color:var(--color-text)] font-semibold group-hover:text-[color:var(--color-accent)]">{prev.title}</div>
    </a>
  ) : <div class="flex-1"></div>}
  {next ? (
    <a href={next.href} class="group flex-1 rounded-lg border border-[color:var(--color-border)] p-4 hover:border-[color:var(--color-accent)] transition-colors text-right">
      <div class="text-xs uppercase tracking-wider text-[color:var(--color-text-faint)] mb-1">Next →</div>
      <div class="text-[color:var(--color-text)] font-semibold group-hover:text-[color:var(--color-accent)]">{next.title}</div>
    </a>
  ) : <div class="flex-1"></div>}
</nav>
```

- [ ] **Step 3: Commit**

```bash
git add sysdesign-website-astro/src/components/LessonHeader.astro sysdesign-website-astro/src/components/PrevNextNav.astro
git commit -m "add LessonHeader and PrevNextNav"
```

---

## Phase 3 — Pages and lesson layout (Tasks 12–15)

### Task 12: Landing page (`/`)

**Files:**
- Create: `sysdesign-website-astro/src/pages/index.astro`

- [ ] **Step 1: Write index.astro**

```astro
---
import { getCollection } from 'astro:content';
import BaseLayout from '../layouts/BaseLayout.astro';
import Navbar from '../components/Navbar.astro';
import Footer from '../components/Footer.astro';
import Hero from '../components/Hero.astro';
import CredibilityBar from '../components/CredibilityBar.astro';
import ModuleCardsGrid from '../components/ModuleCardsGrid.astro';

const sections = (await getCollection('sections')).sort((a, b) => a.data.order - b.data.order);
const lessons = await getCollection('lessons');

const lessonCounts: Record<string, number> = {};
for (const l of lessons) {
  lessonCounts[l.data.section] = (lessonCounts[l.data.section] ?? 0) + 1;
}

const totalLessons = lessons.length;
const totalReading = lessons.reduce((sum, l) => sum + l.data.readingMinutes, 0);
const hours = Math.max(1, Math.round(totalReading / 60));
---
<BaseLayout title="System Design Course">
  <Navbar />
  <Hero />
  <CredibilityBar sections={sections.length} lessons={totalLessons} hours={hours} />
  <ModuleCardsGrid sections={sections} lessonCounts={lessonCounts} />
  <Footer />
</BaseLayout>
```

- [ ] **Step 2: Add 6 placeholder section files (so the grid has all 7 cards)**

Repeat the pattern for each, with `status: coming-soon`. Files to create:

- `src/content/sections/architectural-patterns.md`
- `src/content/sections/networks-and-communication.md`
- `src/content/sections/distributed-systems.md`
- `src/content/sections/data-storage.md`
- `src/content/sections/resilience-and-observability.md`
- `src/content/sections/security-and-data-protection.md`

Example contents (write each with the appropriate slug/order/title/summary):

```md
---
slug: architectural-patterns
order: 2
title: Architectural Patterns
summary: DDD, microservices, event-driven architecture, serverless, multi-tenancy. The vocabulary of modern SaaS architecture.
status: coming-soon
---

# Architectural Patterns
```

```md
---
slug: networks-and-communication
order: 3
title: Networks & Communication
summary: API styles, protocols, network components, service meshes, and how it all fits together in cloud VPCs.
status: coming-soon
---

# Networks & Communication
```

```md
---
slug: distributed-systems
order: 4
title: Distributed Systems
summary: Sharding, replication, CAP, consensus, distributed coordination, and how Kubernetes orchestrates the lot.
status: coming-soon
---

# Distributed Systems
```

```md
---
slug: data-storage
order: 5
title: Data Storage & Processing
summary: Database scalability, ACID vs BASE, isolation levels, message brokers, exactly-once semantics, and big-data pipelines.
status: coming-soon
---

# Data Storage & Processing
```

```md
---
slug: resilience-and-observability
order: 6
title: Resilience & Observability
summary: Redundancy, rate limiting, circuit breakers, bulkheads, the outbox pattern, and SRE practices.
status: coming-soon
---

# Resilience & Observability
```

```md
---
slug: security-and-data-protection
order: 7
title: Security & Data Protection
summary: AuthN/AuthZ, securing cloud-native applications, data at rest and in transit, compliance frameworks.
status: coming-soon
---

# Security & Data Protection
```

- [ ] **Step 3: Verify build**

```bash
cd sysdesign-website-astro && npx astro build
```

Expected: build succeeds; `dist/index.html` exists. Note: the build may complain about the `lessons` collection being empty — that's fine for now.

- [ ] **Step 4: Spot-check in browser**

```bash
cd sysdesign-website-astro && npx astro dev
```

Visit `http://localhost:4321/`. Confirm: hero renders, 7 cards visible, only "Architecture Basics" looks active, theme toggle works, dark mode works.

- [ ] **Step 5: Commit**

```bash
git add sysdesign-website-astro/src/pages/index.astro sysdesign-website-astro/src/content/sections/
git commit -m "add landing page with 7-section grid (Section 1 active)"
```

---

### Task 13: Course page (`/course`)

**Files:**
- Create: `sysdesign-website-astro/src/pages/course.astro`

- [ ] **Step 1: Write course.astro**

```astro
---
import { getCollection } from 'astro:content';
import BaseLayout from '../layouts/BaseLayout.astro';
import Navbar from '../components/Navbar.astro';
import Footer from '../components/Footer.astro';

const sections = (await getCollection('sections')).sort((a, b) => a.data.order - b.data.order);
const lessons = (await getCollection('lessons')).sort((a, b) => a.data.order - b.data.order);

const lessonsBySection = lessons.reduce<Record<string, typeof lessons>>((acc, l) => {
  (acc[l.data.section] ??= []).push(l);
  return acc;
}, {});
---
<BaseLayout title="Course outline · System Design Course">
  <Navbar />
  <main class="mx-auto max-w-3xl px-4 py-12">
    <h1 class="text-3xl sm:text-4xl font-bold text-[color:var(--color-text)] mb-2 tracking-tight">Course outline</h1>
    <p class="text-[color:var(--color-text-muted)] mb-10">Seven sections, ~40 lessons, free forever.</p>

    {sections.map((s) => {
      const ready = s.data.status === 'ready';
      const items = lessonsBySection[s.data.slug] ?? [];
      const groups = items.reduce<Record<string, typeof items>>((acc, l) => {
        (acc[l.data.group ?? ''] ??= []).push(l);
        return acc;
      }, {});
      return (
        <section class:list={['mb-8', !ready && 'opacity-60']}>
          <h2 class="text-xl font-semibold text-[color:var(--color-text)] mb-1">
            {s.data.order}. {s.data.title}
            {!ready && <span class="ml-3 text-xs font-normal uppercase tracking-wider text-[color:var(--color-text-faint)]">[coming soon]</span>}
          </h2>
          <p class="text-sm text-[color:var(--color-text-muted)] mb-3">{s.data.summary}</p>
          {ready && Object.entries(groups).map(([group, ls]) => (
            <div class="ml-4 mb-3">
              {group && <div class="text-xs uppercase tracking-wider text-[color:var(--color-text-faint)] mt-3 mb-1">{group}</div>}
              <ul class="space-y-1">
                {ls.map((l) => (
                  <li>
                    <a href={`/lesson/${l.data.section}/${l.data.slug}`} class="text-sm text-[color:var(--color-text)] hover:text-[color:var(--color-accent)]">
                      <span class="text-[color:var(--color-text-faint)] mr-2">{s.data.order}.{l.data.order}</span>
                      {l.data.title}
                      <span class="ml-2 text-xs text-[color:var(--color-text-faint)]">→ {l.data.readingMinutes} min</span>
                    </a>
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </section>
      );
    })}
  </main>
  <Footer />
</BaseLayout>
```

- [ ] **Step 2: Verify build**

```bash
cd sysdesign-website-astro && npx astro build
```

Expected: build succeeds (lesson list will be empty until Phase 4; that is fine).

- [ ] **Step 3: Commit**

```bash
git add sysdesign-website-astro/src/pages/course.astro
git commit -m "add course outline page"
```

---

### Task 14: Section hub page (`/section/[slug]`)

**Files:**
- Create: `sysdesign-website-astro/src/pages/section/[slug].astro`
- Create: `sysdesign-website-astro/src/components/LessonCard.astro`

- [ ] **Step 1: Write LessonCard.astro**

```astro
---
interface Props {
  href: string;
  order: number;
  parentOrder: number;
  title: string;
  summary: string;
  readingMinutes: number;
}
const { href, order, parentOrder, title, summary, readingMinutes } = Astro.props;
---
<a href={href} class="group block border-b border-[color:var(--color-border)] py-4 hover:bg-[color:var(--color-bg-muted)] -mx-4 px-4 transition-colors">
  <div class="flex items-baseline gap-3">
    <span class="text-sm font-mono text-[color:var(--color-text-faint)] shrink-0">{parentOrder}.{order}</span>
    <div class="flex-1">
      <div class="flex items-baseline justify-between gap-3">
        <h3 class="text-base font-semibold text-[color:var(--color-text)] group-hover:text-[color:var(--color-accent)]">{title}</h3>
        <span class="text-xs text-[color:var(--color-text-faint)] shrink-0">{readingMinutes} min →</span>
      </div>
      <p class="text-sm text-[color:var(--color-text-muted)] mt-1">{summary}</p>
    </div>
  </div>
</a>
```

- [ ] **Step 2: Write section/[slug].astro**

```astro
---
import { getCollection } from 'astro:content';
import BaseLayout from '../../layouts/BaseLayout.astro';
import Navbar from '../../components/Navbar.astro';
import Footer from '../../components/Footer.astro';
import LessonCard from '../../components/LessonCard.astro';

export async function getStaticPaths() {
  const sections = await getCollection('sections', ({ data }) => data.status === 'ready');
  return sections.map((s) => ({ params: { slug: s.data.slug }, props: { section: s } }));
}

const { section } = Astro.props;
const lessons = (await getCollection('lessons', ({ data }) => data.section === section.data.slug))
  .sort((a, b) => a.data.order - b.data.order);

const totalMinutes = lessons.reduce((s, l) => s + l.data.readingMinutes, 0);

const groups = lessons.reduce<Record<string, typeof lessons>>((acc, l) => {
  (acc[l.data.group ?? ''] ??= []).push(l);
  return acc;
}, {});

const groupOrder = Object.keys(groups);
---
<BaseLayout title={`${section.data.title} · System Design Course`}>
  <Navbar />
  <main class="mx-auto max-w-3xl px-4 py-12">
    <nav class="text-xs text-[color:var(--color-text-muted)] mb-4">
      <a href="/course" class="hover:text-[color:var(--color-text)]">Course</a>
      <span class="mx-1.5">/</span>
      <span>Section {section.data.order}</span>
    </nav>

    <header class="rounded-2xl bg-gradient-to-br from-[color:var(--color-accent-soft)] via-transparent to-transparent border border-[color:var(--color-border)] p-8 mb-10">
      <div class="text-xs font-semibold uppercase tracking-widest text-[color:var(--color-accent)] mb-2">Section {section.data.order}</div>
      <h1 class="text-3xl sm:text-4xl font-bold text-[color:var(--color-text)] tracking-tight mb-3">{section.data.title}</h1>
      <p class="text-[color:var(--color-text-muted)] text-lg max-w-2xl">{section.data.summary}</p>
      <div class="mt-4 text-sm text-[color:var(--color-text-faint)]">
        {lessons.length} lessons · ~{Math.max(1, Math.round(totalMinutes / 60 * 10) / 10)} h reading
      </div>
    </header>

    {groupOrder.map((group) => (
      <section class="mb-8">
        {group && <h2 class="text-sm font-semibold uppercase tracking-wider text-[color:var(--color-text-faint)] mb-2">{group}</h2>}
        <div>
          {groups[group].map((l) => (
            <LessonCard
              href={`/lesson/${section.data.slug}/${l.data.slug}`}
              order={l.data.order}
              parentOrder={section.data.order}
              title={l.data.title}
              summary={l.data.summary}
              readingMinutes={l.data.readingMinutes}
            />
          ))}
        </div>
      </section>
    ))}

    {lessons.length > 0 && (
      <div class="mt-8 text-center">
        <a href={`/lesson/${section.data.slug}/${lessons[0].data.slug}`} class="inline-block px-6 py-3 rounded-lg font-semibold text-white bg-[color:var(--color-accent)] hover:bg-[color:var(--color-accent-hover)] transition-colors">
          Start with {section.data.order}.{lessons[0].data.order} →
        </a>
      </div>
    )}
  </main>
  <Footer />
</BaseLayout>
```

- [ ] **Step 3: Verify build**

```bash
cd sysdesign-website-astro && npx astro build
```

Expected: builds — at this stage section page exists but has empty lesson list until Phase 4 lands lessons.

- [ ] **Step 4: Commit**

```bash
git add sysdesign-website-astro/src/pages/section/ sysdesign-website-astro/src/components/LessonCard.astro
git commit -m "add section hub page and LessonCard"
```

---

### Task 15: Lesson page + LessonLayout (`/lesson/[section]/[lesson]`)

**Files:**
- Create: `sysdesign-website-astro/src/layouts/LessonLayout.astro`
- Create: `sysdesign-website-astro/src/pages/lesson/[section]/[lesson].astro`

- [ ] **Step 1: Write LessonLayout.astro**

```astro
---
import BaseLayout from './BaseLayout.astro';
import Navbar from '../components/Navbar.astro';
import Footer from '../components/Footer.astro';
import CourseSidebar from '../components/CourseSidebar.tsx';
import OnPageTOC from '../components/OnPageTOC.tsx';
import LessonHeader from '../components/LessonHeader.astro';
import PrevNextNav from '../components/PrevNextNav.astro';
import type { TocEntry } from '../lib/tocFromHtml';

export interface Props {
  pageTitle: string;
  sectionTitle: string;
  sectionHref: string;
  lessonTitle: string;
  lessonOrder: number;
  readingMinutes: number;
  lastUpdated: string;
  sidebar: {
    sectionTitle: string;
    sectionHref: string;
    lessons: { slug: string; title: string; order: number; group?: string; href: string }[];
    currentSlug: string;
  };
  toc: TocEntry[];
  prev?: { href: string; title: string };
  next?: { href: string; title: string };
}

const { pageTitle, sectionTitle, sectionHref, lessonTitle, lessonOrder, readingMinutes, lastUpdated, sidebar, toc, prev, next } = Astro.props;
---
<BaseLayout title={pageTitle}>
  <Navbar />
  <div class="mx-auto max-w-7xl px-4 lg:grid lg:grid-cols-[240px_minmax(0,1fr)_220px] lg:gap-10 py-8">
    <div class="lg:sticky lg:top-20 lg:self-start lg:max-h-[calc(100vh-6rem)] lg:overflow-y-auto pb-6">
      <CourseSidebar
        client:load
        sectionTitle={sidebar.sectionTitle}
        sectionHref={sidebar.sectionHref}
        lessons={sidebar.lessons}
        currentSlug={sidebar.currentSlug}
      />
    </div>

    <article class="prose-lesson mx-auto">
      <LessonHeader
        title={lessonTitle}
        readingMinutes={readingMinutes}
        lastUpdated={lastUpdated}
        sectionTitle={sectionTitle}
        sectionHref={sectionHref}
        order={lessonOrder}
      />
      <slot />
      <PrevNextNav prev={prev} next={next} />
    </article>

    <div class="hidden lg:block lg:sticky lg:top-20 lg:self-start lg:max-h-[calc(100vh-6rem)] lg:overflow-y-auto">
      <OnPageTOC client:load entries={toc} />
    </div>
  </div>
  <Footer />
</BaseLayout>
```

- [ ] **Step 2: Write pages/lesson/[section]/[lesson].astro**

```astro
---
import { getCollection, getEntry } from 'astro:content';
import LessonLayout from '../../../layouts/LessonLayout.astro';
import Callout from '../../../components/Callout.astro';
import { tocFromHtml } from '../../../lib/tocFromHtml';

export async function getStaticPaths() {
  const lessons = await getCollection('lessons');
  const sections = await getCollection('sections');
  const sectionMap = new Map(sections.map((s) => [s.data.slug, s]));

  return lessons.map((entry) => ({
    params: { section: entry.data.section, lesson: entry.data.slug },
    props: {
      entry,
      section: sectionMap.get(entry.data.section)!,
      allLessonsInSection: lessons
        .filter((l) => l.data.section === entry.data.section)
        .sort((a, b) => a.data.order - b.data.order),
    },
  }));
}

const { entry, section, allLessonsInSection } = Astro.props;
const { Content, headings } = await entry.render();

// Build TOC from headings (Astro provides slugged ids on <h2>/<h3>).
const toc = headings
  .filter((h) => h.depth === 2 || h.depth === 3)
  .map((h) => ({ id: h.slug, text: h.text, depth: h.depth as 2 | 3 }));

const idx = allLessonsInSection.findIndex((l) => l.data.slug === entry.data.slug);
const prevLesson = allLessonsInSection[idx - 1];
const nextLesson = allLessonsInSection[idx + 1];

const sidebar = {
  sectionTitle: section.data.title,
  sectionHref: `/section/${section.data.slug}`,
  lessons: allLessonsInSection.map((l) => ({
    slug: l.data.slug,
    title: l.data.title,
    order: l.data.order,
    group: l.data.group,
    href: `/lesson/${section.data.slug}/${l.data.slug}`,
  })),
  currentSlug: entry.data.slug,
};

const prev = prevLesson ? { href: `/lesson/${section.data.slug}/${prevLesson.data.slug}`, title: prevLesson.data.title } : undefined;
const next = nextLesson ? { href: `/lesson/${section.data.slug}/${nextLesson.data.slug}`, title: nextLesson.data.title } : undefined;
---
<LessonLayout
  pageTitle={`${entry.data.title} · System Design Course`}
  sectionTitle={section.data.title}
  sectionHref={`/section/${section.data.slug}`}
  lessonTitle={entry.data.title}
  lessonOrder={entry.data.order}
  readingMinutes={entry.data.readingMinutes}
  lastUpdated={entry.data.lastUpdated}
  sidebar={sidebar}
  toc={toc}
  prev={prev}
  next={next}
>
  <Content components={{ Callout }} />
</LessonLayout>
```

- [ ] **Step 3: Verify build (will succeed but produce no lesson pages until Phase 4)**

```bash
cd sysdesign-website-astro && npx astro build
```

Expected: build succeeds.

- [ ] **Step 4: Commit**

```bash
git add sysdesign-website-astro/src/layouts/LessonLayout.astro sysdesign-website-astro/src/pages/lesson/
git commit -m "add LessonLayout and lesson route"
```

---

## Phase 4 — Content pipeline (Tasks 16–24)

### Task 16: Download all 8 Section 1 PDFs and convert to text

**Files:**
- Create: `sysdesign-website-astro/pdfs/1-1.pdf` … `1-8.pdf` (gitignored)
- Create: `sysdesign-website-astro/pdfs/1-1.txt` … `1-8.txt` (gitignored)
- Create: `sysdesign-website-astro/pdfs/MAPPING.md` (committed — for traceability)

- [ ] **Step 1: Download the 8 PDFs**

```bash
cd sysdesign-website-astro && mkdir -p pdfs && cd pdfs

declare -A IDS=(
  [1-1]=1-5-376GkLuuhYfWT4UrZRpQ9MWsufIVd
  [1-2]=1LKyIi_gizllI8NGO4W5lyzsSPOfuFPUE
  [1-3]=1mZpUVUix_RgbsH5G0dsvuZ5yMJGPlXiV
  [1-4]=1ifp-1pK35khUbTZvVC75jAIgNulSONB3
  [1-5]=1wleq7ZvhBPp38zgKUzL_0dR4j3onaxQ9
  [1-6]=1h0-J-vFnqfZXMhpeGSg8ukO5i28XQlXO
  [1-7]=1WuGyVVgdfVMrU8s2wmonYEBOc_4I245q
  [1-8]=1huLxmZVtlvXyxLkgr3oe12TvfpUJ-nqy
)

for k in "${!IDS[@]}"; do
  gog -a razkevich8@gmail.com drive download "${IDS[$k]}" --output "$k.pdf"
done
ls -la
```

Note: ID for 1-3 needs verification — `1huLxmZVtlvXyxLkgr3oe12TvfpUJ-nqy` was listed as "1-3" in the Drive listing earlier. The mapping below assumes Drive filenames `X-Y.pdf` correspond to lesson order Y in section X. **If a download produces unexpected content, re-list the folder with `gog drive ls --parent 1kXzlAuGPaYM-HF1T2nv-So6Pc06SuNkf --max 100` and re-map.**

Expected: 8 PDF files in `pdfs/`.

- [ ] **Step 2: Convert PDFs to text**

```bash
cd sysdesign-website-astro/pdfs && for f in 1-*.pdf; do pdftotext -layout "$f" "${f%.pdf}.txt"; done && ls *.txt
```

Expected: 8 `.txt` files.

- [ ] **Step 3: Verify mapping by reading first ~20 lines of each .txt**

```bash
cd sysdesign-website-astro/pdfs && for f in 1-*.txt; do echo "=== $f ==="; head -20 "$f"; done
```

Read the first heading of each PDF text. Compare to the hypothesized mapping in the spec (PDF 1-N ↔ lesson at position N in `sysdesign-website/docs/1_architecture_basics/` ordered by sidebar). Fix the mapping table below if any PDF is out of place.

- [ ] **Step 4: Write MAPPING.md (committed) capturing actual mapping**

```md
# Section 1 — PDF ↔ lesson mapping (verified)

| PDF | Lesson slug | EN source | RU source |
|---|---|---|---|
| 1-1.pdf | what-is-architecture | docs-en/.../what_is_architecture_system_design.md | docs/.../what_is_architecture_system_design_ru.md |
| 1-2.pdf | architectural-views | docs-en/.../architectural_views.md | docs/.../architectural_views_ru.md |
| 1-3.pdf | decomposition-boundaries | docs-en/.../decomposition_boundaries.md | docs/.../decomposition_boundaries_ru.md |
| 1-4.pdf | architecture-tradeoffs | docs-en/.../architecture_tradeoffs.md | docs/.../architecture_tradeoffs_ru.md |
| 1-5.pdf | evolution-change-management | docs-en/.../evolution_change_management.md | docs/.../evolution_change_management_ru.md |
| 1-6.pdf | requirements | docs-en/.../requirements.md | docs/.../requirements_ru.md |
| 1-7.pdf | quality-attributes-constraints | docs-en/.../quality_attributes_constraints.md | docs/.../quality_attributes_constraints_ru.md |
| 1-8.pdf | communication-patterns | docs-en/.../communication_patterns.md | docs/.../communication_patterns_ru.md |
```

If actual mapping differs from the hypothesis, update before committing.

- [ ] **Step 5: Copy reused images into public/**

```bash
cp /Users/razkevich/code/system_design_course/sysdesign-website/docs-en/1_architecture_basics/*.png /Users/razkevich/code/system_design_course/sysdesign-website-astro/public/images/section-1/
```

Expected: `activity.png`, `c4.png`, `hexagonal.png`, `sequence.png`, `state_machine.png` copied.

- [ ] **Step 6: Commit**

```bash
git add sysdesign-website-astro/pdfs/MAPPING.md sysdesign-website-astro/public/images/section-1/
git commit -m "verify PDF→lesson mapping and copy section 1 images"
```

---

### Tasks 17–24: Write each lesson MDX (one task per lesson)

**Per-lesson template (applies to Tasks 17 through 24):**

For each lesson, the steps below produce one MDX file. Source materials:

- `sysdesign-website-astro/pdfs/1-N.txt` — most authoritative.
- `sysdesign-website/docs/1_architecture_basics/<en_filename>_ru.md` — medium fidelity.
- `sysdesign-website/docs-en/1_architecture_basics/<en_filename>.md` — thinnest, but already in target voice.

**Translation rules (apply to every lesson):**
1. **Read the entire `1-N.txt` first.** Note any sections, examples, or callouts that are richer than the existing EN markdown.
2. Treat the existing EN file as the *structural shell*. Keep heading IDs stable so external links don't break.
3. Re-express the RU material in idiomatic English engineer prose — friendly + professional, not literal. Example transforms:
   - RU "является ключевым" → EN "matters because…" (avoid "is the key").
   - Long RU left-branching clauses → 2 short EN sentences.
4. Where the source material naturally permits, frame the example as a **multi-tenant SaaS at high load** scenario rather than an abstract one. Don't shoehorn — only when natural.
5. End with a **Recap** section (3-5 bullets).
6. Where the RU source has a "watch out / mistake / pitfall" → use `<Callout type="pitfall">`. Use `<Callout type="info">` for definitions, `tip` for advice, `warning` for things that bite in production.
7. Inline images: refer to `/images/section-1/<filename>.png`. Add descriptive alt text — translate any RU label only verbally in the alt text or surrounding caption rather than redrawing.
8. Frontmatter must satisfy the schema in `src/content/config.ts`.

---

### Task 17: Lesson 1.1 — What is Architecture and System Design

**Files:**
- Create: `sysdesign-website-astro/src/content/lessons/architecture-basics/01-what-is-architecture.mdx`

- [ ] **Step 1: Read sources**

```bash
cat /Users/razkevich/code/system_design_course/sysdesign-website-astro/pdfs/1-1.txt | less
cat /Users/razkevich/code/system_design_course/sysdesign-website/docs/1_architecture_basics/what_is_architecture_system_design_ru.md
cat /Users/razkevich/code/system_design_course/sysdesign-website/docs-en/1_architecture_basics/what_is_architecture_system_design.md
```

- [ ] **Step 2: Write `01-what-is-architecture.mdx`**

Frontmatter must look exactly like this (fill in `readingMinutes` and `summary` from the actual content):

```mdx
---
title: What is Architecture and System Design?
slug: what-is-architecture
order: 1
section: architecture-basics
group: Foundation Concepts
summary: Why architecture and system design matter for SaaS at scale, and what happens when teams skip them.
readingMinutes: 6
lastUpdated: "2026-04-25"
---

import Callout from '../../../components/Callout.astro';

[BODY GOES HERE — re-expressed English, see sources above]

## Recap

- [bullet 1]
- [bullet 2]
- [bullet 3]
```

The body must be at least as deep as `1-1.txt`, expressed in idiomatic English, with at least one `<Callout>` block where the source material warrants it, and a Recap section. Frame examples through multi-tenant SaaS scale where natural.

- [ ] **Step 3: Verify lesson builds**

```bash
cd sysdesign-website-astro && npx astro check && npx astro build
```

Expected: build succeeds; `dist/lesson/architecture-basics/what-is-architecture/index.html` exists.

- [ ] **Step 4: Spot-check in browser**

```bash
cd sysdesign-website-astro && npx astro dev
```

Visit `http://localhost:4321/lesson/architecture-basics/what-is-architecture`. Confirm: header renders, sidebar lists the lesson with order 1.1, on-page TOC populates from `<h2>` headings, prev/next disabled (only lesson so far), prose width feels right.

- [ ] **Step 5: Commit**

```bash
git add sysdesign-website-astro/src/content/lessons/architecture-basics/01-what-is-architecture.mdx
git commit -m "add lesson 1.1 — what is architecture and system design"
```

---

### Task 18: Lesson 1.2 — Architectural Views

**Files:**
- Create: `sysdesign-website-astro/src/content/lessons/architecture-basics/02-architectural-views.mdx`

Follow the same Read → Write → Verify → Commit pattern as Task 17.

- [ ] **Step 1: Read** `pdfs/1-2.txt`, `architectural_views_ru.md`, `architectural_views.md`.
- [ ] **Step 2: Write `02-architectural-views.mdx`** with frontmatter:

```mdx
---
title: Architectural Views
slug: architectural-views
order: 2
section: architecture-basics
group: Foundation Concepts
summary: 4+1, C4, hexagonal, and how to pick the right lens for the question you're answering.
readingMinutes: 8
lastUpdated: "2026-04-25"
---

import Callout from '../../../components/Callout.astro';
```

Body re-expressed from sources. Reference images via `/images/section-1/c4.png`, `/images/section-1/hexagonal.png`, `/images/section-1/sequence.png`, `/images/section-1/state_machine.png`, `/images/section-1/activity.png` — keep only the ones the source material actually uses.

- [ ] **Step 3: `npx astro check && npx astro build`** — expect success.
- [ ] **Step 4: Visit `http://localhost:4321/lesson/architecture-basics/architectural-views`** in browser. Confirm images render.
- [ ] **Step 5: Commit**

```bash
git add sysdesign-website-astro/src/content/lessons/architecture-basics/02-architectural-views.mdx
git commit -m "add lesson 1.2 — architectural views"
```

---

### Task 19: Lesson 1.3 — Decomposition and Boundaries

**Files:**
- Create: `sysdesign-website-astro/src/content/lessons/architecture-basics/03-decomposition-boundaries.mdx`

- [ ] **Step 1: Read** `pdfs/1-3.txt`, `decomposition_boundaries_ru.md`, `decomposition_boundaries.md`.
- [ ] **Step 2: Write `03-decomposition-boundaries.mdx`** — frontmatter:

```mdx
---
title: Decomposition and Boundaries
slug: decomposition-boundaries
order: 3
section: architecture-basics
group: Core Principles
summary: Coupling, cohesion, bounded contexts — how to break a SaaS platform into pieces you can actually reason about.
readingMinutes: 12
lastUpdated: "2026-04-25"
---

import Callout from '../../../components/Callout.astro';
```

- [ ] **Step 3: Build, browser-check, commit.**

```bash
cd sysdesign-website-astro && npx astro check && npx astro build
git add sysdesign-website-astro/src/content/lessons/architecture-basics/03-decomposition-boundaries.mdx
git commit -m "add lesson 1.3 — decomposition and boundaries"
```

---

### Task 20: Lesson 1.4 — Trade-offs in Software Architecture

**Files:**
- Create: `sysdesign-website-astro/src/content/lessons/architecture-basics/04-architecture-tradeoffs.mdx`

- [ ] **Step 1: Read** `pdfs/1-4.txt`, `architecture_tradeoffs_ru.md`, `architecture_tradeoffs.md`.
- [ ] **Step 2: Write `04-architecture-tradeoffs.mdx`** — frontmatter:

```mdx
---
title: Trade-offs in Software Architecture
slug: architecture-tradeoffs
order: 4
section: architecture-basics
group: Core Principles
summary: Every architectural decision is a trade-off. The frame, the language, and the failure modes.
readingMinutes: 10
lastUpdated: "2026-04-25"
---

import Callout from '../../../components/Callout.astro';
```

- [ ] **Step 3: Build, browser-check, commit.**

```bash
cd sysdesign-website-astro && npx astro check && npx astro build
git add sysdesign-website-astro/src/content/lessons/architecture-basics/04-architecture-tradeoffs.mdx
git commit -m "add lesson 1.4 — architecture trade-offs"
```

---

### Task 21: Lesson 1.5 — Evolution and Change Management

**Files:**
- Create: `sysdesign-website-astro/src/content/lessons/architecture-basics/05-evolution-change-management.mdx`

- [ ] **Step 1: Read** `pdfs/1-5.txt`, `evolution_change_management_ru.md`, `evolution_change_management.md`.
- [ ] **Step 2: Write `05-evolution-change-management.mdx`** — frontmatter:

```mdx
---
title: Evolution and Change Management
slug: evolution-change-management
order: 5
section: architecture-basics
group: Core Principles
summary: Architectures that survive long enough to matter. Evolutionary design, fitness functions, and change without panic.
readingMinutes: 11
lastUpdated: "2026-04-25"
---

import Callout from '../../../components/Callout.astro';
```

- [ ] **Step 3: Build, browser-check, commit.**

```bash
cd sysdesign-website-astro && npx astro check && npx astro build
git add sysdesign-website-astro/src/content/lessons/architecture-basics/05-evolution-change-management.mdx
git commit -m "add lesson 1.5 — evolution and change management"
```

---

### Task 22: Lesson 1.6 — Requirements Gathering

**Files:**
- Create: `sysdesign-website-astro/src/content/lessons/architecture-basics/06-requirements.mdx`

- [ ] **Step 1: Read** `pdfs/1-6.txt`, `requirements_ru.md`, `requirements.md`.
- [ ] **Step 2: Write `06-requirements.mdx`** — frontmatter:

```mdx
---
title: Requirements Gathering
slug: requirements
order: 6
section: architecture-basics
group: Core Principles
summary: Functional, non-functional, and the questions you should ask before drawing any boxes.
readingMinutes: 8
lastUpdated: "2026-04-25"
---

import Callout from '../../../components/Callout.astro';
```

- [ ] **Step 3: Build, browser-check, commit.**

```bash
cd sysdesign-website-astro && npx astro check && npx astro build
git add sysdesign-website-astro/src/content/lessons/architecture-basics/06-requirements.mdx
git commit -m "add lesson 1.6 — requirements gathering"
```

---

### Task 23: Lesson 1.7 — Quality Attributes and Constraints

**Files:**
- Create: `sysdesign-website-astro/src/content/lessons/architecture-basics/07-quality-attributes-constraints.mdx`

- [ ] **Step 1: Read** `pdfs/1-7.txt`, `quality_attributes_constraints_ru.md`, `quality_attributes_constraints.md`.
- [ ] **Step 2: Write `07-quality-attributes-constraints.mdx`** — frontmatter:

```mdx
---
title: Quality Attributes and Constraints
slug: quality-attributes-constraints
order: 7
section: architecture-basics
group: Core Principles
summary: Performance, scalability, reliability, security — naming the things you actually care about.
readingMinutes: 7
lastUpdated: "2026-04-25"
---

import Callout from '../../../components/Callout.astro';
```

- [ ] **Step 3: Build, browser-check, commit.**

```bash
cd sysdesign-website-astro && npx astro check && npx astro build
git add sysdesign-website-astro/src/content/lessons/architecture-basics/07-quality-attributes-constraints.mdx
git commit -m "add lesson 1.7 — quality attributes and constraints"
```

---

### Task 24: Lesson 1.8 — Communication Patterns

**Files:**
- Create: `sysdesign-website-astro/src/content/lessons/architecture-basics/08-communication-patterns.mdx`

- [ ] **Step 1: Read** `pdfs/1-8.txt`, `communication_patterns_ru.md`, `communication_patterns.md`.
- [ ] **Step 2: Write `08-communication-patterns.mdx`** — frontmatter:

```mdx
---
title: Communication Patterns
slug: communication-patterns
order: 8
section: architecture-basics
group: Core Principles
summary: Sync, async, request/reply, pub/sub — choosing the right shape for service-to-service traffic.
readingMinutes: 7
lastUpdated: "2026-04-25"
---

import Callout from '../../../components/Callout.astro';
```

- [ ] **Step 3: Build, browser-check, commit.**

```bash
cd sysdesign-website-astro && npx astro check && npx astro build
git add sysdesign-website-astro/src/content/lessons/architecture-basics/08-communication-patterns.mdx
git commit -m "add lesson 1.8 — communication patterns"
```

---

## Phase 5 — Search, polish, deploy (Tasks 25–28)

### Task 25: Search across Section 1 (Fuse.js, build-time index)

**Files:**
- Create: `sysdesign-website-astro/src/lib/searchIndex.ts`
- Create: `sysdesign-website-astro/src/lib/searchIndex.test.ts`
- Create: `sysdesign-website-astro/src/components/SearchWidget.tsx`
- Create: `sysdesign-website-astro/src/pages/search-index.json.ts`
- Modify: `sysdesign-website-astro/src/components/Navbar.astro` (mount widget)

- [ ] **Step 1: Write the failing test for `buildSearchIndex`**

```ts
// src/lib/searchIndex.test.ts
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
```

- [ ] **Step 2: Run test (expect FAIL)**

```bash
cd sysdesign-website-astro && npx vitest run src/lib/searchIndex.test.ts
```

- [ ] **Step 3: Implement `buildSearchIndex`**

```ts
// src/lib/searchIndex.ts
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
```

- [ ] **Step 4: Run test (expect PASS)**

```bash
cd sysdesign-website-astro && npx vitest run src/lib/searchIndex.test.ts
```

- [ ] **Step 5: Emit search-index.json at build time**

```ts
// src/pages/search-index.json.ts
import type { APIRoute } from 'astro';
import { getCollection } from 'astro:content';
import { buildSearchIndex } from '../lib/searchIndex';

export const GET: APIRoute = async () => {
  const lessons = await getCollection('lessons');
  const records = buildSearchIndex(lessons);
  return new Response(JSON.stringify(records), {
    headers: { 'Content-Type': 'application/json' },
  });
};
```

- [ ] **Step 6: Write SearchWidget.tsx**

```tsx
// src/components/SearchWidget.tsx
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
```

- [ ] **Step 7: Mount the widget in Navbar.astro**

In `src/components/Navbar.astro`, modify the imports and add the widget before `<ThemeToggle />`:

```astro
---
import ThemeToggle from './ThemeToggle.tsx';
import SearchWidget from './SearchWidget.tsx';
---
```

And inside the nav, just before `<ThemeToggle client:load />`:

```astro
<SearchWidget client:load />
```

- [ ] **Step 8: Build + browser-check**

```bash
cd sysdesign-website-astro && npx astro build && npx astro preview
```

In the browser, press ⌘K (or click "Search"), type a word from any lesson title, confirm results appear and links navigate correctly.

- [ ] **Step 9: Commit**

```bash
git add sysdesign-website-astro/src/lib/searchIndex.ts sysdesign-website-astro/src/lib/searchIndex.test.ts sysdesign-website-astro/src/pages/search-index.json.ts sysdesign-website-astro/src/components/SearchWidget.tsx sysdesign-website-astro/src/components/Navbar.astro
git commit -m "add Fuse.js search across Section 1 lessons"
```

---

### Task 26: Manual QA pass — desktop + mobile + dark mode

**Files:** none (manual verification)

- [ ] **Step 1: Build and serve**

```bash
cd sysdesign-website-astro && npx astro build && npx astro preview
```

- [ ] **Step 2: Desktop QA (≥1280 wide)**

Visit each route and verify:

- `/` — hero gradient, 7 cards (1 ready + 6 coming-soon), CTA buttons work.
- `/course` — Section 1 lessons listed; sections 2-7 greyed.
- `/section/architecture-basics` — gradient header, 8 lesson cards in 2 groups, "Start with 1.1 →" CTA navigates correctly.
- `/lesson/architecture-basics/<each slug>` for all 8 — three columns visible, sidebar highlights current, on-page TOC scroll-spy works on long pages, prev/next correct (1.1 has no prev, 1.8 has no next), images load, callouts render.

- [ ] **Step 3: Mobile QA (≤640 wide, use browser devtools)**

- Sidebar collapses behind floating "Lessons" button.
- TOC hides on mobile (`hidden lg:block`).
- Prose remains readable (no horizontal scroll).
- Theme toggle still reachable.

- [ ] **Step 4: Dark mode QA**

Toggle theme. Verify:

- No flash of light theme on page reload (FOUC script in `BaseLayout.astro`).
- Callouts have appropriate dark variants.
- Images don't look washed out (light PNGs on dark backgrounds — accept or fix per image; if any image looks bad, wrap in `<figure class="bg-white rounded p-2">` in the relevant lesson MDX).

- [ ] **Step 5: Fix anything broken**

Apply targeted edits. Re-run `astro build`, re-verify. Commit each fix individually:

```bash
git add <files>
git commit -m "fix: <specific issue>"
```

If everything passes:

```bash
git commit --allow-empty -m "qa: section 1 manual pass complete"
```

---

### Task 27: DigitalOcean App Platform spec + deploy

**Files:**
- Create: `sysdesign-website-astro/.do/app.yaml`

- [ ] **Step 1: Push current branch to GitHub**

```bash
cd /Users/razkevich/code/system_design_course && git push origin main
```

Expected: GitHub has the latest commits.

- [ ] **Step 2: Write `.do/app.yaml`**

```yaml
name: sysdesign-course
region: nyc
static_sites:
  - name: web
    github:
      repo: razkevich/system_design_course
      branch: main
      deploy_on_push: true
    source_dir: sysdesign-website-astro
    build_command: npm ci && npm run build
    output_dir: dist
    environment_slug: node-js
    catchall_document: 404.html
```

- [ ] **Step 3: Validate spec**

```bash
doctl apps spec validate sysdesign-website-astro/.do/app.yaml
```

Expected: "Spec is valid." If validation fails, read the error and adjust.

- [ ] **Step 4: Create the app**

```bash
doctl apps create --spec sysdesign-website-astro/.do/app.yaml --wait
```

This may take 3–8 minutes. Watch for "App creation succeeded." Note the app ID and `live_url` from the output.

- [ ] **Step 5: Verify the live URL**

```bash
APP_ID=$(doctl apps list --format ID --no-header | head -1)
doctl apps get $APP_ID --format LiveURL --no-header
```

Visit the printed `*.ondigitalocean.app` URL. Confirm: landing page renders, all 8 lesson pages reachable, CSS loads.

- [ ] **Step 6: Commit and push**

```bash
git add sysdesign-website-astro/.do/app.yaml
git commit -m "add DO App Platform spec for sysdesign-course"
git push origin main
```

- [ ] **Step 7: Verify auto-deploy works**

Make one trivial change (e.g., bump a dot in the footer copyright line) and push:

```bash
# Edit Footer.astro slightly
git add sysdesign-website-astro/src/components/Footer.astro
git commit -m "test: trivial change to verify auto-deploy"
git push origin main
```

Watch the DO dashboard or:

```bash
doctl apps list-deployments $APP_ID
```

A new deployment should appear and reach "ACTIVE" within a few minutes.

---

### Task 28: Wrap-up — README and handoff

**Files:**
- Create: `sysdesign-website-astro/README.md`

- [ ] **Step 1: Write README.md**

```md
# System Design Course — Astro site

Free, English-language system design course focused on multi-tenant SaaS at high load.

**Live:** [URL from `doctl apps list`]

## Local development

```bash
npm install
npm run dev      # http://localhost:4321
npm run build    # → dist/
npm run preview  # preview production build
npm run check    # astro + tsc
npm test         # vitest
```

## Project layout

- `src/content/sections/` — section metadata
- `src/content/lessons/<section>/` — lesson MDX
- `src/components/` — Astro + React components
- `src/layouts/` — `BaseLayout`, `LessonLayout`
- `src/lib/` — pure utils with Vitest tests
- `src/pages/` — routes (`/`, `/course`, `/section/[slug]`, `/lesson/[section]/[lesson]`)
- `public/images/section-1/` — reused diagrams
- `pdfs/` — RU source PDFs (gitignored)

## Adding a new lesson

1. Create `src/content/lessons/<section>/NN-<slug>.mdx` with frontmatter matching `src/content/config.ts`.
2. `npm run check` to validate frontmatter.
3. `npm run build` to render the new route.

## Adding a new section

1. Create `src/content/sections/<slug>.md`. Set `status: ready` only when at least one lesson is published.
2. Add lessons under `src/content/lessons/<slug>/`.

## Deployment

DigitalOcean App Platform (static site, free tier). Spec at `.do/app.yaml`. Pushes to `main` auto-deploy.
```

- [ ] **Step 2: Commit and push**

```bash
git add sysdesign-website-astro/README.md
git commit -m "add README for the new Astro site"
git push origin main
```

---

## Self-Review

- [x] **Spec coverage:** every section in `2026-04-25-sysdesign-course-astro-design.md` has at least one task. Routes ✓, components (kept + new) ✓, content pipeline ✓, deployment ✓, acceptance criteria ✓.
- [x] **Placeholder scan:** no "TBD" / "implement later" / "similar to". One known unknown — the per-lesson MDX bodies (Tasks 17–24) are intentionally written by the implementer at execution time from the verified RU sources, but each task has explicit *rules* (see Tasks 17–24 preamble) and a working template, not a placeholder.
- [x] **Type consistency:** `TocEntry` used in `tocFromHtml.ts` and `OnPageTOC.tsx` ✓. `SidebarLesson` used in `CourseSidebar.tsx` and constructed in `LessonLayout.astro` ✓. `SearchRecord` used in `searchIndex.ts`, `SearchWidget.tsx`, and `search-index.json.ts` ✓. Frontmatter schema in `config.ts` matches every lesson MDX example ✓. `readingMinutes` (not `readingTime`) used everywhere ✓.

---

**Plan complete.** 28 tasks, ~1500 LOC, ~8 lessons of content writing. Acceptance gate is the live `*.ondigitalocean.app` URL with all 8 lessons reachable, sidebar+TOC+prev/next working, dark mode + search functional, and one auto-deploy verified.
