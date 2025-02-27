<?php

use App\Http\Middleware\RegisterLogging;
use Modules\People\Livewire\PeopleForm;
use Illuminate\Support\Facades\Route;
use Modules\People\Livewire\PeopleList;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class,
    'checkAccess:peoples' //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/cadastros/alunos', PeopleList::class)
        ->name('peoples-list');
    Route::get('/cadastros/alunos/novo', PeopleForm::class)
        ->name('peoples-create');
    Route::get('/cadastros/alunos/{peoples}/editar', PeopleForm::class)
        ->name('peoples-edit');
});
