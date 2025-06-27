<?php

namespace App\Livewire\Extracurricular\StudentActivities;

use App\Models\Extracurricular\ExtraActivities;
use App\Models\Extracurricular\StudentActivities;
use App\Services\LaiGuz\TableService;
use Livewire\Component;

use Livewire\Attributes\On;

class StudentActivityRemove extends Component
{
    //Dados da tabela
    protected $queryService;
    public $model = "App\Models\Extracurricular\StudentActivities"; //Model principal
    public $modelId = "student_activities.id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['peoples.number' => 'asc'];
    public $relationTables =  "peoples,peoples.id,student_activities.student_id"; //Relacionamentos ( table , key , foreingKey )
    public $customSearch;  //Colunas personalizadas, customizar no model
    public $columnsInclude = 'peoples.id as ids,peoples.name,peoples.number,peoples.nick,peoples.logo_path,peoples.sex,student_activities.active as status';
    public $searchable = 'peoples.name,peoples.number,peoples.nick'; //Colunas pesquisadas no banco de dados

    public $paginate = 15; //Qtd de registros por página
    public $active = 'student_activities.active';


    public $removeSelected = [];
    public $class;

    public $activity;
    public $activity_id;
    public $modality;

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
                    'extra_activities_id' => $this->activity_id,
                    'student_activities.active' => 1
                ],
                'customSearch' => $this->customSearch,
                'active' => $this->active,
            ])
            ->getData();
        // dd($dataTable);
        return view(
            'livewire.extracurricular.student-activities.student-activity-remove',
            compact('dataTable')
        );
    }
    public function selectRemoveStudent($id)
    {
        $index = array_search($id, $this->removeSelected);
        if ($index !== false) {
            unset($this->removeSelected[$index]);
        } else {
            $this->removeSelected[] = $id;
        }
    }
    public function removeStudent()
    {
        if (!empty($this->removeSelected)) {
            foreach ($this->removeSelected as $key => $value) {
                $id = intval($value);
                $data = StudentActivities::find($id);
                // dd($data);
                $data->active = 0;
                $data->save();
            }
            $this->openAlert('success', 'Exclusão da atividade realizada com sucesso');
        } else {
            $this->openAlert('error', 'Nenhum aluno selecionado');
        }
        $this->dispatch('update_list');

        $this->removeSelected = [];
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
