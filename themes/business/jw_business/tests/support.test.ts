import { describe, expect, test } from "bun:test";
import { validateInquiry } from "../src/scripts/support";

const response = (data: unknown, status = 200) => new Response(JSON.stringify(data), {status});
function server(replies: Response[]) {
  const calls: URLSearchParams[] = [];
  const fetcher = (async (_url: unknown, init: RequestInit) => { calls.push(init.body as URLSearchParams); return replies.shift()!; }) as typeof fetch;
  return {fetcher, calls};
}
describe("inquiry submission boundary", () => {
  test("checks content before requesting the QA-specific token", async () => {
    const mock=server([response({subject:"",content:""}),response({error:"",token:"valid"})]);
    expect(await validateInquiry(mock.fetcher,"/filter","/token","문의","내용")).toBe("valid");
    expect(mock.calls[0]?.get("subject")).toBe("문의");
    expect(mock.calls[1]?.get("token_case")).toBe("qa_write");
  });
  test("forbidden text never requests a write token", async () => {
    const mock=server([response({subject:"금지",content:""})]);
    await expect(validateInquiry(mock.fetcher,"/filter","/token","금지","내용")).rejects.toThrow("금지어");
    expect(mock.calls.length).toBe(1);
  });
  test("malformed filter and failed HTTP responses fail closed", async () => {
    for (const reply of [response({}),response({},503)]) {
      const mock=server([reply]);
      await expect(validateInquiry(mock.fetcher,"/filter","/token","제목","내용")).rejects.toThrow();
      expect(mock.calls.length).toBe(1);
    }
  });
  test("expired login or missing token cannot submit", async () => {
    for (const data of [{error:"로그인 필요",token:""},{token:""},null]) {
      const mock=server([response({subject:"",content:""}),response(data)]);
      await expect(validateInquiry(mock.fetcher,"/filter","/token","제목","내용")).rejects.toThrow();
    }
  });
});
