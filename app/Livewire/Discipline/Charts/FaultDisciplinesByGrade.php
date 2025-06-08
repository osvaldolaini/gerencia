<?php

namespace App\Livewire\Discipline\Charts;

use App\Models\Admin\Settings\Settings;
use App\Models\Discipline\FaultDiscipline;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class FaultDisciplinesByGrade extends Component
{
    public $date_start;
    public $date_end;
    public $chartLabels = [];
    public $chartDatasets = [];

    public function render()
    {
        return view('livewire.discipline.charts.fault-disciplines-by-grade');
    }

    public function mount()
    {
        $this->date_start = now()->startOfYear()->toDateString();
        $this->date_end = now()->toDateString();
        $this->prepareChartData();
    }

    private function prepareChartData()
    {
        $rawData = FaultDiscipline::select([
            'school_grades.name as grade',
            'fault_disciplines.decision',
            DB::raw('COUNT(*) as total')
        ])
            ->join('school_classes', 'school_classes.id', '=', 'fault_disciplines.school_classes_id')
            ->join('school_grades', 'school_grades.id', '=', 'school_classes.school_grade_id')
            ->whereNotNull('fault_disciplines.supplement_number')
            ->whereNotNull('fault_disciplines.decision')
            ->where('fault_disciplines.active', 1)
            ->whereBetween('fault_disciplines.bi_date', [$this->date_start, $this->date_end])
            ->groupBy('school_grades.name', 'fault_disciplines.decision')
            ->orderBy('school_grades.name')
            ->get();

        $decisions = [
            'advertencia' => 'Advertência',
            'repreensao' => 'Repreensão',
            'atividade_orientacao_educacional' => 'Atividade de Orientação Educacional',
            'retirada_cm' => 'Retirada do CM',
            'exclusao_disciplinar' => 'Exclusão Disciplinar',
        ];


        $labels = $rawData->pluck('grade')->unique()->values()->toArray();
        foreach ($decisions as $key => $label) {
            $dataset = [
                'label' => $label,
                'data' => [],
            ];

            foreach ($labels as $grade) {
                $dataset['data'][] = $grouped[$key][$grade] ?? 0;
            }

            $datasets[] = $dataset;
        }

        sort($labels);
        $this->chartLabels = $labels;

        $grouped = [];
        foreach ($rawData as $row) {
            $grade = $row->grade;
            $decision = trim(strtolower(str_replace("'", '', $row->decision)));
            $grouped[$decision][$grade] = $row->total;
        }

        $datasets = [];
        foreach ($decisions as $decision) {
            $dataset = [
                'label' => ucfirst(str_replace('_', ' ', $decision)),
                'data' => [],
            ];

            foreach ($labels as $grade) {
                $dataset['data'][] = $grouped[$decision][$grade] ?? 0;
            }

            $datasets[] = $dataset;
        }

        $this->chartDatasets = $datasets;
    }
}
