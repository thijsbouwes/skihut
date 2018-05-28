import Vue from 'vue';
import Router from 'vue-router';
import { store } from '../store';
import Dashboard from '../pages/Dashboard';
import Users from '../pages/users/Index';
import CreateUser from '../pages/users/Create';
import ShowUser from '../pages/users/Show';
import Events from '../pages/events/Index';
import CreateEvent from '../pages/events/Create';
import UpdateEvent from '../pages/events/Update';
import Products from '../pages/products/Index';
import CreateProduct from '../pages/products/Create';
import UpdateProduct from '../pages/products/Update';
import Stocks from '../pages/stocks/Index';
import CreateStock from '../pages/stocks/Create';
import UpdateStock from '../pages/stocks/Update';
import Login from '../pages/Login';
import ResetPassword from '../pages/users/ResetPassword';
import ForgotPassword from '../pages/users/ForgotPassword';
import NotFound from '../pages/NotFound';
import Auth from '../service/auth-service';
import Layout from '../layouts/main/Layout';

Vue.use(Router);

export const router = new Router({
    linkActiveClass: 'active',
    mode: 'history',
    routes: [
        {
            path: '',
            meta: { requiresAuth: true },
            component: Layout,
            children: [
                {
                    path     : '',
                    name     : 'account',
                    component: ShowUser
                }
            ]
        },
        {
            path: '/dashboard',
            name: 'Dashboard',
            component: Dashboard,
            meta: { requiresAuth: true, requiresAdmin: true }
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
                },
                {
                    path: 'account',
                    name: 'users.account',
                    component: ShowUser
                },
                {
                    path: 'account/:id',
                    name: 'users.show',
                    component: ShowUser
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
            path: '/stocks',
            component: Layout,
            meta: { requiresAuth: true, requiresAdmin: true },
            children: [
                {
                    path: '',
                    name: 'stocks',
                    component: Stocks,
                },
                {
                    path: 'create',
                    name: 'stocks.create',
                    component: CreateStock
                },
                {
                    path: 'update/:id',
                    name: 'stocks.update',
                    component: UpdateStock
                }
            ]
        },
        {
            path: '/login',
            name: 'Login',
            component: Login,
            meta: { requiresGuest: true }
        },
        {
            path: '/confirm/:token/:email',
            name: 'confirm',
            component: ResetPassword,
            meta: { requiresGuest: true }
        },
        {
            path: '/forgot-password',
            name: 'forgot-password',
            component: ForgotPassword,
            meta: { requiresGuest: true }
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

    document.title = 'Skihut | ' + name;
    next();
});

// Check auth
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth) && Auth.isLoggedIn() === false) {
        next('/login');
    }
    next();
});

// Check auth guest
router.beforeEach((to, from, next) => {
    if (to.meta.requiresGuest && Auth.isLoggedIn() === true) {
        next('/');
    }
    next();
});

// Check admin
router.beforeEach((to, from, next) => {
    store.dispatch('profile/loadProfile')
        .then(response => {
            if (to.matched.some(record => record.meta.requiresAdmin) && store.getters['profile/is_admin'] === false) {
                next('/');
            } else {
                next();
            }
        })
        .catch(error => {
            next();
        });
});