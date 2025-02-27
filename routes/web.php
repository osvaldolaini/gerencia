<?php

use App\Http\Middleware\RegisterLogging;
use App\Livewire\Admin\Page\Panel;
use App\Livewire\Admin\Settings\Logs;
use App\Livewire\Admin\Settings\Settings;
use App\Livewire\Admin\Users\UserForm;
use App\Livewire\Admin\Users\UserList;
use App\Livewire\Peoples\PeopleForm;
use App\Livewire\Peoples\PeopleList;
use App\Livewire\Settings\Companies\CompanyForm;
use App\Livewire\Settings\Companies\Companylist;
use App\Livewire\Students\StudentForm;
use App\Livewire\Students\StudentList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class
])->group(function () {
    Route::get('/admin/dashboard', Panel::class)->name('dashboard');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class
])->group(function () {
    Route::get('/admin/configurações-gerais', Settings::class)->name('settings');
    Route::get('/log-viewer', Logs::class)->name('logs');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class,
    'checkAccess:users' //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/cadastros/usuários', UserList::class)
        ->name('users-list');
    Route::get('/cadastros/usuários/novo', UserForm::class)
        ->name('user-create');
    Route::get('/cadastros/usuários/{user}/editar', UserForm::class)
        ->name('user-edit');
});


//CADASTRO DE PESSOAS //
//Estudantes//
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class,
    'checkAccess:students' //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/cadastros/alunos', StudentList::class)
        ->name('student-list');
    Route::get('/cadastros/alunos/novo', StudentForm::class)
        ->name('student-create');
    Route::get('/cadastros/alunos/{peoples}/editar', StudentForm::class)
        ->name('student-edit');
});

//COMPANIAS //
//Compania//
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class,
    'checkAccess:companies' //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/companias/compania', Companylist::class)
        ->name('companies-list');
    Route::get('/companias/compania/novo', CompanyForm::class)
        ->name('companies-create');
    Route::get('/companias/compania/{companies}/editar', CompanyForm::class)
        ->name('companies-edit');
});
