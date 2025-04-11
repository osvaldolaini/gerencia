<?php

namespace App\Livewire\Faults\Panel;

use App\Models\Fault\SchoolFaults;
use Livewire\Component;

class FaultsPanel extends Component
{
    public $recentFaults;
    public $topStudents;
    public function render()
    {
        // 10 lançamentos mais recentes
        $this->recentFaults = SchoolFaults::with('students')
            ->latest('date')
            ->take(10)
            ->get();

        // 10 alunos com mais faltas
        $this->topStudents = SchoolFaults::select('student_id')
            ->selectRaw('SUM(qtd) as total_faults')
            ->groupBy('student_id')
            ->orderByDesc('total_faults')
            ->with('students')
            ->take(10)
            ->get();
        return view('livewire.faults.panel.faults-panel');
    }
}
