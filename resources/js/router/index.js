import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    { 
        path: '/', 
        name: 'home', 
        redirect: '/dashboard',
        meta: { title: 'Home' }
        
    },
    { 
        path: '/login', 
        name: 'login', 
        component: () => import('../Components/Auth/Login.vue'),
        meta: { title: 'Login' }
    },
    { 
        path: '/register', 
        name: 'register', 
        component: () => import('../Components/Auth/Register.vue'),
        meta: { title: 'Register' }
    },
    { 
        path: '/dashboard', 
        name: 'dashboard', 
        component: () => import('../Components/Dashboard.vue') 
    },
    { 
        path: '/posts/create', 
        name: 'create-post', 
        component: () => import('../Components/Posts/CreatePost.vue') 
    },
    { 
        path: '/posts', 
        name: 'posts', 
        component: () => import('../Components/Posts/PostsList.vue') 
    },
    { 
        path: '/cigarettes', 
        name: 'cigarettes', 
        component: () => import('../Components/Cigarettes/CigarettesList.vue') 
    },
    { 
        path: '/:pathMatch(.*)*', 
        name: 'not-found', 
        component: () => import('../Components/NotFound.vue') 
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;