# System Design Course — Astro site

Free, English-language system design course focused on multi-tenant SaaS at high load.

**Canonical English site.** Public URL: https://razkevich.github.io/system_design_course/

GitHub Actions builds this directory and deploys GitHub Pages. See the repo README for the one-time Pages setting and for how this catalog differs from the Russian Docusaurus site.

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
- `public/images/` — lesson diagrams (section 1, sharding, CAP, cache, AWS, DDD, Kubernetes).
- `pdfs/` — Russian source PDFs and OCR output (gitignored).

## Adding a new lesson

1. Create `src/content/lessons/<section>/NN-<slug>.mdx` with frontmatter matching the schema in `src/content.config.ts`.
2. `npm run check` to validate frontmatter.
3. `npm run build` to render the new route.

## Adding a new section

1. Create `src/content/sections/<slug>.md`. Set `status: ready` only when at least one lesson is published.
2. Add lessons under `src/content/lessons/<slug>/`.

## Deployment

GitHub Pages, project site for `razkevich/system_design_course`.

Workflow: `../.github/workflows/deploy-astro-pages.yml`. It runs `npm ci`, tests, and `npm run build` with:

```bash
BASE_PATH=/system_design_course
SITE=https://razkevich.github.io
```

Pages source must be **GitHub Actions** (Settings → Pages). The site is then:

https://razkevich.github.io/system_design_course/

Leave `BASE_PATH` unset for a root-hosted build. `.do/app.yaml` is the older DigitalOcean spec and is not the English publish path.
