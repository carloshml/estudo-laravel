<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center p-6">
    <div class="w-full max-w-3xl bg-white shadow-lg rounded-lg p-6">
      <h1 class="text-2xl font-bold text-gray-800 mb-4">Lista de Pessoas</h1>

      <!-- Formulário para adicionar pessoa -->
      <form @submit.prevent="salvarPessoa" class="mb-6 space-y-4">
        <div>
          <label class="block text-gray-700 font-medium">Nome</label>
          <input v-model="novaPessoa.nome" type="text"
            class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
          <p v-if="erros.nome" class="text-red-600 text-sm mt-1">{{ erros.nome[0] }}</p>
        </div>

        <div>
          <label class="block text-gray-700 font-medium">Idade</label>
          <input v-model="novaPessoa.idade" type="number"
            class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
          <p v-if="erros.idade" class="text-red-600 text-sm mt-1">{{ erros.idade[0] }}</p>
        </div>

        <div>
          <label class="block text-gray-700 font-medium">Documento</label>
          <input v-model="novaPessoa.documento" type="text"
            class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
          <p v-if="erros.documento" class="text-red-600 text-sm mt-1">{{ erros.documento[0] }}</p>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
          Salvar Pessoa
        </button>
      </form>

      <!-- Tabela de pessoas -->
      <table class="w-full border-collapse">
        <thead>
          <tr class="bg-gray-200 text-left">
            <th class="p-3 font-semibold text-gray-700">Nome</th>
            <th class="p-3 font-semibold text-gray-700">Idade</th>
            <th class="p-3 font-semibold text-gray-700">Documento</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="pessoa in pessoas" :key="pessoa.id" class="border-b hover:bg-gray-50">
            <td class="p-3 text-gray-800">{{ pessoa.nome }}</td>
            <td class="p-3 text-gray-600">{{ pessoa.idade }} anos</td>
            <td class="p-3 text-gray-600">{{ pessoa.documento }}</td>
          </tr>
        </tbody>
      </table>

      <div v-if="pessoas.length === 0" class="text-center text-gray-500 mt-4">
        Nenhuma pessoa cadastrada ainda.
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      pessoas: [],
      novaPessoa: { nome: '', idade: '', documento: '' },
      erros: {} // agora está definido
    }
  },
  mounted() {
    this.carregarPessoas();
  },
  methods: {
    carregarPessoas() {
      fetch('/api/pessoas')
        .then(res => res.json())
        .then(data => { this.pessoas = data });
    },
    salvarPessoa() {
      fetch('/api/pessoas', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify(this.novaPessoa)
      })
        .then(async res => {
          if (!res.ok) {
            const errorData = await res.json();
            this.erros = errorData.errors || {};
            throw new Error(errorData.message);
          }
          return res.json();
        })
        .then(data => {
          this.pessoas.push(data);
          this.novaPessoa = { nome: '', idade: '', documento: '' };
          this.erros = {}; // limpa erros
        })
        .catch(err => console.error(err));
    }
  }
}
</script>