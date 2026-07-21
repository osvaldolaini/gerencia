<?php

namespace App\Livewire\Signatures;

use App\Models\Signatures\DocumentSigner;
use Livewire\Component;


use App\Services\LaiGuz\TableService;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class DocumentSignersList extends Component
{
    public $breadcrumb = 'Assinadores';
    public $modal = true;
    public $showJetModal = false;
    public $showModalForm = false;

    public $rules;
    public $detail;
    public $signatures;
    public $id;
    public $sex;

    //Dados da tabela
    protected $queryService;
    public $model = "App\Models\Signatures\DocumentSigner"; //Model principal
    public $modelId = "document_signers.id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['role' => 'asc'];
    public $relationTables =  "users,users.id,document_signers.user_id";
    public $customSearch;  //Colunas personalizadas, customizar no model
    public $columnsInclude = 'users.name,document_signers.role,document_signers.user_id,document_signers.active as status';
    public $searchable = 'users.name,document_signers.role,'; //Colunas pesquisadas no banco de dados

    public $paginate = 15; //Qtd de registros por página
    public $active = 'document_signers.active';

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
            'livewire.signatures.document-signers-list',
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
            $this->signatures = '';
        } else {
            redirect()->route('document-signers-create');
        }
    }

    //Update
    public function showUpdate($id)
    {

        if ($this->modal) {
            $this->showModalForm = true;
            $this->signatures = DocumentSigner::find($id);
        } else {
            redirect()->route('document-signers-edit', $id);
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
        $data = DocumentSigner::where('id', $id)->first();
        $data->active = 0;
        $data->save();

        $this->openAlert('success', 'Registro excluido com sucesso.');

        $this->showJetModal = false;
    }
    //ACTIVE
    public function buttonActive($id)
    {
        $data = DocumentSigner::where('id', $id)->first();
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
