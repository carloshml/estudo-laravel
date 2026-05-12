@extends('layouts.app')

@section('title', 'Pessoa')

@section('content')
    <div id="app" class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="mb-8">
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">


                    <!-- Botões lado a lado -->
                    <div class="flex gap-4">

                        <a href="javascript:history.back()"
                            class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <pessoas-read :id="{{ $id }}"></pessoas-read>
    </div>
@endsection