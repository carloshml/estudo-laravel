<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            // Gerar token Sanctum para API
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => '/dashboard', // Mudado para dashboard
                    'token' => $token,
                    'user' => $user
                ]);
            }
            
            // Para web, armazenar token na sessão
            session(['api_token' => $token]);
            
            return redirect()->intended('/dashboard'); // Mudado para dashboard
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
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect('/login');
    }
}