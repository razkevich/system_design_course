import { describe, expect, it } from 'vitest';
import { withBase } from './withBase';

describe('withBase', () => {
  it('leaves root-relative paths alone when the site is served from /', () => {
    expect(withBase('/course', '/')).toBe('/course');
    expect(withBase('/', '/')).toBe('/');
  });

  it('prefixes project-site paths for GitHub Pages', () => {
    expect(withBase('/course', '/system_design_course/')).toBe('/system_design_course/course');
    expect(withBase('/lesson/distributed-systems/cap', '/system_design_course/')).toBe(
      '/system_design_course/lesson/distributed-systems/cap',
    );
    expect(withBase('/', '/system_design_course/')).toBe('/system_design_course/');
  });

  it('does not rewrite external or relative urls', () => {
    expect(withBase('https://github.com/razkevich/system_design_course', '/system_design_course/')).toBe(
      'https://github.com/razkevich/system_design_course',
    );
    expect(withBase('#section', '/')).toBe('#section');
  });
});
