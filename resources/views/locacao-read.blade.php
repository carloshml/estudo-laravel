@extends('layouts.app')

@section('title', 'Detalhes da Locação | Sistema de Locação')

@section('content')
    <div id="app" class="container mx-auto px-4 py-8 max-w-7xl">
        <locacao-read :id="{{ $id }}"></locacao-read>
    </div>
@endsection
