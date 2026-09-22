import { resolve } from "node:path";

import { buildThemeTokens, checkThemeTokens } from "./build";

const [command, source, output] = Bun.argv.slice(2);

if (!command || !source || !output || !["build", "check"].includes(command)) {
  console.error("usage: bun run packages/theme-tokens/src/cli.ts <build|check> <theme.tokens.json> <output-dir>");
  process.exit(2);
}

try {
  if (command === "build") await buildThemeTokens(resolve(source), resolve(output));
  else await checkThemeTokens(resolve(source), resolve(output));
  console.log(`theme tokens ${command} passed`);
} catch (error) {
  console.error((error as Error).message);
  process.exit(1);
}
