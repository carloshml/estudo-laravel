{{-- resources/views/user-profile.blade.php --}}
@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div id="app" class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Meu Perfil</h1>
        <p class="text-gray-600 mt-1">Gerencie suas informações pessoais</p>
    </div>
    
    <user-profile :id="{{ $id }}"></user-profile>
</div>
@endsection