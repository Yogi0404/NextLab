<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->only('email', 'password');

        if (Auth::attempt($data)) {

    $role = Auth::user()->role;

    if ($role == 'admin') {
        return redirect('/admin');
    } elseif ($role == 'petugas') {
        return redirect('/petugasdashboard');
    } else {
        return redirect('/userdashboard');
    }

}

        return back()->with('error', 'Email atau password salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function showRegister()
{
    return view('auth.register');
}

public function register(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed'
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user' // default user
    ]);

    return redirect('/login')->with('success', 'Register berhasil!');
}
}
