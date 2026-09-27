import stylelint from "stylelint";
import { resolve } from "node:path";
const args = process.argv.slice(2);
const files = args.length ? args : ["themes/business/jw_business/src/styles/*.css"];
const result = await stylelint.lint({ files, configFile: resolve("stylelint.config.mjs"), formatter: "string" });
if (result.report) console.log(result.report);
process.exitCode = result.errored ? 1 : 0;
