<p align="center"><a href="https://github.com/laiguz" target="_blank"><img src="https://avatars.githubusercontent.com/u/138938048?v=4" width="100" alt="Laravel Logo"></a></p>

## Versão santos dumont (beta)

> Novo
> Configurações

    ->Cadastro de escola
    ->Cadastro de companhias
    ->Cadastro de batalhão
    ->Cadastro de séries
    ->Cadastro de turmas
    ->inclusão e exclusão de alunos na turma

> Cadastros

    ->Cadastro de alunos (nome,sexo,nome de guerra,número)
    ->usuários

## Pré configurações

## V 1.3

    -Redirect fortify "user" e "admin" panel

## V 1.2.1

    -Novo side-bar

## V 1.2

    -Criação do middleware "CheckAccess"

## V 1.1.1

    -Upload da foto do usuário

## V 1.1

    -Layout Dark
    -Trocar painel do usuário
    -Acesso do usuário

## V 1.0

    -Configuração do layout da pagina principal
    -Configuração do layout das paginas de login e registro

## Setup inicial (jetstream + livewire + tailwind)

-laravel new sistemaAero
-cd sistemaAero
-composer require laravel/jetstream
-php artisan jetstream:install livewire --dark
-npm install
-npm run build
-php artisan livewire:publish --config
-php artisan migrate
-php artisan vendor:publish --tag=laravel-errors
-php artisan storage:link

    >livewire.config
    // 'layout' => 'components.layouts.app',
    	'layout' => 'layouts.app',

## 'Plugin Tailwind'

-npm i -D daisyui@latest
-plugins: [require("daisyui")], (tailwind.config.js)
-npm run build

## 'Portugues para o laravel (lucascudo/laravel-pt-br-localization)

-php artisan lang:publish'
-composer require lucascudo/laravel-pt-br-localization --dev
-php artisan vendor:publish --tag=laravel-pt-br-localization
//https://github.com/opcodesio/log-viewer
-composer require opcodesio/log-viewer
-php artisan log-viewer:publish

## 'Pacote LOG activitylog'

composer require spatie/laravel-activitylog
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
php artisan migrate
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-config"
