const AuthRoutes = {
  path: "/app",
  component: () => import("@/layouts/blank/BlankLayout.vue"),
  meta: {
    requiresAuth: false,
  },
  children: [
    {
      name: "Login",
      path: "/app/login",
      component: () => import("@/components/auth/Login.vue"),
    },
    {
      name: "Register",
      path: "/app/register",
      component: () => import("@/components/auth/Register.vue"),
    },
  ],
};

export default AuthRoutes;
