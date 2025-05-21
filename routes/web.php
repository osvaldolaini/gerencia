<?php

use App\Livewire\ReadmeView;
use App\Http\Middleware\RegisterLogging;
use App\Livewire\Admin\Page\Panel;
use App\Livewire\Admin\Settings\Logs;
use App\Livewire\Admin\Settings\Settings;
use App\Livewire\Admin\Users\UserForm;
use App\Livewire\Admin\Users\UserList;
use App\Livewire\App\Dashboard as App;
use App\Livewire\App\Discipline\MyFosList;
use App\Livewire\App\Faults\FaultInsert;
use App\Livewire\App\Faults\MyFaultsList;
use App\Livewire\Discipline\FactObserveds\FactObservedEdit;
use App\Livewire\Discipline\FactObserveds\FactObservedForm;
use App\Livewire\Discipline\FactObserveds\FactObservedList;
use App\Livewire\Discipline\FaultDisciplines\FaultDisciplineEdit;
use App\Livewire\Discipline\FaultDisciplines\FaultDisciplineForm;
use App\Livewire\Discipline\FaultDisciplines\FaultDisciplineList;
use App\Livewire\Discipline\Settings\Faults\FaultForm;
use App\Livewire\Discipline\Settings\Faults\FaultList;
use App\Livewire\Discipline\Panel\DisciplinePanel;
use App\Livewire\Faults\Panel\FaultsPanel;
use App\Livewire\Faults\Panel\SchoolFaultsFilter;
use App\Livewire\Faults\SchoolFaultEdit;
use App\Livewire\Faults\SchoolFaultForm;
use App\Livewire\Faults\SchoolFaultJustified;
use App\Livewire\Faults\SchoolFaultList;
use App\Livewire\Peoples\PeopleForm;
use App\Livewire\Peoples\PeopleList;
use App\Livewire\Settings\Companies\CompanyForm;
use App\Livewire\Settings\Companies\Companylist;
use App\Livewire\Settings\SchoolBattalion\SchoolBattalionForm;
use App\Livewire\Settings\SchoolBattalion\SchoolBattalionList;
use App\Livewire\Settings\SchoolBattalion\SchoolBattalionView;
use App\Livewire\Settings\SchoolBattalionStudents\SchoolBattalionStudentForm;
use App\Livewire\Settings\SchoolBattalionStudents\SchoolBattalionStudentGrade;
use App\Livewire\Settings\SchoolBattalionStudents\SchoolBattalionStudentList;
use App\Livewire\Settings\SchoolClasses\SchoolClassesForm;
use App\Livewire\Settings\SchoolClasses\SchoolClassesList;
use App\Livewire\Settings\SchoolClasses\SchoolClassesStudents;
use App\Livewire\Settings\SchoolClasses\SchoolClassesView;
use App\Livewire\Settings\SchoolClassesYears\SchoolClassesYearForm;
use App\Livewire\Settings\SchoolClassesYears\SchoolClassesYearList;
use App\Livewire\Settings\SchoolClassroomSeats\SchoolClassroomSeatForm;
use App\Livewire\Settings\SchoolGrades\SchoolGradeForm;
use App\Livewire\Settings\SchoolGrades\SchoolGradeList;
use App\Livewire\Students\StudentForm;
use App\Livewire\Students\StudentList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/umask', function () {
//     return decoct(umask());
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class
])->group(function () {
    Route::get('/admin/dashboard', Panel::class)->name('dashboard');
    Route::get('/versoes', ReadmeView::class)->name('versions');
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
//Efetivo
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class,
    'checkAccess:peoples' //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/cadastros/efetivo', PeopleList::class)
        ->name('peoples-list');
    Route::get('/cadastros/efetivo/novo', PeopleForm::class)
        ->name('peoples-create');
    Route::get('/cadastros/efetivo/{peoples}/editar', PeopleForm::class)
        ->name('peoples-edit');
});
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
    Route::get('/companhias/compania', Companylist::class)
        ->name('companies-list');
    Route::get('/companhias/compania/novo', CompanyForm::class)
        ->name('companies-create');
    Route::get('/companhias/compania/{companies}/editar', CompanyForm::class)
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
    Route::get('/companhias/ano-escolar', SchoolGradeList::class)
        ->name('school-grades-list');
    Route::get('/companhias/ano-escolar/novo', CompanyForm::class)
        ->name('school-grades-create');
    Route::get('/companhias/ano-escolar/{school_grades}/editar', CompanyForm::class)
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
    Route::get('/companhias/anos', SchoolClassesYearList::class)
        ->name('school-classes-years-list');
    Route::get('/companhias/anos/novo', SchoolClassesYearForm::class)
        ->name('school-classes-years-create');
    Route::get('/companhias/anos/{school_classes_years}/editar', SchoolClassesYearForm::class)
        ->name('school-classes-years-edit');
    Route::get('/companhias/anos/{school_grades}/visualizar', SchoolClassesView::class)
        ->name('school-classes-view');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class,
    'checkAccess:school_classes_years' //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/companhias/anos/{school_classes_years}/turmas', SchoolClassesList::class)
        ->name('school-classes-year-list');
    Route::get('/companhias/turmas/{school_classes}/editar', SchoolClassesForm::class)
        ->name('school-classes-edit');
    Route::get('/companhias/turmas/{school_classes}/alunos', SchoolClassesStudents::class)
        ->name('school-classes-students');

    //Espelho de classe
    Route::get('/companhias/turmas/{school_classes}/espelho-de-classe', SchoolClassroomSeatForm::class)
        ->name('school-classes-classroom-seats');
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
    Route::get('/batalhao/anos/{school_battalion}/visualizar', SchoolBattalionView::class)
        ->name('school-battalion-view');
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

//DISCIPLINA
//FAFD
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class,
    'checkAccess:fault_discipline' //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/disciplina/falta-disciplinar', FaultDisciplineList::class)
        ->name('fault-discipline-list');
    Route::get('/disciplina/falta-disciplinar/novo', FaultDisciplineForm::class)
        ->name('fault-discipline-create');
    Route::get('/disciplina/falta-disciplinar/{fault_discipline}/editar', FaultDisciplineEdit::class)
        ->name('fault-discipline-edit');

    Route::get('/disciplina/painel', DisciplinePanel::class)
        ->name('fact-observed-panel');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class,
    'checkAccess:disciplinary_fault' //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/disciplina/configs/falta', FaultList::class)
        ->name('faults-list');
    Route::get('/disciplina/configs/falta/novo', FaultForm::class)
        ->name('faults-create');
    Route::get('/disciplina/configs/falta/{faults}/editar', FaultForm::class)
        ->name('faults-edit');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class,
    'checkAccess:fact_observed' //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/disciplina/fato-observado', FactObservedList::class)
        ->name('fact-observed-list');
    Route::get('/disciplina/fato-observado/novo', FactObservedForm::class)
        ->name('fact-observed-create');
    Route::get('/disciplina/fato-observado/{fact_observed}/editar', FactObservedEdit::class)
        ->name('fact-observed-edit');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class,
    'checkAccess:school_faults' //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/faltas-escolares/lançar-faltas', SchoolFaultList::class)
        ->name('school-faults-list');
    Route::get('/faltas-escolares/novo', SchoolFaultForm::class)
        ->name('school-faults-create');
    Route::get('/faltas-escolares/{school_faults}/editar', SchoolFaultEdit::class)
        ->name('school-faults-edit');
    Route::get('/faltas-escolares/{school_faults}/justificativa', SchoolFaultJustified::class)
        ->name('school-faults-justified');

    Route::get('/faltas-escolares/busca-avançada', SchoolFaultsFilter::class)
        ->name('school-faults-filter');

    Route::get('/faltas-escolares/painel', FaultsPanel::class)
        ->name('school-faults-panel');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RegisterLogging::class //MIDDLEWARE QUE DEFINE QUEM ENTRA NA PÁGINA
])->group(function () {
    Route::get('/aplicativo', App::class)
        ->name('aplicativo');
    Route::get('/disciplina/fato-observado/meus-fatos-observados', MyFosList::class)
        ->name('my-fact-observed');
    Route::get('/faltas/inserir-faltas', FaultInsert::class)
        ->name('insert-faults');
    Route::get('/faltas/faltas-lancadas', SchoolFaultList::class)
        ->name('my-insert-faults');
});
