<?php

namespace App\Livewire\Settings\SchoolClasses;

use App\Models\Settings\SchoolClasses;
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
    public $columnsInclude = 'peoples.id as ids,peoples.name,peoples.number,peoples.nick,peoples.logo_path,peoples.sex,school_classes_students.active as status';
    public $searchable = 'peoples.name,peoples.number,peoples.nick'; //Colunas pesquisadas no banco de dados

    public $paginate = 15; //Qtd de registros por página
    public $active = 'school_classes_students.active';


    public $removeSelected = [];
    public $school_classes_id;
    public $class;


    public function mount($school_classes_id)
    {
        $this->school_classes_id = $school_classes_id;
        $this->class = SchoolClasses::find($this->school_classes_id)->title;
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
                    'school_classes_id' => $this->school_classes_id,
                    'school_classes_students.active' => 1
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
                $id = intval($value);
                $data = SchoolClassesStudent::find($id);
                // dd($data);
                $data->active = 0;
                $data->save();
            }
            $this->openAlert('success', 'Exclusão da turma realizada com sucesso');
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
