<template>
    <div class="w-full max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-2xl font-bold text-white text-center">Acessar Sistema</h2>
            </div>

            <!-- Form -->
            <div class="p-8">
                <!-- Error Messages -->
                <div v-if="errorMessage" class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 rounded">
                    <p class="text-red-600 text-sm">{{ errorMessage }}</p>
                </div>

                <form @submit.prevent="handleLogin">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">E-mail</label>
                        <input type="email" v-model="form.email" required autofocus
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Senha</label>
                        <input type="password" v-model="form.password" required
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    </div>

                    <div class="mb-6 flex items-center justify-between">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" v-model="form.remember" class="mr-2 rounded border-gray-300">
                            <span class="text-sm text-gray-600">Lembrar-me</span>
                        </label>
                    </div>

                    <button type="submit" :disabled="loading"
                        class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-3 rounded-lg hover:from-green-700 transition font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                        <span v-if="loading" class="inline-block animate-spin mr-2">⚡</span>
                        {{ loading ? 'Entrando...' : 'Entrar' }}
                    </button>
                </form>

                <!-- Link para registro -->
                <div class="mt-6 pt-4 border-t border-gray-200 text-center">
                    <p class="text-gray-600">
                        Não tem uma conta?
                        <a href="/register" class="text-green-600 hover:text-green-700 font-semibold hover:underline transition">
                            Cadastre-se aqui
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AuthLogin',
    data() {
        return {
            form: {
                email: '',
                password: '',
                remember: false
            },
            loading: false,
            errorMessage: null
        }
    },
    methods: {
        async handleLogin() {
            this.loading = true;
            this.errorMessage = null;

            try {
                const response = await fetch('/login', {
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
                    // Armazenar token do Sanctum
                    if (data.token) {
                        localStorage.setItem('api_token', data.token);
                        // Configurar axios para usar o token
                        if (window.axios) {
                            window.axios.defaults.headers.common['Authorization'] = `Bearer ${data.token}`;
                        }
                    }
                    
                    window.location.href = data.redirect || '/dashboard';
                } else {
                    this.errorMessage = data.message || 'Credenciais inválidas. Verifique seu e-mail e senha.';
                }
            } catch (error) {
                console.error('Login error:', error);
                this.errorMessage = 'Erro ao tentar fazer login. Tente novamente.';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>