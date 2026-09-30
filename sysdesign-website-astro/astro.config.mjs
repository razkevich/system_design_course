import { defineConfig } from 'astro/config';
import react from '@astrojs/react';
import mdx from '@astrojs/mdx';
import tailwindcss from '@tailwindcss/vite';

// Project Pages: BASE_PATH=/system_design_course
// Root hosts (DigitalOcean): leave BASE_PATH unset.
const basePath = (process.env.BASE_PATH || '/').replace(/\/$/, '') || '/';

/** Rewrite root-relative markdown links and images so GitHub Pages project sites work. */
function remarkRewriteRootUrls() {
  const prefix = basePath === '/' ? '' : basePath;
  return (tree) => {
    if (!prefix) return;
    const walk = (node) => {
      if (!node || typeof node !== 'object') return;
      if (
        (node.type === 'image' || node.type === 'link') &&
        typeof node.url === 'string' &&
        node.url.startsWith('/') &&
        !node.url.startsWith('//')
      ) {
        node.url = prefix + node.url;
      }
      if (Array.isArray(node.children)) node.children.forEach(walk);
    };
    walk(tree);
  };
}

export default defineConfig({
  site: process.env.SITE,
  base: basePath,
  output: 'static',
  integrations: [react(), mdx()],
  vite: {
    plugins: [tailwindcss()],
  },
  markdown: {
    remarkPlugins: [remarkRewriteRootUrls],
    shikiConfig: {
      themes: { light: 'github-light', dark: 'github-dark' },
    },
  },
});
