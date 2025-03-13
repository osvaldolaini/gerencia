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
use App\Livewire\Settings\SchoolBattalion\SchoolBattalionForm;
use App\Livewire\Settings\SchoolBattalion\SchoolBattalionList;
use App\Livewire\Settings\SchoolBattalionStudents\SchoolBattalionStudentForm;
use App\Livewire\Settings\SchoolBattalionStudents\SchoolBattalionStudentGrade;
use App\Livewire\Settings\SchoolBattalionStudents\SchoolBattalionStudentList;
use App\Livewire\Settings\SchoolClasses\SchoolClassesForm;
use App\Livewire\Settings\SchoolClasses\SchoolClassesList;
use App\Livewire\Settings\SchoolClasses\SchoolClassesStudents;
use App\Livewire\Settings\SchoolClassesYears\SchoolClassesYearForm;
use App\Livewire\Settings\SchoolClassesYears\SchoolClassesYearList;
use App\Livewire\Settings\SchoolGrades\SchoolGradeForm;
use App\Livewire\Settings\SchoolGrades\SchoolGradelist;
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
//Ano escolar
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class,
    'checkAccess:school_grades' //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/companias/ano-escolar', SchoolGradelist::class)
        ->name('school-grades-list');
    Route::get('/companias/ano-escolar/novo', CompanyForm::class)
        ->name('school-grades-create');
    Route::get('/companias/ano-escolar/{school_grades}/editar', CompanyForm::class)
        ->name('school-grades-edit');
});

//Turmas
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class,
    'checkAccess:school_classes_years' //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/companias/anos', SchoolClassesYearList::class)
        ->name('school-classes-years-list');
    Route::get('/companias/anos/novo', SchoolClassesYearForm::class)
        ->name('school-classes-years-create');
    Route::get('/companias/anos/{school_classes_years}/editar', SchoolClassesYearForm::class)
        ->name('school-classes-years-edit');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class,
    'checkAccess:school_classes_years' //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/companias/anos/{school_classes_years}/turmas', SchoolClassesList::class)
        ->name('school-classes-year-list');
    Route::get('/companias/turmas/{school_classes}/editar', SchoolClassesForm::class)
        ->name('school-classes-edit');
    Route::get('/companias/turmas/{school_classes}/alunos', SchoolClassesStudents::class)
        ->name('school-classes-students');
});

//Batalhão
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class,
    'checkAccess:school_battalion' //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/batalhao/anos', SchoolBattalionList::class)
        ->name('school-battalion-list');
    Route::get('/batalhao/anos/novo', SchoolBattalionForm::class)
        ->name('school-battalion-create');
    Route::get('/batalhao/anos/{school_battalion}/editar', SchoolBattalionForm::class)
        ->name('school-battalion-edit');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class,
    'checkAccess:school_battalion' //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/batalhao/montar/{school_battalions}', SchoolBattalionStudentGrade::class)
        ->name('school-battalion-students-grade');
    Route::get('/batalhao/montar/{school_battalions}/ano/{school_grades}/serie', SchoolBattalionStudentList::class)
        ->name('school-battalion-students-mount');
    // Route::get('/batalhao/montar/novo', SchoolBattalionStudentForm::class)
    //     ->name('school-battalion-students-create');
    // Route::get('/batalhao/montar/{school_battalion}/editar', SchoolBattalionForm::class)
    //     ->name('school-battalion-students-edit');
});
