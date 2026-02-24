<?php

namespace App\Livewire\Faults;

use App\Models\Fault\SchoolFaults;
use App\Models\Settings\SchoolClassesYears;
use App\Services\LaiGuz\TableService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SchoolFaultList extends Component
{
    use WithPagination;
    public $breadcrumb = 'Faltas escolares';
    public $modal = true;
    public $showJetModal = false;
    public $showModalForm = false;

    public $rules;
    public $detail;
    public $school_faults;
    public $id;

    //Dados da tabela
    protected $queryService;
    public $model = "App\Models\Fault\SchoolFaults"; //Model principal
    public $modelId = "school_faults.id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['school_faults.date' => 'desc'];
    public $relationTables =  "peoples,peoples.id,school_faults.student_id"; //Relacionamentos ( table , key , foreingKey )
    public $customSearch = ['date' => 'date'];  //Colunas personalizadas, customizar no model
    public $columnsInclude = 'date,student_id,peoples.name,justified,qtd,school_faults.created_at,peoples.nick,peoples.number,peoples.logo_path as path,school_faults.created_by,school_faults.active as status';
    public $searchable = 'date,peoples.name,peoples.nick,peoples.number,student_id'; //Colunas pesquisadas no banco de dados

    public $paginate = 15; //Qtd de registros por página
    public $active = 'school_faults.active';

    public $actived;



    #[On('see_excluded')]
    public function render(TableService $queryService)
    {

        $this->actived = now()->year;
        if (SchoolClassesYears::where("active", 1)->first()) {
            $this->actived = SchoolClassesYears::where("active", 1)->first()->year;
        }

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
                // 'where' => [
                //     'school_faults.created_by' => Auth::user()->name,
                // ],
                'customSearch' => $this->customSearch,
                'active' => $this->active,
            ])
            ->getData();
        // dd($dataTable);
        return view(
            'livewire.faults.school-fault-list',
            compact('dataTable')
        );
    }
    public function addSort($field)
    {
        // dd($field);
        if (isset($this->sorts[$field])) {
            $this->sorts[$field] = $this->sorts[$field] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sorts = [];
            $this->sorts[$field] = '';
            $this->sorts[$field] = 'asc';
        }
        // dd($this->sorts);
    }
    //CREATE
    public function showCreate()
    {
        if ($this->modal) {
            $this->showModalForm = true;
            $this->school_faults = '';
        } else {
            redirect()->route('school-faults-create');
        }
    }

    //Update
    public function showUpdate($id)
    {
        redirect()->route('school-faults-edit', $id);
    }

    //DELETE
    public function showModalDelete($id)
    {
        $this->showJetModal = true;
        if (isset($id)) {
            $this->id = $id;
        } else {
            $this->id = '';
        }
    }
    public function delete($id)
    {
        $data = SchoolFaults::where('id', $id)->first();
        $data->active = 0;
        $data->save();

        $this->openAlert('success', 'Registro excluido com sucesso.');

        $this->showJetModal = false;
    }
    //ACTIVE
    public function buttonActive($id)
    {
        $data = SchoolFaults::where('id', $id)->first();
        if ($data->active == 1) {
            $data->active = 0;
            $data->save();
        } else {
            $data->active = 1;
            $data->save();
        }
        $this->openAlert('success', 'Registro atualizado com sucesso.');
    }
    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
    public function justify(SchoolFaults $school_faults, $justify)
    {
        $school_faults->justified = $justify;
        $school_faults->save();
    }
}
