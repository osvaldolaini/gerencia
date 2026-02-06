<?php

namespace App\Livewire\Faults\Charts;

use App\Models\Fault\SchoolFaults;
use App\Models\Settings\SchoolClassesYears;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FaultsByGrade extends Component
{
    public $labels;
    public $data;
    public $year;


    public function render()
    {
        $this->year = now()->year;
        $this->year = SchoolClassesYears::where("active", 1)->first()->year;

        $this->chart();
        return view('livewire.faults.charts.faults-by-grade');
    }
    public function chart()
    {
        $companiesAccess = Auth::user()->json_companies;
        $gradesChartRaw = SchoolFaults::select('school_grades_id', DB::raw('SUM(qtd) as total_faults'))
            ->when(!in_array('all', $companiesAccess), function ($query) use ($companiesAccess) {
                $query->whereIn('companies_id', $companiesAccess);
            })
            ->where('active', 1)

            ->whereYear('date', $this->year)
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
