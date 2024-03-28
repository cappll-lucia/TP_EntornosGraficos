<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentsRoutes
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role_id == 1) {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'Acceso restringido a Alumnos.');
    }
}
