<?php

namespace App\Livewire\App\Discipline;

use App\Services\LaiGuz\TableService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class MyFosList extends Component
{
    use WithPagination;
    public $breadcrumb = 'Fatos observados';
    public $modal = true;
    public $showJetModal = false;
    public $showModalForm = false;
    public $modalFafd = false;

    public $rules;
    public $detail;
    public $fact_observed;
    public $id;

    //Dados da tabela
    protected $queryService;
    public $model = "App\Models\Discipline\FactObserved"; //Model principal
    public $modelId = "fact_observeds.id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['fact_observeds.number' => 'desc'];
    public $relationTables =  "peoples,peoples.id,fact_observeds.student_id"; //Relacionamentos ( table , key , foreingKey )
    public $customSearch;  //Colunas personalizadas, customizar no model
    public $columnsInclude = 'peoples.logo_path as path,fact_observeds.updated_at,fafd,fafd_id,fact_observer,fact_observer_function,year,al_number,al_nick,al_class,student_id,fact_type,fact_hour,fact_date,fact_observeds.number,fact,sincomil_date,fact_observeds.active as status';
    public $searchable = 'fact_observeds.created_by,fact_hour,fact_date,year,al_number,al_nick,al_class,fact_observeds.number,fact'; //Colunas pesquisadas no banco de dados

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
                'where' => [
                    'fact_observeds.created_by' => Auth::user()->name,
                ],
                'customSearch' => $this->customSearch,
                'active' => $this->active,
            ])
            ->getData();
        return view(
            'livewire.app.discipline.my-fos-list',
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
    }
    //CREATE
    public function showCreate()
    {
        $this->showModalForm = true;
    }

    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
