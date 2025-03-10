<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|string|max:20',
            'cpf' => 'required|string|unique:users,cpf|max:14',
            'gender' => 'nullable|string|max:10',
            'password' => 'required|string|confirmed|min:6',
        ]);

        // Criação do usuário
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'cpf' => preg_replace('/\D/', '', $request->input('cpf')), 
            'gender' => $request->input('gender'),
            'password' => bcrypt($request->input('password')),
        ]);

        Auth::login($user);

        return redirect()->route('profile');
    }



    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('profile');
        }

        return view('auth.login'); 
    }


    public function login(Request $request)
    {
        $request->validate([
            'cpf' => 'required|string',
            'password' => 'required|string',
        ]);

        $cpf = preg_replace('/\D/', '', $request->input('cpf')); 

        if (Auth::attempt(['cpf' => $cpf, 'password' => $request->input('password')])) {
            return redirect()->route('profile');
        }

        return back()->withErrors([
            'cpf' => 'As credenciais fornecidas estão incorretas.',
        ]);
    }



    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login.form');
    }
}
