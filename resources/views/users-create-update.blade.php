{{-- resources/views/users-create-update.blade.php --}}
@extends('layouts.app')

@section('title', $id > 0 ? 'Editar Usuário' : 'Novo Usuário')

@section('content')
<div id="app" class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">{{ $id > 0 ? 'Editar Usuário' : 'Novo Usuário' }}</h1>
            <a href="{{ route('users.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-xl hover:bg-gray-700 transition">
                Voltar
            </a>
        </div>
    </div>
    
    <users-create-update :id="{{ $id }}"></users-create-update>
</div>
@endsection