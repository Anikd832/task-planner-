const MainRoutes = {
  path: '/app',
  meta: {
    requiresAuth: true
  },
  component: () => import('@/layouts/full/FullLayout.vue'),
  children: [
    {
      name: 'Dashboard',
      path: 'dashboard',
      meta: { requiresAuth: true },
      component: () => import('@/components/dashboard/DashboardHome.vue')
    },
    {
      name: 'Users',
      path: 'users',
      meta: { requiresAuth: true },
      component: () => import('@/components/user/User.vue')
    },
    {
      name: 'Subjects',
      path: 'subjects',
      meta: { requiresAuth: true },
      component: () => import('@/components/subject/SubjectHome.vue')
    },
    {
      name: 'Routine',
      path: 'routine',
      meta: { requiresAuth: true },
      component: () => import('@/components/routine/Routine.vue')
    }
  ]
};

export default MainRoutes;
