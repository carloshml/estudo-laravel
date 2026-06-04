<template>
  <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Filtros Avançados -->
    <div class="p-4 bg-gray-50 border-b space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Filtro por período -->
        <div>
          <label class="block text-gray-600 text-xs font-medium mb-1">Período (Início)</label>
          <VueDatePicker
            v-model="filtros.inicio"
            :enable-time-picker="true"
            :formats="dateFormats"
            model-type="yyyy-MM-dd HH:mm:ss"
            :start-time="{ hours: 0, minutes: 0 }"
            auto-apply
            placeholder="De..."
            :clearable="true"
            :week-start="0"
            class="w-full"
          />
        </div>
        <div>
          <label class="block text-gray-600 text-xs font-medium mb-1">Período (Fim)</label>
          <VueDatePicker
            v-model="filtros.fim"
            :enable-time-picker="true"
            :formats="dateFormats"
            model-type="yyyy-MM-dd HH:mm:ss"
            :start-time="{ hours: 23, minutes: 59 }"
            auto-apply
            placeholder="Até..."
            :clearable="true"
            :week-start="0"
            class="w-full"
          />
        </div>
        <!-- Filtro por cliente -->
        <div>
          <label class="block text-gray-600 text-xs font-medium mb-1">Cliente</label>
          <select v-model="filtros.cliente_id" class="w-full border rounded-lg p-2 text-sm">
            <option value="">Todos</option>
            <option v-for="c in clientes" :key="c.id" :value="c.id">{{ c.nome }}</option>
          </select>
        </div>
        <!-- Filtro por item -->
        <div>
          <label class="block text-gray-600 text-xs font-medium mb-1">Item</label>
          <select v-model="filtros.item_id" class="w-full border rounded-lg p-2 text-sm">
            <option value="">Todos</option>
            <option v-for="item in items" :key="item.id" :value="item.id">{{ item.name }}</option>
          </select>
        </div>
      </div>
      <div class="flex items-center gap-4">
        <!-- Filtro por status -->
        <div>
          <select v-model="filtros.status" class="border rounded-lg px-3 py-2 text-sm">
            <option value="">Todos os status</option>
            <option value="ativo">Ativo</option>
            <option value="finalizado">Finalizado</option>
            <option value="cancelado">Cancelado</option>
          </select>
        </div>
        <button @click="aplicarFiltros" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition text-sm font-medium">
          Filtrar
        </button>
        <button @click="limparFiltros" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-sm font-medium">
          Limpar
        </button>
      </div>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="flex justify-center items-center py-16">
      <div class="text-center">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-amber-600 mb-4"></div>
        <p class="text-gray-500">Carregando locações...</p>
      </div>
    </div>

    <!-- Results -->
    <div v-else>
      <div class="bg-gradient-to-r from-amber-600 to-amber-700 px-6 py-4">
        <div class="flex justify-between items-center text-white">
          <h2 class="text-xl font-bold">Locações de Itens</h2>
          <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">Total: {{ locacoes.length }}</span>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50 border-b-2 border-gray-200">
            <tr>
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Item</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Cliente Responsável</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Localização</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Início</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Fim</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Ações</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="loc in locacoes" :key="loc.id" class="hover:bg-gray-50 transition-colors">
              <td class="px-4 py-3 font-medium text-gray-900">{{ loc.item ? loc.item.name : '—' }}</td>
              <td class="px-4 py-3 text-gray-700">{{ loc.cliente ? loc.cliente.nome : '—' }}</td>
              <td class="px-4 py-3 text-gray-700">{{ loc.location }}</td>
              <td class="px-4 py-3 text-gray-600 text-sm">{{ formatDate(loc.inicio) }}</td>
              <td class="px-4 py-3 text-gray-600 text-sm">{{ formatDate(loc.fim) }}</td>
              <td class="px-4 py-3">
                <span :class="statusClass(loc.status)" class="px-2 py-1 rounded-full text-xs font-semibold">{{ loc.status }}</span>
              </td>
              <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                  <button @click="editLoc(loc.id)" class="text-yellow-600 hover:text-yellow-800" title="Editar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                  </button>
                  <button v-if="loc.status === 'ativo'" @click="finalizarLoc(loc.id)" class="text-green-600 hover:text-green-800" title="Finalizar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                  </button>
                  <button @click="deleteLoc(loc.id)" class="text-red-600 hover:text-red-800" title="Excluir">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="locacoes.length === 0" class="text-center py-16">
        <p class="text-gray-500 text-lg">Nenhuma locação encontrada.</p>
      </div>
    </div>
  </div>
</template>

<script>
import { VueDatePicker } from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

export default {
  components: { VueDatePicker },
  data() {
    return {
      locacoes: [],
      clientes: [],
      items: [],
      loading: true,
      dateFormats: { input: 'dd/MM/yyyy HH:mm' },
      filtros: {
        inicio: null,
        fim: null,
        cliente_id: '',
        item_id: '',
        status: ''
      }
    }
  },
  mounted() {
    this.fetchSelects();
    this.fetchLocacoes();
  },
  methods: {
    getHeaders() {
      const token = localStorage.getItem('api_token');
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
      const h = { 'Content-Type': 'application/json', 'Accept': 'application/json' };
      if (token) h['Authorization'] = `Bearer ${token}`;
      if (csrfToken) h['X-CSRF-TOKEN'] = csrfToken;
      return h;
    },
    fetchSelects() {
      const h = this.getHeaders();
      Promise.all([
        fetch('/api/clientes', { headers: h }).then(r => r.json()),
        fetch('/api/items', { headers: h }).then(r => r.json()),
      ]).then(([clientes, items]) => {
        this.clientes = clientes;
        this.items = items;
      });
    },
    fetchLocacoes() {
      this.loading = true;
      const params = new URLSearchParams();

      if (this.filtros.inicio) {
        params.append('inicio', this.filtros.inicio);
      }
      if (this.filtros.fim) {
        params.append('fim', this.filtros.fim);
      }
      if (this.filtros.cliente_id) {
        params.append('cliente_id', this.filtros.cliente_id);
      }
      if (this.filtros.item_id) {
        params.append('item_id', this.filtros.item_id);
      }
      if (this.filtros.status) {
        params.append('status', this.filtros.status);
      }

      const url = '/api/locacoes' + (params.toString() ? '?' + params.toString() : '');

      fetch(url, { headers: this.getHeaders() })
        .then(res => {
          if (res.status === 401) { window.location.href = '/login'; return; }
          return res.json();
        })
        .then(data => { if (data) { this.locacoes = data; } this.loading = false; })
        .catch(() => { this.loading = false; });
    },
    aplicarFiltros() {
      this.fetchLocacoes();
    },
    limparFiltros() {
      this.filtros = { inicio: null, fim: null, cliente_id: '', item_id: '', status: '' };
      this.fetchLocacoes();
    },
    formatDateForApi(date) {
      if (!date) return null;
      const d = date instanceof Date ? date : new Date(date);
      const pad = (n) => String(n).padStart(2, '0');
      return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}:00`;
    },
    formatDate(d) {
      if (!d) return '—';
      return new Date(d).toLocaleString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
    },
    formatDisplayDate(date) {
      if (!date) return '';
      const d = new Date(date);
      const pad = (n) => String(n).padStart(2, '0');
      return `${pad(d.getDate())}/${pad(d.getMonth() + 1)}/${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}`;
    },
    statusClass(s) {
      if (s === 'ativo') return 'bg-green-100 text-green-800';
      if (s === 'finalizado') return 'bg-gray-100 text-gray-800';
      return 'bg-red-100 text-red-800';
    },
    editLoc(id) { window.location.href = `/locacoes/${id}/edit`; },
    finalizarLoc(id) {
      if (!confirm('Finalizar esta locação?')) return;
      fetch(`/api/locacoes/${id}/status`, { method: 'PATCH', headers: this.getHeaders(), body: JSON.stringify({ status: 'finalizado' }) })
        .then(res => { if (res.ok) { this.fetchLocacoes(); alert('Locação finalizada!'); } });
    },
    deleteLoc(id) {
      if (!confirm('Excluir esta locação?')) return;
      fetch(`/api/locacoes/${id}`, { method: 'DELETE', headers: this.getHeaders() })
        .then(res => { if (res.ok) this.fetchLocacoes(); });
    }
  }
}
</script>
