<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Verificar se é o primeiro usuário do sistema
        $isFirstUser = User::count() === 0;
        $role = $isFirstUser ? 'admin' : 'user';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'is_active' => true, // Usuário ativo por padrão
        ]);

        // Criar perfil
        UserProfile::create([
            'user_id' => $user->id,
            'preferences' => ['theme' => 'light', 'notifications' => true]
        ]);

        Auth::login($user);
        
        // Atualizar last_login_at
        $user->update(['last_login_at' => now()]);
        
        // Gerar token Sanctum para API
        $token = $user->createToken('auth-token')->plainTextToken;
        session(['api_token' => $token]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => '/dashboard',
                'user' => $user,
                'token' => $token
            ]);
        }

        return redirect('/dashboard');
    }
}