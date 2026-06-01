
@extends('layouts.app')

@section('title', 'Detalhes do Usuário')

@section('content')
<div id="app" class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Detalhes do Usuário</h1>
            <div class="flex gap-4">
                <a href="{{ route('users.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-xl hover:bg-gray-700 transition">
                    Voltar
                </a>
            </div>
        </div>
    </div>
    
    <user-read :id="{{ $id }}"></user-read>
</div>
@endsection