<?php

namespace App\Livewire\Settings\SchoolClasses;

use App\Models\Settings\SchoolClasses;
use App\Models\Settings\SchoolClassesStudent;
use App\Services\LaiGuz\TableService;
use Livewire\Component;

use Livewire\Attributes\On;

class SchoolClassesStudents extends Component
{
    public $breadcrumb = 'Turma: ';

    public $school_classes;
    //Fields
    public $school_classes_id;
    public $title;
    public $year;

    public $addSelected = [];

    //Dados da tabela
    protected $queryService;
    public $model = "App\Models\Peoples"; //Model principal
    public $modelId = "id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['number' => 'asc'];
    public $relationTables; //Relacionamentos ( table , key , foreingKey )
    public $customSearch;  //Colunas personalizadas, customizar no model
    public $columnsInclude = 'name,nick,number,sex,active as status';
    public $searchable = 'name,nick,number'; //Colunas pesquisadas no banco de dados

    public $paginate = 15; //Qtd de registros por página
    public $active = 'active';

    public $class;

    public function mount(SchoolClasses $school_classes)
    {
        if ($school_classes->getAttributes()) {
            $this->school_classes = $school_classes;
            $this->school_classes_id = $school_classes->id;
            $this->title        = $school_classes->title;
            $this->year         = $school_classes->school_classes_year_id;
            $this->breadcrumb .= $this->title . ' / ' . $school_classes->classYears->year;
            $this->class = SchoolClassesStudent::where('active', 1)->where('school_classes_id', $this->school_classes_id)->get();
        }
    }
    #[On('update_list')]
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
        $index = array_search($id, $this->addSelected);
        if ($index !== false) {
            unset($this->addSelected[$index]);
        } else {
            $this->addSelected[] = $id;
        }
    }
    public function addStudent()
    {
        if (!empty($this->addSelected)) {
            foreach ($this->addSelected as $key => $value) {
                SchoolClassesStudent::updateOrCreate([
                    'school_classes_year_id' => $this->school_classes->classYears->id,
                    'people_id'      => $value,
                ], [
                    'school_classes_id' => $this->school_classes_id,
                    'active'         => 1,
                ]);
            }
        } else {
            $this->openAlert('error', 'Nenhum aluno selecionado');
        }

        $this->addSelected = [];
        $this->dispatch('update_list');
        $this->openAlert('success', 'Inclusão na turma realizada com sucesso');
    }

    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
