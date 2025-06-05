<?php

namespace App\Livewire\Discipline\Panel;

use App\Models\Admin\Settings\Settings;
use App\Models\Discipline\FaultDiscipline;
use App\Traits\HandlesTmpUploads;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

class FaultDisciplinePanel extends Component
{

    use HandlesTmpUploads;

    public $recentFafd;
    public $topStudentsFafd;
    public $date_start;
    public $date_end;

    public function mount()
    {
        $this->date_start   = now()->startOfYear()->toDateString();
        $this->date_end     = now()->toDateString();
    }
    public function render()
    {
        $companiesAccess = Auth::user()->json_companies;
        $this->recentFafd = FaultDiscipline::query()
            ->when(!in_array('all', $companiesAccess), function ($query) use ($companiesAccess) {
                $query->whereIn('company_id', $companiesAccess);
            })
            ->with(['students'])
            ->where('active', 1)
            ->latest()
            ->take(10)
            ->get();

        $this->topStudentsFafd = FaultDiscipline::query()
            ->when(!in_array('all', $companiesAccess), function ($query) use ($companiesAccess) {
                $query->whereIn('company_id', $companiesAccess);
            })
            ->selectRaw('student_id, COUNT(*) as total')
            ->where('active', 1)
            ->groupBy('student_id')
            ->orderByDesc('total')
            ->with('students') // Certifique-se de que a relação está definida no model
            ->limit(10)
            ->get();
        return view('livewire.discipline.panel.fault-discipline-panel');
    }
    public function generatePdf()
    {

        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        if (empty($this->date_start)) {
            $this->openAlert('error', 'Selecione a data inicial');
            return;
        }
        if (empty($this->date_end)) {
            $this->openAlert('error', 'Selecione a data final');
            return;
        }
        $data1 = new DateTime($this->date_start);
        $data2 = new DateTime($this->date_end);

        // Calcula a diferença
        $diff = $data1->diff($data2);

        if ($diff->invert) {
            $this->openAlert('error', 'A data final não pode ser maior que a inicial.');
            return;
        }

        $config = Settings::find(1);

        $logoPath = url('storage/logos-school/logo-header.png');



        $punitions = FaultDiscipline::select([
            'school_grades.name as grade',
            'fault_disciplines.decision',
            DB::raw('COUNT(*) as total'),
        ])
            ->join('school_classes', 'school_classes.id', '=', 'fault_disciplines.school_classes_id')
            ->join('school_grades', 'school_grades.id', '=', 'school_classes.school_grade_id')
            ->whereNotNull('fault_disciplines.bi_date')
            ->whereNotNull('fault_disciplines.decision')
            ->where('fault_disciplines.active', 1)
            // ->whereBetween('fault_disciplines.bi_date', [$this->date_start, $this->date_end])  // filtro pelo período
            ->groupBy('school_grades.name', 'fault_disciplines.decision')
            ->orderBy('school_grades.name')
            ->orderBy('fault_disciplines.decision')
            ->get();


        dd($punitions);
        $tabela = [];

        foreach ($punitions as $row) {
            $grade = $row->grade;
            $decision = $row->decision;
            $total = $row->total;

            $tabela[$grade][$decision] = $total;
        }

        dd($tabela);
        // Crie uma instância do mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            // 'orientation'        => 'P', //[P,L]
            'format' => 'A4-L',
            'margin_left'   => 15,
            'margin_top'    => 25,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($mpdf);
        $html = view(
            'livewire.discipline.fault-disciplines.pdfs.map-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Mapa de faltas disciplinares',
                'punitions'              => $tabela,
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
        $file = trim('mapa_de_faltas_disciplinares' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTabMap', pdfPath: $pdfPath);
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
