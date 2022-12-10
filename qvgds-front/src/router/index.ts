import { createRouter, createWebHistory } from "vue-router";
import DesignSystemView from "../views/DesignSystem.vue"; 
import LoginView from "../views/Login.vue"; 
import GameView from "../views/Game.vue"; 

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
    },
    {
      path: "/game/:sessionId/:username",
      name: "game",
      component: GameView
    }
  ]
});

export default router;
