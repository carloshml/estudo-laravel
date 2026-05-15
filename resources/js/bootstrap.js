import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Accept'] = 'application/json';

// Configurar token CSRF para todas as requisições
const token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// Configurar token do Sanctum para API
const apiToken = localStorage.getItem('api_token');
if (apiToken) {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${apiToken}`;
}

// Interceptador para tratar erro 401 (não autorizado)
window.axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response && error.response.status === 401) {
            localStorage.removeItem('api_token');
            if (!window.location.pathname.includes('/login') && !window.location.pathname.includes('/register')) {
                window.location.href = '/login';
            }
        }
        return Promise.reject(error);
    }
);