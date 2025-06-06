<?php

namespace App\Livewire\Discipline\Panel;

use App\Models\Admin\Settings\Settings;
use App\Models\Discipline\FaultDiscipline;
use App\Models\Peoples;
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

    public $showModal;
    public $config;
    public $tabela;

    public function mount()
    {
        $this->date_start   = now()->startOfYear()->toDateString();
        $this->date_end     = now()->toDateString();
        $this->config = $config = Settings::find(1);
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

        // $config = Settings::find(1);

        $this->punitions();
        $this->grau();
    }

    private function punitions()
    {
        $logoPath = url('storage/logos-school/logo-header.png');
        $this->showModal = true;
        $punitions = FaultDiscipline::select([
            'school_grades.name as grade',
            // 'school_classes.title as class',
            'fault_disciplines.decision',
            DB::raw('COUNT(*) as total'),
        ])
            ->join('school_classes', 'school_classes.id', '=', 'fault_disciplines.school_classes_id')
            ->join('school_grades', 'school_grades.id', '=', 'school_classes.school_grade_id')
            ->whereNotNull('fault_disciplines.supplement_number')
            ->whereNotNull('fault_disciplines.decision')
            ->where('fault_disciplines.active', 1)
            ->whereBetween('fault_disciplines.bi_date', [$this->date_start, $this->date_end])
            ->groupBy('school_grades.name', 'fault_disciplines.decision')
            ->orderBy('school_grades.name')
            ->orderBy('fault_disciplines.decision')
            ->get();


        $this->tabela = [];

        foreach ($punitions as $p) {
            $grade = $p->grade;

            // Corrige a chave: remove aspas simples e deixa lowercase
            $decision = trim(strtolower(str_replace("'", "", $p->decision)));

            $total = $p->total;

            // Inicializa a linha com zeros se não existir
            if (!isset($this->tabela[$grade])) {
                $this->tabela[$grade] = array_fill_keys([
                    'advertencia',
                    'repreensao',
                    'atividade_orientacao_educacional',
                    'retirada_cm',
                    'exclusao_disciplinar',
                ], 0);
            }

            // Garante que só atualize se for um tipo conhecido
            if (array_key_exists($decision, $this->tabela[$grade])) {
                $this->tabela[$grade][$decision] += $total;
            }

            // Atualiza o total sempre no fim
            $this->tabela[$grade]['TOTAL'] = array_sum($this->tabela[$grade]);
        }




        // dd($tabela);
        // Crie uma instância do mPDF
        // $mpdf = new \Mpdf\Mpdf([
        //     'mode'          => 'utf-8',
        //     // 'orientation'        => 'P', //[P,L]
        //     'format' => 'A4-L',
        //     'margin_left'   => 15,
        //     'margin_top'    => 25,
        //     'default_font_size'  => 9,
        //     'default_font'  => 'arial',
        // ]);
        // dd($mpdf);
        // $html = view(
        //     'livewire.discipline.fault-disciplines.pdfs.map-pdf',
        //     [
        //         'logoPath'          => $logoPath,
        //         'date_start'        => $this->date_start,
        //         'date_end'          => $this->date_end,
        //         'title'             => 'Mapa de faltas disciplinares',
        //         'tabela'         => $tabela,
        //         'config'            => $config,
        //         'responsible'       => Auth::user()->name,
        //     ]
        // )->render();

        // Adicione o conteúdo HTML ao PDF
        //     $mpdf->SetHTMLHeader('
        //           <table width="100%">
        //               <tr >
        //                   <td width="50%">
        //                       <img width="50" src="' . $logoPath . '" alt="Logo">
        //                   </td>
        //                   <td width="50%" style="text-align: right;">
        //                       <strong>' . $config->name . '</strong><br>

        //                   </td>
        //               </tr>
        //           </table>
        //           ');
        //     $mpdf->SetHTMLFooter('
        //    <table width="100%">
        //        <tr>
        //            <td width="66%">Impressão realizada em {DATE j/m/Y} às {DATE H:i:s}</td>
        //            <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
        //        </tr>
        //    </table>');
        //     $mpdf->WriteHTML($html);

        // Salve o PDF temporariamente
        // $file = trim('mapa_de_faltas_disciplinares' . Str::uuid() . '.pdf');

        // if (!is_dir(storage_path('app/public/pdf-tmp'))) {
        //     mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        // }

        // $down = storage_path('app/public/pdf-tmp/' . $file);
        // $pdfPath = url('storage/pdf-tmp/' . $file);

        // $mpdf->Output($down, 'F');

        // $this->dispatch('openPdfInNewTabMap', pdfPath: $pdfPath);
    }
    private function grau()
    {
        $alunos = Peoples::select('peoples.*', 'school_grades.name as serie_name')
            ->join('school_classes_students', 'school_classes_students.people_id', '=', 'peoples.id')
            ->join('school_classes', 'school_classes.id', '=', 'school_classes_students.school_classes_id')
            ->join('school_grades', 'school_grades.id', '=', 'school_classes.school_grade_id')
            ->where('peoples.active', 1)
            ->where('peoples.type', 1)
            ->where('school_classes_students.active', 1)
            ->get();

        $comportamentoPorSerie = [];

        foreach ($alunos as $aluno) {
            $serie = $aluno->serie_name ?? 'Sem Série';
            $status = $aluno->grau_status;

            if (!isset($comportamentoPorSerie[$serie])) {
                $comportamentoPorSerie[$serie] = [
                    'EXCEPCIONAL' => 0,
                    'ÓTIMO' => 0,
                    'BOM' => 0,
                    'REGULAR' => 0,
                    'INSUFICIENTE' => 0,
                    'MAU' => 0,
                ];
            }
            $comportamentoPorSerie[$serie][$status]++;
        }

        foreach ($comportamentoPorSerie as $serie => $counts) {
            if (!isset($this->tabela[$serie])) {
                $this->tabela[$serie] = [
                    'advertencia' => 0,
                    'repreensao' => 0,
                    'atividade_orientacao_educacional' => 0,
                    'retirada_cm' => 0,
                    'exclusao_disciplinar' => 0,
                    'TOTAL' => 0,
                ];
            }

            $this->tabela[$serie]['excepcional'] = $counts['EXCEPCIONAL'];
            $this->tabela[$serie]['otimo'] = $counts['ÓTIMO'];
            $this->tabela[$serie]['bom'] = $counts['BOM'];
            $this->tabela[$serie]['regular'] = $counts['REGULAR'];
            $this->tabela[$serie]['insuficiente'] = $counts['INSUFICIENTE'];
            $this->tabela[$serie]['mau'] = $counts['MAU'];

            $totalComportamento = array_sum($counts);
            $totalPunicoes = $this->tabela[$serie]['TOTAL'] ?? 0;

            $this->tabela[$serie]['total_comportamento'] = $totalComportamento;
            $this->tabela[$serie]['total_geral'] = $totalComportamento + $totalPunicoes;
        }
    }




    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
