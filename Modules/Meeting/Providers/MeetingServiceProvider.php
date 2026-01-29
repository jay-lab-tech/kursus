<?php

namespace Modules\Meeting\Providers;

use Illuminate\Support\ServiceProvider;

class MeetingServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Meeting';

    protected string $moduleNameLower = 'meeting';

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
