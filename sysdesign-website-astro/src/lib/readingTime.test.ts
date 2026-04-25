import { describe, expect, it } from 'vitest';
import { readingMinutes } from './readingTime';

describe('readingMinutes', () => {
  it('returns at least 1 minute for very short text', () => {
    expect(readingMinutes('hello world')).toBe(1);
  });

  it('rounds up to the nearest minute at 200 wpm', () => {
    const text = Array(401).fill('word').join(' ');
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
