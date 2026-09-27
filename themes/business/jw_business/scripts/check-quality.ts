import { mkdir, writeFile } from "node:fs/promises";
import { join, resolve } from "node:path";
import { checkQuality, loadPolicy } from "./quality/check";
import { groupDigest } from "./quality/files";
import { writeComparison } from "./quality/comparison";

const root = resolve(import.meta.dirname, "..");
const [command = "check", group, implementer] = process.argv.slice(2);
try {
  const { contract } = await loadPolicy(root);
  const groups = [...new Set(contract.pages.map(page => page.group))];
  if (!["check", "release", "complete", "start", "prepare", "compare"].includes(command)) throw new Error(`unknown quality command: ${command}`);
  if (["complete", "start", "prepare", "compare"].includes(command) && (!group || !groups.includes(group))) throw new Error(`group required: ${groups.join(", ")}`);
  if (command === "complete") {
    for (const previous of groups.slice(0, groups.indexOf(group!))) {
      const result = await checkQuality(root, previous);
      if (result.result !== "pass") throw new Error(`NEXT_BATCH_BLOCKED: ${previous} 미통과. ${group} 완료 처리 불가.`);
    }
  }
  if (command === "compare") {
    console.log(await writeComparison(root, contract, group!));
  } else if (command === "prepare") {
    if (!implementer || implementer.length < 6) throw new Error("실제 구현 작업 ID를 지정하세요.");
    const pages = contract.pages.filter(page => page.group === group);
    const draft = {
      schemaVersion: 2, group, inputDigest: await groupDigest(root, group!), implementer,
      reviewer: "PENDING", reviewedAt: new Date().toISOString(), result: "pending",
      captures: [], pages: pages.map(page => ({ id: page.id,
        purpose: { id: "purpose", result: "fail", reason: "실제 화면과 페이지 목적의 일치를 검토해야 합니다." },
        imagery: { id: "imagery", result: "fail", reason: "사진과 자료의 적합성 및 원본 중복을 검토해야 합니다." },
        composition: { id: "composition", result: "fail", reason: "첫 화면과 본문의 구성이 다른 선택 이유를 제공하는지 검토해야 합니다." },
      })), comparisons: pages.flatMap((left, index) => pages.slice(index + 1).map(right => ({ left: left.id, right: right.id, result: "fail", reason: "PC·모바일 비교판에서 두 변형의 실제 차이를 검토해야 합니다." }))), interactions: [],
    };
    await mkdir(join(root, "quality/reviews"), { recursive: true });
    const destination = join(root, `quality/reviews/${group}.draft.json`);
    // Never overwrite an existing draft or a review. This command cannot approve anything.
    await writeFile(destination, `${JSON.stringify(draft, null, 2)}\n`, { flag: "wx" });
    console.log(destination);
  } else if (command === "start") {
    for (const previous of groups.slice(0, groups.indexOf(group!))) {
      const result = await checkQuality(root, previous);
      if (result.result !== "pass") throw new Error(`NEXT_BATCH_BLOCKED: ${previous} 미통과 (${result.failures.length}건). ${group} 착수 불가.`);
    }
    const pages = contract.pages.filter(page => page.group === group);
    if (pages.some(page => !page.ready)) throw new Error(`DESIGN_NOT_READY: ${group}의 페이지별 설계부터 확정해야 합니다.`);
    console.log(`ready to start: ${group}`);
  } else {
    const result = await checkQuality(root, command === "release" ? "release" : command === "complete" ? group! : "current");
    console.log(JSON.stringify(result, null, 2));
    process.exitCode = result.result === "pass" ? 0 : 1;
  }
} catch (error) {
  console.error(JSON.stringify({ result: "fail", code: "QUALITY_BLOCKED", message: String(error) }, null, 2));
  process.exitCode = 1;
}
