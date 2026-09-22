import { gzipSync } from "node:zlib";
import { readFile, readdir } from "node:fs/promises";
import { join, relative, resolve, sep } from "node:path";

const themeRoot = resolve(import.meta.dirname, "..");
const payloadRoot = join(themeRoot, "theme");
const pagesRoot = join(themeRoot, "pages");

function portablePath(path: string): string {
  return path.split(sep).join("/");
}

async function walkFiles(root: string): Promise<string[]> {
  const entries = await readdir(root, { withFileTypes: true });
  const files: string[] = [];
  for (const entry of entries) {
    const path = join(root, entry.name);
    if (entry.isDirectory()) files.push(...await walkFiles(path));
    else if (entry.isFile()) files.push(path);
  }
  return files;
}

function assert(condition: unknown, message: string): asserts condition {
  if (!condition) throw new Error(message);
}

function isYoungcartPath(path: string): boolean {
  const parts = path.split("/");
  return path === "js/theme.shop.list.js"
    || parts.some((part) => part === "shop" || part.startsWith("shop_"))
    || path.includes("_shop.");
}

async function main(): Promise<void> {
  const inventory = JSON.parse(await readFile(join(themeRoot, "docs/BASIC-INVENTORY.json"), "utf8")) as {
    files: Array<{ path: string; area: string }>;
  };
  const files = (await walkFiles(payloadRoot)).map((path) => portablePath(relative(payloadRoot, path))).sort();
  const pageFiles = (await walkFiles(pagesRoot)).map((path) => portablePath(relative(pagesRoot, path))).sort();
  const fileSet = new Set(files);
  const inherited = inventory.files.filter((file) => !isYoungcartPath(file.path) && file.path !== "screenshot.png");

  for (const file of inherited) assert(fileSet.has(file.path), `community payload file is missing: ${file.path}`);
  for (const file of inventory.files.filter((entry) => isYoungcartPath(entry.path))) {
    assert(!fileSet.has(file.path), `Youngcart file entered the payload: ${file.path}`);
  }
  assert(!fileSet.has("screenshot.png"), "inherited basic screenshot must not enter the payload");
  assert(!files.some((path) => path.endsWith(".map") || path.includes("node_modules")), "development file entered the payload");
  assert(pageFiles.length === 76, `expected 75 page routes and one catalog, found ${pageFiles.length}`);
  assert(pageFiles.includes("index.php"), "page catalog route is missing");
  assert(pageFiles.filter((path) => path !== "index.php").every((path) => /^[a-z][a-z0-9-]*-[1-5]\.php$/.test(path)), "invalid generated page route name");

  const cssPath = join(payloadRoot, "css/jw-business.min.css");
  const jsPath = join(payloadRoot, "js/jw-business.min.js");
  const [css, js] = await Promise.all([readFile(cssPath, "utf8"), readFile(jsPath, "utf8")]);
  assert(css.includes("data-theme=jw-light") && css.includes("data-theme=jw-dark"), "jw-light/jw-dark themes are missing");
  assert(
    !css.includes("data-theme=corporate")
      && !css.includes("data-theme=business")
      && !css.includes("data-theme=cupcake")
      && !css.includes("data-theme=light"),
    "an unapproved DaisyUI theme entered the CSS",
  );
  assert(css.includes("Pretendard Variable"), "Pretendard font faces are missing");
  assert(css.includes(".tw\\:d-btn"), "Tailwind and DaisyUI prefixes are not combined as tw:d-*");
  assert(css.includes("url(../fonts/"), "font URLs must be relative to the installed theme CSS");
  assert(!css.includes("url(/fonts/"), "absolute font URLs would escape the installed theme directory");
  assert(!/url\(["']?https?:/i.test(css), "remote CSS asset URL is forbidden");
  assert(!js.includes("sourceMappingURL"), "source map reference entered the JavaScript");

  const fontFiles = files.filter((path) => path.startsWith("fonts/") && path.endsWith(".woff2"));
  assert(fontFiles.length === 92, `expected 92 Pretendard subsets, found ${fontFiles.length}`);

  const cssGzip = gzipSync(css).byteLength;
  const jsGzip = gzipSync(js).byteLength;
  assert(cssGzip <= 90 * 1024, `CSS gzip budget exceeded: ${cssGzip} bytes`);
  assert(jsGzip <= 80 * 1024, `JavaScript gzip budget exceeded: ${jsGzip} bytes`);

  const manifest = JSON.parse(await readFile(join(themeRoot, "ASSET-MANIFEST.json"), "utf8")) as { assets: unknown[] };
  assert(manifest.assets.length > fontFiles.length, "asset manifest does not cover built and inherited assets");

  console.log(JSON.stringify({
    payloadFiles: files.length,
    pageFiles: pageFiles.length,
    inheritedFiles: inherited.length,
    registeredAssets: manifest.assets.length,
    fontFiles: fontFiles.length,
    cssGzip,
    jsGzip
  }, null, 2));
}

await main();
