import { createRouter, createWebHistory } from 'vue-router';
import AuthView from '@/views/AuthView.vue';
import DashboardView from '@/views/DashboardView.vue';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'Auth',
            component: AuthView
        },
        {
            path: '/dashboard',
            name: 'Dashboard',
            component: DashboardView,
            meta: { requiresAuth: true }
        },
        {
            path: '/:catchAll(.*)',
            redirect: { name: 'Auth'}
        },
    ]
});

// Check if user is authenticated in to keep access to the Dashboard
router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('isAuthenticated') === 'true';
    if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated) {
        next({ name:'Auth' });
    }else{
        next();
    }
})

export default router;