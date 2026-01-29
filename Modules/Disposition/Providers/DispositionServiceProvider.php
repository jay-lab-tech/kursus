<?php

namespace Modules\Disposition\Providers;

use Illuminate\Support\ServiceProvider;

class DispositionServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Disposition';

    protected string $moduleNameLower = 'disposition';

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function boot(): void
    {
        //
    }

    public function provides(): array
    {
        return [];
    }
}
