const steps = [
  ["bun", "run", "themes/business/jw_business/scripts/check-structure.ts"],
  ["bun", "run", "tools/verify-impeccable.ts"],
  ["bun", "run", "packages/theme-contracts/src/cli.ts", "check"],
  ["bun", "test", "packages/theme-contracts/tests"],
  ["bun", "test", "packages/theme-tokens/tests"],
  ["bun", "test", "packages/theme-tooling/tests"],
];

for (const command of steps) {
  const result = Bun.spawnSync({
    cmd: command,
    cwd: process.cwd(),
    stdin: "inherit",
    stdout: "inherit",
    stderr: "inherit",
  });

  if (result.exitCode !== 0) process.exit(result.exitCode);
}

console.log("foundation check passed");
