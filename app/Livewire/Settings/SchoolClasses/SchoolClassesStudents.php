<?php

namespace App\Livewire\Settings\SchoolClasses;

use App\Models\Settings\SchoolClasses;
use App\Models\Settings\SchoolClassesStudent;
use App\Services\LaiGuz\TableService;
use Livewire\Component;

class SchoolClassesStudents extends Component
{
    public $breadcrumb = 'Turma: ';
    //Fields
    public $school_classes;
    public $title;
    public $year;

    public $addSelected = false;
    public $removeSelected = false;


    //Dados da tabela
    protected $queryService;
    public $model = "App\Models\Peoples"; //Model principal
    public $modelId = "id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['number' => 'asc'];
    public $relationTables; //Relacionamentos ( table , key , foreingKey )
    public $customSearch;  //Colunas personalizadas, customizar no model
    public $columnsInclude = 'name,nick,number,active as status';
    public $searchable = 'name,nick,number'; //Colunas pesquisadas no banco de dados

    public $paginate = 15; //Qtd de registros por página
    public $active = 'active';



    public $class;

    public function mount(SchoolClasses $school_classes)
    {
        if ($school_classes->getAttributes()) {
            $this->school_classes           = $school_classes->id;
            $this->title        = $school_classes->title;
            $this->year         = $school_classes->school_classes_year_id;
            $this->breadcrumb .= $this->title;
            $this->class = SchoolClassesStudent::where('active', 1)->where('school_classes_id', $this->school_classes)->get();
        }
    }
    public function render(TableService $queryService)
    {

        $dataTable = $queryService
            ->setModel($this->model)
            ->setParameters([
                'modelId' => $this->modelId,
                'relationTables' => $this->relationTables,
                'columnsInclude' => $this->columnsInclude,
                'searchable' => $this->searchable,
                'sort' => $this->sorts,
                'paginate' => $this->paginate,
                'search' => $this->search,
                'where' => [
                    'type' => 1
                ],
                'customSearch' => $this->customSearch,
                'active' => $this->active,
            ])
            ->getData();

        return view(
            'livewire.settings.school-classes.school-classes-students',
            compact('dataTable')
        );
    }

    public function selectAddStudent($id)
    {
        $this->removeSelected = false;
        $this->addSelected = $id;
    }
    public function selectRemoveStudent($id)
    {
        $this->removeSelected = $id;
        $this->addSelected = '';
    }
    public function addStudent()
    {
        if ($this->addSelected) {
            SchoolClassesStudent::create([
                'active'         => 1,
                'school_classes_id' => $this->school_classes,
                'people_id'      => $this->addSelected,
            ]);
        } else {

            $this->openAlert('error', 'Nenhum aluno selecionado');
        }

        $this->addSelected = '';
        $this->removeSelected = false;
        $this->class = SchoolClassesStudent::where('active', 1)->where('school_classes_id', $this->school_classes)->get();
    }
    public function removeStudent()
    {
        if ($this->removeSelected) {
            $data = SchoolClassesStudent::find($this->removeSelected);
            $data->active = 0;
            $data->save();
        } else {
            $this->openAlert('error', 'Nenhum aluno selecionado');
        }

        $this->addSelected = '';
        $this->removeSelected = '';
        $this->class = SchoolClassesStudent::where('active', 1)->where('school_classes_id', $this->school_classes)->get();
    }

    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
