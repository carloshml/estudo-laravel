<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // Não precisa de Hash::make() porque seu modelo já tem casts
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // ← puro, o casts resolve
        ]);

        Auth::login($user);

        return redirect('/pessoas');
    }
}