<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirector
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if(!$user || !$user->role) {
            return redirect()->route('login')->with("error", "Access Denied");
        }

        $role = $user->role->title;

        $routes = [
            'Receiptionist' => 'receiption',
            'Manager' => 'managers',
            'Staff' => 'staff'
        ];

        // If the current route isn't inside their allowed group, redirect
        $currentRouteName = $request->route()->getName();

        if (isset($redirectRoutes[$role])) {
            $allowedPrefix = explode('.', $routes[$role])[0];

            if (!str_starts_with($currentRouteName, $allowedPrefix)) {
                return redirect()->route($routes[$role]);
            }
        }

        return $next($request);
    }
}
