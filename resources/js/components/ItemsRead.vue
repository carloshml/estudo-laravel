<template>
  <div v-if="loading" class="text-center py-8"><p class="text-gray-500">Carregando...</p></div>

  <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-xl p-6 text-center">
    <p class="text-red-600 font-medium">{{ error }}</p>
    <a href="/itens" class="inline-block mt-4 text-teal-600 hover:text-teal-800 font-medium">← Voltar para lista</a>
  </div>

  <div v-else>
    <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 py-4 rounded-xl">
      <div class="text-white font-bold text-lg">Item</div>
    </div>

    <div class="w-full bg-white shadow-xl rounded-xl p-8 mt-4 space-y-4">
      <div>
        <label class="block text-gray-500 text-sm">Nome</label>
        <p class="text-gray-900 font-medium text-lg">{{ item.name }}</p>
      </div>
      <div>
        <label class="block text-gray-500 text-sm">Pessoa</label>
        <p class="text-gray-900 font-medium">{{ item.pessoa ? item.pessoa.nome : '—' }}</p>
      </div>

      <!-- Histórico de locações -->
      <div v-if="item.locacoes && item.locacoes.length > 0" class="mt-6">
        <h3 class="text-gray-700 font-semibold mb-3">Histórico de Locações</h3>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-3 py-2 text-left">Localização</th>
                <th class="px-3 py-2 text-left">Início</th>
                <th class="px-3 py-2 text-left">Fim</th>
                <th class="px-3 py-2 text-left">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              <tr v-for="loc in item.locacoes" :key="loc.id">
                <td class="px-3 py-2">{{ loc.localizacao ? loc.localizacao.nome : '—' }}</td>
                <td class="px-3 py-2">{{ formatDate(loc.inicio) }}</td>
                <td class="px-3 py-2">{{ formatDate(loc.fim) }}</td>
                <td class="px-3 py-2">
                  <span :class="statusClass(loc.status)" class="px-2 py-0.5 rounded-full text-xs font-semibold">{{ loc.status }}</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="flex justify-end gap-4 pt-4">
        <a :href="`/itens/${id}/edit`" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-6 rounded-lg transition">Editar</a>
        <a href="/itens" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-6 rounded-lg transition">Voltar</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: { id: { type: Number, required: true } },
  data() { return { item: null, loading: true, error: null } },
  mounted() {
    const token = localStorage.getItem('api_token');
    const headers = { 'Accept': 'application/json' };
    if (token) headers['Authorization'] = `Bearer ${token}`;

    fetch(`/api/items/${this.id}`, { headers })
      .then(res => {
        if (res.status === 404) { this.error = 'Item não encontrado'; this.loading = false; return; }
        if (res.status === 401) { window.location.href = '/login'; return; }
        return res.json();
      })
      .then(data => { if (data) { this.item = data; this.loading = false; } })
      .catch(() => { this.error = 'Erro ao carregar'; this.loading = false; });
  },
  methods: {
    formatDate(d) {
      if (!d) return '—';
      return new Date(d).toLocaleString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
    },
    statusClass(s) {
      if (s === 'ativo') return 'bg-green-100 text-green-800';
      if (s === 'finalizado') return 'bg-gray-100 text-gray-800';
      return 'bg-red-100 text-red-800';
    }
  }
}
</script>
