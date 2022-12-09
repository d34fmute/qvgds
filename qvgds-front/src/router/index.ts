import { createRouter, createWebHistory } from "vue-router";
import DesignSystemView from "../views/DesignSystem.vue"; 
import LoginView from "../views/Login.vue"; 

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: LoginView
    },
    {
      path: "/ds",
      name: "ds",
      component: DesignSystemView
    }
  ]
});

export default router;
