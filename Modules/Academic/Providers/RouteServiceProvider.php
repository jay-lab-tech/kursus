<?php

namespace Modules\Academic\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $moduleNamespace = 'Modules\Academic\Http\Controllers';

    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->namespace($this->moduleNamespace)
                ->group(module_path('Academic', '/Routes/api.php'));

            Route::middleware('web')
                ->namespace($this->moduleNamespace)
                ->group(module_path('Academic', '/Routes/web.php'));
        });
    }
}
