// vite.config.js
import { defineConfig } from "file:///D:/xampp8.1.6/htdocs/study-planner-web/node_modules/vite/dist/node/index.js";
import laravel from "file:///D:/xampp8.1.6/htdocs/study-planner-web/node_modules/laravel-vite-plugin/dist/index.js";
import vue from "file:///D:/xampp8.1.6/htdocs/study-planner-web/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import Vuetify, { transformAssetUrls } from "file:///D:/xampp8.1.6/htdocs/study-planner-web/node_modules/vite-plugin-vuetify/dist/index.mjs";
import Layouts from "file:///D:/xampp8.1.6/htdocs/study-planner-web/node_modules/vite-plugin-vue-layouts/dist/index.mjs";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true
    }),
    Layouts(),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false
        },
        template: {
          compilerOptions: {
            // treat all tags with a dash as custom elements
            isCustomElement: (tag) => tag.includes("-")
          }
        }
      }
    }),
    Vuetify({
      autoImport: true,
      styles: {
        configFile: "resources/js/styles/settings.scss"
      }
    })
  ],
  resolve: {
    alias: {
      "@": "/resources/js"
    }
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJEOlxcXFx4YW1wcDguMS42XFxcXGh0ZG9jc1xcXFxzdHVkeS1wbGFubmVyLXdlYlwiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9maWxlbmFtZSA9IFwiRDpcXFxceGFtcHA4LjEuNlxcXFxodGRvY3NcXFxcc3R1ZHktcGxhbm5lci13ZWJcXFxcdml0ZS5jb25maWcuanNcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfaW1wb3J0X21ldGFfdXJsID0gXCJmaWxlOi8vL0Q6L3hhbXBwOC4xLjYvaHRkb2NzL3N0dWR5LXBsYW5uZXItd2ViL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCB2dWUgZnJvbSAnQHZpdGVqcy9wbHVnaW4tdnVlJztcbmltcG9ydCBWdWV0aWZ5LCB7IHRyYW5zZm9ybUFzc2V0VXJscyB9IGZyb20gJ3ZpdGUtcGx1Z2luLXZ1ZXRpZnknXG5pbXBvcnQgTGF5b3V0cyBmcm9tICd2aXRlLXBsdWdpbi12dWUtbGF5b3V0cydcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcbiAgICBwbHVnaW5zOiBbXG4gICAgICAgIGxhcmF2ZWwoe1xuICAgICAgICAgICAgaW5wdXQ6IFsncmVzb3VyY2VzL2Nzcy9hcHAuY3NzJywgJ3Jlc291cmNlcy9qcy9hcHAuanMnXSxcbiAgICAgICAgICAgIHJlZnJlc2g6IHRydWUsXG4gICAgICAgIH0pLFxuICAgICAgICBMYXlvdXRzKCksXG4gICAgICAgIHZ1ZSh7XG4gICAgICAgICAgICB0ZW1wbGF0ZToge1xuICAgICAgICAgICAgICAgIHRyYW5zZm9ybUFzc2V0VXJsczoge1xuICAgICAgICAgICAgICAgICAgICBiYXNlOiBudWxsLFxuICAgICAgICAgICAgICAgICAgICBpbmNsdWRlQWJzb2x1dGU6IGZhbHNlLFxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgdGVtcGxhdGU6IHtcbiAgICAgICAgICAgICAgICAgIGNvbXBpbGVyT3B0aW9uczoge1xuICAgICAgICAgICAgICAgICAgICAvLyB0cmVhdCBhbGwgdGFncyB3aXRoIGEgZGFzaCBhcyBjdXN0b20gZWxlbWVudHNcbiAgICAgICAgICAgICAgICAgICAgaXNDdXN0b21FbGVtZW50OiAodGFnKSA9PiB0YWcuaW5jbHVkZXMoJy0nKVxuICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0sXG4gICAgICAgIH0pLFxuICAgICAgICBWdWV0aWZ5KHtcbiAgICAgICAgICAgIGF1dG9JbXBvcnQ6IHRydWUsXG4gICAgICAgICAgICBzdHlsZXM6IHtcbiAgICAgICAgICAgICAgICBjb25maWdGaWxlOiBcInJlc291cmNlcy9qcy9zdHlsZXMvc2V0dGluZ3Muc2Nzc1wiXG4gICAgICAgICAgICB9XG4gICAgICAgIH0pXG4gICAgXSxcbiAgICByZXNvbHZlOiB7XG4gICAgICAgIGFsaWFzOiB7XG4gICAgICAgICAgICBcIkBcIjogXCIvcmVzb3VyY2VzL2pzXCJcbiAgICAgICAgfVxuICAgIH1cbn0pO1xuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUE0UyxTQUFTLG9CQUFvQjtBQUN6VSxPQUFPLGFBQWE7QUFDcEIsT0FBTyxTQUFTO0FBQ2hCLE9BQU8sV0FBVywwQkFBMEI7QUFDNUMsT0FBTyxhQUFhO0FBRXBCLElBQU8sc0JBQVEsYUFBYTtBQUFBLEVBQ3hCLFNBQVM7QUFBQSxJQUNMLFFBQVE7QUFBQSxNQUNKLE9BQU8sQ0FBQyx5QkFBeUIscUJBQXFCO0FBQUEsTUFDdEQsU0FBUztBQUFBLElBQ2IsQ0FBQztBQUFBLElBQ0QsUUFBUTtBQUFBLElBQ1IsSUFBSTtBQUFBLE1BQ0EsVUFBVTtBQUFBLFFBQ04sb0JBQW9CO0FBQUEsVUFDaEIsTUFBTTtBQUFBLFVBQ04saUJBQWlCO0FBQUEsUUFDckI7QUFBQSxRQUNBLFVBQVU7QUFBQSxVQUNSLGlCQUFpQjtBQUFBO0FBQUEsWUFFZixpQkFBaUIsQ0FBQyxRQUFRLElBQUksU0FBUyxHQUFHO0FBQUEsVUFDNUM7QUFBQSxRQUNGO0FBQUEsTUFDSjtBQUFBLElBQ0osQ0FBQztBQUFBLElBQ0QsUUFBUTtBQUFBLE1BQ0osWUFBWTtBQUFBLE1BQ1osUUFBUTtBQUFBLFFBQ0osWUFBWTtBQUFBLE1BQ2hCO0FBQUEsSUFDSixDQUFDO0FBQUEsRUFDTDtBQUFBLEVBQ0EsU0FBUztBQUFBLElBQ0wsT0FBTztBQUFBLE1BQ0gsS0FBSztBQUFBLElBQ1Q7QUFBQSxFQUNKO0FBQ0osQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
