@extends('layouts.app')

@section('title', 'Dashboard | Meu Sistema')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Welcome Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h1 class="text-2xl font-bold text-white">
                    Bem-vindo, {{ auth()->user()->name }}!
                </h1>
                <p class="text-green-100 mt-1">Sistema de Gestão de Pessoas</p>
            </div>
            
            <div class="p-8">
                <p class="text-gray-600 text-lg mb-6">
                    Este é um projeto de estudo com Laravel e Vue para gestão de pessoas.
                </p>
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-600 text-sm font-semibold uppercase">Total Pessoas</p>
                                <p class="text-3xl font-bold text-blue-900" id="totalPessoas">0</p>
                            </div>
                            <div class="bg-blue-500 rounded-full p-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-600 text-sm font-semibold uppercase">Média de Idade</p>
                                <p class="text-3xl font-bold text-purple-900" id="mediaIdade">0</p>
                            </div>
                            <div class="bg-purple-500 rounded-full p-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-600 text-sm font-semibold uppercase">Documentos Únicos</p>
                                <p class="text-3xl font-bold text-green-900" id="totalDocumentos">0</p>
                            </div>
                            <div class="bg-green-500 rounded-full p-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Menu Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Pessoas Card -->
                    <a href="{{ route('pessoas.index') }}" class="group">
                        <div class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-green-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg w-16 h-16 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Pessoas</h3>
                            <p class="text-gray-600">Gerencie todas as pessoas cadastradas no sistema</p>
                            <div class="mt-4 text-green-600 font-semibold flex items-center gap-2 group-hover:gap-3 transition-all">
                                Acessar
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Nova Pessoa Card -->
                    <a href="{{ route('pessoas.create') }}" class="group">
                        <div class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-blue-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg w-16 h-16 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Nova Pessoa</h3>
                            <p class="text-gray-600">Adicione uma nova pessoa ao sistema</p>
                            <div class="mt-4 text-blue-600 font-semibold flex items-center gap-2 group-hover:gap-3 transition-all">
                                Cadastrar
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Perfil Card -->
                    <div class="bg-white border-2 border-gray-200 rounded-xl p-6">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg w-16 h-16 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Meu Perfil</h3>
                        <p class="text-gray-600">{{ auth()->user()->email }}</p>
                        <div class="mt-4 text-gray-600 text-sm">
                            Membro desde: {{ auth()->user()->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Últimas pessoas -->
        <ultimas-pessoas></ultimas-pessoas>
    </div>
    
    @push('scripts')
    <script>
        // Buscar estatísticas
        fetch('/api/pessoas', {
            headers: {
                'Authorization': `Bearer {{ session('api_token') }}`,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('totalPessoas').textContent = data.length;
            
            const somaIdade = data.reduce((sum, pessoa) => sum + pessoa.idade, 0);
            const media = data.length > 0 ? Math.round(somaIdade / data.length) : 0;
            document.getElementById('mediaIdade').textContent = media;
            
            const docsUnicos = new Set(data.map(p => p.documento)).size;
            document.getElementById('totalDocumentos').textContent = docsUnicos;
        })
        .catch(err => console.error(err));
    </script>
    @endpush
@endsection