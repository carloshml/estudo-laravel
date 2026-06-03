@extends('layouts.app')

@section('title', 'Detalhes do Cliente | Meu Sistema')

@section('content')
    <div id="app" class="container mx-auto px-4 py-8 max-w-7xl">
        <cliente-read :id="{{ $id }}"></cliente-read>
    </div>
@endsection
