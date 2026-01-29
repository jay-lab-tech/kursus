<?php

namespace Modules\Academic\Providers;

use Illuminate\Support\ServiceProvider;

class AcademicServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Academic';

    protected string $moduleNameLower = 'academic';

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
