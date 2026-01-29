<?php

namespace Modules\Disposition\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $moduleNamespace = 'Modules\Disposition\Http\Controllers';

    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->namespace($this->moduleNamespace)
                ->group(module_path('Disposition', '/Routes/api.php'));

            Route::middleware('web')
                ->namespace($this->moduleNamespace)
                ->group(module_path('Disposition', '/Routes/web.php'));
        });
    }
}
