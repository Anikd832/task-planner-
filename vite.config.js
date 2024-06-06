import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import Vuetify, { transformAssetUrls } from "vite-plugin-vuetify";
import Layouts from "vite-plugin-vue-layouts";

export default defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true,
    }),
    Layouts(),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        }
      },
    }),
    Vuetify({
      autoImport: true,
      styles: {
        configFile: "resources/js/styles/settings.scss",
      },
    }),
  ],
  resolve: {
    alias: {
      "@": "/resources/js",
    },
  },
});
