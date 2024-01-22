<?php

namespace App\Http\Middleware\Company;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->guard('company')->check()) {
            $company = $request->route()->parameters()['company'];
            return redirect()->route('company.auth.login', $company)->withErrors([
                'username' => ['Expired session!']
            ]);
        }
        return $next($request);
    }
}
