<?php

namespace App\Providers\LaiGuz;

use App\Services\LaiGuz\TableService;
use Illuminate\Support\ServiceProvider;

class TableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TableService::class, function ($app) {
            return new TableService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
