<template>


  <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 rounded-xl">
    <div class="flex justify-between items-center text-white">
      Pessoa
    </div>
  </div>

  <div class="w-full   bg-white shadow-xl rounded-xl p-8"> <!-- Form -->
    <form @submit.prevent="salvarPessoa" class="space-y-5">
      <div>
        <label class="block text-gray-700 font-medium mb-1">Nome</label>
        <input disabled v-model="novaPessoa.nome" type="text"
          class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300 focus:border-blue-400">
        <p v-if="erros.nome" class="text-red-600 text-sm mt-1">{{ erros.nome[0] }}</p>
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Idade</label>
        <input disabled v-model="novaPessoa.idade" type="number"
          class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300 focus:border-blue-400">
        <p v-if="erros.idade" class="text-red-600 text-sm mt-1">{{ erros.idade[0] }}</p>
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Documento</label>
        <input disabled v-model="novaPessoa.documento" type="text"
          class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300 focus:border-blue-400">
        <p v-if="erros.documento" class="text-red-600 text-sm mt-1">{{ erros.documento[0] }}</p>
      </div>

      <!-- Actions -->
      <div class="flex justify-end gap-4">

      </div>
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
      const token = localStorage.getItem('api_token');
      const headers = {};

      if (token) {
        headers['Authorization'] = `Bearer ${token}`;
      }

      fetch(`/api/pessoas/${this.id}`, { headers })
        .then(res => {
          if (res.status === 401) {
            localStorage.removeItem('api_token');
            window.location.href = '/login';
            throw new Error('Não autorizado');
          }
          return res.json();
        })
        .then(data => {
          this.novaPessoa = {
            nome: data.nome,
            idade: data.idade,
            documento: data.documento
          }
        })
        .catch(err => console.error(err));
    }
  }
}
</script>