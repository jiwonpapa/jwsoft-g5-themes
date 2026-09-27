import { test, expect } from 'bun:test';
import { sections } from './gallery/build';
test('section extraction retains nested markup and source PHP without rendering it', () => {
  expect(sections('<main><section>A<section><?php echo $x; ?></section></section><section>B</section></main>')).toEqual(['<section>A<section><?php echo $x; ?></section></section>', '<section>B</section>']);
});
