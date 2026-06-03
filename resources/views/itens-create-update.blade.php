@extends('layouts.app')

@section('title', 'Cadastrar Item')

@section('content')
    <div id="app" class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Gestão de Itens</h1>
            <p class="text-gray-600 mt-1">Gerencie os itens cadastrados</p>
            <a href="{{ url('/itens') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition">
                Voltar
            </a>
        </div>
        <items-create :id="{{ $id }}"></items-create>
    </div>
@endsection
