<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;

Route::prefix('pessoas')->group(function () {
    Route::get('/', [PessoaController::class, 'list']);
    Route::get('/{id}', [PessoaController::class, 'getById']);
    Route::post('/', [PessoaController::class, 'store']);
    Route::put('/{id}', [PessoaController::class, 'update']);
    Route::delete('/{id}', [PessoaController::class, 'destroy']);
});


