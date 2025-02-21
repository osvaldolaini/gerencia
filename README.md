<p align="center"><a href="https://github.com/laiguz" target="_blank"><img src="https://avatars.githubusercontent.com/u/138938048?v=4" width="100" alt="Laravel Logo"></a></p>

## V 1.16 - OPERATIONAL

    - Criação da instrução
    - Perna do voo
    - Privado
    - Translado
    - Voo de cheque

## V 1.15 - SEG VOO

    - Incidentes
    - RELPREV

## V 1.14 - Notificações

    -Alertas
    User
        Visualização de alertas

## V 1.13.1 - Botão para escolher se os apagados aparecem ou não

    Melhorias
        - Botão ativa/desativa apagados
        - Padronização das listas
    Correções
        - Inclusão do use WithPagination

## V 1.13 - Instruções

    -Cursos
    -Fases
    -Missões
    -Atividades
    -Configurações
        -Tipo de voo
        -Tipo de instrução
        -Niveis de aprendizdo
        -Condições de voo
    melhorias
        - Ordenar com arrasta e solta
        - Clonar missão

## V 1.12 - Banco de horas

    - Banco de horas
    - Ajuste
    - Troca
    - Extorno

## V 1.11 - Combustível

    - Reabastecimento da bomba
    - Abastecimento aeronave externo
    - Abastecimento aeronave interna

    Melhorias
        - Categorias de plano de contas ajustavel no menu config
        - Botões da tabela

## V 1.10.2 - Financeiro

    - Categoria de plano de contas
    Melhorias
        - Tabela de preços em pdf

## V 1.10.1 - Vendas

    Melhorias
        - Inversão da ordem: primeiro forma de pagamento depois conta, caso só tenha uma conta com a forma de pagamento nem aparece a select.
        - inclusão do campo motivo no momento da exclusão das movimentações financeiras.
        - inclusão dos PDF (Venda, entrada e saída)
    Correções
        - Jsons (direção e contatos)

## V 1.10 - Vendas

    - Venda
    - Checkout das vendas e contas a receber
    - Parcelas

    Melhorias
        - Criação do campo "pack_type" na tabela packs
        - Inclusão do campo "pack_type" na celula "packages" da tabela "prices"
        - Trait de conversão de celulas específicas como ( valor, data)

> ALTER TABLE `users` ADD `activities` JSON NULL DEFAULT NULL AFTER `accesses`;

## V 1.9 - Financeiro

    - Entradas
    - Saídas
    - Contas a pagar
    - Contas a receber
    - Configurações

    Melhorias
        - Correção do dropdown do financeiro

## V 1.8 - Agendamento

    - Indisponibilidades
    - Agendamento
    - Configuração de horários

    Melhorias
        - Criação de um autocomplete de pessoas

## V 1.7 - Cadastros - AERÓDROMOS

    - Cadastro de aeronaves
    - Layout datePicker

## V 1.6 - Cadastros - AERONAVES e MODELOS

    - Cadastro de aeronaves
    - Cadastro de modelo de aeronaves

## V 1.5 - Laini

    -Service Provider LaiGuz Table
    -Layout Table

## V 1.4 - Laini

    - Formulário configurações
        -Abas (Dados gerais, logo, contatos, diretoria, aeródromo)
    -Repeater
        - contatos
        - diretoria

## V 1.3 - Laini

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
