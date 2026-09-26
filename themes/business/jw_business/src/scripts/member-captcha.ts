type Recaptcha = {
  render(element: HTMLElement, options: Record<string, unknown>): number;
  getResponse(id: number): string;
  execute(id: number): void;
  reset(id: number): void;
};

// Only the configured reCAPTCHA screen loads the provider. Its response remains
// a normal form field, verified by G5's existing server-side captcha library.
export function initializeMemberRecaptcha(form: HTMLFormElement, showError: (message: string) => void): () => boolean {
  const container = form.querySelector<HTMLElement>(".g-recaptcha");
  if (!container) return () => true;
  const providerWindow = window as typeof window & { grecaptcha?: Recaptcha; jwMemberCaptchaReady?: () => void };
  let widget: number | undefined;
  let pending = false;
  const invisible = container.dataset.size === "invisible";
  const render = (): void => {
    if (!providerWindow.grecaptcha || widget !== undefined) return;
    widget = providerWindow.grecaptcha.render(container, {
      sitekey: container.dataset.sitekey,
      size: invisible ? "invisible" : "compact",
      badge: "inline",
      callback: () => {
        if (!pending) return;
        pending = false;
        form.requestSubmit();
      },
      "expired-callback": () => { pending = false; },
      "error-callback": () => {
        pending = false;
        showError("자동등록방지 연결에 실패했습니다. 네트워크를 확인한 뒤 다시 시도해 주세요.");
      },
    });
  };
  providerWindow.jwMemberCaptchaReady = render;
  const script = document.createElement("script");
  script.src = "https://www.google.com/recaptcha/api.js?hl=ko&render=explicit&onload=jwMemberCaptchaReady";
  script.async = true;
  script.addEventListener("error", () => showError("자동등록방지를 불러오지 못했습니다. 네트워크를 확인한 뒤 페이지를 새로고침해 주세요."));
  document.head.append(script);

  return () => {
    const provider = providerWindow.grecaptcha;
    if (!provider || widget === undefined) {
      showError("자동등록방지를 불러오는 중입니다. 잠시 후 다시 시도해 주세요.");
      return false;
    }
    if (provider.getResponse(widget)) return true;
    if (invisible) {
      if (!pending) { pending = true; provider.execute(widget); }
    } else {
      showError("자동등록방지 확인을 완료해 주세요.");
      container.scrollIntoView({ block: "center" });
    }
    return false;
  };
}
