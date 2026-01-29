<?php

namespace Modules\Letters\Providers;

use Illuminate\Support\ServiceProvider;

class LettersServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Letters';

    protected string $moduleNameLower = 'letters';

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
