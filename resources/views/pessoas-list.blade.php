<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pessoas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div id="app">
        <pessoas-list></pessoas-list>
        <div class="mt-6 text-center">
            <a href="{{ url('/pessoas/create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                Nova Pessoa
            </a>
        </div>
    </div>
</body>
</html>
