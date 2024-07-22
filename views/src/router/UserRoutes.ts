import UserView from "../views/UserView.vue";
import UserCreate from "../components/Users/UserCreateComponent.vue";
import UserUpdate from "../components/Users/UserUpdateComponent.vue";
import UserProfile from "../components/Users/UserProfileComponent.vue";
import { RouteRecordRaw } from "vue-router";

export const UserRoutes: Array<RouteRecordRaw> = [
  {
    path: "/users",
    component: UserView,
    name: "users",
    children: [{ path: "crear", component: UserCreate, name: "UserCreate" }],
    meta: {
      reqAuth: true,
      rol: "admin",
    },
  },
  {
    path: "/users/:id",
    component: UserUpdate,
    name: "UserUpdate",
    meta: {
      reqAuth: true,
      rol: "admin",
    },
  },
  {
    path: "/users/:id/profile",
    component: UserProfile,
    name: "UserProfile",
    meta: {
      reqAuth: true,
      rol: "admin",
    },
  },
  {
    path: "/register",
    component: () => import("../components/RegisterComponent.vue"),
    name: "registro",
    meta: {
      reqAuth: false,
      rol: "",
    },
  },
];

export const nombreUsuario = "emartinez";
