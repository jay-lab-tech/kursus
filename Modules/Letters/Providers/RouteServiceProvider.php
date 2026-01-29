<?php

namespace Modules\Letters\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $moduleNamespace = 'Modules\Letters\Http\Controllers';

    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->namespace($this->moduleNamespace)
                ->group(module_path('Letters', '/Routes/api.php'));

            Route::middleware('web')
                ->namespace($this->moduleNamespace)
                ->group(module_path('Letters', '/Routes/web.php'));
        });
    }
}
