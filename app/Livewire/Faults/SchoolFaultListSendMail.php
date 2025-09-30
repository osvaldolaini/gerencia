<?php

namespace App\Livewire\Faults;

use App\Models\Fault\SchoolFaults;
use App\Services\LaiGuz\TableService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SchoolFaultListSendMail extends Component
{
    use WithPagination;
    public $breadcrumb = 'Faltas escolares';
    public $modal = true;
    public $showJetModal = false;
    public $showModalForm = false;

    public $rules;
    public $detail;
    public $peoples;
    public $id;
    public $sex;

    protected $queryService;
    public $model = "App\Models\Peoples"; //Model principal
    public $modelId = "id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['function' => 'asc'];
    public $relationTables; //Relacionamentos ( table , key , foreingKey )
    public $customSearch;  //Colunas personalizadas, customizar no model
    public $columnsInclude = 'name,nick,sex,function,logo_path,posto_grad,active as status';
    public $searchable = 'name,nick,sex,function'; //Colunas pesquisadas no banco de dados

    public $paginate = 15; //Qtd de registros por página
    public $active = 'active';


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
                    'type' => 0
                ],
                'customSearch' => $this->customSearch,
                'active' => $this->active,
            ])
            ->getData();
        return view(
            'livewire.faults.school-fault-list-send-mail',
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
   
    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }

}
