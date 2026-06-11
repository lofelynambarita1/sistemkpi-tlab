<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->isStaff()) {
            if (Auth::check() && Auth::user()->isHROrManager()) {
                return redirect()->route('hr.kpi.index')
                    ->with('info', 'Halaman ini hanya untuk staff.');
            }
            abort(403, 'Akses tidak diizinkan.');
        }
        return $next($request);
    }
}
