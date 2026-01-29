<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * LEGACY MENU GENERATION - DISABLED FOR SPA
         * 
         * This middleware generates menus for the old backend system.
         * Since the application is now a Single Page Application (SPA),
         * these menus are not used. Keeping middleware for potential
         * future Blade view integration.
         * 
         * Routes referenced (if backend routes are added in future):
         * - backend.dashboard
         * - backend.notifications.index
         * - backend.settings
         * - backend.backups.index
         * - backend.users.index
         * - backend.roles.index
         * - log-viewer::dashboard
         * - log-viewer::logs.list
         */
        
        // Menu generation disabled for SPA system
        // Uncomment below if transitioning back to server-side rendered backend
        
        /*
        \Menu::make('admin_sidebar', function ($menu) {
            // ... menu items would go here ...
        })->sortBy('order');
        */

        return $next($request);
    }
}
