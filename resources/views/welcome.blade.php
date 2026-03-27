<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo | Meu Sistema</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center">
    <div class="text-center max-w-xl mx-auto p-8 bg-white shadow-lg rounded-xl">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Bem-vindo ao Sistema</h1>
        <p class="text-gray-600 mb-8">
            Este é um projeto de estudo com Laravel e Vue para gestão de pessoas.
        </p>

        <a href="{{ url('/pessoas') }}"
           class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 7h18M3 12h18M3 17h18"></path>
            </svg>
            Ir para Lista de Pessoas
        </a>
    </div>
</body>
</html>