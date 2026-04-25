import { defineCollection, z } from 'astro:content';
import { glob } from 'astro/loaders';

const sections = defineCollection({
  loader: glob({ pattern: '**/*.md', base: './src/content/sections' }),
  schema: z.object({
    slug: z.string(),
    order: z.number().int().positive(),
    title: z.string(),
    summary: z.string(),
    status: z.enum(['ready', 'coming-soon']),
  }),
});

const lessons = defineCollection({
  loader: glob({ pattern: '**/*.{md,mdx}', base: './src/content/lessons' }),
  schema: z.object({
    title: z.string(),
    slug: z.string(),
    order: z.number().int().positive(),
    section: z.string(),
    summary: z.string(),
    readingMinutes: z.number().int().positive(),
    lastUpdated: z.string(),
    group: z.string().optional(),
  }),
});

export const collections = { sections, lessons };
