<?php

namespace Modules\People\Providers;

use Illuminate\Support\ServiceProvider;

class PeopleServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Registrar serviços ou bindings do módulo
    }

    public function boot()
    {
        // Carregar rotas
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        // Carregar views
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'people');

        // Carregar migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
