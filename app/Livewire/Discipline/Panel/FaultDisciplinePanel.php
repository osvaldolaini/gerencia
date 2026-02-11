<?php

namespace App\Livewire\Discipline\Panel;

use App\Models\Admin\Settings\Settings;
use App\Models\Discipline\FaultDiscipline;
use App\Models\Peoples;
use App\Models\Settings\SchoolClassesYears;
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
        $year = now()->year;
        $year = SchoolClassesYears::where("active", 1)->first()->year;

        $companiesAccess = Auth::user()->json_companies;
        $this->recentFafd = FaultDiscipline::query()
            ->when(!in_array('all', $companiesAccess), function ($query) use ($companiesAccess) {
                $query->whereIn('company_id', $companiesAccess);
            })

            ->with(['students'])
            ->where('active', 1)
            ->whereYear('year', $year)
            ->latest()
            ->take(10)
            ->get();

        $this->topStudentsFafd = FaultDiscipline::query()
            ->when(!in_array('all', $companiesAccess), function ($query) use ($companiesAccess) {
                $query->whereIn('company_id', $companiesAccess);
            })
            ->selectRaw('student_id, COUNT(*) as total')
            ->where('active', 1)
            ->whereYear('year', $year)
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
        $this->somaTotalGeral(); // por último, calcula os totais
    }

    private function punitions()
    {
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

            $decision = trim(strtolower(str_replace("'", "", $p->decision)));

            $total = $p->total;

            if (!isset($this->tabela[$grade])) {
                $this->tabela[$grade] = array_fill_keys([
                    'advertencia',
                    'repreensao',
                    'atividade_orientacao_educacional',
                    'retirada_cm',
                    'exclusao_disciplinar',
                ], 0);
            }

            if (array_key_exists($decision, $this->tabela[$grade])) {
                $this->tabela[$grade][$decision] += $total;
            }

            // Soma apenas as punições, ignorando TOTAL
            $this->tabela[$grade]['TOTAL'] = array_sum(
                array_filter(
                    $this->tabela[$grade],
                    fn($key) => $key !== 'TOTAL',
                    ARRAY_FILTER_USE_KEY
                )
            );
        }
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
    private function somaTotalGeral()
    {
        $totaisGerais = [
            'advertencia' => 0,
            'repreensao' => 0,
            'atividade_orientacao_educacional' => 0,
            'retirada_cm' => 0,
            'exclusao_disciplinar' => 0,
            'TOTAL' => 0,
            'excepcional' => 0,
            'otimo' => 0,
            'bom' => 0,
            'regular' => 0,
            'insuficiente' => 0,
            'mau' => 0,
            'total_comportamento' => 0,
            'total_geral' => 0,
        ];

        foreach ($this->tabela as $serie => $dados) {
            foreach ($totaisGerais as $key => $val) {
                $totaisGerais[$key] += $dados[$key] ?? 0;
            }
        }

        $this->tabela['SOMA'] = $totaisGerais;
    }





    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
