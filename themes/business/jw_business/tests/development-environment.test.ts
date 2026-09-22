import { describe, expect, test } from "bun:test";

import { currentBunVersion, inspectDevelopmentEnvironment, loadDevelopmentContext } from "../scripts/development-environment";

describe("customer development environment", () => {
  test("the current workspace satisfies the machine-readable contract", async () => {
    const context = await loadDevelopmentContext();
    const findings = await inspectDevelopmentEnvironment(context);

    expect(context.contract.product.slug).toBe("jw_business");
    expect(context.contract.toolchain.serverIncluded).toBe(false);
    expect(findings.filter((finding) => finding.level === "fail")).toEqual([]);
  });

  test("an unsupported Bun version fails before source work begins", async () => {
    const context = await loadDevelopmentContext();
    const findings = await inspectDevelopmentEnvironment(context, "0.0.0");

    expect(currentBunVersion()).toBe(context.contract.toolchain.bun);
    expect(findings.find((finding) => finding.id === "bun-version")?.level).toBe("fail");
  });
});
