export default {
  plugins: ["./harness/design/theme-colors.mjs"],
  rules: {
    "color-no-invalid-hex": true,
    "block-no-empty": true,
    "declaration-block-no-duplicate-properties": true,
    "jw/theme-colors": true,
  },
  overrides: [{
    files: ["**/home-four.css"],
    rules: {
      // FORME website/brand specimens: docs/MAIN-4-DESIGN.md. Hosting UI remains token-based.
      "jw/theme-colors": [true, { artworkSelectors: ["^\\.h4-demo", "^\\.h4-brand-wordmark", "^\\.h4-swatch"] }],
    },
  }],
};
