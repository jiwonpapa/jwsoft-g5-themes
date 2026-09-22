export function searchValidation(value: string): string {
  const query = value.trim();
  if ([...query].length < 2) return "검색어를 두 글자 이상 입력해 주세요.";
  if ((query.match(/ /g) ?? []).length > 1) return "검색어의 공백은 한 개까지 사용할 수 있습니다.";
  return "";
}

export function initializeCommunityUtilities(): void {
  document.querySelectorAll<HTMLFormElement>("[data-jw-global-search]").forEach((form) => {
    form.addEventListener("submit", (event) => {
      const input = form.elements.namedItem("stx") as HTMLInputElement;
      const error = searchValidation(input.value);
      const status = form.querySelector<HTMLElement>("[data-jw-support-status]");
      if (status) { status.hidden = !error; status.textContent = error; }
      if (error) { event.preventDefault(); input.focus(); } else { input.value = input.value.trim(); }
    });
  });
  document.querySelectorAll<HTMLFormElement>("[data-jw-new-delete]").forEach((form) => {
    const all = form.querySelector<HTMLInputElement>("[data-jw-new-select-all]");
    const rows = [...form.querySelectorAll<HTMLInputElement>('input[name="chk_bn_id[]"]')];
    all?.addEventListener("change", () => rows.forEach((row) => { row.checked = all.checked; }));
    rows.forEach((row) => row.addEventListener("change", () => {
      if (all) { all.checked = rows.every((item) => item.checked); all.indeterminate = rows.some((item) => item.checked) && !all.checked; }
    }));
    form.addEventListener("submit", (event) => {
      if (!rows.some((row) => row.checked)) {
        event.preventDefault();
        const status = form.querySelector<HTMLElement>("[data-jw-support-status]");
        if (status) { status.hidden = false; status.textContent = "삭제할 게시물을 선택해 주세요."; status.focus(); }
        return;
      }
      if (!window.confirm("선택한 게시물을 삭제하시겠습니까? 삭제한 자료는 복구할 수 없습니다.")) event.preventDefault();
    });
  });
}
