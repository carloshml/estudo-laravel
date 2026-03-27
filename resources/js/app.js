import './bootstrap';
import { createApp } from 'vue';

// Importar seu componente
import Pessoas from './components/Pessoas.vue';

const app = createApp({});

// Registrar componente
app.component('pessoas', Pessoas);

app.mount('#app');

