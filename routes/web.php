<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;


Route::view('/pessoas', 'pessoas-list');
Route::view('/pessoas/create', 'pessoas-create');
Route::get('/', function () {
    return view('welcome');
});
