<?php

// app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        
        if (!$user || !in_array($user->role->name, $roles)) {
            return response()->json(['message' => 'Unauthorized. Anda tidak memiliki akses ke fitur ini.'], 403);
        }
        
        return $next($request);
    }
}