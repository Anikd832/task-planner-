import "./bootstrap";

import router from './router'
import vuetify from "./plugins/vuetify";
import PerfectScrollbar from 'vue3-perfect-scrollbar';
import VueTablerIcons from 'vue-tabler-icons';
import VueApexCharts from 'vue3-apexcharts';
import { createPinia } from 'pinia'
import '@/scss/style.scss';

import App from './App.vue'

import { createApp } from "vue";
const app = createApp(App)

const pinia = createPinia()

app.use(router)
app.use(pinia)
app.use(vuetify);
app.use(PerfectScrollbar);
app.use(VueTablerIcons);
app.use(VueApexCharts);

app.mount("#app");
