<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Verify2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('dashboard') && Auth::user()->privilege->privilege_grade == 4) {
            return redirect()->route('database');
        }
        if (Team::count() == 0 && !$request->routeIs('fillDatabase') && Auth::user()->privilege->privilege_grade == 4) {
            return redirect()->route('fillDatabase');
        }elseif(Team::count() > 0 && $request->routeIs('fillDatabase') && Auth::user()->privilege->privilege_grade == 4){
            return redirect()->route('database');
        }
        if (Auth::user()->two_factor_confirmed_at == null && config('app.debug') == false) {
            return redirect()->route('two-factor-register');
        }

        return $next($request);
    }
}
