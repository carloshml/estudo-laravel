<template>
  <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center py-16">
      <div class="text-center">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mb-4"></div>
        <p class="text-gray-500">Carregando pessoas...</p>
      </div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="bg-red-50 border-l-4 border-red-500 p-6 m-6 rounded-lg">
      <div class="flex items-center gap-3">
        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
          <h3 class="text-red-800 font-semibold">Erro ao carregar dados</h3>
          <p class="text-red-600 text-sm">{{ error }}</p>
          <button @click="fetchPessoas" class="mt-2 text-red-700 text-sm font-medium hover:underline">
            Tentar novamente
          </button>
        </div>
      </div>
    </div>

    <!-- Success State -->
    <div v-else>
      <!-- Table Header with Stats -->
      <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
        <div class="flex justify-between items-center text-white">
          <h2 class="text-xl font-bold">Lista de Pessoas</h2>
          <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">
            Total: {{ pessoas.length }}
          </span>
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50 border-b-2 border-gray-200">
            <tr>
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nome</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Idade</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Documento</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Ações</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="pessoa in pessoas" :key="pessoa.id" class="hover:bg-gray-50 transition-colors duration-150">
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <div
                    class="w-10 h-10 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center">
                    <span class="text-green-700 font-semibold text-sm">
                      {{ pessoa.nome.charAt(0).toUpperCase() }}
                    </span>
                  </div>
                  <span class="font-medium text-gray-900">{{ pessoa.nome }}</span>
                </div>
              </td>
              <td class="px-6 py-4">
                <span class="inline-flex items-center gap-1">
                  <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  {{ pessoa.idade }} anos
                </span>
              </td>
              <td class="px-6 py-4">
                <code class="bg-gray-100 px-2 py-1 rounded text-sm text-gray-700">
                  {{ formatDocument(pessoa.documento) }}
                </code>
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center gap-2">
                  <button @click="viewPessoa(pessoa.id)" class="text-blue-600 hover:text-blue-800 transition"
                    title="Visualizar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                      </path>
                    </svg>
                  </button>
                  <button @click="editPessoa(pessoa.id)" class="text-yellow-600 hover:text-yellow-800 transition"
                    title="Editar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                      </path>
                    </svg>
                  </button>
                  <button @click="deletePessoa(pessoa.id)" class="text-red-600 hover:text-red-800 transition"
                    title="Excluir">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                      </path>
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Empty State -->
      <div v-if="pessoas.length === 0" class="text-center py-16">
        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
          </path>
        </svg>
        <p class="text-gray-500 text-lg">Nenhuma pessoa cadastrada ainda.</p>
        <a href="/pessoas/create" class="inline-block mt-4 text-green-600 hover:text-green-700 font-medium">
          + Adicionar primeira pessoa
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      pessoas: [],
      loading: true,
      error: null
    }
  },
  mounted() {
    this.fetchPessoas()
  },
  methods: {
    fetchPessoas() {
      this.loading = true
      this.error = null

      fetch('/api/pessoas')
        .then(res => {
          if (!res.ok) {
            throw new Error(`HTTP ${res.status}: ${res.statusText}`)
          }
          return res.json()
        })
        .then(data => {
          this.pessoas = data
          this.loading = false
        })
        .catch(err => {
          console.error('Error fetching pessoas:', err)
          this.error = err.message || 'Falha ao carregar os dados'
          this.loading = false
        })
    },

    formatDocument(documento) {
      // Format CPF or CNPJ automatically
      const clean = documento.replace(/\D/g, '')
      if (clean.length === 11) {
        return clean.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4')
      } else if (clean.length === 14) {
        return clean.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5')
      }
      return documento
    },

    viewPessoa(id) {
      window.location.href = `/pessoas/${id}`
    },

    editPessoa(id) {
      window.location.href = `/pessoas/${id}/edit`
    },

    deletePessoa(id) {
      if (confirm('Tem certeza que deseja excluir esta pessoa?')) {
        fetch(`/api/pessoas/${id}`, { method: 'DELETE' })
          .then(res => {
            if (res.ok) {
              this.fetchPessoas() // Reload the list
              alert('Pessoa excluída com sucesso!')
            } else {
              throw new Error('Erro ao excluir')
            }
          })
          .catch(err => {
            console.error('Error deleting pessoa:', err)
            alert('Erro ao excluir pessoa. Tente novamente.')
          })
      }
    }
  }
}
</script>

<style scoped>
/* Optional: Add smooth transitions */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>