<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class RolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$allowedRoles): Response
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $user_role = Role::find($user->role_id)?->title;
        if (!in_array($user_role, $allowedRoles)) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
