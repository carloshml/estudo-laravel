<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\UserController;

// Rotas protegidas pelo Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Rotas de Pessoas
    Route::prefix('pessoas')->group(function () {
        Route::get('/', [PessoaController::class, 'list']);
        Route::get('/stats', function() {
            $pessoas = \App\Models\Pessoa::all();
            return response()->json([
                'total' => $pessoas->count(),
                'media_idade' => $pessoas->avg('idade'),
                'documentos_unicos' => $pessoas->unique('documento')->count()
            ]);
        });
        Route::get('/{id}', [PessoaController::class, 'getById']);
        Route::post('/', [PessoaController::class, 'store']);
        Route::put('/{id}', [PessoaController::class, 'update']);
        Route::delete('/{id}', [PessoaController::class, 'destroy']);
    });
    
    // Rotas de Usuários
    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UserController::class, 'list']);
        Route::get('/{id}', [UserController::class, 'getById']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
        Route::post('/{id}/avatar', [UserController::class, 'updateAvatar']);
        Route::put('/{id}/profile', [UserController::class, 'updateProfile']);
        Route::get('/{id}/activities', [UserController::class, 'getActivities']);
    });
    
    // Rotas de Atividades
    Route::get('/activities', [UserController::class, 'getAllActivities']);
});