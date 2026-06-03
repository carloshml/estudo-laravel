@extends('layouts.app')

@section('title', 'Detalhes do Item | Meu Sistema')

@section('content')
    <div id="app" class="container mx-auto px-4 py-8 max-w-7xl">
        <items-read :id="{{ $id }}"></items-read>
    </div>
@endsection
