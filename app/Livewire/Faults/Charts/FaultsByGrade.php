<?php

namespace App\Livewire\Faults\Charts;

use App\Models\Fault\SchoolFaults;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FaultsByGrade extends Component
{


    public $labels;
    public $color;
    public $data;
    public function render()
    {
        $this->chart();
        return view('livewire.faults.charts.faults-by-grade');
    }
    public function chart()
    {
        $gradesChartRaw = SchoolFaults::select('school_grades_id', DB::raw('SUM(qtd) as total_faults'))
            ->groupBy('school_grades_id')
            ->with('grades')
            ->get();
        // Labels: nomes dos anos escolares
        $this->labels = $gradesChartRaw->pluck('grades.name')->map(fn($name) => $name ?? 'Não informado')->toArray();

        // Data: quantidade de faltas por ano escolar
        $this->data = $gradesChartRaw->pluck('total_faults')->map(function ($value) {
            return number_format($value, 0, '.', '');
        })->toArray();
        // dd($this->data, $this->labels);
        // $this->labels = $gradesChart['label'];
        // $this->data = $gradesChart['data'];
    }
}
