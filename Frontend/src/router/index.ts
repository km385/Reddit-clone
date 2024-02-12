import { createRouter, createWebHistory } from 'vue-router'
import HomeView from "@/views/HomeView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      children: [

      ]
    },
    {
      path: '/test',
      name: 'test',
      component: () => import('../views/HomeView.vue')
    },
    {
      path: '/r/:community/comments/:id',
      name: 'comments',
      component: () => import('../views/CommentsView.vue')
    }
  ]
})

export default router
