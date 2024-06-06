import { createRouter, createWebHistory } from "vue-router";
import MainRoutes from "./MainRoutes";
import AuthRoutes from "./AuthRoutes";
import AuthService from "../services/AuthService";

const router = createRouter({
  history: createWebHistory(import.meta.env.VITE_BASE_URL || "/"),
  routes: [
    {
      path: "/app/:pathMatch(.*)*",
      component: () => import("@/components/errors/Error404.vue"),
    },
    MainRoutes,
    AuthRoutes,
  ],
});

router.beforeEach(async (to, from) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!AuthService.getToken().token) {
      return {
        path: "/app/login",
        // save the location we were at to come back later
        query: { redirect: to.fullPath }
      };
    }
  }
});

export default router;
