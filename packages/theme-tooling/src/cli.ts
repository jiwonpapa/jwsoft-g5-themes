import { resolve } from "node:path";

import { packageTheme } from "./package-theme";
import { scaffoldTheme, type ScaffoldOptions } from "./scaffold";

function readFlags(args: string[]): Record<string, string[]> {
  const flags: Record<string, string[]> = {};
  for (let index = 0; index < args.length; index += 2) {
    const key = args[index];
    const value = args[index + 1];
    if (!key?.startsWith("--") || !value) throw new Error(`invalid argument near ${key ?? "end"}`);
    (flags[key.slice(2)] ??= []).push(value);
  }
  return flags;
}

function required(flags: Record<string, string[]>, name: string): string {
  const value = flags[name]?.[0];
  if (!value) throw new Error(`--${name} is required`);
  return value;
}

function parseGates(values: string[]): Array<{ id: string; evidence: string }> {
  return values.map((value) => {
    const separator = value.indexOf("=");
    if (separator < 1 || separator === value.length - 1) throw new Error("--gate must use <id>=<evidence-path>");
    return { id: value.slice(0, separator), evidence: value.slice(separator + 1) };
  });
}

const [command, ...args] = Bun.argv.slice(2);

try {
  const flags = readFlags(args);
  const repoRoot = resolve(flags["repo-root"]?.[0] ?? ".");
  if (command === "scaffold") {
    const youngcart = required(flags, "youngcart") as ScaffoldOptions["youngcart"];
    if (!["excluded", "optional", "included"].includes(youngcart)) throw new Error("youngcart must be excluded, optional, or included");
    const themeRoot = await scaffoldTheme({
      repoRoot,
      category: required(flags, "category"),
      slug: required(flags, "slug"),
      name: required(flags, "name"),
      industry: required(flags, "industry"),
      youngcart,
      tokensFile: resolve(required(flags, "tokens"))
    });
    console.log(`theme scaffold created: ${themeRoot}`);
  } else if (command === "package") {
    const result = await packageTheme({
      repoRoot,
      themeRoot: resolve(repoRoot, required(flags, "theme")),
      outputDir: resolve(repoRoot, required(flags, "output")),
      sourceCommit: required(flags, "source-commit"),
      gnuboardVersion: required(flags, "g5-version"),
      gnuboardCommit: required(flags, "g5-commit"),
      generatedAt: required(flags, "generated-at"),
      manualVersionUrl: required(flags, "manual-url"),
      gates: parseGates(flags.gate ?? [])
    });
    console.log(`theme package created: ${result.zipPath}\nsha256: ${result.sha256}`);
  } else {
    throw new Error("usage: cli.ts <scaffold|package> [options]");
  }
} catch (error) {
  console.error((error as Error).message);
  process.exit(1);
}
