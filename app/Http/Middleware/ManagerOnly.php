<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManagerOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
        if (!$user->isManager()) abort(403, 'Halaman ini hanya untuk Manager.');
        return $next($request);
    }
}