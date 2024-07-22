import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import { UserRoutes } from "./UserRoutes.ts";
import { useAuthStore } from "../store/auth.ts";
import { PostRoutes } from "./PostRoutes.ts";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    component: () => import("../views/HomeView.vue"),
    name: "Home",
    meta: {
      reqAuth: false,
      rol: "",
    },
  },

  {
    path: "/:pathMatch(.*)*",
    component: () => import("../views/ErrorPageNotFound.vue"),
    name: "ErrorPageNotFound",
    meta: {
      reqAuth: false,
      rol: "",
    },
  },
  {
    path: "/login",
    component: () => import("../views/LoginView.vue"),
    name: "LoginPage",
    meta: {
      reqAuth: false,
      rol: "",
    },
  },
  {
    path: "/dashboard",
    component: () => import("../views/DashboardView.vue"),
    name: "Dashboard",
    meta: {
      reqAuth: true,
      rol: "admin",
    },
  },

  ...UserRoutes,
  ...PostRoutes,
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});
router.beforeEach((to, from, next) => {
  const store = useAuthStore();
  const auth = store.getAuthorized;
  const rol = store.getRol;

  if (to.matched.some((record) => record.meta.reqAuth)) {
    const needAuth = to.meta.reqAuth;
    const needRol = to.meta.rol;

    if (!needAuth || needRol != rol || !auth) {
      next("/login");
    } else {
      next();
    }
  } else {
    next();
  }
});
export default router;
