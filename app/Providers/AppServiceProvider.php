<?php

namespace App\Providers;

use App\Providers\Lg\LgTableServiceProvider;
use Illuminate\Support\ServiceProvider;
use Modules\People\Providers\PeopleServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PeopleServiceProvider::class;
    }
}
