<?php

namespace App\Livewire\Settings\SchoolClasses;

use App\Models\Settings\SchoolClassesStudent;
use App\Services\LaiGuz\TableService;
use Livewire\Component;

use Livewire\Attributes\On;

class SchoolClassesUpdateds extends Component
{
    //Dados da tabela
    protected $queryService;
    public $model = "App\Models\Settings\SchoolClassesStudent"; //Model principal
    public $modelId = "school_classes_students.id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['peoples.number' => 'asc'];
    public $relationTables =  "peoples,peoples.id,school_classes_students.people_id"; //Relacionamentos ( table , key , foreingKey )
    public $customSearch;  //Colunas personalizadas, customizar no model
    public $columnsInclude = 'peoples.name,peoples.number,peoples.nick,peoples.sex,school_classes_students.active as status';
    public $searchable = 'peoples.name,peoples.number,peoples.nick'; //Colunas pesquisadas no banco de dados

    public $paginate = 15; //Qtd de registros por página
    public $active = 'school_classes_students.active';


    public $removeSelected = [];
    public $school_classes_id;

    public function mount($school_classes_id)
    {
        $this->school_classes_id = $school_classes_id;
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
                    'school_classes_id' => $this->school_classes_id
                ],
                'customSearch' => $this->customSearch,
                'active' => $this->active,
            ])
            ->getData();
        // dd($dataTable);
        return view(
            'livewire.settings.school-classes.school-classes-updateds',
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
                $data = SchoolClassesStudent::find($value);
                $data->active = 0;
                $data->save();
            }
        } else {
            $this->openAlert('error', 'Nenhum aluno selecionado');
        }
        $this->dispatch('update_list');
        $this->openAlert('success', 'Exclusão da turma realizada com sucesso');
        $this->removeSelected = [];
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
