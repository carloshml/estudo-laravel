<template>
  <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="p-4 bg-gray-50 border-b">
      <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
        <div class="relative">
          <input type="text" v-model="search" placeholder="Buscar por item, pessoa, local..."
            class="pl-10 pr-4 py-2 border rounded-lg w-72 focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
          <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </div>
        <select v-model="filterStatus" class="border rounded-lg px-3 py-2">
          <option value="">Todos</option>
          <option value="ativo">Ativos</option>
          <option value="finalizado">Finalizados</option>
          <option value="cancelado">Cancelados</option>
        </select>
      </div>
    </div>

    <div v-if="loading" class="flex justify-center items-center py-16">
      <div class="text-center">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-amber-600 mb-4"></div>
        <p class="text-gray-500">Carregando locações...</p>
      </div>
    </div>

    <div v-else>
      <div class="bg-gradient-to-r from-amber-600 to-amber-700 px-6 py-4">
        <div class="flex justify-between items-center text-white">
          <h2 class="text-xl font-bold">Locações de Itens</h2>
          <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">Total: {{ filteredItems.length }}</span>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50 border-b-2 border-gray-200">
            <tr>
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Item</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Pessoa Responsável</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Localização</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Início</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Fim</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
              <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Ações</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="loc in filteredItems" :key="loc.id" class="hover:bg-gray-50 transition-colors">
              <td class="px-4 py-3 font-medium text-gray-900">{{ loc.item ? loc.item.name : '—' }}</td>
              <td class="px-4 py-3 text-gray-700">{{ loc.pessoa ? loc.pessoa.nome : '—' }}</td>
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

      <div v-if="filteredItems.length === 0" class="text-center py-16">
        <p class="text-gray-500 text-lg">Nenhuma locação encontrada.</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return { locacoes: [], loading: true, search: '', filterStatus: '' }
  },
  computed: {
    filteredItems() {
      let filtered = this.locacoes;
      if (this.filterStatus) filtered = filtered.filter(l => l.status === this.filterStatus);
      if (this.search) {
        const s = this.search.toLowerCase();
        filtered = filtered.filter(l =>
          (l.item && l.item.name.toLowerCase().includes(s)) ||
          (l.pessoa && l.pessoa.nome.toLowerCase().includes(s)) ||
          l.location.toLowerCase().includes(s)
        );
      }
      return filtered;
    }
  },
  mounted() { this.fetchLocacoes(); },
  methods: {
    fetchLocacoes() {
      this.loading = true;
      const token = localStorage.getItem('api_token');
      const headers = { 'Accept': 'application/json' };
      if (token) headers['Authorization'] = `Bearer ${token}`;
      fetch('/api/locacoes', { headers })
        .then(res => res.json())
        .then(data => { this.locacoes = data; this.loading = false; })
        .catch(() => { this.loading = false; });
    },
    formatDate(d) {
      if (!d) return '—';
      return new Date(d).toLocaleString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
    },
    statusClass(s) {
      if (s === 'ativo') return 'bg-green-100 text-green-800';
      if (s === 'finalizado') return 'bg-gray-100 text-gray-800';
      return 'bg-red-100 text-red-800';
    },
    editLoc(id) { window.location.href = `/locacoes/${id}/edit`; },
    finalizarLoc(id) {
      if (!confirm('Finalizar esta locação?')) return;
      const token = localStorage.getItem('api_token');
      const headers = { 'Content-Type': 'application/json', 'Accept': 'application/json' };
      if (token) headers['Authorization'] = `Bearer ${token}`;
      fetch(`/api/locacoes/${id}/status`, { method: 'PATCH', headers, body: JSON.stringify({ status: 'finalizado' }) })
        .then(() => this.fetchLocacoes());
    },
    deleteLoc(id) {
      if (!confirm('Excluir esta locação?')) return;
      const token = localStorage.getItem('api_token');
      const headers = {};
      if (token) headers['Authorization'] = `Bearer ${token}`;
      fetch(`/api/locacoes/${id}`, { method: 'DELETE', headers }).then(() => this.fetchLocacoes());
    }
  }
}
</script>
