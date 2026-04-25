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
