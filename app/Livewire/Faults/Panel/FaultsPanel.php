<?php

namespace App\Livewire\Faults\Panel;

use App\Models\Fault\SchoolFaults;
use App\Models\Settings\SchoolClassesYears;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FaultsPanel extends Component
{
    public $recentFaults;
    public $topStudents;
    public $year;

    public function render()
    {
        $this->year = now()->year;
        $this->year = SchoolClassesYears::where("active", 1)->first()->year;

        $companiesAccess = Auth::user()->json_companies;

        $this->recentFaults = SchoolFaults::query()
            ->when(!in_array('all', $companiesAccess), function ($query) use ($companiesAccess) {
                $query->whereIn('companies_id', $companiesAccess);
            })
            ->whereYear('date', $this->year)
            ->where('active', 1)
            ->with(['students', 'companies', 'grades', 'class'])
            ->latest()
            ->take(10)
            ->get();

        // 10 alunos com mais faltas
        $this->topStudents = SchoolFaults::query()
            ->when(!in_array('all', $companiesAccess), function ($query) use ($companiesAccess) {
                $query->whereIn('companies_id', $companiesAccess);
            })
            ->where('active', 1)
            $this->year = SchoolClassesYears::where("active", 1)->first()->year;
            ->selectRaw('student_id, SUM(qtd) as total_faults')
            ->groupBy('student_id')
            ->orderByDesc('total_faults')
            ->with('students')
            ->take(10)
            ->get();

        // dd($this->topStudents);

        return view('livewire.faults.panel.faults-panel');
    }
}
