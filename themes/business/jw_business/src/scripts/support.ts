type FilterResult = { subject: string; content: string };

export async function validateInquiry(fetcher: typeof fetch, filterUrl: string, tokenUrl: string, subject: string, content: string): Promise<string> {
  const post = async (url: string, values: Record<string, string>): Promise<unknown> => {
    const response = await fetcher(url, { method: "POST", credentials: "same-origin", headers: { "X-Requested-With": "XMLHttpRequest" }, body: new URLSearchParams(values) });
    if (!response.ok) throw new Error("서버에 연결하지 못했습니다. 입력 내용은 유지됩니다. 다시 시도해 주세요.");
    return response.json();
  };
  const filter = await post(filterUrl, { subject, content }) as FilterResult | null;
  if (!filter || typeof filter.subject !== "string" || typeof filter.content !== "string") throw new Error("금지어 검사 응답을 확인하지 못했습니다. 다시 시도해 주세요.");
  if (filter.subject || filter.content) throw new Error(`${filter.subject ? "제목" : "내용"}에 금지어(${filter.subject || filter.content})가 있습니다.`);
  const result = await post(tokenUrl, { token_case: "qa_write" }) as { error?: string; token?: string } | null;
  if (!result || result.error || typeof result.token !== "string" || !result.token) throw new Error(result?.error || "저장 권한을 확인하지 못했습니다. 로그인 상태를 확인해 주세요.");
  return result.token;
}

function showError(form: HTMLFormElement, message: string): void {
  const status = form.querySelector<HTMLElement>("[data-jw-support-status]");
  if (status) { status.hidden = false; status.textContent = message; status.focus(); }
}

export function initializeSupport(): void {
  document.querySelectorAll<HTMLFormElement>("[data-jw-qa-write]").forEach((form) => {
    form.addEventListener("submit", async (event) => {
      event.preventDefault();
      if (form.dataset.submitting === "true") return;
      const subject = form.elements.namedItem("qa_subject");
      const content = form.elements.namedItem("qa_content");
      const token = form.elements.namedItem("token");
      if (!(subject instanceof HTMLInputElement) || !(content instanceof HTMLTextAreaElement) || !(token instanceof HTMLInputElement)) { showError(form, "입력 필드를 확인하지 못했습니다."); return; }
      // Optional editor integration uses the same native bridge as board writing.
      const readEditor = (window as typeof window & { get_editor_qa_content?: () => string }).get_editor_qa_content;
      if (typeof readEditor === "function") content.value = readEditor();
      if (!subject.value.trim() || !content.value.trim()) { showError(form, "제목과 내용을 입력해 주세요."); (!subject.value.trim() ? subject : content).focus(); return; }
      if (!form.reportValidity()) return;
      form.dataset.submitting = "true";
      form.setAttribute("aria-busy", "true");
      const submit = form.querySelector<HTMLButtonElement>('button[type="submit"]');
      if (submit) submit.disabled = true;
      let saved = false;
      try {
        token.value = await validateInquiry(fetch, form.dataset.filterUrl ?? "", form.dataset.tokenUrl ?? "", subject.value, content.value);
        HTMLFormElement.prototype.submit.call(form);
        saved = true;
      } catch (error) {
        showError(form, error instanceof Error ? error.message : "저장 준비에 실패했습니다. 다시 시도해 주세요.");
      } finally {
        if (!saved) { delete form.dataset.submitting; form.removeAttribute("aria-busy"); if (submit) submit.disabled = false; }
      }
    });
  });
  document.querySelectorAll<HTMLFormElement>("[data-jw-qa-delete]").forEach((form) => {
    const all = form.querySelector<HTMLInputElement>("[data-jw-qa-select-all]");
    const rows = [...form.querySelectorAll<HTMLInputElement>('input[name="chk_qa_id[]"]')];
    all?.addEventListener("change", () => rows.forEach((row) => { row.checked = all.checked; }));
    rows.forEach((row) => row.addEventListener("change", () => { if (all) { all.checked = rows.every((item) => item.checked); all.indeterminate = rows.some((item) => item.checked) && !all.checked; } }));
    form.addEventListener("submit", (event) => {
      if (!rows.some((row) => row.checked)) { event.preventDefault(); showError(form, "삭제할 문의를 선택해 주세요."); return; }
      if (!window.confirm("선택한 문의를 삭제하시겠습니까? 삭제한 문의는 복구할 수 없습니다.")) event.preventDefault();
    });
  });
}
