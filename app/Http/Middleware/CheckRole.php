<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // If no roles specified, allow all authenticated users
        if (empty($roles)) {
            return $next($request);
        }

        // Check if user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthorized. Please login first.'
            ], 401);
        }

        $userRole = auth()->user()->role;

        // Check if user's role is in allowed roles
        if (!in_array($userRole, $roles)) {
            return response()->json([
                'message' => "Forbidden. You don't have permission to access this resource.",
                'required_role' => $roles,
                'your_role' => $userRole
            ], 403);
        }

        return $next($request);
    }
}
