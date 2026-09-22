import { resolve } from "node:path";

import { createValidators, validateContractFile, validateRepository } from "./contracts";

const repoRoot = resolve(import.meta.dir, "../../..");
const [command = "check", target] = Bun.argv.slice(2);

let failures;
if (command === "check") {
  failures = await validateRepository(repoRoot);
} else if (command === "validate" && target) {
  failures = await validateContractFile(resolve(target), await createValidators());
} else {
  console.error("usage: cli.ts check | validate <contract.json>");
  process.exit(2);
}

if (failures.length) {
  for (const failure of failures) {
    console.error(`${failure.file}: ${failure.message}`);
  }
  process.exit(1);
}

console.log(command === "check" ? "contract check passed" : "contract valid");
