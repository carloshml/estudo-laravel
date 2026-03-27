import './bootstrap';
import { createApp } from 'vue';
import PessoasList from './components/PessoasList.vue';
import PessoasCreate from './components/PessoasCreate.vue';
const app = createApp({});

// Registrar componente
app.component('pessoas-list', PessoasList);
app.component('pessoas-create-update', PessoasCreate);


app.mount('#app');

