<?php

namespace App\Livewire\Discipline\Compliments;

use App\Models\Discipline\Compliments;
use App\Services\LaiGuz\TableService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ComplimentList extends Component

{
    use WithPagination;
    public $breadcrumb = 'Elogios';
    public $modal = true;
    public $showJetModal = false;
    public $showModalForm = false;

    public $rules;
    public $detail;
    public $faults;
    public $id;

    //Dados da tabela
    protected $queryService;
    public $model = "App\Models\Discipline\Compliments"; //Model principal
    public $modelId = "compliments.id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['year' => 'desc', 'number' => 'desc'];
    public $relationTables = "peoples,peoples.id,compliments.student_id";  //Relacionamentos ( table , key , foreingKey )
    public $customSearch; //Colunas personalizadas, customizar no model
    public $columnsInclude = 'compliments.number,peoples.logo_path,year,al_nick,compliments.student_id,al_number,al_class,fact_date,solution_date,bi_date,sincomil_date,compliments.active as status';
    public $searchable = 'compliments.number,year,al_nick,al_number,al_class'; //Colunas pesquisadas no banco de dados

    public $paginate = 10; //Qtd de registros por página
    public $active = 'compliments.active';

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
        return view(
            'livewire.discipline.compliments.compliment-list',
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
            redirect()->route('compliment-create');
        }
    }

    //Update
    public function showUpdate($id)
    {
        redirect()->route('compliment-edit', $id);
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
        $data = Compliments::where('id', $id)->first();
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
        $data = Compliments::where('id', $id)->first();
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
