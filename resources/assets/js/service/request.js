import axios from "axios/index";
import { ENDPOINTS, HTTP_CODES } from "../config/api";
import { router } from '../router';

// Add a response interceptor, to check response on auth
axios.interceptors.response.use(null, (error) => {
    if (error.response.status === HTTP_CODES.UNAUTHORIZED) {
        router.push('/login');
        console.warn(error);
    }

    return Promise.reject(error);
});

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Setup base url
axios.defaults.baseURL = ENDPOINTS.BASE;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

export default axios;

