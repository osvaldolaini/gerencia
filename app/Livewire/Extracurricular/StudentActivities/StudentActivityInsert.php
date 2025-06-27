<?php

namespace App\Livewire\Extracurricular\StudentActivities;

use App\Models\Extracurricular\ExtraActivities;
use App\Models\Extracurricular\StudentActivities;
use App\Services\LaiGuz\TableService;
use Livewire\Component;

use Livewire\Attributes\On;

class StudentActivityInsert extends Component
{
    public $activity;
    public $activity_id;
    public $modality;

    public $addSelected = [];

    //Dados da tabela
    protected $queryService;
    public $model = "App\Models\Peoples"; //Model principal
    public $modelId = "id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['number' => 'asc'];
    public $relationTables; //Relacionamentos ( table , key , foreingKey )
    public $customSearch;  //Colunas personalizadas, customizar no model
    public $columnsInclude = 'name,nick,number,sex,logo_path,active as status';
    public $searchable = 'name,nick,number'; //Colunas pesquisadas no banco de dados

    public $paginate = 15; //Qtd de registros por página
    public $active = 'active';


    public function mount(ExtraActivities $extra_activity)
    {
        if ($extra_activity->getAttributes()) {
            $this->activity        = $extra_activity->title;
            $this->activity_id     = $extra_activity->id;
            $this->modality        = $extra_activity->modality->title;
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
            'livewire.extracurricular.student-activities.student-activity-insert',
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
                StudentActivities::updateOrCreate([
                    'student_id'      => $value,
                    'extra_activities_id' => $this->activity_id,
                ], [
                    'active'         => 1,
                ]);
            }
        } else {
            $this->openAlert('error', 'Nenhum aluno selecionado');
        }

        $this->addSelected = [];
        $this->dispatch('update_list');
        $this->openAlert('success', 'Inclusão na atividade realizada com sucesso');
    }

    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
