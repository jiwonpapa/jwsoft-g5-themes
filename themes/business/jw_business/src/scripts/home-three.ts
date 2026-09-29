import { scroll } from "motion";

/** Main 3 connects the concourse map to the actual destination signs. */
export function initializeHomeThree(root: ParentNode = document): void {
  const scene = root.querySelector<HTMLElement>("[data-jwh3-wayfinding-scroll]");
  if (!scene || scene.dataset.jwh3Ready === "true") return;
  scene.dataset.jwh3Ready = "true";
  const reduced = window.matchMedia("(prefers-reduced-motion: reduce)");
  const desktop = window.matchMedia("(min-width: 768px)");
  const buttons = Array.from(scene.querySelectorAll<HTMLButtonElement>("[data-jwh3-route]"));
  const routes = ["a", "b", "c"];
  let stopScroll: (() => void) | undefined;
  let manual = false;
  const select = (route: string): void => {
    scene.dataset.routeStep = route;
    buttons.forEach(button => button.setAttribute("aria-pressed", String(button.dataset.jwh3Route === route)));
  };
  const configure = (): void => {
    stopScroll?.();
    manual = false;
    scene.dataset.jwh3Motion = String(!reduced.matches);
    select("a");
    if (!reduced.matches && desktop.matches) {
      stopScroll = scroll((progress: number) => {
        if (!manual) select(routes[Math.min(2, Math.floor(progress * 3))] ?? "a");
      }, { target: scene.querySelector<HTMLElement>(".jwh3-wayfinding-v2") ?? scene, offset: ["start 0.5", "start 0"] });
    }
  };
  buttons.forEach(button => button.addEventListener("click", () => {
    manual = true;
    select(button.dataset.jwh3Route ?? "a");
  }));
  reduced.addEventListener("change", configure);
  desktop.addEventListener("change", configure);
  configure();
  window.addEventListener("beforeunload", () => {
    stopScroll?.();
    reduced.removeEventListener("change", configure);
    desktop.removeEventListener("change", configure);
  }, { once: true });
}
