{{-- resources/views/activities.blade.php --}}
@extends('layouts.app')

@section('title', 'Atividades do Sistema')

@section('content')
<div id="app" class="container mx-auto px-4 py-8 max-w-7xl">
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Log de Atividades</h1>
            <a href="{{ route('dashboard') }}" class="bg-gray-600 text-white px-6 py-3 rounded-xl hover:bg-gray-700 transition">
                Voltar
            </a>
        </div>
    </div>
    
    <activities-log></activities-log>
</div>
@endsection