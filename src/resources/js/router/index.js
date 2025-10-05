import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/client/Login.vue';
import Tables from '../components/client/Tables.vue';
import Dashboard from '../components/admin/Dashboard.vue';

const routes = [
    {
        path: '/',
        component: Tables,
    },
    {
        path: '/admin/login',
        component: Login,
    },
    {
        path: '/admin',
        component: Dashboard,
        meta: { requiresAuth: true },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
    if (to.meta.requiresAuth && !token) {
        next('/admin/login');
    } else {
        next();
    }
});

export default router;
