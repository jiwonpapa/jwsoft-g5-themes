import tailwindcss from "@tailwindcss/vite";
import { defineConfig } from "vite";
import { resolve } from "node:path";

export default defineConfig({
  base: "./",
  plugins: [tailwindcss()],
  build: {
    assetsInlineLimit: 0,
    cssCodeSplit: false,
    emptyOutDir: true,
    minify: true,
    outDir: "build/vite",
    sourcemap: false,
    target: ["chrome111", "firefox128", "safari16.4"],
    rollupOptions: {
      input: resolve(import.meta.dirname, "src/scripts/theme.ts"),
      output: {
        entryFileNames: "js/jw-business.min.js",
        assetFileNames: (asset) => {
          const name = asset.names[0] ?? "asset";
          if (name.endsWith(".css")) return "css/jw-business.min.css";
          if (name.endsWith(".woff2")) return "fonts/[name][extname]";
          return "assets/[name]-[hash][extname]";
        }
      }
    }
  }
});
