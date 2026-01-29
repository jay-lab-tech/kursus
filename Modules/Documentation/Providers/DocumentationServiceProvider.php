<?php

namespace Modules\Documentation\Providers;

use Illuminate\Support\ServiceProvider;

class DocumentationServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Documentation';

    protected string $moduleNameLower = 'documentation';

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
