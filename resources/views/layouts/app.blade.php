<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Meu Sistema')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <nav class="bg-gray-800 p-4 flex justify-between items-center">
        <div class="text-white font-bold text-lg">Meu Sistema</div>
        <div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                    Sair
                </button>
            </form>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center">
        @yield('content')
    </main>
</body>
</html>
