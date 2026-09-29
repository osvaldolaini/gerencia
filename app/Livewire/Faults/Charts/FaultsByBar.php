<?php

namespace App\Livewire\Faults\Charts;

use App\Models\Fault\SchoolFaults;
use App\Models\Peoples;
use App\Models\Settings\SchoolClassesYears;
use App\Models\Settings\SchoolGrades;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FaultsByBar extends Component
{
    public $labels;
    public $data;
    public $year;

    public array $faultsByGrade = [];


    public function render()
    {
        $this->year = now()->year;
        $this->year = SchoolClassesYears::where("active", 1)->first()->year;

        $this->chart();
        return view('livewire.faults.charts.faults-by-bar');
    }


    private function chart()
    {
        $schoolYear = SchoolClassesYears::where('active', 1)->first();

        if (!$schoolYear) {
            $this->year = null;
            $this->faultsByGrade = [];
            $this->labels = [];
            $this->data = [];

            return;
        }

        $this->year = $schoolYear->year;

        $faults = SchoolFaults::query()
            ->where('active', 1)
            ->where('school_classes_year_id', $schoolYear->id)
            ->whereNotNull('school_grades_id')
            ->with('companies')
            ->get()
            ->groupBy('student_id');

        $this->faultsByGrade = $faults
            ->map(function ($studentFaults) {

                $firstFault = $studentFaults->first();

                $totalFaults = $studentFaults->sum('qtd');

                $workload = (float) ($firstFault->companies?->workload ?? 1200);

                $percent = $workload > 0
                    ? ($totalFaults / $workload) * 100
                    : 0;

                return [
                    'grade_id'     => $firstFault->school_grades_id,
                    'total_faults' => $totalFaults,
                    'workload'     => $workload,
                    'percent'      => $percent,
                ];
            })
            ->filter(function ($student) {
                return $student['percent'] > 7.5;
            })
            ->groupBy('grade_id')
            ->map(function ($students) {

                return [
                    'above_7_5' => $students
                        ->where('percent', '>', 7.5)
                        ->where('percent', '<=', 15)
                        ->count(),

                    'above_15' => $students
                        ->where('percent', '>', 15)
                        ->where('percent', '<=', 25)
                        ->count(),

                    'above_25' => $students
                        ->where('percent', '>', 25)
                        ->count(),
                ];
            })
            ->toArray();

        /*
    |--------------------------------------------------------------------------
    | Labels
    |--------------------------------------------------------------------------
    */

        $grades = SchoolGrades::whereIn(
            'id',
            array_keys($this->faultsByGrade)
        )
            ->pluck('name', 'id');

        $this->labels = [];

        foreach ($this->faultsByGrade as $gradeId => $data) {
            $this->labels[] = $grades[$gradeId] ?? 'Série ' . $gradeId;
        }

        /*
    |--------------------------------------------------------------------------
    | Datasets
    |--------------------------------------------------------------------------
    */

        $this->data = [
            [
                'label' => '7,5% a 15%',
                'data' => array_column($this->faultsByGrade, 'above_7_5'),
            ],
            [
                'label' => '15% a 25%',
                'data' => array_column($this->faultsByGrade, 'above_15'),
            ],
            [
                'label' => 'Acima de 25%',
                'data' => array_column($this->faultsByGrade, 'above_25'),
            ],
        ];
    }
}
