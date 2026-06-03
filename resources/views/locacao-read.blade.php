@extends('layouts.app')

@section('title', 'Detalhes da Locação | Meu Sistema')

@section('content')
    <div id="app" class="container mx-auto px-4 py-8 max-w-7xl">
        <locacao-read :id="{{ $id }}"></locacao-read>
    </div>
@endsection
