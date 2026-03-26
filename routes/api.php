<?php
 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;

Route::post('/pessoas', [PessoaController::class, 'store']);
Route::get('/pessoas', [PessoaController::class, 'index']);

 