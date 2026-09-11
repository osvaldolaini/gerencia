<?php

namespace App\Livewire\Discipline\Panel;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Peoples;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\Settings\Settings;
use App\Traits\HandlesTmpUploads;


use App\Enums\MilitaryRank;
use App\Models\Discipline\FactObserved;
use App\Models\Emails;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlanilhaFaultsView;

class CriticalDegree extends Component
{
    use WithPagination;
    use HandlesTmpUploads;
    public $breadcrumb = 'Faltas escolares';
    public $modal = true;
    public $showJetModal = false;
    public $showModalForm = false;

    public $rules;
    public $detail;
    public $peoples;
    public $id;
    public $sex;

    public $emails;
    public $contacts;
    public $attachment;
    public $percent;

    public $showModalConfirm = false;
    public $loading = false;

    public $search;
    public $sortStudents = 'percent_desc';
    public $allStudents;
    public $student;
    public $students = array();

    public $companyId = 'all';

    #[On('see_excluded')]
    public function render()
    {
        return view('livewire.discipline.panel.critical-degree');
    }

    #[On('company-selected')]
    public function companySelected($companyId)
    {
        // $companyId terá o valor selecionado
        $this->companyId = $companyId;
        // dd($companyId);
        $this->applyStudentFilters();
    }

    public function mount()
    {
        $this->loadStudents();
    }
    public function loadStudents()
    {
        $dataTable = Peoples::where('active', 1)
            ->where('type', 1)
            ->get();

        $this->allStudents = $dataTable
            ->filter(function ($student) {
                return $student->al_class &&
                    $student->adjusted_grau < 5;
            })
            ->values()
            ->all();

        $this->applyStudentFilters();
    }
    public function applyStudentFilters()
    {
        $students = collect($this->allStudents);

        // FILTRO POR COMPANHIA
        // FILTRO POR COMPANHIA
        if ($this->companyId !== 'all') {
            $students = $students->filter(function ($student) {
                return (string) $student->company?->id === (string) $this->companyId;
            });
        }

        // SEARCH
        if ($this->search) {

            $search = mb_strtolower($this->search);

            $students = $students->filter(function ($student) use ($search) {

                $nick = mb_strtolower($student->nick ?? '');
                $number = (string) ($student->number ?? '');

                return str_contains($nick, $search)
                    || str_contains($number, $search);
            });
        }

        // SORT
        switch ($this->sortStudents) {

            case 'percent_desc':
                $students = $students->sortByDesc('calculate_adjusted_grau');
                break;

            case 'percent_asc':
                $students = $students->sortBy('calculate_adjusted_grau');
                break;

            case 'name_asc':
                $students = $students->sortBy('nick');
                break;

            case 'name_desc':
                $students = $students->sortByDesc('nick');
                break;
        }



        $this->students = $students->values()->all();
    }

    //Baixar relação 
    public function exportExcel()
    {
        return Excel::download(
            new PlanilhaFaultsView(
                $this->students,
                Settings::find(1)
            ),
            'planilha_alunos_com_mais_de_7_5_%_de_faltas.xlsx'
        );
    }

    //Imprimir relação
    public function exportPdf()
    {

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
            'livewire.faults.pdfs.faults-more-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Frequência escolar',
                'students'          => $this->students,
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
        $file = trim('alunos_com_mais_faltas_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTab', pdfPath: $pdfPath);
    }

    //Enviar email 
    public function showConfirm(Peoples $student, $percent)
    {
        $this->contacts = $student->contacts;
        $this->percent = $percent;
        $this->student = $student;
        if ($this->contacts->count() > 0) {
            $this->showModalConfirm = true;
        } else {
            $this->dispatch('openAlert', 'error', 'Nenhum contato cadastrado');
        }
    }
}
