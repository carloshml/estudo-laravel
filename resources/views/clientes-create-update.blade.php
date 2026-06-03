@extends('layouts.app')

@section('title', 'Cadastrar Cliente')

@section('content')
    <div id="app" class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Gestão de Clientes</h1>
            <p class="text-gray-600 mt-1">Gerencie seus clientes cadastrados</p>
            <a href="{{ url('/clientes') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition mt-2">Voltar</a>
        </div>
        <clientes-create-update :id="{{ $id }}"></clientes-create-update>
    </div>
@endsection
