export const PostRoutes = [
  {
    path: "/posts",
    component: () => import("../views/PostView.vue"),
    name: "Posts",
  },
];
