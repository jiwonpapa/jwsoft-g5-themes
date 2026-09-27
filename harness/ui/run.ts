import { root } from "./catalog";
const [command = "check", ...args] = process.argv.slice(2);
if (!["check", "capture", "compare", "selftest", "gallery"].includes(command)) throw new Error("Unknown UI command");
const pageArg = args.indexOf("--page");
const pages = pageArg >= 0 ? args.splice(pageArg, 2)[1] : undefined;
if (args.some(arg => /update-snapshots|^-u$/.test(arg))) throw new Error("Baseline updates require independent review; automatic updates are forbidden.");
const child = Bun.spawn(["bun", "x", "--no-install", "playwright", "test", "-c", "harness/ui/playwright.config.ts", ...args], {
  cwd: root, env: { ...process.env, JW_UI_COMMAND: command, ...(pages ? { JW_UI_PAGES: pages } : {}) },
  stdout: "inherit", stderr: "inherit", stdin: "inherit",
});
process.exit(await child.exited);
