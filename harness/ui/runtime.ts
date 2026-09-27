import { cp, mkdir, readFile, writeFile, access } from "node:fs/promises";
import { createHash, randomBytes } from "node:crypto";
import { resolve } from "node:path";
import { root, themeRoot, mainPages } from "./catalog";
import { buildGallery, galleryOutput } from "./gallery/build";
const directory = resolve(root, ".runtime/ui");
const site = resolve(directory, "site");
export async function command(args: string[], env = process.env) {
  const p = Bun.spawn(args, { cwd: root, env, stdin: "inherit", stdout: "inherit", stderr: "inherit" });
  const exit = await p.exited;
  if (exit) throw new Error(args[0] + " failed: " + exit);
}
export const compose = ["docker", "compose", "-f", "harness/ui/compose.yaml"];
async function exists(path: string) { try { await access(path); return true; } catch { return false; } }
const [action = "up", ...args] = process.argv.slice(2);
if (action === "up") {
  await mkdir(site, { recursive: true });
  if (!(await exists(resolve(site, ".jw-ui-fixture")))) {
    if (await exists(resolve(site, "common.php"))) throw new Error("Refusing to overwrite an unowned G5 checkout");
    const lock = JSON.parse(await readFile(resolve(root, "harness/upstream/gnuboard5.lock.json"), "utf8"));
    const response = await fetch(lock.source);
    if (!response.ok) throw new Error("Cannot download pinned G5: " + response.status);
    const bytes = Buffer.from(await response.arrayBuffer());
    if (createHash("sha256").update(bytes).digest("hex") !== lock.sha256) throw new Error("G5 archive hash mismatch");
    await writeFile(resolve(directory, "upstream.tgz"), bytes);
    await command(["tar", "-xzf", resolve(directory, "upstream.tgz"), "--strip-components=1", "-C", site]);
    await writeFile(resolve(site, ".jw-ui-fixture"), lock.commit + "\n");
  }
  if (!(await exists(resolve(directory, ".env")))) {
    const password = randomBytes(24).toString("hex");
    await writeFile(resolve(directory, ".env"), "JW_UI_DB_PASSWORD=" + password + "\nMYSQL_ROOT_PASSWORD=" + password + "\n", { mode: 0o600 });
  }
  await cp(resolve(themeRoot, "theme"), resolve(site, "theme/jw_business"), { recursive: true });
  await cp(resolve(themeRoot, "pages"), resolve(site, "pages"), { recursive: true });
  await writeFile(resolve(root, "harness/ui/routes.json"), JSON.stringify([
    { code: "10", name: "메인", route: "/" },
    ...mainPages.map((page, index) => ({ code: "10" + (index + 1) + "0", name: page.purpose.slice(0, 24), route: page.route })),
  ]));
  await buildGallery();
  await cp(galleryOutput, resolve(site, "__jw-dev"), { recursive: true });
  await command([...compose, "up", "-d", "--build", "--wait", "db", "php", "web"]);
  await command([...compose, "exec", "-T", "php", "php", "/harness/install-fixture.php"]);
  console.log("G5 fixture: http://127.0.0.1:18086");
} else if (action === "down") {
  await command([...compose, "down"]);
} else if (action === "test") {
  const mode = args[0] || "check";
  if (!["check", "capture", "compare", "selftest", "gallery"].includes(mode)) throw new Error("Invalid test mode");
  await command([...compose, "run", "--rm", "-e", "JW_UI_PAGES=" + (process.env.JW_UI_PAGES || ""), "-e", "JW_UI_COMMAND=" + mode, "runner", "bash", "harness/ui/runner.sh"]);
} else throw new Error("Use up, down or test");
