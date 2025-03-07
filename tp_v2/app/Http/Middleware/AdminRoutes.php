<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminRoutes
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role_id == 4) {
            return $next($request);
        }

        return redirect()->route('welcome')->with('error', 'Acceso restringido a Administradores.');
    }
}
