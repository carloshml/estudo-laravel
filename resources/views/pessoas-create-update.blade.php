<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Pessoa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div id="app">
        <div>
            <a href="{{ url('/pessoas') }}"
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                voltar
            </a>
        </div>
        <pessoas-create-update :id="{{ $id }}"></pessoas-create-update>
    </div>
</body>

</html>