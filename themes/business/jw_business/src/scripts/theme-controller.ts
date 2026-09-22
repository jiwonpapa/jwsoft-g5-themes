import { initializeMobileMenu } from "./mobile-menu";
import {
  ArrowDown,
  Building2,
  Target,
  Files,
  Calendar,
  Compass,
  Monitor,
  ArrowLeft,
  ArrowRight,
  ArrowUp,
  ArrowUpRight,
  ChevronDown,
  createIcons,
  LogOut,
  Image,
  Lock,
  Menu,
  MessageCircle,
  Moon,
  Search,
  Sun,
  UserRound,
  X
} from "lucide";

export const LIGHT_THEME = "jw-light";
export const DARK_THEME = "jw-dark";
export const THEME_STORAGE_KEY = "jw-business-theme";

export type ThemeName = typeof LIGHT_THEME | typeof DARK_THEME;

export function isThemeName(value: unknown): value is ThemeName {
  return value === LIGHT_THEME || value === DARK_THEME;
}

export function resolveThemeChoice(saved: unknown, prefersDark: boolean): ThemeName {
  return isThemeName(saved) ? saved : prefersDark ? DARK_THEME : LIGHT_THEME;
}

export function nextTheme(current: ThemeName): ThemeName {
  return current === DARK_THEME ? LIGHT_THEME : DARK_THEME;
}

function readSavedTheme(): ThemeName | null {
  try {
    const saved = window.localStorage.getItem(THEME_STORAGE_KEY);
    return isThemeName(saved) ? saved : null;
  } catch {
    return null;
  }
}

function saveTheme(theme: ThemeName): void {
  try {
    window.localStorage.setItem(THEME_STORAGE_KEY, theme);
  } catch {
    // Storage can be unavailable in private or hardened browser contexts.
  }
}

function applyTheme(theme: ThemeName): void {
  document.documentElement.dataset.theme = theme;
  document.documentElement.style.colorScheme = theme === DARK_THEME ? "dark" : "light";

  document.querySelectorAll<HTMLElement>("[data-jw-theme-toggle]").forEach((control) => {
    const switchesToDark = theme === LIGHT_THEME;
    control.setAttribute("aria-label", switchesToDark ? "다크 모드로 전환" : "라이트 모드로 전환");
    control.setAttribute("aria-pressed", String(theme === DARK_THEME));
    const label = control.querySelector<HTMLElement>("[data-jw-theme-label]");
    if (label) label.textContent = switchesToDark ? "다크 모드" : "라이트 모드";
    const icon = control.querySelector<HTMLElement>("[data-lucide]");
    if (icon) icon.dataset.lucide = switchesToDark ? "moon" : "sun";
  });
}

function initializeThemeControls(): void {
  const media = window.matchMedia("(prefers-color-scheme: dark)");
  applyTheme(resolveThemeChoice(readSavedTheme(), media.matches));

  document.querySelectorAll<HTMLElement>("[data-jw-theme-toggle]").forEach((control) => {
    control.addEventListener("click", () => {
      const current = isThemeName(document.documentElement.dataset.theme)
        ? document.documentElement.dataset.theme
        : resolveThemeChoice(null, media.matches);
      const theme = nextTheme(current);
      saveTheme(theme);
      applyTheme(theme);
      renderIcons();
    });
  });

  media.addEventListener("change", (event) => {
    if (readSavedTheme() === null) {
      applyTheme(resolveThemeChoice(null, event.matches));
      renderIcons();
    }
  });
}

function initializeStickyHeader(): void {
  const header = document.querySelector<HTMLElement>("[data-jw-sticky-header]");
  if (!header || header.dataset.jwInitialized === "true") return;
  header.dataset.jwInitialized = "true";

  let previousY = Math.max(window.scrollY, 0);
  let distance = 0;
  let frame = 0;

  const show = (): void => header.classList.remove("is-hidden");
  const update = (): void => {
    frame = 0;
    const currentY = Math.max(window.scrollY, 0);
    const delta = currentY - previousY;
    header.classList.toggle("is-scrolled", currentY > 8);

    if (currentY <= 80 || header.contains(document.activeElement)) {
      distance = 0;
      show();
    } else if (delta < 0) {
      distance = 0;
      show();
    } else if (delta > 0) {
      distance += delta;
      if (distance >= 12) header.classList.add("is-hidden");
    }

    previousY = currentY;
  };

  window.addEventListener("scroll", () => {
    if (frame === 0) frame = window.requestAnimationFrame(update);
  }, { passive: true });
  header.addEventListener("focusin", show);
  update();
}

function initializePopupLayer(): void {
  const layer = document.querySelector<HTMLElement>("[data-jw-popup-layer]");
  if (!layer || layer.dataset.jwInitialized === "true") return;
  layer.dataset.jwInitialized = "true";

  layer.addEventListener("click", (event) => {
    const target = event.target instanceof Element
      ? event.target.closest<HTMLButtonElement>("[data-jw-popup-dismiss]")
      : null;
    const popup = target?.closest<HTMLElement>("[data-jw-popup]");
    if (!target || !popup) return;

    if (target.dataset.jwPopupDismiss === "snooze") {
      const name = popup.dataset.cookieName ?? "";
      const hours = Number.parseInt(target.dataset.hours ?? "0", 10);
      if (/^hd_pops_\d+$/.test(name) && Number.isFinite(hours) && hours > 0) {
        const expires = new Date(Date.now() + hours * 60 * 60 * 1000).toUTCString();
        const parts = [`${encodeURIComponent(name)}=1`, `Expires=${expires}`, "Path=/", "SameSite=Lax"];
        const cookieDomain = layer.dataset.cookieDomain?.trim();
        if (cookieDomain) parts.push(`Domain=${cookieDomain}`);
        if (window.location.protocol === "https:") parts.push("Secure");
        document.cookie = parts.join("; ");
      }
    }

    popup.hidden = true;
    if (!layer.querySelector("[data-jw-popup]:not([hidden])")) layer.hidden = true;
  });
}

function initializeBackToTop(): void {
  document.querySelectorAll<HTMLButtonElement>("[data-jw-back-to-top]").forEach((button) => {
    button.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: window.matchMedia("(prefers-reduced-motion: reduce)").matches ? "auto" : "smooth" });
    });
  });
}

function initializeReveals(): void {
  const elements = [...document.querySelectorAll<HTMLElement>("[data-jw-reveal]")];
  if (!elements.length || window.matchMedia("(prefers-reduced-motion: reduce)").matches || !("IntersectionObserver" in window)) return;

  elements.forEach((element) => element.classList.add("is-reveal-pending"));
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;
      entry.target.classList.add("is-revealed");
      observer.unobserve(entry.target);
    });
  }, { rootMargin: "0px 0px -10%", threshold: 0.08 });
  elements.forEach((element) => observer.observe(element));
}

function initializeBoardLists(): void {
  document.querySelectorAll<HTMLFormElement>("[data-jw-board-list]").forEach((form) => {
    const checkAll = form.querySelector<HTMLInputElement>("[data-jw-check-all]");
    const rowChecks = [...form.querySelectorAll<HTMLInputElement>("[data-jw-row-check]")];

    checkAll?.addEventListener("change", () => {
      rowChecks.forEach((checkbox) => {
        checkbox.checked = checkAll.checked;
      });
    });

    rowChecks.forEach((checkbox) => {
      checkbox.addEventListener("change", () => {
        if (!checkAll) return;
        checkAll.checked = rowChecks.length > 0 && rowChecks.every((item) => item.checked);
        checkAll.indeterminate = rowChecks.some((item) => item.checked) && !checkAll.checked;
      });
    });

    form.addEventListener("submit", (event) => {
      const submitter = event.submitter instanceof HTMLButtonElement ? event.submitter : null;
      const action = submitter?.dataset.jwListAction;
      if (!action) return;

      if (!rowChecks.some((checkbox) => checkbox.checked)) {
        event.preventDefault();
        window.alert("작업할 게시물을 하나 이상 선택해 주세요.");
        return;
      }

      if (action === "delete" && !window.confirm("선택한 게시물을 삭제하시겠습니까? 삭제한 자료는 복구할 수 없습니다.")) {
        event.preventDefault();
        return;
      }

      if (action === "copy" || action === "move") {
        event.preventDefault();
        const target = window.open("", "boardmove", "left=50,top=50,width=560,height=620,scrollbars=yes");
        if (!target) {
          window.alert("팝업 차단을 해제한 뒤 다시 시도해 주세요.");
          return;
        }
        const sw = form.elements.namedItem("sw");
        if (sw instanceof HTMLInputElement) sw.value = action;
        const originalAction = form.action;
        const originalTarget = form.target;
        form.target = "boardmove";
        form.action = form.action.replace(/board_list_update\.php(?:\?.*)?$/, "move.php");
        form.submit();
        form.action = originalAction;
        form.target = originalTarget;
        if (sw instanceof HTMLInputElement) sw.value = "";
      }
    });
  });
}

function initializeLinkActions(): void {
  document.addEventListener("click", async (event) => {
    const element = event.target instanceof Element ? event.target.closest<HTMLElement>("a, button") : null;
    if (!element) return;

    const confirmation = element.dataset.jwConfirm;
    if (confirmation && !window.confirm(confirmation)) {
      event.preventDefault();
      return;
    }

    if (element instanceof HTMLAnchorElement && element.dataset.jwPopupLink) {
      event.preventDefault();
      window.open(element.href, element.dataset.jwPopupLink, "left=50,top=50,width=560,height=620,scrollbars=yes");
      return;
    }

    if (element instanceof HTMLAnchorElement && element.matches("[data-jw-download]")) {
      const point = Number.parseInt(element.dataset.point ?? "0", 10);
      if (point < 0) {
        event.preventDefault();
        if (element.dataset.member !== "true") {
          window.alert("다운로드 권한이 없습니다. 로그인 후 이용해 주세요.");
          return;
        }
        if (!window.confirm("파일을 내려받으면 " + Math.abs(point).toLocaleString() + "점이 차감됩니다. 계속하시겠습니까?")) return;
        const url = new URL(element.href);
        url.searchParams.set("js", "on");
        window.location.href = url.toString();
      }
      return;
    }

    if (element instanceof HTMLAnchorElement && element.matches("[data-jw-reaction]")) {
      event.preventDefault();
      try {
        const body = new URLSearchParams({ js: "on" });
        const response = await fetch(element.href, {
          method: "POST",
          body,
          credentials: "same-origin",
          headers: { "X-Requested-With": "XMLHttpRequest" },
        });
        const data = await response.json() as { error?: string; count?: number | string };
        if (data.error) {
          window.alert(data.error);
          return;
        }
        const count = element.querySelector("strong");
        if (count && data.count !== undefined) count.textContent = Number(data.count).toLocaleString();
      } catch {
        window.location.href = element.href;
      }
    }
  });
}

function initializeCaptcha(): void {
  document.querySelectorAll<HTMLElement>("[data-jw-captcha]").forEach((captcha) => {
    const key = captcha.querySelector<HTMLInputElement>("#captcha_key");
    if (key) {
      key.inputMode = "numeric";
      key.autocomplete = "off";
      key.placeholder = "숫자 입력";
      key.setAttribute("aria-describedby", "captcha_info");
    }
    const image = captcha.querySelector<HTMLImageElement>("#captcha_img");
    const reload = captcha.querySelector<HTMLButtonElement>("#captcha_reload");
    const audioButton = captcha.querySelector<HTMLButtonElement>("#captcha_mp3");
    const audioElement = captcha.querySelector<HTMLAudioElement>("#captcha_audio");
    let audioUrl = "";

    const fetchAudioUrl = async (): Promise<string> => {
      const response = await fetch(captcha.dataset.audioUrl ?? "", {
        method: "POST",
        credentials: "same-origin",
        cache: "no-store",
      });
      const value = (await response.text()).trim();
      return value ? value + (value.includes("?") ? "&" : "?") + "t=" + Date.now() : "";
    };

    const refresh = async (): Promise<void> => {
      if (!image || !reload) return;
      reload.disabled = true;
      try {
        await fetch(captcha.dataset.sessionUrl ?? "", {
          method: "POST",
          credentials: "same-origin",
          cache: "no-store",
        });
        image.src = (captcha.dataset.imageUrl ?? "") + "?t=" + Date.now();
        audioUrl = await fetchAudioUrl();
        if (audioElement) audioElement.src = audioUrl;
      } finally {
        reload.disabled = false;
      }
    };

    reload?.addEventListener("click", () => void refresh());
    audioButton?.addEventListener("click", async () => {
      try {
        audioUrl = await fetchAudioUrl();
        if (!audioUrl) return;
        const player = audioElement ?? new Audio();
        player.src = audioUrl;
        await player.play();
      } catch {
        window.alert("음성 안내를 재생하지 못했습니다. 새로고침 후 다시 시도해 주세요.");
      }
    });
    void refresh();
  });
}

function showFormError(form: HTMLFormElement, message: string): void {
  let status = form.querySelector<HTMLElement>("[data-jw-form-status]");
  if (!status) {
    status = document.createElement("p");
    status.className = "jw-form-status";
    status.dataset.jwFormStatus = "";
    status.setAttribute("role", "alert");
    status.tabIndex = -1;
    form.prepend(status);
  }
  status.textContent = message;
  status.hidden = false;
  status.focus();
}

function initializeComments(): void {
  const toggle = document.querySelector<HTMLButtonElement>("[data-jw-comments-toggle]");
  const body = document.querySelector<HTMLElement>("[data-jw-comments-body]");
  if (toggle && body) {
    toggle.addEventListener("click", () => {
      const expanded = toggle.getAttribute("aria-expanded") === "true";
      toggle.setAttribute("aria-expanded", String(!expanded));
      toggle.textContent = expanded ? "댓글 펼치기" : "댓글 접기";
      body.hidden = expanded;
    });
  }

  const form = document.querySelector<HTMLFormElement>("[data-jw-comment-form]");
  if (!form) return;
  const originalWrap = document.querySelector<HTMLElement>("#jw-comment-form-wrap");
  const home = document.createComment("comment form home");
  originalWrap?.before(home);
  const cancel = form.querySelector<HTMLButtonElement>("[data-jw-comment-cancel]");
  const content = form.elements.namedItem("wr_content");
  const work = form.querySelector<HTMLInputElement>("[data-jw-comment-work]");
  const commentId = form.querySelector<HTMLInputElement>("[data-jw-comment-id]");
  const secret = form.querySelector<HTMLInputElement>("[data-jw-comment-secret]");
  const count = form.querySelector<HTMLElement>("[data-jw-comment-count] span");

  const updateCount = (): void => {
    if (content instanceof HTMLTextAreaElement && count) count.textContent = String([...content.value].length);
  };
  if (content instanceof HTMLTextAreaElement) content.addEventListener("input", updateCount);
  updateCount();
  cancel?.addEventListener("click", () => {
    if (!originalWrap || !(content instanceof HTMLTextAreaElement) || !work || !commentId) return;
    home.after(originalWrap);
    work.value = "c";
    commentId.value = "";
    content.value = "";
    if (secret) secret.checked = false;
    const heading = originalWrap.querySelector("h3");
    if (heading) heading.textContent = "댓글 쓰기";
    const submit = form.querySelector<HTMLButtonElement>('button[type="submit"]');
    if (submit) submit.textContent = "댓글 등록";
    cancel.hidden = true;
    updateCount();
    content.focus();
  });
  const redirectedComment = /^#c_(\d+)$/.exec(window.location.hash);
  if (redirectedComment) document.getElementById("comment-" + redirectedComment[1])?.scrollIntoView();

  document.querySelectorAll<HTMLAnchorElement>("[data-jw-comment-action]").forEach((link) => {
    link.addEventListener("click", (event) => {
      event.preventDefault();
      if (!originalWrap || !(content instanceof HTMLTextAreaElement) || !work || !commentId) return;
      const id = link.dataset.commentId ?? "";
      const mode = link.dataset.jwCommentAction === "edit" ? "cu" : "c";
      const slot = document.querySelector<HTMLElement>((mode === "cu" ? "#jw-comment-edit-" : "#jw-comment-reply-") + id);
      if (!slot) return;

      link.closest("details")?.removeAttribute("open");
      slot.append(originalWrap);
      if (cancel) cancel.hidden = false;
      const submit = form.querySelector<HTMLButtonElement>('button[type="submit"]');
      if (submit) submit.textContent = mode === "cu" ? "수정 저장" : "답글 등록";
      work.value = mode;
      commentId.value = id;
      content.value = mode === "cu"
        ? document.querySelector<HTMLTextAreaElement>("#jw-comment-saved-" + id)?.value ?? ""
        : "";
      if (secret) secret.checked = mode === "cu" && Boolean(document.querySelector<HTMLInputElement>("#jw-comment-secret-" + id)?.value);
      const heading = originalWrap.querySelector("h3");
      if (heading) heading.textContent = mode === "cu" ? "댓글 수정" : "답글 쓰기";
      document.querySelector<HTMLButtonElement>("#captcha_reload")?.click();
      updateCount();
      content.focus();
    });
  });

  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    if (form.dataset.jwSubmitting === "true" || form.dataset.jwChecking === "true" || !(content instanceof HTMLTextAreaElement)) return;

    content.value = content.value.trim();
    const length = [...content.value].length;
    const min = Number.parseInt(form.dataset.min ?? "0", 10);
    const max = Number.parseInt(form.dataset.max ?? "0", 10);
    if (!content.value || (min > 0 && length < min) || (max > 0 && length > max)) {
      showFormError(form, min || max ? "댓글은 " + min + "자 이상 " + max + "자 이하로 입력해 주세요." : "댓글 내용을 입력해 주세요.");
      content.focus();
      return;
    }

    const name = form.elements.namedItem("wr_name");
    const password = form.elements.namedItem("wr_password");
    if (name instanceof HTMLInputElement && !name.value.trim()) {
      showFormError(form, "이름을 입력해 주세요.");
      name.focus();
      return;
    }
    if (password instanceof HTMLInputElement && !password.value.trim()) {
      showFormError(form, "비밀번호를 입력해 주세요.");
      password.focus();
      return;
    }

    form.dataset.jwChecking = "true";
    form.setAttribute("aria-busy", "true");
    const submitButton = form.querySelector<HTMLButtonElement>('button[type="submit"]');
    if (submitButton) submitButton.disabled = true;
    const priorStatus = form.querySelector<HTMLElement>("[data-jw-form-status]");
    if (priorStatus) priorStatus.hidden = true;
    try {
      const captchaKey = form.elements.namedItem("captcha_key");
      if (captchaKey instanceof HTMLInputElement) {
        const captchaResponse = await fetch(form.dataset.captchaResultUrl ?? "", {
          method: "POST",
          body: new URLSearchParams({ captcha_key: captchaKey.value }),
          credentials: "same-origin",
          headers: { "X-Requested-With": "XMLHttpRequest" },
        });
        if ((await captchaResponse.text()).trim() !== "1") {
          showFormError(form, "자동등록방지 문자가 맞지 않습니다. 새로고침 후 다시 입력해 주세요.");
          form.querySelector<HTMLButtonElement>("#captcha_reload")?.click();
          captchaKey.select();
          captchaKey.focus();
          return;
        }
      }

      const filterResponse = await fetch(form.dataset.filterUrl ?? "", {
        method: "POST",
        body: new URLSearchParams({ subject: "", content: content.value }),
        credentials: "same-origin",
        headers: { "X-Requested-With": "XMLHttpRequest" },
      });
      const filter = await filterResponse.json() as { content?: string };
      if (filter.content) {
        showFormError(form, "내용에 금지단어('" + filter.content + "')가 포함되어 있습니다.");
        content.focus();
        return;
      }

      const tokenResponse = await fetch(form.dataset.tokenUrl ?? "", { credentials: "same-origin", cache: "no-store" });
      const tokenData = await tokenResponse.json() as { token?: string };
      if (!tokenData.token) throw new Error("missing comment token");
      const existingToken = form.elements.namedItem("token");
      let tokenInput: HTMLInputElement;
      if (existingToken instanceof HTMLInputElement) {
        tokenInput = existingToken;
      } else {
        tokenInput = document.createElement("input");
        tokenInput.type = "hidden";
        tokenInput.name = "token";
        form.prepend(tokenInput);
      }
      tokenInput.value = tokenData.token;
      form.dataset.jwSubmitting = "true";
      form.querySelector<HTMLButtonElement>('button[type="submit"]')?.setAttribute("disabled", "");
      form.submit();
    } catch {
      form.dataset.jwSubmitting = "false";
      showFormError(form, "댓글 등록 준비 중 오류가 발생했습니다. 잠시 후 다시 시도해 주세요.");
    } finally {
      delete form.dataset.jwChecking;
      form.removeAttribute("aria-busy");
      if (form.dataset.jwSubmitting !== "true" && submitButton) submitButton.disabled = false;
    }
  });
}

function initializeLogin(): void {
  document.querySelectorAll<HTMLButtonElement>("[data-jw-find-certify]").forEach((button) => {
    button.addEventListener("click", () => {
      if (button.dataset.certUrl) window.open(button.dataset.certUrl, button.dataset.windowName || "auth_popup", "width=440,height=620,scrollbars=yes,resizable=yes")?.focus();
    });
  });
  document.querySelector<HTMLFormElement>("[data-jw-password-reset]")?.addEventListener("submit", (event) => {
    const form = event.currentTarget as HTMLFormElement;
    const password = form.elements.namedItem("mb_password") as HTMLInputElement;
    const repeat = form.elements.namedItem("mb_password_re") as HTMLInputElement;
    if (password.value !== repeat.value) {
      event.preventDefault();
      showFormError(form, "새 비밀번호와 비밀번호 확인이 일치하지 않습니다.");
      repeat.focus();
    }
  });
  document.querySelectorAll<HTMLInputElement>("[data-jw-auto-login]").forEach((checkbox) => {
    checkbox.addEventListener("change", () => {
      if (checkbox.checked) {
        checkbox.checked = window.confirm("자동 로그인은 공용 기기에서 개인정보가 노출될 수 있습니다. 사용하시겠습니까?");
      }
    });
  });
}

function initializeWriteForm(): void {
  const form = document.querySelector<HTMLFormElement>("[data-jw-write-form]");
  if (!form) return;
  const subject = form.elements.namedItem("wr_subject");
  const content = form.elements.namedItem("wr_content");
  const count = form.querySelector<HTMLElement>("[data-jw-write-count]");

  const syncEditor = (): void => {
    const editorReader = (window as typeof window & { get_editor_wr_content?: () => string }).get_editor_wr_content;
    if (content instanceof HTMLTextAreaElement && typeof editorReader === "function") {
      content.value = editorReader();
    }
  };
  const updateCount = (): void => {
    if (content instanceof HTMLTextAreaElement && count) count.textContent = String([...content.value].length);
  };
  if (content instanceof HTMLTextAreaElement) content.addEventListener("input", updateCount);
  updateCount();

  form.querySelector<HTMLInputElement>("[data-jw-html-mode]")?.addEventListener("change", (event) => {
    const checkbox = event.currentTarget as HTMLInputElement;
    if (!checkbox.checked) {
      checkbox.value = "";
      return;
    }
    checkbox.value = window.confirm("줄바꿈을 HTML <br> 태그로 변환하시겠습니까?") ? "html2" : "html1";
  });

  form.querySelectorAll<HTMLInputElement>('input[type="file"]').forEach((input) => {
    input.addEventListener("change", () => {
      const hasSvg = [...(input.files ?? [])].some((file) => /\.svg(?:z)?$/i.test(file.name) || /image\/svg\+xml/i.test(file.type));
      if (hasSvg) {
        showFormError(form, "SVG 파일은 업로드할 수 없습니다.");
        input.value = "";
      }
    });
  });

  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    if (form.dataset.jwSubmitting === "true" || form.dataset.jwChecking === "true") return;
    syncEditor();
    if (!(subject instanceof HTMLInputElement) || !(content instanceof HTMLTextAreaElement)) {
      showFormError(form, "글쓰기 입력 필드를 확인할 수 없습니다.");
      return;
    }
    subject.value = subject.value.trim();
    content.value = content.value.trim();
    if (!subject.value) {
      showFormError(form, "제목을 입력해 주세요.");
      subject.focus();
      return;
    }
    const length = [...content.value].length;
    const min = Number.parseInt(form.dataset.min ?? "0", 10);
    const max = Number.parseInt(form.dataset.max ?? "0", 10);
    if (!content.value || (min > 0 && length < min) || (max > 0 && length > max)) {
      showFormError(form, min || max ? "내용은 " + min + "자 이상 " + max + "자 이하로 입력해 주세요." : "내용을 입력해 주세요.");
      content.focus();
      return;
    }

    form.dataset.jwChecking = "true";
    form.setAttribute("aria-busy", "true");
    const submitButton = form.querySelector<HTMLButtonElement>('button[type="submit"]');
    if (submitButton) submitButton.disabled = true;
    const priorStatus = form.querySelector<HTMLElement>("[data-jw-form-status]");
    if (priorStatus) priorStatus.hidden = true;
    try {
      const captchaKey = form.elements.namedItem("captcha_key");
      if (captchaKey instanceof HTMLInputElement) {
        const captchaResponse = await fetch(form.dataset.captchaResultUrl ?? "", {
          method: "POST",
          body: new URLSearchParams({ captcha_key: captchaKey.value }),
          credentials: "same-origin",
          headers: { "X-Requested-With": "XMLHttpRequest" },
        });
        if ((await captchaResponse.text()).trim() !== "1") {
          showFormError(form, "자동등록방지 문자가 맞지 않습니다. 새로고침 후 다시 입력해 주세요.");
          form.querySelector<HTMLButtonElement>("#captcha_reload")?.click();
          captchaKey.select();
          captchaKey.focus();
          return;
        }
      }

      const filterResponse = await fetch(form.dataset.filterUrl ?? "", {
        method: "POST",
        body: new URLSearchParams({ subject: subject.value, content: content.value }),
        credentials: "same-origin",
        headers: { "X-Requested-With": "XMLHttpRequest" },
      });
      const filter = await filterResponse.json() as { subject?: string; content?: string };
      if (filter.subject || filter.content) {
        showFormError(form, (filter.subject ? "제목" : "내용") + "에 금지단어('" + (filter.subject || filter.content) + "')가 포함되어 있습니다.");
        (filter.subject ? subject : content).focus();
        return;
      }

      const boTable = form.elements.namedItem("bo_table");
      if (!(boTable instanceof HTMLInputElement)) throw new Error("missing board");
      const tokenResponse = await fetch(form.dataset.tokenUrl ?? "", {
        method: "POST",
        body: new URLSearchParams({ bo_table: boTable.value }),
        credentials: "same-origin",
        headers: { "X-Requested-With": "XMLHttpRequest" },
      });
      const tokenData = await tokenResponse.json() as { error?: string; token?: string; url?: string };
      if (tokenData.error || !tokenData.token) {
        showFormError(form, tokenData.error || "글쓰기 토큰을 발급하지 못했습니다.");
        if (tokenData.url) window.location.href = tokenData.url;
        return;
      }
      const tokenInput = document.createElement("input");
      tokenInput.type = "hidden";
      tokenInput.name = "token";
      tokenInput.value = tokenData.token;
      form.prepend(tokenInput);
      form.dataset.jwSubmitting = "true";
      form.querySelector<HTMLButtonElement>('button[type="submit"]')?.setAttribute("disabled", "");
      form.submit();
    } catch {
      form.dataset.jwSubmitting = "false";
      showFormError(form, "작성 준비 중 오류가 발생했습니다. 잠시 후 다시 시도해 주세요.");
    } finally {
      delete form.dataset.jwChecking;
      form.removeAttribute("aria-busy");
      if (form.dataset.jwSubmitting !== "true" && submitButton) submitButton.disabled = false;
    }
  });

  const dialog = form.querySelector<HTMLDialogElement>("[data-jw-autosave-dialog]");
  const open = form.querySelector<HTMLButtonElement>("[data-jw-autosave-open]");
  const close = dialog?.querySelector<HTMLButtonElement>("[data-jw-autosave-close]");
  const list = dialog?.querySelector<HTMLUListElement>("[data-jw-autosave-list]");
  const countLabel = form.querySelector<HTMLElement>("[data-jw-autosave-count]");
  if (!dialog || !open || !close || !list || !(subject instanceof HTMLInputElement) || !(content instanceof HTMLTextAreaElement)) return;

  const parseXml = (value: string): Document => new DOMParser().parseFromString(value, "application/xml");
  const loadList = async (): Promise<void> => {
    const response = await fetch(dialog.dataset.listUrl ?? "", { credentials: "same-origin", cache: "no-store" });
    const items = [...parseXml(await response.text()).querySelectorAll("list > item")];
    list.replaceChildren();
    if (!items.length) {
      const empty = document.createElement("li");
      empty.className = "jw-autosave-dialog__empty";
      empty.textContent = "임시 저장된 글이 없습니다.";
      list.append(empty);
      return;
    }
    items.forEach((item) => {
      const row = document.createElement("li");
      const loadButton = document.createElement("button");
      const deleteButton = document.createElement("button");
      const date = document.createElement("time");
      loadButton.type = "button";
      loadButton.textContent = item.querySelector("subject")?.textContent || "제목 없음";
      loadButton.dataset.asId = item.querySelector("id")?.textContent ?? "";
      loadButton.dataset.uid = item.querySelector("uid")?.textContent ?? "";
      loadButton.dataset.jwAutosaveLoad = "";
      date.textContent = item.querySelector("datetime")?.textContent ?? "";
      deleteButton.type = "button";
      deleteButton.textContent = "삭제";
      deleteButton.dataset.asId = loadButton.dataset.asId;
      deleteButton.dataset.jwAutosaveDelete = "";
      row.append(loadButton, date, deleteButton);
      list.append(row);
    });
  };

  open.addEventListener("click", () => {
    void loadList().then(() => dialog.showModal());
  });
  close.addEventListener("click", () => dialog.close());
  dialog.addEventListener("click", (event) => {
    if (event.target === dialog) dialog.close();
  });
  list.addEventListener("click", async (event) => {
    const target = event.target instanceof Element ? event.target.closest<HTMLButtonElement>("button") : null;
    if (!target) return;
    const asId = target.dataset.asId ?? "";
    if (target.hasAttribute("data-jw-autosave-load")) {
      const url = new URL(dialog.dataset.loadUrl ?? "", window.location.href);
      url.searchParams.set("as_id", asId);
      const response = await fetch(url, { credentials: "same-origin" });
      const item = parseXml(await response.text()).querySelector("item");
      subject.value = item?.querySelector("subject")?.textContent ?? "";
      content.value = item?.querySelector("content")?.textContent ?? "";
      const uid = form.elements.namedItem("uid");
      if (uid instanceof HTMLInputElement) uid.value = target.dataset.uid ?? uid.value;
      updateCount();
      dialog.close();
    } else if (target.hasAttribute("data-jw-autosave-delete") && window.confirm("이 임시 저장 글을 삭제하시겠습니까?")) {
      const url = new URL(dialog.dataset.deleteUrl ?? "", window.location.href);
      url.searchParams.set("as_id", asId);
      const response = await fetch(url, { credentials: "same-origin" });
      const newCount = (await response.text()).trim();
      if (newCount === "-1") {
        showFormError(form, "임시 저장 글을 삭제하지 못했습니다.");
        return;
      }
      if (countLabel) countLabel.textContent = newCount;
      target.closest("li")?.remove();
    }
  });

  let savedSubject = subject.value;
  let savedContent = content.value;
  window.setInterval(async () => {
    syncEditor();
    if (!subject.value || !content.value || (subject.value === savedSubject && content.value === savedContent)) return;
    const uid = form.elements.namedItem("uid");
    if (!(uid instanceof HTMLInputElement)) return;
    const response = await fetch(dialog.dataset.saveUrl ?? "", {
      method: "POST",
      body: new URLSearchParams({ uid: uid.value, subject: subject.value, content: content.value }),
      credentials: "same-origin",
      headers: { "X-Requested-With": "XMLHttpRequest" },
    });
    const newCount = (await response.text()).trim();
    if (newCount && countLabel) countLabel.textContent = newCount;
    savedSubject = subject.value;
    savedContent = content.value;
  }, 60_000);
}

function initializeRegistrationTerms(): void {
  const form = document.querySelector<HTMLFormElement>("[data-jw-register-terms]");
  if (!form) return;
  const agreements = [...form.querySelectorAll<HTMLInputElement>("[data-jw-required-agreement]")];
  const all = form.querySelector<HTMLInputElement>("[data-jw-agree-all]");

  const syncAll = (): void => {
    if (!all) return;
    all.checked = agreements.length > 0 && agreements.every((agreement) => agreement.checked);
    all.indeterminate = agreements.some((agreement) => agreement.checked) && !all.checked;
  };
  all?.addEventListener("change", () => {
    agreements.forEach((agreement) => {
      agreement.checked = all.checked;
    });
  });
  agreements.forEach((agreement) => agreement.addEventListener("change", syncAll));

  form.addEventListener("submit", (event) => {
    const missing = agreements.find((agreement) => !agreement.checked);
    if (!missing) return;
    event.preventDefault();
    window.alert("회원가입에 필요한 필수 약관에 동의해 주세요.");
    missing.focus();
  });
}

function initializeMemberForm(): void {
  const form = document.querySelector<HTMLFormElement>("[data-jw-member-form]");
  if (!form) return;

  const input = (name: string): HTMLInputElement | null => {
    const field = form.elements.namedItem(name);
    return field instanceof HTMLInputElement ? field : null;
  };
  const showStatus = (name: string, message: string, success = false): void => {
    const status = form.querySelector<HTMLElement>(`[data-jw-field-status="${name}"]`);
    if (!status) return;
    status.textContent = message;
    status.classList.toggle("jw-field-status--success", success);
    status.classList.toggle("jw-field-status--error", !success && message !== "");
  };
  const checkEndpoint = async (url: string | undefined, values: Record<string, string>): Promise<string> => {
    if (!url) return "입력값 검사 주소를 확인할 수 없습니다.";
    const response = await fetch(url, {
      method: "POST",
      body: new URLSearchParams(values),
      credentials: "same-origin",
      headers: { "X-Requested-With": "XMLHttpRequest" },
    });
    if (!response.ok) return "입력값을 확인하지 못했습니다. 잠시 후 다시 시도해 주세요.";
    return (await response.text()).trim();
  };

  form.querySelectorAll<HTMLInputElement>('input[type="file"]').forEach((fileInput) => {
    fileInput.addEventListener("change", () => {
      const invalid = [...(fileInput.files ?? [])].some((file) => !/\.(?:gif|jpe?g|png)$/i.test(file.name));
      if (!invalid) return;
      showFormError(form, "회원 이미지는 GIF, JPG, PNG 파일만 등록할 수 있습니다.");
      fileInput.value = "";
    });
  });

  form.querySelectorAll<HTMLButtonElement>("[data-jw-certify]").forEach((button) => {
    button.addEventListener("click", () => {
      const currentType = input("cert_type")?.value ?? "";
      if (currentType && !window.confirm("이미 본인확인을 완료했습니다. 기존 인증을 취소하고 다시 진행하시겠습니까?")) return;
      const url = button.dataset.certUrl;
      if (!url) {
        showFormError(form, "본인확인 설정을 확인해 주세요.");
        return;
      }
      const popup = window.open(url, button.dataset.windowName || "auth_popup", "width=440,height=620,scrollbars=yes,resizable=yes");
      popup?.focus();
    });
  });

  form.querySelector<HTMLButtonElement>("[data-jw-address-search]")?.addEventListener("click", () => {
    type PostcodeResult = {
      zonecode: string;
      roadAddress: string;
      jibunAddress: string;
      userSelectedType: "R" | "J";
      bname: string;
      buildingName: string;
    };
    type PostcodeApi = new (options: { oncomplete: (data: PostcodeResult) => void }) => { open: () => void };
    const addressWindow = window as typeof window & {
      kakao?: { Postcode?: PostcodeApi };
      daum?: { Postcode?: PostcodeApi };
    };
    const Postcode = addressWindow.kakao?.Postcode ?? addressWindow.daum?.Postcode;
    if (!Postcode) {
      showFormError(form, "주소 검색 서비스를 불러오는 중입니다. 잠시 후 다시 시도해 주세요.");
      return;
    }
    new Postcode({
      oncomplete: (data) => {
        const primary = data.userSelectedType === "R" ? data.roadAddress : data.jibunAddress;
        const extras = data.userSelectedType === "R" ? [data.bname, data.buildingName].filter(Boolean).join(", ") : "";
        const zip = input("mb_zip");
        const address1 = input("mb_addr1");
        const address2 = input("mb_addr2");
        const address3 = input("mb_addr3");
        const jibeon = input("mb_addr_jibeon");
        if (zip) zip.value = data.zonecode;
        if (address1) address1.value = primary;
        if (address3) address3.value = extras ? `(${extras})` : "";
        if (jibeon) jibeon.value = data.userSelectedType;
        address2?.focus();
      },
    }).open();
  });

  const promotionParent = form.querySelector<HTMLInputElement>("[data-jw-promotion-parent]");
  const promotionChildren = [...form.querySelectorAll<HTMLInputElement>("[data-jw-promotion-child]")];
  const syncPromotionParent = (): void => {
    if (!promotionParent) return;
    promotionParent.checked = promotionChildren.length > 0 && promotionChildren.every((child) => child.checked);
    promotionParent.indeterminate = promotionChildren.some((child) => child.checked) && !promotionParent.checked;
  };
  promotionParent?.addEventListener("change", () => {
    promotionChildren.forEach((child) => {
      child.checked = promotionParent.checked;
    });
  });
  promotionChildren.forEach((child) => child.addEventListener("change", syncPromotionParent));
  syncPromotionParent();

  const consentDialog = document.querySelector<HTMLDialogElement>("[data-jw-consent-dialog]");
  const consentTitle = consentDialog?.querySelector<HTMLElement>("[data-jw-consent-title]");
  const consentContent = consentDialog?.querySelector<HTMLElement>("[data-jw-consent-content]");
  document.querySelectorAll<HTMLButtonElement>("[data-jw-consent-open]").forEach((button) => {
    button.addEventListener("click", () => {
      const template = document.getElementById(button.dataset.jwConsentOpen ?? "");
      if (!consentDialog || !consentContent || !(template instanceof HTMLTemplateElement)) return;
      if (consentTitle) consentTitle.textContent = button.closest(".jw-preference")?.querySelector("strong")?.textContent ?? "선택 동의 안내";
      consentContent.replaceChildren(template.content.cloneNode(true));
      consentDialog.showModal();
    });
  });
  consentDialog?.querySelector<HTMLButtonElement>("[data-jw-consent-close]")?.addEventListener("click", () => consentDialog.close());
  consentDialog?.addEventListener("click", (event) => {
    if (event.target === consentDialog) consentDialog.close();
  });

  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    if (form.dataset.jwSubmitting === "true" || form.dataset.jwChecking === "true") return;
    if (!form.reportValidity()) return;

    const id = input("mb_id");
    const password = input("mb_password");
    const passwordRepeat = input("mb_password_re");
    const nickname = input("mb_nick");
    const email = input("mb_email");
    const phone = input("mb_hp");
    const recommend = input("mb_recommend");
    const isNew = form.dataset.mode === "";

    if (password?.value !== passwordRepeat?.value) {
      showFormError(form, "비밀번호가 일치하지 않습니다.");
      passwordRepeat?.focus();
      return;
    }
    if (isNew && form.dataset.certRequired === "true" && !input("cert_no")?.value) {
      showFormError(form, "회원가입을 위해 본인확인을 완료해 주세요.");
      form.querySelector<HTMLButtonElement>("[data-jw-certify]")?.focus();
      return;
    }
    if (recommend?.value && id?.value.toLowerCase() === recommend.value.toLowerCase()) {
      showFormError(form, "본인을 추천인으로 입력할 수 없습니다.");
      recommend.focus();
      return;
    }

    form.dataset.jwChecking = "true";
    form.setAttribute("aria-busy", "true");
    const submitButton = form.querySelector<HTMLButtonElement>('button[type="submit"]');
    if (submitButton) submitButton.disabled = true;
    const priorStatus = form.querySelector<HTMLElement>("[data-jw-form-status]");
    if (priorStatus) priorStatus.hidden = true;
    try {
      const checks: Array<{ name: string; field: HTMLInputElement; url: string | undefined; values: Record<string, string> }> = [];
      if (isNew && id) checks.push({ name: "id", field: id, url: form.dataset.idUrl, values: { reg_mb_id: id.value } });
      if (nickname) checks.push({ name: "nick", field: nickname, url: form.dataset.nickUrl, values: { reg_mb_nick: nickname.value, reg_mb_id: id?.value ?? "" } });
      if (email) checks.push({ name: "email", field: email, url: form.dataset.emailUrl, values: { reg_mb_email: email.value, reg_mb_id: id?.value ?? "" } });
      if (phone?.value) checks.push({ name: "phone", field: phone, url: form.dataset.phoneUrl, values: { reg_mb_hp: phone.value, reg_mb_id: id?.value ?? "" } });
      if (recommend?.value) checks.push({ name: "recommend", field: recommend, url: form.dataset.recommendUrl, values: { reg_mb_recommend: recommend.value } });

      for (const check of checks) {
        showStatus(check.name, "확인 중…");
        const message = await checkEndpoint(check.url, check.values);
        if (message) {
          showStatus(check.name, message);
          showFormError(form, message);
          check.field.focus();
          return;
        }
        showStatus(check.name, "확인되었습니다.", true);
      }

      const captchaKey = input("captcha_key");
      if (captchaKey) {
        const captchaResponse = await fetch(form.dataset.captchaResultUrl ?? "", {
          method: "POST",
          body: new URLSearchParams({ captcha_key: captchaKey.value }),
          credentials: "same-origin",
          headers: { "X-Requested-With": "XMLHttpRequest" },
        });
        if ((await captchaResponse.text()).trim() !== "1") {
          showFormError(form, "자동등록방지 문자가 맞지 않습니다. 새로고침 후 다시 입력해 주세요.");
          form.querySelector<HTMLButtonElement>("#captcha_reload")?.click();
          captchaKey.select();
          captchaKey.focus();
          return;
        }
      }

      form.dataset.jwSubmitting = "true";
      form.querySelector<HTMLButtonElement>('button[type="submit"]')?.setAttribute("disabled", "");
      form.submit();
    } catch {
      form.dataset.jwSubmitting = "false";
      showFormError(form, "회원정보 확인 중 오류가 발생했습니다. 잠시 후 다시 시도해 주세요.");
    } finally {
      delete form.dataset.jwChecking;
      form.removeAttribute("aria-busy");
      if (form.dataset.jwSubmitting !== "true" && submitButton) submitButton.disabled = false;
    }
  });
}

function renderIcons(): void {
  createIcons({
    attrs: { "aria-hidden": "true", focusable: "false", "stroke-width": 1.8 },
    icons: {
      ArrowDown,
  Building2,
  Target,
  Files,
  Calendar,
  Compass,
  Monitor,
  ArrowLeft,
      ArrowRight,
      ArrowUp,
      ArrowUpRight,
      ChevronDown,
      LogOut,
      Image,
      Lock,
      Menu,
      MessageCircle,
      Moon,
      Search,
      Sun,
      UserRound,
      X
    }
  });
}

export function initializeTheme(): void {
  const run = (): void => {
    initializeThemeControls();
    initializeStickyHeader();
    initializeMobileMenu();
    initializePopupLayer();
    initializeBackToTop();
    initializeReveals();
    initializeBoardLists();
    initializeLinkActions();
    initializeCaptcha();
    initializeComments();
    initializeLogin();
    initializeWriteForm();
    initializeRegistrationTerms();
    initializeMemberForm();
    renderIcons();
  };

  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", run, { once: true });
  else run();
}
