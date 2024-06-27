import {createRouter, createWebHistory} from 'vue-router'
import MainLayout from "@/views/MainLayout.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            component: MainLayout,
            children: [
                {
                    path: '',
                    name: 'home',
                    component: () => import('../views/HomeView.vue')
                },
                {
                    path: '/r/:community/comments/:id',
                    name: 'comments',
                    component: () => import('../views/CommentsView.vue')
                },
                {
                    path: '/r/:community/',
                    name: 'community',
                    component: () => import('../views/CommunityView.vue'),
                },
                {
                    path: '/user/:username',
                    name: 'userProfile',
                    component: () => import('../views/UserProfileView.vue')
                }
            ]
        },
        {
            path: '/submit',
            name: 'create',
            component: () => import('../views/CreateView.vue'),
        }
    ]
})

export default router
