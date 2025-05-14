<?php

namespace App\Livewire\Discipline\FactObserveds;

use App\Models\Discipline\FactObserved;
use App\Models\Discipline\FaultDiscipline;
use App\Services\LaiGuz\TableService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Str;

class FactObservedList extends Component
{
    use WithPagination;
    public $breadcrumb = 'Fatos observados';
    public $modal = true;
    public $showJetModal = false;
    public $showModalForm = false;
    public $modalFafd = false;
    public $showReadModal = false;

    public $rules;
    public $detail;
    public $fact_observed;
    public $id;
    public $read;

    //Dados da tabela
    protected $queryService;
    public $model = "App\Models\Discipline\FactObserved"; //Model principal
    public $modelId = "fact_observeds.id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['fact_observeds.number' => 'desc'];
    public $relationTables =  "peoples,peoples.id,fact_observeds.student_id"; //Relacionamentos ( table , key , foreingKey )
    public $customSearch;  //Colunas personalizadas, customizar no model
    public $columnsInclude = 'peoples.logo_path as path,faults,fact_observeds.updated_at,fafd,fafd_id,fact_observer,fact_observer_function,year,al_number,al_nick,al_class,student_id,fact_type,fact_hour,fact_date,fact_observeds.number,fact,sincomil_date,fact_observeds.active as status';
    public $searchable = 'fact_hour,fact_date,year,al_number,al_nick,al_name,al_class,fact_observeds.number,fact'; //Colunas pesquisadas no banco de dados

    public $paginate = 15; //Qtd de registros por página
    public $active = 'fact_observeds.active';

    #[On('see_excluded')]
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
                'customSearch' => $this->customSearch,
                'active' => $this->active,
            ])
            ->getData();
        // dd($dataTable);
        return view(
            'livewire.discipline.fact-observeds.fact-observed-list',
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
            $this->fact_observed = '';
        } else {
            redirect()->route('fact-observed-create');
        }
    }

    //Update
    public function showUpdate($id)
    {
        redirect()->route('fact-observed-edit', $id);
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
    //VER
    public function showRead($id)
    {
        $this->showReadModal = true;
        $this->read = '';
        if ($id) {
            $this->read = FactObserved::find($id);
        }
    }
    //DELETE
    public function showModalFafd($id)
    {
        $this->modalFafd = true;
        if (isset($id)) {
            $this->id = $id;
        } else {
            $this->id = '';
        }
    }
    public function delete($id)
    {
        $data = FactObserved::where('id', $id)->first();
        $data->active = 0;
        $data->save();

        $this->openAlert('success', 'Registro excluido com sucesso.');

        $this->showJetModal = false;
    }
    //ACTIVE
    public function buttonActive($id)
    {
        $data = FactObserved::where('id', $id)->first();
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

    public function fafd_create($id)
    {
        $fact = FactObserved::where('id', $id)->first();
        foreach (json_decode($fact->faults, true) as $value) {
            $f[] = $value;
        }

        $fafd = FaultDiscipline::create([
            'active'                   => 1,
            // 'number'                   => $fact->number,
            'year'                     => $fact->year,
            'cia'                      => $fact->cia,
            'company_id'               => $fact->company_id,
            'cmt_cia'                  => $fact?->company->cmt_cia,
            'cmt_cia_posto'            => $fact?->company->cmt_cia_posto,
            'student_id'               => $fact->student_id,
            'al_nick'                  => $fact->al_nick,
            'al_name'                  => $fact->al_name,
            'al_number'                => $fact->al_number,
            'al_class'                 => $fact->al_class,
            'fact'                     => $fact->fact,
            'fact_hour'                => $fact->fact_hour,
            'fact_date'                => $fact->fact_date,
            'fact_type'                => $fact->fact_type,
            'faults'                   => $f,
            'fact_observer'            => $fact->fact_observer,
            'fact_observer_function'   => $fact->fact_observer_function,
            'fact_observer_id'         => $fact->fact_observer_id,
            'code'                     => Str::uuid(),
        ]);

        $fact->fafd = 1;
        $fact->fafd_id = $fafd->id;
        $fact->save();

        $this->modalFafd = false;
        $this->openAlert('success', 'Registro atualizado com sucesso.');
    }
}
