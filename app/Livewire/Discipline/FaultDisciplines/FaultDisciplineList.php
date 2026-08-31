<?php

namespace App\Livewire\Discipline\FaultDisciplines;

use App\Models\Discipline\FaultDiscipline;
use App\Models\Settings\SchoolClassesYears;
use App\Services\LaiGuz\TableService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class FaultDisciplineList extends Component
{
    use WithPagination;
    public $breadcrumb = 'FAFD';
    public $modal = true;
    public $showJetModal = false;
    public $showModalForm = false;

    public $rules;
    public $detail;
    public $faults;
    public $id;


    //Dados da tabela
    protected $queryService;
    public $model = "App\Models\Discipline\FaultDiscipline"; //Model principal
    public $modelId = "fault_disciplines.id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['year' => 'desc', 'number' => 'desc'];
    public $relationTables = "peoples,peoples.id,fault_disciplines.student_id";  //Relacionamentos ( table , key , foreingKey )
    public $customSearch; //Colunas personalizadas, customizar no model
    public $columnsInclude = 'fault_disciplines.number,decision,peoples.logo_path,year,al_nick,fault_disciplines.student_id,al_number,al_class,fact_date,solution_date,delivered_date,justification_date,bi_date,sincomil_date,fault_disciplines.active as status';
    public $searchable = 'fault_disciplines.number,year,al_nick,al_number,al_class'; //Colunas pesquisadas no banco de dados

    public $paginate = 10; //Qtd de registros por página
    public $active = 'fault_disciplines.active';
    public $actived;

    public $company = 'all';

    #[On('see_excluded')]
    public function render(TableService $queryService)
    {
        $this->actived = now()->year;
        if (SchoolClassesYears::where("active", 1)->first()) {
            $this->actived = SchoolClassesYears::where("active", 1)->first()->year;
        }
        $where['year'] = $this->actived;

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
                'customSearch' => $this->customSearch,
                'active' => $this->active,
            ])
            ->getData();
        return view(
            'livewire.discipline.fault-disciplines.fault-discipline-list',
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
            $this->faults = '';
        } else {
            redirect()->route('fault-discipline-create');
        }
    }

    //Update
    public function showUpdate($id)
    {
        redirect()->route('fault-discipline-edit', $id);
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
        $data = FaultDiscipline::where('id', $id)->first();
        $data->active = 0;
        $data->save();

        $this->openAlert('success', 'Registro excluido com sucesso.');

        $this->showJetModal = false;
    }
    #[On('modalClose')]
    public function modalClose()
    {
        $this->showModalForm = false;
    }
    //ACTIVE
    public function buttonActive($id)
    {
        $data = FaultDiscipline::where('id', $id)->first();
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
}
