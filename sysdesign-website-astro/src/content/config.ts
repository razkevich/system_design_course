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
    section: z.string(),
    summary: z.string(),
    readingMinutes: z.number().int().positive(),
    lastUpdated: z.string(),
    group: z.string().optional(),
  }),
});

export const collections = { sections, lessons };
