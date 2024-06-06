/**
 * Framework documentation: https://vuetifyjs.com`
 */

// Styles
import "@mdi/font/css/materialdesignicons.css";
import { md3 } from 'vuetify/blueprints'
import "vuetify/styles";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

// Composables
import { createVuetify } from "vuetify";
import { PurpleTheme } from "@/theme/LightTheme";

// https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides

export default createVuetify({
  // blueprint: md3,
  components,
  directives,
  theme: {
    defaultTheme: "PurpleTheme",
    themes: {
      PurpleTheme,
    },
  },
  defaults: {
    VBtn: {},
    VCard: {
      rounded: "md",
    },
    VTextField: {
      rounded: "lg",
    },
    VTooltip: {
      // set v-tooltip default location to top
      location: "top",
    },
    VDataTableServer: {
      itemsPerPageOptions: [
        {value: 10, title: '10'},
        {value: 25, title: '25'},
        {value: 50, title: '50'},
        {value: 100, title: '100'},
        {value: 500, title: '500'},
        {value: 1000, title: '1000'},
      ],
      showCurrentPage: true,
      showExpand: true,
    }
  },
});
