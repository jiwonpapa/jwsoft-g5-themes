import { createHash } from "node:crypto";
import { cp, lstat, mkdir, readFile, readdir, rm, writeFile } from "node:fs/promises";
import { basename, dirname, join, relative, resolve, sep } from "node:path";

const themeRoot = resolve(import.meta.dirname, "..");
const sourceRoot = join(themeRoot, "src/php");
const buildRoot = join(themeRoot, "build/vite");
const payloadRoot = join(themeRoot, "theme");
const pagesRoot = join(themeRoot, "pages");
const pageCatalogPath = join(sourceRoot, "pages/catalog.json");
const inventoryPath = join(themeRoot, "docs/BASIC-INVENTORY.json");
const assetManifestPath = join(themeRoot, "ASSET-MANIFEST.json");
const staticExtensions = new Set(["css", "gif", "ico", "jpeg", "jpg", "js", "png", "svg", "webp", "woff", "woff2"]);

function portablePath(path: string): string {
  return path.split(sep).join("/");
}

function sha256(bytes: Uint8Array): string {
  return createHash("sha256").update(bytes).digest("hex");
}

function assetId(prefix: string, path: string): string {
  const readable = path.toLowerCase().replace(/[^a-z0-9]+/g, "-").replace(/^-|-$/g, "").slice(0, 72) || "asset";
  return `${prefix}-${readable}-${sha256(new TextEncoder().encode(path)).slice(0, 8)}`;
}

function isYoungcartPath(path: string): boolean {
  const parts = path.split("/");
  return path === "js/theme.shop.list.js"
    || parts.some((part) => part === "shop" || part.startsWith("shop_"))
    || path.includes("_shop.");
}

async function walkFiles(root: string): Promise<string[]> {
  const entries = await readdir(root, { withFileTypes: true });
  const files: string[] = [];
  for (const entry of entries.sort((left, right) => left.name.localeCompare(right.name))) {
    const path = join(root, entry.name);
    if (entry.isDirectory()) files.push(...await walkFiles(path));
    else if (entry.isFile()) files.push(path);
  }
  return files;
}

async function copyFile(source: string, destination: string): Promise<void> {
  await mkdir(dirname(destination), { recursive: true });
  await cp(source, destination);
}

async function buildPageRoutes(): Promise<number> {
  const catalog = JSON.parse(await readFile(pageCatalogPath, "utf8")) as {
    pageTypes: Array<{ id: string; layouts: string[] }>;
  };
  await rm(pagesRoot, { recursive: true, force: true });
  await mkdir(pagesRoot, { recursive: true });

  const routeIds: string[] = [];
  for (const pageType of catalog.pageTypes) {
    if (!/^[a-z][a-z0-9-]*$/.test(pageType.id)) throw new Error(`invalid page type id: ${pageType.id}`);
    if (!Array.isArray(pageType.layouts) || pageType.layouts.length !== 5) {
      throw new Error(`page type must define five layouts: ${pageType.id}`);
    }

    for (let index = 0; index < pageType.layouts.length; index += 1) {
      const pageId = `${pageType.id}-${index + 1}`;
      routeIds.push(pageId);
      await writeFile(
        join(pagesRoot, `${pageId}.php`),
        `<?php\ninclude_once dirname(__DIR__).'/common.php';\n$jw_page_id = '${pageId}';\ninclude G5_THEME_PATH.'/pages/page.php';\n`,
      );
    }
  }

  await writeFile(
    join(pagesRoot, "index.php"),
    "<?php\ninclude_once dirname(__DIR__).'/common.php';\ninclude G5_THEME_PATH.'/pages/catalog-index.php';\n",
  );
  return routeIds.length;
}

async function main(): Promise<void> {
  if (basename(themeRoot) !== "jw_business" || basename(payloadRoot) !== "theme") {
    throw new Error("refusing to build outside themes/business/jw_business/theme");
  }
  if (!(await lstat(buildRoot).catch(() => null))?.isDirectory()) {
    throw new Error("Vite output is missing; run build:assets first");
  }

  const inventory = JSON.parse(await readFile(inventoryPath, "utf8")) as {
    files: Array<{ path: string; area: string }>;
  };
  const excluded = new Set(
    inventory.files
      .filter((file) => isYoungcartPath(file.path) || file.path === "screenshot.png")
      .map((file) => file.path)
  );

  await rm(payloadRoot, { recursive: true, force: true });
  await mkdir(payloadRoot, { recursive: true });
  const pageRouteCount = await buildPageRoutes();

  for (const source of await walkFiles(sourceRoot)) {
    const path = portablePath(relative(sourceRoot, source));
    if (!excluded.has(path)) await copyFile(source, join(payloadRoot, path));
  }
  for (const source of await walkFiles(buildRoot)) {
    const path = portablePath(relative(buildRoot, source));
    await copyFile(source, join(payloadRoot, path));
  }

  await cp(join(themeRoot, "src/assets/brand"), join(payloadRoot, "assets/brand"), { recursive: true });

  const assets = [];
  for (const file of await walkFiles(payloadRoot)) {
    const path = portablePath(relative(payloadRoot, file));
    const extension = path.split(".").pop()?.toLowerCase() ?? "";
    if (!staticExtensions.has(extension)) continue;

    const bytes = await readFile(file);
    const blenderLogo = path.startsWith("assets/brand/");
    const generatedImage = path.startsWith("assets/") && /\.(?:avif|jpe?g|png|webp)$/i.test(path);
    const generated = path === "css/jw-business.min.css" || path === "js/jw-business.min.js" || path.startsWith("fonts/") || generatedImage;
    const font = path.startsWith("fonts/");
    assets.push({
      id: assetId(generated ? "build" : "g5", path),
      path: `theme/${path}`,
      sha256: sha256(bytes),
      provenance: generated ? "generated" : "original",
      ...(generated ? {
        generatedBy: blenderLogo
          ? "Blender 5.2.2 LTS + ImageMagick WebP"
          : font
          ? "Vite 8.3.0 + Pretendard 1.3.9"
          : generatedImage
            ? "OpenAI image generation + cwebp + Vite 8.3.0"
            : "Vite 8.3.0"
      } : {}),
      ...(font
        ? { sourceUrl: "https://github.com/orioncactus/pretendard/releases/tag/v1.3.9" }
        : generated
          ? {}
          : { sourceUrl: `https://github.com/gnuboard/gnuboard5/blob/v5.6.391/theme/basic/${path.split("/").map(encodeURIComponent).join("/")}` }),
      author: blenderLogo
        ? "JW SOFT; lettering based on Pretendard by Kil Hyung-jin"
        : font
        ? "Kil Hyung-jin"
        : generatedImage
          ? "OpenAI image generation, directed by JW SOFT"
          : generated
            ? "JW SOFT and bundled library authors"
            : "SIR",
      acquiredAt: "2026-09-21",
      licenseExpression: blenderLogo
        ? "LicenseRef-JWSOFT AND OFL-1.1"
        : font
        ? "OFL-1.1"
        : generatedImage
          ? "LicenseRef-OpenAI-Generated-Asset AND LicenseRef-JWSOFT"
          : path === "css/jw-business.min.css"
          ? "MIT AND OFL-1.1 AND LicenseRef-JWSOFT"
          : path === "js/jw-business.min.js"
            ? "ISC AND MIT AND LicenseRef-JWSOFT"
            : "LGPL-2.1-only",
      usageScope: "theme",
      salePackage: true
    });
  }

  await writeFile(assetManifestPath, `${JSON.stringify({
    $schema: "../../../packages/theme-contracts/schemas/asset-manifest.schema.json",
    schemaVersion: 1,
    theme: "jw_business",
    assets
  }, null, 2)}\n`);

  console.log(`payload built: ${payloadRoot} (${inventory.files.length - excluded.size} inherited files, ${assets.length} registered assets, ${pageRouteCount} page routes)`);
}

await main();
