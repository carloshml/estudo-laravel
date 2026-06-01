<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// ========== ROTAS PÚBLICAS (sem login) ==========
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// ========== ROTAS PROTEGIDAS (precisa estar logado) ==========
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('welcome');
    })->name('dashboard');
    
    // Rotas de Pessoas
    Route::view('/pessoas', 'pessoas-list')->name('pessoas.index');
    Route::get('/pessoas/create', function () {
        return view('pessoas-create-update', ['id' => 0]);
    })->name('pessoas.create');
    Route::get('/pessoas/{id}/edit', function ($id) {
        return view('pessoas-create-update', ['id' => $id]);
    })->name('pessoas.edit');
    Route::get('/pessoas/{id}', function ($id) {
        return view('pessoa-read', ['id' => $id]);
    })->name('pessoas.show');
    
    // Rotas de Usuários
    Route::view('/usuarios', 'users-list')->name('users.index');
    Route::get('/usuarios/create', function () {
        return view('users-create-update', ['id' => 0]);
    })->name('users.create');
    Route::get('/usuarios/{id}/edit', function ($id) {
        return view('users-create-update', ['id' => $id]);
    })->name('users.edit');
    Route::get('/usuarios/{id}', function ($id) {
        return view('user-read', ['id' => $id]);
    })->name('users.show');
    Route::get('/perfil', function () {
        return view('user-profile', ['id' => auth()->id()]);
    })->name('profile');
    Route::get('/atividades', function () {
        return view('activities');
    })->name('activities');
    
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
});