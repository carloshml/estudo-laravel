<?php

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\PessoaController;


Route::get('/pessoas', [PessoaController::class, 'index']);
Route::get('/', function () {
    return view('welcome');
});
