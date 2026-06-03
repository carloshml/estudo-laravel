@extends('layouts.app')

@section('title', 'Lista de Pessoas | Sistema de Locação')

@section('content')
    <div id="app" class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Gestão de Pessoas</h1>
                        <p class="text-gray-600 mt-1">Gerencie suas pessoas cadastradas</p>
                    </div>

                    <!-- Botões lado a lado -->
                    <div class="flex gap-4">
                        <a href="{{ url('/pessoas/create?id=0') }}"
                            class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Nova Pessoa
                        </a>

                        <a href="{{ url('/') }}"
                            class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <pessoas-list></pessoas-list>
    </div>
@endsection