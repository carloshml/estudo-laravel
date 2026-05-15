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
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => '/pessoas'
                ]);
            }
            
            return redirect()->intended('/pessoas');
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
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect('/');
    }
}