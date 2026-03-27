<?php

use Illuminate\Support\Facades\Route;


Route::view('/pessoas', 'pessoas-list');

Route::get('/pessoas/create', function (\Illuminate\Http\Request $request) {
    $id = $request->query('id', 0); // pega ?id=0 ou outro valor
    return view('pessoas-create-update', compact('id'));
});

Route::get('/pessoas/{id}/edit', function ($id) {
    return view('pessoas-create-update', ['id' => $id]);
});

Route::get('/', function () {
    return view('welcome');
});
