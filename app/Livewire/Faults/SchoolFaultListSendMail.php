<?php

namespace App\Livewire\Faults;

use App\Models\Fault\SchoolFaults;
use App\Services\LaiGuz\TableService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Peoples;

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
    public $columnsInclude = 'name,nick,sex,function,logo_path,posto_grad,type,active as status';
    public $searchable = 'name,nick,sex,function'; //Colunas pesquisadas no banco de dados

    public $paginate = 15; //Qtd de registros por página
    public $active = 'active';

    public $students = array();


    #[On('see_excluded')]
    public function render(TableService $queryService)
    {
        $dataTable = Peoples::where('active',1)->where('type',1)->orderBy('nick','asc')->get();
            foreach ($dataTable as $student) {
                    if ($student?->al_class) {
                        if($student->total_faults_percent > 6.5){
                        $this->students[] = $student;
                    } 
                }
            }
        
        // dd($this->students);
        return view(
            'livewire.faults.school-fault-list-send-mail'
        );
    }
   //Aditamentos
    public function print()
    {
        // dd($this->students);
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');
        
        $config = Settings::find(1);

        $logoPath = url('storage/logos-school/logo-header.png');

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
            'livewire.faults.pdf.faults-more-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Aditamento',
                'data'              => $this->students,
                'config'            => $config,
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
        $file = trim('alunos_com_mais_de_7.5%_de_faltas' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTabClasses', pdfPath: $pdfPath);
    }
   
    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }

}
