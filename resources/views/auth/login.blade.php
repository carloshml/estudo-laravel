@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-md mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
            <h2 class="text-2xl font-bold text-white text-center">Acessar Sistema</h2>
        </div>

        <div class="p-8">
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 rounded">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">E-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Senha</label>
                    <input type="password" name="password" required
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-6 flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2">
                        <span class="text-sm text-gray-600">Lembrar-me</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-3 rounded-lg hover:from-green-700 transition font-semibold">
                    Entrar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection