import { createRouter, createWebHistory } from 'vue-router';
import AuthView from '@/views/AuthView.vue';
import DashboardView from '@/views/DashboardView.vue';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/auth',
            name: 'Auth',
            component: AuthView
        },
        {
            path: '/dashboard',
            name: 'Dashboard',
            component: DashboardView
        },
    ]
})

export default router