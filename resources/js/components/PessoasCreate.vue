<template>
  <div class="w-full max-w-3xl bg-white shadow-lg rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">
      {{ id > 0 ? 'Editar Pessoa' : 'Cadastrar Pessoa' }}
    </h1>

    <form @submit.prevent="salvarPessoa" class="space-y-4">
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
        {{ id > 0 ? 'Atualizar Pessoa' : 'Salvar Pessoa' }}
      </button>
    </form>
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      novaPessoa: { nome: '', idade: '', documento: '' },
      erros: {}
    }
  },
  mounted() {
    if (this.id > 0) {
      // busca pessoa existente
      fetch(`/api/pessoas/${this.id}`)
        .then(res => res.json())
        .then(data => {
          this.novaPessoa = {
            nome: data.nome,
            idade: data.idade,
            documento: data.documento
          }
        })
        .catch(err => console.error(err));
    }
  },
  methods: {
    salvarPessoa() {
      const url = this.id > 0 ? `/api/pessoas/${this.id}` : '/api/pessoas';
      const method = this.id > 0 ? 'PUT' : 'POST';

      const requisicao = {
        method,
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify(this.novaPessoa)
      }

      console.log(' requisicao :::: ', requisicao)

      fetch(url, requisicao)
        .then(async res => {
          if (!res.ok) {
            const errorData = await res.json();
            this.erros = errorData.errors || {};
            throw new Error(errorData.message);
          }
          return res.json();
        })
        .then(() => {
          this.erros = {};
          alert(this.id > 0 ? 'Pessoa atualizada com sucesso!' : 'Pessoa cadastrada com sucesso!');
          window.location.href = `/pessoas/`
        })
        .catch(err => console.error(err));
    }
  }
}
</script>