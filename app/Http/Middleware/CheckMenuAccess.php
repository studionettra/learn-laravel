<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

class CheckMenuAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        // Mengambil segmen pertama URL, contoh: /user/create atau /user/1/edit akan dibaca 'user'
        $currentSegment = $request->segment(1);

        // Kecualikan halaman utama yang boleh diakses semua role setelah login
        if (in_array($currentSegment, ['dashboard', 'home', 'profile'])) {
            return $next($request);
        }

        // Cari data menu yang kolom url-nya mengandung segmen saat ini
        $menu = Menu::where('url', 'LIKE', $currentSegment . '%')->first();

        // Jika URL yang diketik manual tidak didaftarkan di data master menu, ijinkan lewat (atau block sesuai kebutuhan)
        if (!$menu) {
            return $next($request);
        }

        // Cek hak akses ke tabel pivot menu_role menggunakan role_id milik user
        $hasAccess = $menu->roles()->where('roles.id', $user->role_id)->exists();

        if (!$hasAccess) {
            // Lempar ke halaman 403 Forbidden bawaan Laravel jika tidak punya hak akses
            abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
        }

        return $next($request);
    }
}
