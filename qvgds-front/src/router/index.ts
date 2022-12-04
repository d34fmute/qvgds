import { createRouter, createWebHistory } from "vue-router";
import DesignSystemView from "../views/DesignSystem.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: DesignSystemView
    }
  ]
});

export default router;
