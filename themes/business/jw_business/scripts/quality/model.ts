import Ajv2020 from "ajv/dist/2020.js";

export interface Requirement { id: string; description: string; selector: string; min: number }
export interface PagePlan {
  id: string; group: string; path: string; route: string; purpose: string; layout: string;
  ready: boolean; firstViewport: string; composition: string; imagery: string;
  requirements: Requirement[]; interactions: string[];
}
export interface QualityContract { schemaVersion: 1; pages: PagePlan[] }
export interface AssetRecord { path: string; sha256: string; origin: string; owner: string }
export interface AssetRegistry { schemaVersion: 1; photos: AssetRecord[] }
export interface Artifact { path: string; sha256: string }
export interface Capture extends Artifact {
  page: string; viewport: "desktop" | "mobile"; mode: "light" | "dark";
  width: number; height: number; url: string; capturedAt: string;
  fullPage: true; documentHeight: number; media: string[];
  requirements: Array<{ id: string; count: number; visible: boolean }>;
}
export interface Judgment { id: string; result: "pass" | "fail"; reason: string }
export interface Review {
  schemaVersion: 1; group: string; inputDigest: string; implementer: string; reviewer: string;
  reviewedAt: string; result: "pass" | "fail" | "pending";
  captures: Capture[];
  pages: Array<{ id: string; purpose: Judgment; imagery: Judgment; composition: Judgment }>;
  comparisons: Array<{ left: string; right: string; result: "pass" | "fail"; reason: string }>;
  interactions: Array<{ page: string; id: string; viewport: "desktop" | "mobile";
    result: "pass" | "fail"; steps: string; before: Artifact; after: Artifact }>;
}
export interface Failure { code: string; target: string; message: string }
export interface QualityResult {
  result: "pass" | "fail"; scope: string; inputDigest: string;
  pages: number; failures: Failure[];
  photoUsage: Array<{ path: string; pages: string[] }>;
}

const text = { type: "string", minLength: 1 };
const prose = { type: "string", minLength: 12 };
const hash = { type: "string", pattern: "^[a-f0-9]{64}$" };
const stringList = { type: "array", items: text, uniqueItems: true };
const object = (properties: Record<string, unknown>) => ({ type: "object", additionalProperties: false, properties, required: Object.keys(properties) });
const list = (items: unknown) => ({ type: "array", items });
const artifact = object({ path: text, sha256: hash });
const judgment = object({ id: text, result: { enum: ["pass", "fail"] }, reason: prose });
const schemas = {
  contract: object({ schemaVersion: { const: 1 }, pages: list(object({
    id: text, group: text, path: text, route: text, purpose: prose, layout: text,
    ready: { type: "boolean" }, firstViewport: text, composition: text, imagery: text,
    requirements: { type: "array", minItems: 1, items: object({ id: text, description: prose, selector: text, min: { type: "integer", minimum: 1 } }) },
    interactions: stringList,
  })) }),
  assets: object({ schemaVersion: { const: 1 }, photos: list(object({ path: text, sha256: hash, origin: text, owner: text })) }),
  review: object({
    schemaVersion: { const: 1 }, group: text, inputDigest: hash, implementer: text, reviewer: text,
    reviewedAt: text, result: { enum: ["pass", "fail", "pending"] },
    captures: list(object({ path: text, sha256: hash, page: text,
      viewport: { enum: ["desktop", "mobile"] }, mode: { enum: ["light", "dark"] },
      width: { type: "integer", minimum: 320 }, height: { type: "integer", minimum: 480 },
      url: text, capturedAt: text, fullPage: { const: true }, documentHeight: { type: "integer", minimum: 480 }, media: stringList,
      requirements: list(object({ id: text, count: { type: "integer", minimum: 0 }, visible: { type: "boolean" } })),
    })),
    pages: list(object({ id: text, purpose: judgment, imagery: judgment, composition: judgment })),
    comparisons: list(object({ left: text, right: text, result: { enum: ["pass", "fail"] }, reason: prose })),
    interactions: list(object({ page: text, id: text, viewport: { enum: ["desktop", "mobile"] },
      result: { enum: ["pass", "fail"] }, steps: prose, before: artifact, after: artifact })),
  }),
};
const ajv = new Ajv2020({ strict: true, allErrors: true });
const validators = Object.fromEntries(Object.entries(schemas).map(([key, schema]) => [key, ajv.compile(schema)]));
export function validate<T>(kind: keyof typeof schemas, value: unknown): T {
  const validator = validators[kind]!;
  if (!validator(value)) throw new Error(`${kind}: ${ajv.errorsText(validator.errors)}`);
  return value as T;
}
