<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Pessoa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div id="app" class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="mb-8">
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                   

                    <!-- Botões lado a lado -->
                    <div class="flex gap-4">

                        <a href="{{ url('/pessoas') }}"
                            class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <pessoas-read :id="{{ $id }}"></pessoas-read>
    </div>
</body>

</html>