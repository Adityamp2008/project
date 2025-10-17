<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function index()
    {
        // Kalau sudah login, langsung arahkan ke dashboard sesuai role
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login'); // pastikan kamu punya resources/views/login.blade.php
    }

    /**
     * Proses login user berdasarkan username & password
     */
    public function loginAction(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Arahkan user sesuai role
            return $this->redirectByRole(Auth::user()->role);
        }

        // Gagal login
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * Logout dan hapus sesi
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Redirect user berdasarkan role
     */
    private function redirectByRole($role)
    {
        switch ($role) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'petugas':
                return redirect('/petugas/dashboard');
            case 'kepdin':
                return redirect('/kepdin/dashboard');
            default:
                return redirect('/'); // fallback
        }
    }
}
