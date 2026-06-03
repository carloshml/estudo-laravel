@extends('layouts.app')

@section('title', 'Lista de Clientes | Sistema de Locação')

@section('content')
    <div id="app" class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestão de Clientes</h1>
                    <p class="text-gray-600 mt-1">Gerencie seus clientes cadastrados</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ url('/clientes/create') }}" class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition-all shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Novo Cliente
                    </a>
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition-all shadow-lg">Voltar</a>
                </div>
            </div>
        </div>
        <clientes-list></clientes-list>
    </div>
@endsection
