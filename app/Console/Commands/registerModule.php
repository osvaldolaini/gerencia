<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class registerModule extends Command
{
    protected $signature = 'module:register {name}';
    protected $description = 'Registra um módulo existente na aplicação';

    public function handle()
    {
        $name = $this->argument('name');
        $modulePath = base_path("Modules/{$name}");

        if (!File::exists($modulePath)) {
            $this->error("O módulo {$name} não foi encontrado em Modules!");
            return;
        }

        // Verificar se o ServiceProvider existe
        $serviceProvider = "Modules\\{$name}\\Providers\\{$name}ServiceProvider";
        if (!class_exists($serviceProvider)) {
            $this->error("O ServiceProvider {$serviceProvider} não existe no módulo {$name}!");
            return;
        }

        // Registrar o ServiceProvider no app
        $this->registerServiceProvider($serviceProvider);

        $this->info("Módulo {$name} registrado com sucesso!");
    }

    private function registerServiceProvider($serviceProvider)
    {
        $appConfigPath = config_path('app.php');
        $configContent = File::get($appConfigPath);

        // Verificar se o ServiceProvider já está registrado
        if (strpos($configContent, $serviceProvider) !== false) {
            $this->warn("O ServiceProvider {$serviceProvider} já está registrado.");
            return;
        }

        // Adicionar o ServiceProvider ao array de providers
        $search = "'providers' => [";
        $replacement = "'providers' => [\n        {$serviceProvider}::class,";
        $newContent = str_replace($search, $replacement, $configContent);

        File::put($appConfigPath, $newContent);
        $this->info("ServiceProvider {$serviceProvider} adicionado ao config/app.php.");
    }
}
