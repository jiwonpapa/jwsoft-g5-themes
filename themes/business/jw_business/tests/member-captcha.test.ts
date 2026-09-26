import { afterEach, expect, test } from "bun:test";
import { initializeMemberRecaptcha } from "../src/scripts/member-captcha";

const originalWindow = globalThis.window;
const originalDocument = globalThis.document;
afterEach(() => {
  globalThis.window = originalWindow;
  globalThis.document = originalDocument;
});

function fixture(invisible = false) {
  const errors: string[] = [];
  let response = "", executes = 0, submits = 0, scrolls = 0;
  let options: Record<string, any> = {};
  const listeners: Record<string, () => void> = {};
  const container = { dataset: { sitekey: "test-key", size: invisible ? "invisible" : "normal" }, scrollIntoView: () => scrolls++ };
  const form = { querySelector: () => container, requestSubmit: () => submits++ } as unknown as HTMLFormElement;
  const script = { src: "", async: false, addEventListener: (event: string, callback: () => void) => { listeners[event] = callback; } };
  const state = {} as any;
  globalThis.window = state;
  globalThis.document = { createElement: () => script, head: { append: () => {} } } as unknown as Document;
  const check = initializeMemberRecaptcha(form, (message) => errors.push(message));
  const ready = () => {
    state.grecaptcha = { render: (_: unknown, config: Record<string, any>) => { options = config; return 42; }, getResponse: () => response, execute: () => executes++ };
    state.jwMemberCaptchaReady();
  };
  return { check, ready, errors, script, listeners, setResponse: (value: string) => { response = value; }, callback: (name: string) => options[name](), counts: () => ({ executes, submits, scrolls }), options: () => options };
}

test("reCAPTCHA is scoped to forms containing a provider widget", () => {
  const form = { querySelector: () => null } as unknown as HTMLFormElement;
  expect(initializeMemberRecaptcha(form, () => {})()).toBe(true);
});
test("pending API and unchecked checkbox stop submission; a provider response continues to G5", () => {
  const f = fixture();
  expect(f.check()).toBe(false);
  f.ready();
  expect(f.options().size).toBe("compact");
  expect(f.check()).toBe(false);
  expect(f.counts().scrolls).toBe(1);
  f.setResponse("server-must-verify-this");
  expect(f.check()).toBe(true);
  expect(f.counts().submits).toBe(0);
});
test("invisible verification executes once and resumes native validation exactly once", () => {
  const f = fixture(true); f.ready();
  expect(f.check()).toBe(false); expect(f.check()).toBe(false);
  expect(f.counts().executes).toBe(1);
  f.setResponse("test-response"); f.callback("callback"); f.callback("callback");
  expect(f.counts().submits).toBe(1);
  expect(f.check()).toBe(true);
});
test("provider errors and expired tokens allow another verification attempt", () => {
  const f = fixture(true); f.ready(); f.check(); f.callback("error-callback");
  expect(f.errors.at(-1)).toContain("네트워크");
  f.check(); f.callback("expired-callback"); f.check();
  expect(f.counts().executes).toBe(3);
  expect(f.counts().submits).toBe(0);
});
test("API download failure displays recovery guidance and never submits", () => {
  const f = fixture(); f.listeners.error?.();
  expect(f.errors.at(-1)).toContain("새로고침");
  expect(f.check()).toBe(false);
  expect(f.counts().submits).toBe(0);
});
