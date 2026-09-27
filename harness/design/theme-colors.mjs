import stylelint from "stylelint";
import valueParser from "postcss-value-parser";

export const ruleName = "jw/theme-colors";
export const messages = stylelint.utils.ruleMessages(ruleName, {
  rejected: value => "Use a semantic token for UI color: " + value,
});
export function fixedColors(value) {
  const found = [];
  valueParser(value).walk(node => {
    if (node.type === "function" && ["url"].includes(node.value.toLowerCase())) return false;
    if (node.type === "function" && /^(rgb|rgba|hsl|hsla|hwb|lab|lch|oklab|oklch|color)$/i.test(node.value)) {
      found.push(valueParser.stringify(node)); return false;
    }
    if (node.type === "word" && (/^#[\da-f]{3,8}$/i.test(node.value) || /^(white|black|red|blue|green|gray|grey|yellow|orange|purple|pink)$/i.test(node.value))) found.push(node.value);
  });
  return found;
}
export default stylelint.createPlugin(ruleName, (enabled, options = {}) => (root, result) => {
  if (!enabled) return;
  root.walkDecls(decl => {
    if (!/color|background|border|shadow|fill|stroke|^--/.test(decl.prop)) return;
    // daisyUI palette definitions are the theme provider, not consumers bypassing tokens.
    if (decl.parent?.type === 'atrule' && decl.parent.name === 'plugin' && /^['"]daisyui\/theme['"]$/.test(decl.parent.params) && decl.prop.startsWith('--color-')) return;
    const selector = decl.parent?.selector || "";
    if ((options.artworkSelectors || []).some(pattern => new RegExp(pattern).test(selector))) return;
    for (const color of fixedColors(decl.value)) stylelint.utils.report({ message: messages.rejected(color), node: decl, result, ruleName });
  });
});
