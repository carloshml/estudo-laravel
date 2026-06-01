import './bootstrap';
import { createApp } from 'vue';

// Importar componentes
import PessoasList from './components/PessoasList.vue';
import PessoasCreate from './components/PessoasCreate.vue';
import PessoasRead from './components/PessoasRead.vue';
import UltimasPessoas from './components/UltimasPessoas.vue';
import UsersList from './components/UsersList.vue';
import UsersCreateUpdate from './components/UsersCreateUpdate.vue';
import UserRead from './components/UserRead.vue';
import UserProfile from './components/UserProfile.vue';
import ActivitiesLog from './components/ActivitiesLog.vue';
import AuthLogin from './components/AuthLogin.vue';
import AuthRegister from './components/AuthRegister.vue';

// Função helper para fazer fetch com CSRF
window.apiFetch = function(url, options = {}) {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    const apiToken = localStorage.getItem('api_token');
    
    const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...options.headers
    };
    
    if (token && !url.includes('/api/')) {
        headers['X-CSRF-TOKEN'] = token;
    }
    
    if (apiToken) {
        headers['Authorization'] = `Bearer ${apiToken}`;
    }
    
    return fetch(url, {
        ...options,
        headers
    });
};

const app = createApp({});

// Registrar componentes
app.component('pessoas-list', PessoasList);
app.component('pessoas-create-update', PessoasCreate);
app.component('pessoas-read', PessoasRead);
app.component('ultimas-pessoas', UltimasPessoas);
app.component('users-list', UsersList);
app.component('users-create-update', UsersCreateUpdate);
app.component('user-read', UserRead);
app.component('user-profile', UserProfile);
app.component('activities-log', ActivitiesLog);
app.component('auth-login', AuthLogin);
app.component('auth-register', AuthRegister);

app.mount('#app');