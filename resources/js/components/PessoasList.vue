<template>
  <div class="w-full max-w-3xl bg-white shadow-lg rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Lista de Pessoas</h1>

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
</template>

<script>
export default {
  data() {
    return { pessoas: [] }
  },
  mounted() {
    fetch('/api/pessoas')
      .then(res => res.json())
      .then(data => { this.pessoas = data })
  }
}
</script>