<?php

namespace App\Livewire\Extracurricular\ExtraActivities;


use App\Models\Admin\Settings\Settings;
use App\Models\Extracurricular\ExtraActivities;
use App\Services\LaiGuz\TableService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

use Illuminate\Support\Str;

use Livewire\WithPagination;


use App\Traits\HandlesTmpUploads;

class ExtraActivityList extends Component
{
    use WithPagination;

    use HandlesTmpUploads;
    public $breadcrumb = 'Atividades';
    public $modal = true;
    public $showJetModal = false;
    public $showModalForm = false;

    public $rules;
    public $detail;
    public $extra_activity;
    public $id;

    //Dados da tabela
    protected $queryService;
    public $model = "App\Models\Extracurricular\ExtraActivities"; //Model principal
    public $modelId = "id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['title' => 'asc'];
    public $relationTables; //Relacionamentos ( table , key , foreingKey )
    public $customSearch;  //Colunas personalizadas, customizar no model
    public $columnsInclude = 'title,extra_modalities_id,active as status';
    public $searchable = 'title'; //Colunas pesquisadas no banco de dados

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
                'customSearch' => $this->customSearch,
                'active' => $this->active,
            ])
            ->getData();
        return view(
            'livewire.extracurricular.extra-activities.extra-activity-list',
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
            $this->extra_activity = '';
        } else {
            redirect()->route('extra-activity-create');
        }
    }

    //Update
    public function showUpdate($id)
    {

        if ($this->modal) {
            $this->showModalForm = true;
            $this->extra_activity = ExtraActivities::find($id);
        } else {
            redirect()->route('extra-activity-edit', $id);
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
        $data = ExtraActivities::where('id', $id)->first();
        $data->active = 0;
        $data->save();

        $this->openAlert('success', 'Registro excluido com sucesso.');

        $this->showJetModal = false;
    }
    //ACTIVE
    public function buttonActive($id)
    {
        $data = ExtraActivities::where('id', $id)->first();
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
    //Todas
    public function list($id)
    {
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        $config = Settings::find(1);
        $logoPath = url('storage/logos-school/logo-header.png');

        // dd($id);
        // Crie uma instância do mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            // 'orientation'        => 'P', //[P,L]
            'format' => 'A4-P',
            'margin_left'   => 15,
            'margin_top'    => 15,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($mpdf);
        $html = view(
            'livewire.extracurricular.student-activities.list-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Alunos',
                'data'              => ExtraActivities::where('id', $id)->first(),
                'config'            => $config,
                'responsible'       => Auth::user()->name,
            ]
        )->render();

        // Adicione o conteúdo HTML ao PDF
        $mpdf->SetHTMLHeader('
              <table width="100%" style="padding-top:20px;>
                  <tr >
                      <td width="50%">
                          <img width="50" src="' . $logoPath . '" alt="Logo">
                      </td>
                      <td width="50%" style="text-align: right;">
                          <strong>' . $config->name . '</strong><br>

                      </td>
                  </tr>
              </table>
              ');
        $mpdf->SetHTMLFooter('
       <table width="100%">
           <tr>
               <td width="66%">Impressão realizada em {DATE j/m/Y} às {DATE H:i:s}</td>
               <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
           </tr>
       </table>');
        $mpdf->WriteHTML($html);

        // Salve o PDF temporariamente
        $file = trim('alunos_atividade_' . ExtraActivities::first($id)->title . '_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');
        $this->dispatch('openPdfInNewTabClasses', pdfPath: $pdfPath);
    }
}
