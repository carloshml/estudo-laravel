<template>
    <div class="w-full max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-2xl font-bold text-white text-center">Criar Conta</h2>
            </div>

            <!-- Form -->
            <div class="p-8">
                <!-- Validation Errors -->
                <div v-if="errors.length" class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 rounded">
                    <p v-for="error in errors" :key="error" class="text-red-600 text-sm">{{ error }}</p>
                </div>

                <form @submit.prevent="handleRegister">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Nome</label>
                        <input type="text" v-model="form.name" required
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">E-mail</label>
                        <input type="email" v-model="form.email" required
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Senha</label>
                        <input type="password" v-model="form.password" required
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Confirmar Senha</label>
                        <input type="password" v-model="form.password_confirmation" required
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    </div>

                    <button type="submit" :disabled="loading"
                        class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-3 rounded-lg hover:from-green-700 transition font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                        <span v-if="loading" class="inline-block animate-spin mr-2">⚡</span>
                        {{ loading ? 'Cadastrando...' : 'Cadastrar' }}
                    </button>
                </form>

                <!-- Link para login -->
                <div class="mt-6 pt-4 border-t border-gray-200 text-center">
                    <p class="text-gray-600">
                        Já tem uma conta?
                        <a href="/login" class="text-green-600 hover:text-green-700 font-semibold hover:underline transition">
                            Faça login aqui
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AuthRegister',
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            loading: false,
            errors: []
        }
    },
    methods: {
        async handleRegister() {
            this.loading = true;
            this.errors = [];

            try {
                const response = await fetch('/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(this.form)
                });

                const data = await response.json();

                if (response.ok) {
                    // Registration successful
                    window.location.href = data.redirect || '/pessoas';
                } else {
                    if (data.errors) {
                        // Laravel validation errors
                        for (const key in data.errors) {
                            this.errors.push(...data.errors[key]);
                        }
                    } else {
                        this.errors.push(data.message || 'Erro ao cadastrar. Verifique os dados informados.');
                    }
                }
            } catch (error) {
                console.error('Register error:', error);
                this.errors.push('Erro ao tentar cadastrar. Tente novamente.');
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>