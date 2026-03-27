<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;

Route::post('/pessoas', [PessoaController::class, 'store']);
Route::get('/pessoas', [PessoaController::class, 'list']);
Route::get('/pessoas/{id}', [PessoaController::class, 'getById']);
Route::put('/pessoas/{id}', [PessoaController::class, 'update']);
Route::delete('/pessoas/{id}', [PessoaController::class, 'destroy']);

