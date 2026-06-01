@extends('layouts.app')

@section('title', 'Usuários | Sistema')

@section('content')
<div id="app" class="container mx-auto px-4 py-8 max-w-7xl">
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestão de Usuários</h1>
                <p class="text-gray-600 mt-1">Gerencie os usuários do sistema</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('users.create') }}" 
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Novo Usuário
                </a>
                <a href="{{ route('dashboard') }}" class="bg-gray-600 text-white px-6 py-3 rounded-xl hover:bg-gray-700 transition">
                    Voltar
                </a>
            </div>
        </div>
    </div>
    
    <users-list></users-list>
</div>
@endsection