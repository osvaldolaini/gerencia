<?php


namespace App\Livewire\Students;

use App\Models\Peoples;

use App\Services\LaiGuz\TableService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;


use Illuminate\Support\Facades\Storage;

use App\Models\Admin\Settings\Settings;
use App\Traits\HandlesTmpUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StudentList extends Component
{
    use WithPagination;

    use HandlesTmpUploads;
    public $breadcrumb = 'Estudantes';
    public $modal = false;
    public $showJetModal = false;
    public $showModalForm = false;

    public $rules;
    public $detail;
    public $students;
    public $id;
    public $sex;

    //Dados da tabela
    protected $queryService;
    public $model = "App\Models\Peoples"; //Model principal
    public $modelId = "id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['number' => 'asc'];
    public $relationTables; //Relacionamentos ( table , key , foreingKey )
    public $customSearch;  //Colunas personalizadas, customizar no model
    public $columnsInclude = 'name,nick,sex,number,logo_path,grau,entry_date,active as status';
    public $searchable = 'name,nick,sex,number'; //Colunas pesquisadas no banco de dados

    public $paginate = 15; //Qtd de registros por página
    public $active = 'active';

    #[On('see_excluded')]
    #[On('importUpdateStudents')]
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
                    'type' => 1
                ],
                'customSearch' => $this->customSearch,
                'active' => $this->active,
            ])
            ->getData();
        return view(
            'livewire.students.student-list',
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
            $this->students = '';
        } else {
            redirect()->route('student-create');
        }
    }

    //Update
    public function showUpdate($id)
    {

        if ($this->modal) {
            $this->showModalForm = true;
            $this->students = Peoples::find($id);
        } else {
            redirect()->route('student-edit', $id);
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
    #[On('closeModal')]
    public function closeModal()
    {
        $this->showModalForm = false;
    }
    //Turmas
    public function history(Peoples $student)
    {
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        $config = Settings::find(1);
        $company = $student?->al_class?->classGrade?->getCompany ?? false;
        $signature = false;
        if ($company) {
            $logoPath = Storage::exists('public/companies/' . $company->id)
                ? url('storage/companies/' . $company->id . '/' . $company->code_image . '_list.png')
                : url('storage/logos-school/logo-header.png');

            $files = Storage::files('public/companies/' . $company->id . '/signature');
            if ($files) {
                $sign = explode('/', $files[0]);
                // dd($signature[4]);
                $signature = url('storage/companies/' . $company->id . '/signature/' . $sign[5]); // Nome do arquivo
            } else {
                $signature = false;
            }
        } else {
            $logoPath = url('storage/logos-school/logo-header.png');
        }


        $studentImage = Storage::exists('public/student/' . $student->id)
            ? url('storage/student/' . $student->id . '/' . $student->code_image . '_list.png')
            : $logoPath;

        // Crie uma instância do mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            // 'orientation'        => 'P', //[P,L]
            'format' => 'A4-P',
            'margin_left'   => 15,
            'margin_top'    => 25,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($mpdf);
        $html = view(
            'livewire.settings.pdf.student-history-pdf',
            [
                'logoPath'          => $logoPath,
                'studentImage'      => $studentImage,
                'signature'         => $signature,
                'student'           => $student,
                'config'            => $config,
                'companies'         => $company,
                'subtext'           => 'Aluno da ' . ($company ? $company->nick : ''),
                'responsible'       => Auth::user()->name,
            ]
        )->render();

        // Adicione o conteúdo HTML ao PDF
        $mpdf->SetHTMLHeader('
            <table width="100%">
                <tr >
                    <td width="50%">
                        <img width="50" src="' . $logoPath . '" alt="Logo">
                    </td>
                    <td width="50%" style="text-align: right;">
                        <strong>' . $config->name . '</strong><br>
                        ' . ($company ? $company->name : '') . '<br>
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
        $file = trim('ficha_individual_' . $student->number . '_' . $student->nick . '_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTabRegister', pdfPath: $pdfPath);
    }
}
