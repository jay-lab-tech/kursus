<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleAuthorize
{
    /**
     * Handle an incoming request.
     * Usage: 'role:admin,instruktur' or 'role:admin'
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Check if user has one of the allowed roles
        $userRole = $user->role ?? 'mahasiswa';
        
        if (!in_array($userRole, $roles)) {
            return response()->json([
                'error' => 'Forbidden',
                'message' => "User role '{$userRole}' is not allowed to access this resource"
            ], 403);
        }

        return $next($request);
    }
}
