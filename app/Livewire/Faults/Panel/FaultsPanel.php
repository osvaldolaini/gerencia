<?php

namespace App\Livewire\Faults\Panel;

use App\Models\Fault\SchoolFaults;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FaultsPanel extends Component
{
    public $recentFaults;
    public $topStudents;
    public function render()
    {
        $companiesAccess = Auth::user()->json_companies;
        $this->recentFaults = SchoolFaults::query()
            ->when(!in_array('all', $companiesAccess), function ($query) use ($companiesAccess) {
                $query->whereIn('companies_id', $companiesAccess);
            })
            ->with(['students', 'companies', 'grades', 'class'])
            ->latest()
            ->take(10)
            ->get();

        // 10 alunos com mais faltas
        $this->topStudents = SchoolFaults::query()
            ->when(!in_array('all', $companiesAccess), function ($query) use ($companiesAccess) {
                $query->whereIn('companies_id', $companiesAccess);
            })
            ->selectRaw('student_id, SUM(qtd) as total_faults')
            ->groupBy('student_id')
            ->orderByDesc('total_faults')
            ->with('students')
            ->take(10)
            ->get();



        return view('livewire.faults.panel.faults-panel');
    }
}
