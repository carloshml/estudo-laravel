<template>
    <div class="mt-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Últimas Pessoas Cadastradas</h2>

        <ul v-if="pessoas.length > 0" class="space-y-3">
            <li v-for="pessoa in pessoas" :key="pessoa.id"
                class="flex justify-between items-center bg-gray-50 p-4 rounded-lg shadow-sm">
                <a :href="`/pessoas/${pessoa.id}`">
                    <div>
                        <p class="text-gray-900 font-medium">{{ pessoa.nome }}</p>
                        <p class="text-gray-600 text-sm">{{ pessoa.idade }} anos - {{ pessoa.documento }}</p>
                    </div>
                </a>
            </li>
        </ul>

        <p v-else class="text-gray-500">Nenhuma pessoa cadastrada ainda.</p>
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
            .then(data => {
                // pega apenas os 3 últimos
                this.pessoas = data.slice(-3).reverse();
            })
            .catch(err => console.error(err));
    }
}
</script>