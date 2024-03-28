<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherRoutes
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role_id == 2) {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'Acceso restringido a Docentes.');
    }
}
