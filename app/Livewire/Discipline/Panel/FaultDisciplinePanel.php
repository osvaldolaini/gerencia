<?php

namespace App\Livewire\Discipline\Panel;

use App\Models\Discipline\FaultDiscipline;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FaultDisciplinePanel extends Component
{
    public $recentFafd;
    public $topStudentsFafd;
    public function render()
    {

        $companiesAccess = Auth::user()->json_companies;
        $this->recentFafd = FaultDiscipline::query()
            ->when(!in_array('all', $companiesAccess), function ($query) use ($companiesAccess) {
                $query->whereIn('company_id', $companiesAccess);
            })
            ->with(['students'])
            ->latest()
            ->take(10)
            ->get();

        $this->topStudentsFafd = FaultDiscipline::query()
            ->when(!in_array('all', $companiesAccess), function ($query) use ($companiesAccess) {
                $query->whereIn('company_id', $companiesAccess);
            })
            ->selectRaw('student_id, COUNT(*) as total')
            ->groupBy('student_id')
            ->orderByDesc('total')
            ->with('students') // Certifique-se de que a relação está definida no model
            ->limit(10)
            ->get();
        return view('livewire.discipline.panel.fault-discipline-panel');
    }
}
