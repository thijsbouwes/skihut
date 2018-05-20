import Vue from 'vue';
import Router from 'vue-router';
import Dashboard from '../pages/Dashboard';
import Users from '../pages/Users';
import CreateUser from '../pages/Users/Create';
import Events from '../pages/events';
import CreateEvent from '../pages/events/Create';
import UpdateEvent from '../pages/events/Update';
import Products from '../pages/products';
import CreateProduct from '../pages/products/Create';
import UpdateProduct from '../pages/products/Update';
import Login from '../pages/Login';
import Confirm from '../pages/Users/Confirm';
import NotFound from '../pages/NotFound';
import Auth from '../service/auth-service';
import Layout from '../layouts/main/Layout';

Vue.use(Router);

export const router = new Router({
    linkActiveClass: 'active',
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'Dashboard',
            component: Dashboard,
            meta: { requiresAuth: true }
        },
        {
            path: '/users',
            meta: { requiresAuth: true, requiresAdmin: true },
            component: Layout,
            children: [
                {
                    path: '',
                    name: 'users',
                    component: Users,
                },
                {
                    path: 'create',
                    name: 'users.create',
                    component: CreateUser
                }
            ]
        },
        {
            path: '/events',
            meta: { requiresAuth: true, requiresAdmin: true },
            component: Layout,
            children: [
                {
                    path: '',
                    name: 'events',
                    component: Events,
                },
                {
                    path: 'create',
                    name: 'events.create',
                    component: CreateEvent
                },
                {
                    path: 'update/:id',
                    name: 'events.update',
                    component: UpdateEvent
                }
            ]
        },
        {
            path: '/products',
            component: Layout,
            meta: { requiresAuth: true, requiresAdmin: true },
            children: [
                {
                    path: '',
                    name: 'products',
                    component: Products,
                },
                {
                    path: 'create',
                    name: 'products.create',
                    component: CreateProduct
                },
                {
                    path: 'update/:id',
                    name: 'products.update',
                    component: UpdateProduct
                }
            ]
        },
        {
            path: '/login',
            name: 'Login',
            component: Login
        },
        {
            path: '/confirm/:token',
            name: 'confirm',
            component: Confirm
        },
        {
            path: '*',
            name: 'Not found',
            component: NotFound,
        }
    ]
});

// Set meta title
router.beforeEach((to, from, next) => {
    // change name.route to Name route
    let name = to.name.split('.').join(' ');
    name = name.charAt(0).toUpperCase() + name.slice(1);

    document.title = 'Home Comfort | ' + name;
    next();
});

// Check auth
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && Auth.isLoggedIn() === false) {
        next('/login');
    }
    next();
});

// Check admin
router.beforeEach((to, from, next) => {
    // if (to.meta.requiresAdmin && store.getters['profile/is_admin'] === false) {
    //     next('/');
    // }
    next();
});