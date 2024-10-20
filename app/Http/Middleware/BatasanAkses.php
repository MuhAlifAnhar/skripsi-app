<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BatasanAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Ambil role dari session
        $userRole = session('role');

        // Cek apakah user memiliki role yang sesuai
        if ($userRole !== $role) {
            // Jika tidak sesuai, redirect atau tampilkan pesan error
            return redirect('/panel/dashboard')->with('error', 'Anda tidak memiliki akses untuk melakukan ini!');
        }

        return $next($request);
    }
}
