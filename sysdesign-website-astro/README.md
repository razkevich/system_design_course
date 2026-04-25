# System Design Course — Astro site

Free, English-language system design course focused on multi-tenant SaaS at high load.

**Live:** https://sysdesign-course-t83nq.ondigitalocean.app

## Local development

```bash
npm install
npm run dev      # http://localhost:4321
npm run build    # → dist/
npm run preview  # preview the production build
npm run check    # astro + tsc
npm test         # vitest
```

## Project layout

- `src/content/sections/` — section metadata (one MD file per section).
- `src/content/lessons/<section>/` — lesson MDX files.
- `src/components/` — Astro and React components.
- `src/layouts/` — `BaseLayout`, `LessonLayout`.
- `src/lib/` — pure utilities with Vitest tests.
- `src/pages/` — routes (`/`, `/course`, `/section/[slug]`, `/lesson/[section]/[lesson]`).
- `public/images/section-1/` — reused diagrams.
- `pdfs/` — Russian source PDFs and OCR output (gitignored).

## Adding a new lesson

1. Create `src/content/lessons/<section>/NN-<slug>.mdx` with frontmatter matching the schema in `src/content.config.ts`.
2. `npm run check` to validate frontmatter.
3. `npm run build` to render the new route.

## Adding a new section

1. Create `src/content/sections/<slug>.md`. Set `status: ready` only when at least one lesson is published.
2. Add lessons under `src/content/lessons/<slug>/`.

## Deployment

DigitalOcean App Platform (static site, free tier). Spec at `.do/app.yaml`. Pushes to `main` auto-deploy.

```bash
doctl apps spec validate .do/app.yaml
doctl apps create --spec .do/app.yaml --wait
```
