<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle($request, Closure $next, $roles)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Pecah role yang dikirim di route jadi array
        $roles = explode('|', $roles);

        // Debug optional
        // \Log::info('Role check', ['user_role' => $user->role, 'allowed_roles' => $roles]);

        // Cek apakah role user termasuk salah satu yang diizinkan
        if (!in_array($user->role, $roles)) {
            abort(403, 'Akses ditolak: role tidak sesuai');
        }

        return $next($request);
    }
}
