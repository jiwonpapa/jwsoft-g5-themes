import { gzipSync } from "node:zlib";
import { readFile, readdir } from "node:fs/promises";
import { join, relative, resolve, sep } from "node:path";

const themeRoot = resolve(import.meta.dirname, "..");
const payloadRoot = join(themeRoot, "theme");
const pagesRoot = join(themeRoot, "pages");
const supersededCommunityPaths = new Set([
  "mobile/skin/latest/basic/latest.carousel.js",
  "mobile/skin/latest/basic/style.css",
  "mobile/skin/latest/notice/style.css",
  "skin/board/basic/style.css",
  "skin/board/gallery/style.css",
  "skin/latest/basic/style.css",
  "skin/latest/notice/style.css",
  "skin/latest/pic_basic/latest.skin.php",
  "skin/latest/pic_basic/style.css",
  "skin/latest/pic_block/latest.skin.php",
  "skin/latest/pic_block/style.css",
  "skin/latest/pic_list/latest.skin.php",
  "skin/latest/pic_list/style.css",
]);
const boardSkins = ["basic", "gallery", "portfolio", "webzine", "download", "video"];
const latestSkins = ["basic", "notice", "image-list", "image-grid", "featured", "slider", "tabs", "video"];

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
  const inherited = inventory.files.filter((file) => !isYoungcartPath(file.path)
    && file.path !== "screenshot.png"
    && !supersededCommunityPaths.has(file.path));

  for (const file of inherited) assert(fileSet.has(file.path), `community payload file is missing: ${file.path}`);
  for (const file of inventory.files.filter((entry) => isYoungcartPath(entry.path))) {
    assert(!fileSet.has(file.path), `Youngcart file entered the payload: ${file.path}`);
  }
  assert(!fileSet.has("screenshot.png"), "inherited basic screenshot must not enter the payload");
  assert(!files.some((path) => path.endsWith(".map") || path.includes("node_modules")), "development file entered the payload");
  for (const skin of boardSkins) {
    for (const root of ["skin/board", "mobile/skin/board"]) {
      for (const file of ["list.skin.php", "view.skin.php", "view_comment.skin.php", "write.skin.php"]) {
        assert(fileSet.has(`${root}/${skin}/${file}`), `board skin file is missing: ${root}/${skin}/${file}`);
      }
    }
  }
  for (const skin of latestSkins) {
    assert(fileSet.has(`skin/latest/${skin}/latest.skin.php`), `PC latest skin is missing: ${skin}`);
    assert(fileSet.has(`mobile/skin/latest/${skin}/latest.skin.php`), `mobile latest skin is missing: ${skin}`);
  }
  for (const path of supersededCommunityPaths) assert(!fileSet.has(path), `superseded legacy file entered the payload: ${path}`);
  assert(pageFiles.length === 74, `expected 70 general pages, 3 onepages and one catalog, found ${pageFiles.length}`);
  assert(pageFiles.includes("index.php"), "page catalog route is missing");
  assert(pageFiles.filter((path) => path !== "index.php").every((path) => /^[a-z][a-z0-9-]*-[1-5]\.php$/.test(path) || /^onepage-(showcase|services|projects)\.php$/.test(path)), "invalid standalone page route name");
  assert(!pageFiles.some((path) => /^home-[1-5]\.php$/.test(path)), "home variants must stay in the theme root");

  const cssPath = join(payloadRoot, "css/jw-business.min.css");
  const jsPath = join(payloadRoot, "js/jw-business.min.js");
  const homeCssPath = join(payloadRoot, "css/home-one.min.css");
  const homeJsPath = join(payloadRoot, "js/home-one.min.js");
  for (const path of ["css/home-four.min.css", "js/home-four.min.js", "assets/home-four/hero.webp", "assets/home-four/discovery.webp", "assets/home-four/digital.webp", "assets/home-four/handoff.webp",
    "css/onepages.min.css", "js/onepages.min.js", "assets/home-three/mobility.webp", "assets/home-three/print.webp", "assets/home-three/exhibition.webp",
    "onepages/assets/images/service-workshop.webp", "onepages/assets/images/courtyard-colonnade.webp",
    "onepages/assets/images/aura-hero.webp", "onepages/assets/images/aura-detail.webp", "onepages/assets/images/aura-living.webp", "onepages/assets/images/service-journey-workshop.webp"]) {
    assert(fileSet.has(path), `seven-page asset missing from installable theme: ${path}`);
  }
  assert(!files.some((path) => /^onepages\/assets\/(?:sequence\/node-\d{3}|images\/node-poster)\.webp$/.test(path)), "retired NODE product imagery must not enter the AURA payload");
  const [css, js, homeCss, homeJs] = await Promise.all([
    readFile(cssPath, "utf8"), readFile(jsPath, "utf8"),
    readFile(homeCssPath, "utf8"), readFile(homeJsPath, "utf8"),
  ]);
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
  assert(css.includes("--jw-motion-duration-reveal"), "motion tokens are missing from the common CSS");
  assert(homeCss.includes(".hero__viewport") && homeCss.includes(".jwh1-process__rail"), "Main 1 CSS was not built by Vite");
  assert(!homeCss.includes(".js-motion .reveal"), "obsolete generic reveal CSS remains in Main 1");
  const sharedChunks = files.filter((path) => path.startsWith("js/chunks/") && path.endsWith(".js"));
  const emblaChunk = sharedChunks.find((path) => /^js\/chunks\/embla-carousel\.esm-[\w-]+\.js$/.test(path));
  const viewportChunk = sharedChunks.find((path) => /^js\/chunks\/viewport-[\w-]+\.js$/.test(path));
  const lucideChunk = sharedChunks.find((path) => /^js\/chunks\/lucide-[\w-]+\.js$/.test(path));
  const scrollChunk = sharedChunks.find((path) => /^js\/chunks\/scroll-[\w-]+\.js$/.test(path));
  const iconChunks = sharedChunks.filter((path) => /^js\/chunks\/(compass|route|target)-[\w-]+\.js$/.test(path));
  assert(sharedChunks.length === 4 + iconChunks.length && emblaChunk && viewportChunk && lucideChunk && scrollChunk, `expected shared Embla, Lucide, Motion and deduplicated icon chunks, found ${sharedChunks.join(", ")}`);
  const emblaImport = `./chunks/${emblaChunk.split("/").pop()}`;
  const viewportImport = `./chunks/${viewportChunk.split("/").pop()}`;
  assert(js.includes(emblaImport) && homeJs.includes(emblaImport), "Embla is not shared by both entries");
  const onepageJs = await readFile(join(payloadRoot, "js/onepages.min.js"), "utf8");
  const scrollImport = `./chunks/${scrollChunk.split("/").pop()}`;
  const homeFourJs = await readFile(join(payloadRoot, "js/home-four.min.js"), "utf8");
  const lucideImport = `./chunks/${lucideChunk.split("/").pop()}`;
  assert(homeFourJs.includes(viewportImport) && homeFourJs.includes(lucideImport) && js.includes(lucideImport), "Main 4 must share Motion viewport and Lucide instead of bundling alternate engines");
  assert(onepageJs.includes(emblaImport) && onepageJs.includes(scrollImport) && homeJs.includes(scrollImport), "onepages and Main 1 do not share the chosen effect stack");
  const [emblaLicense, motionLicense, notices] = await Promise.all([
    readFile(join(themeRoot, "LICENSES/embla-carousel-MIT.txt"), "utf8"),
    readFile(join(themeRoot, "LICENSES/motion-MIT.txt"), "utf8"),
    readFile(join(themeRoot, "THIRD_PARTY_NOTICES.md"), "utf8"),
  ]);
  assert(emblaLicense.includes("Copyright (c) David Jerleke."), "Embla license is missing its attribution");
  assert(motionLicense.includes("[Motion](https://motion.dev) B.V."), "Motion license is missing its attribution");
  assert(notices.includes("Embla Carousel 8.6.0") && notices.includes("Motion 13.4.0"), "bundled motion libraries lack product notices");

  const fontFiles = files.filter((path) => path.startsWith("fonts/") && path.endsWith(".woff2"));
  assert(fontFiles.length === 92, `expected 92 Pretendard subsets, found ${fontFiles.length}`);

  const cssGzip = gzipSync(css).byteLength;
  const jsGzip = gzipSync(js).byteLength;
  const firstPageJsGzip = jsGzip + gzipSync(homeJs).byteLength
    + gzipSync(await readFile(join(payloadRoot, emblaChunk))).byteLength
    + gzipSync(await readFile(join(payloadRoot, viewportChunk))).byteLength
    + gzipSync(await readFile(join(payloadRoot, lucideChunk))).byteLength
    + gzipSync(await readFile(join(payloadRoot, scrollChunk))).byteLength;
  assert(cssGzip <= 90 * 1024, `CSS gzip budget exceeded: ${cssGzip} bytes`);
  assert(jsGzip <= 80 * 1024, `JavaScript gzip budget exceeded: ${jsGzip} bytes`);
  assert(firstPageJsGzip <= 140 * 1024, `Main 1 JavaScript gzip budget exceeded: ${firstPageJsGzip} bytes`);

  const manifest = JSON.parse(await readFile(join(themeRoot, "ASSET-MANIFEST.json"), "utf8")) as {
    assets: Array<{ path: string; provenance: string }>;
  };
  assert(manifest.assets.length > fontFiles.length, "asset manifest does not cover built and inherited assets");
  for (const path of ["theme/css/home-one.min.css", "theme/js/home-one.min.js", "theme/css/home-four.min.css", "theme/js/home-four.min.js", `theme/${sharedChunks[0]}`]) {
    assert(manifest.assets.some((asset) => asset.path === path && asset.provenance === "generated"), `built Main 1 asset has wrong provenance: ${path}`);
  }

  console.log(JSON.stringify({
    payloadFiles: files.length,
    pageFiles: pageFiles.length,
    inheritedFiles: inherited.length,
    registeredAssets: manifest.assets.length,
    fontFiles: fontFiles.length,
    cssGzip,
    jsGzip,
    firstPageJsGzip
  }, null, 2));
}

await main();
