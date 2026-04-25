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
