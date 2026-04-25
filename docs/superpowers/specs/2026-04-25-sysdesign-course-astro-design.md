# System Design Course — Astro Site (Section 1 first)

**Date:** 2026-04-25
**Author:** Alex Razkevich
**Status:** Approved (chunks 1-3) — moving to implementation plan

## Goals

1. **Portfolio piece** for engineering interviews. Looks polished, signals serious engineering, easy to skim in 60 seconds.
2. **Free teaching resource** for the user and others. Easy to navigate, easy to read, easy to come back to.

The primary subject framing is **multi-tenant SaaS systems at high load** — the patterns and trade-offs that actually matter when you're shipping a SaaS product to thousands of paying tenants.

## Scope (this iteration)

- Section 1 (*Architecture Basics*) only, end-to-end. 8 lessons.
- Sections 2-7 surface in the UI as "coming soon" cards, links disabled.
- Build, content pipeline, deploy, all of it complete for Section 1 before generalizing.

The existing Docusaurus site at `sysdesign-website/` stays intact as a reference. The new site lives in `sysdesign-website-astro/`.

## Tech

- Astro 6, React 19, Tailwind v4 (matches the user's other repo `sysdesign-course` for muscle-memory consistency).
- Astro Content Collections (zod schemas) for `sections` and `lessons`.
- MDX for lesson content so we can use `<Callout>` components inline.
- Fuse.js for client-side search across Section 1 lessons (build-time index).
- No PDF viewer, no video embeds, no quizzes, no bookmarks (all in source repo, not used here).

## Visual direction (hybrid)

- **Index / landing / section hub:** bytebytego-ish — gradient hero, card grid, generous whitespace, slightly playful, optimized for "wow in 5 seconds."
- **Lesson reading view:** hellointerview-calm — quiet typography, ~70ch prose width, one accent color, scroll-spy TOC, dense but breathable. Optimized for actual reading.
- Dark mode via Tailwind `dark:`, system-default with toggle.

## Routes & pages

| Route | Purpose |
|---|---|
| `/` | Landing: hero, byline (Alex Razkevich), credibility bar, 7-section card grid (only Section 1 active). |
| `/course` | Full table of contents. Section 1 expanded; rest greyed-out. |
| `/section/architecture-basics` | Section 1 hub: gradient header, intro paragraph, two grouped lesson lists (Foundation Concepts, Core Principles), each row links to a lesson. |
| `/lesson/architecture-basics/<slug>` | Lesson reader. 3 columns desktop (course sidebar / prose / on-page TOC). On mobile: hamburger reveals sidebar+TOC; prose full width. |

ASCII layouts captured in conversation; will live in `sysdesign-website-astro/README.md` for future reference.

## Components

**Reused (cherry-picked from `/Users/razkevich/code/sysdesign-course/src/components`):**
Navbar, Hero, Footer, CredibilityBar, ModuleCardsGrid, CourseSidebar, LessonContent (renamed), SearchWidget.

**New:**
- `OnPageTOC.tsx` — scroll-spy right rail, parses `<h2>`/`<h3>` from current article.
- `PrevNextNav.astro` — bottom of every lesson, resolved from content-collection order.
- `Callout.astro` — variants: `info`, `tip`, `warning`, `pitfall`.
- `LessonHeader.astro` — title + reading time + last-updated.

**Skipped (intentionally):** PdfViewer, IntroVideo, BookmarksList, Quiz, ProgramAccordion.

## Content pipeline (run once per lesson, not at build time)

For each lesson 1-N (N ∈ 1..8):

1. `gog -a razkevich8@gmail.com drive download <id>` to `pdfs/1-N.pdf`.
2. `pdftotext -layout pdfs/1-N.pdf pdfs/1-N.txt`.
3. **Read the full text.** Treat the RU PDF as the most authoritative source.
4. Cross-reference with `sysdesign-website/docs/1_architecture_basics/<slug>_ru.md` (medium fidelity) and `sysdesign-website/docs-en/1_architecture_basics/<slug>.md` (thinnest, but already in target voice).
5. Produce a single English MDX file in `src/content/lessons/architecture-basics/NN-<slug>.mdx`:
   - Keep the existing EN article's structural shell and section IDs.
   - Fold in richer explanations, examples, and asides from the RU PDF / RU markdown wherever the RU material is deeper.
   - **Re-express, don't translate literally.** Idiomatic English engineer-friendly prose. Friendly + professional. Avoid RU sentence shapes (long left-branching clauses, abstract nouns) that read awkward in English.
   - Surface the SaaS multi-tenant / high-load framing wherever the source material has a natural hook.
   - Convert RU inline callouts into `<Callout type="…">` MDX blocks.
6. Frontmatter: `title`, `slug`, `order`, `section`, `readingTime` (auto from word count), `summary`, `lastUpdated`.
7. Re-link images from existing PNGs (`activity.png`, `c4.png`, `hexagonal.png`, `sequence.png`, `state_machine.png`) — copy into `public/images/section-1/`. Reuse as-is unless an image has RU labels that hurt comprehension; flag those for review rather than redrawing.

### PDF ↔ lesson hypothesis (Section 1)

| PDF | Lesson slug |
|---|---|
| `1-1.pdf` | what-is-architecture |
| `1-2.pdf` | architectural-views |
| `1-3.pdf` | decomposition-boundaries |
| `1-4.pdf` | architecture-tradeoffs |
| `1-5.pdf` | evolution-change-management |
| `1-6.pdf` | requirements |
| `1-7.pdf` | quality-attributes-constraints |
| `1-8.pdf` | communication-patterns |

Verified by reading PDF headers before translation begins. Re-map if a header doesn't match.

### Quality gates per lesson

- Reads start-to-finish without jargon dumps.
- One concrete example per major concept (preferably SaaS / multi-tenant flavored).
- Recap section at the end (3-5 bullets).
- A `pitfall` callout where the source has one.
- Internal links updated to new Astro slugs.

### Explicit non-goals

- No new diagrams.
- No literal translation.
- No quizzes, PDFs, or videos.
- No content for sections 2-7 in this iteration.

## Repo layout

```
system_design_course/
├── sysdesign-website/                  ← existing Docusaurus, untouched
└── sysdesign-website-astro/            ← NEW
    ├── astro.config.mjs
    ├── package.json
    ├── tsconfig.json
    ├── .do/app.yaml                    ← DO App Platform spec
    ├── public/
    │   ├── favicon.svg
    │   └── images/section-1/
    ├── src/
    │   ├── content/
    │   │   ├── config.ts
    │   │   ├── sections/
    │   │   │   └── 1-architecture-basics.md
    │   │   └── lessons/
    │   │       └── architecture-basics/
    │   │           └── 01-what-is-architecture.mdx … 08-communication-patterns.mdx
    │   ├── components/        (Navbar, Hero, Footer, ModuleCardsGrid,
    │   │                       CourseSidebar, OnPageTOC, LessonHeader,
    │   │                       PrevNextNav, Callout, SearchWidget)
    │   ├── layouts/           (BaseLayout, LessonLayout)
    │   ├── pages/             (index, course, section/[slug], lesson/[section]/[lesson])
    │   └── styles/global.css
    └── pdfs/                  ← gitignored scratch dir
```

## Deployment

DigitalOcean App Platform — Static Site (free tier).

1. Commit `sysdesign-website-astro/` plus `.do/app.yaml` to `main`.
2. `doctl apps create --spec .do/app.yaml` — App Platform pulls from GitHub `razkevich/system_design_course`, builds from `sysdesign-website-astro/`, serves `dist/`.
3. Default URL: `*.ondigitalocean.app`.
4. Custom domain attachment is a follow-up; out of scope for this iteration.

## Acceptance — "Section 1 done"

- Live `*.ondigitalocean.app` URL with `/`, `/course`, `/section/architecture-basics`, and 8 lesson pages reachable and styled.
- Sidebar, on-page TOC, prev/next, dark-mode toggle, search across Section 1 — all working.
- Each lesson is at least as deep as its RU PDF and reads as natural English.
- Auto-deploy on push to `main` confirmed by one trivial follow-up commit landing live.
- User reviews and signs off before any work begins on Sections 2-7.
