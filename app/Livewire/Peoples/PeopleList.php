<?php

namespace App\Livewire\Peoples;


use App\Models\Peoples;

use App\Services\LaiGuz\TableService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PeopleList extends Component
{
    use WithPagination;
    public $breadcrumb = 'Efetivo';
    public $modal = true;
    public $showJetModal = false;
    public $showModalForm = false;

    public $rules;
    public $detail;
    public $peoples;
    public $id;
    public $sex;

    //Dados da tabela
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
            'livewire.peoples.people-list',
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
            $this->peoples = '';
        } else {
            redirect()->route('peoples-create');
        }
    }

    //Update
    public function showUpdate($id)
    {

        if ($this->modal) {
            $this->showModalForm = true;
            $this->peoples = Peoples::find($id);
        } else {
            redirect()->route('peoples-edit', $id);
        }
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
        $data = Peoples::where('id', $id)->first();
        $data->active = 0;
        $data->save();

        $this->openAlert('success', 'Registro excluido com sucesso.');

        $this->showJetModal = false;
    }
    //ACTIVE
    public function buttonActive($id)
    {
        $data = Peoples::where('id', $id)->first();
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
