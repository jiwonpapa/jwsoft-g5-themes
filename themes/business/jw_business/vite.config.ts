import tailwindcss from "@tailwindcss/vite";
import { defineConfig } from "vite";
import { resolve } from "node:path";

export default defineConfig({
  base: "./",
  plugins: [tailwindcss()],
  build: {
    assetsInlineLimit: 0,
    cssCodeSplit: true,
    emptyOutDir: true,
    minify: true,
    outDir: "build/vite",
    sourcemap: false,
    target: ["chrome111", "firefox128", "safari16.4"],
    rollupOptions: {
      input: {
        "jw-business": resolve(import.meta.dirname, "src/scripts/theme.ts"),
        "home-one": resolve(import.meta.dirname, "src/scripts/home-one-entry.ts"),
        "home-four": resolve(import.meta.dirname, "src/scripts/home-four-entry.ts"),
        "onepages": resolve(import.meta.dirname, "src/scripts/onepages-entry.ts"),
      },
      output: {
        entryFileNames: "js/[name].min.js",
        chunkFileNames: "js/chunks/[name]-[hash].js",
        assetFileNames: (asset) => {
          const name = asset.names[0] ?? "asset";
          if (name.endsWith(".css")) return name.includes("home-one") ? "css/home-one.min.css" : name.includes("home-four") ? "css/home-four.min.css" : name.includes("onepages") ? "css/onepages.min.css" : "css/jw-business.min.css";
          if (name.endsWith(".woff2")) return "fonts/[name][extname]";
          return "assets/[name]-[hash][extname]";
        }
      }
    }
  }
});
