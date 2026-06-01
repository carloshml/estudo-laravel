<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Verificar se o usuário existe e está ativo
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if (!$user) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Usuário não encontrado.'
                ], 401);
            }
            return back()->withErrors([
                'email' => 'Usuário não encontrado.',
            ])->onlyInput('email');
        }

        // Verificar se o usuário está ativo
        if (!$user->is_active) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Sua conta está inativa. Entre em contato com o administrador.'
                ], 403);
            }
            return back()->withErrors([
                'email' => 'Sua conta está inativa. Entre em contato com o administrador.',
            ])->onlyInput('email');
        }

        // Tentar fazer login
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            // Gerar token Sanctum para API
            $user = Auth::user();
            
            // Atualizar last_login_at
            $user->update([
                'last_login_at' => now()
            ]);
            
            $token = $user->createToken('auth-token')->plainTextToken;
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => '/dashboard',
                    'token' => $token,
                    'user' => $user
                ]);
            }
            
            // Para web, armazenar token na sessão
            session(['api_token' => $token]);
            
            return redirect()->intended('/dashboard');
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'As credenciais informadas não correspondem aos nossos registros.'
            ], 401);
        }

        return back()->withErrors([
            'email' => 'As credenciais informadas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Revogar tokens do usuário (se existirem)
        if (Auth::check()) {
            $user = Auth::user();
            $user->tokens()->delete();
        }
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Limpar token da sessão
        $request->session()->forget('api_token');
        
        // Limpar token do localStorage via JavaScript (opcional)
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect('/login');
    }
}