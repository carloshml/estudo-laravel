import './bootstrap';
import { createApp } from 'vue';
import PessoasList from './components/PessoasList.vue';
import PessoasCreate from './components/PessoasCreate.vue';
import PessoasRead from './components/PessoasRead.vue';
import UltimasPessoas from './components/UltimasPessoas.vue';
import AuthLogin from './components/AuthLogin.vue';
import AuthRegister from './components/AuthRegister.vue';

const app = createApp({});

// Registrar componentes
app.component('pessoas-list', PessoasList);
app.component('pessoas-create-update', PessoasCreate);
app.component('pessoas-read', PessoasRead);
app.component('ultimas-pessoas', UltimasPessoas);
app.component('auth-login', AuthLogin);
app.component('auth-register', AuthRegister);

app.mount('#app');