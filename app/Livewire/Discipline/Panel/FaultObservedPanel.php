<?php

namespace App\Livewire\Discipline\Panel;

use App\Models\Discipline\FactObserved;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FaultObservedPanel extends Component
{
    public $recentFos;
    public $topStudentsFos;
    public function render()
    {
        $companiesAccess = Auth::user()->json_companies;
        $this->recentFos = FactObserved::query()
            ->when(!in_array('all', $companiesAccess), function ($query) use ($companiesAccess) {
                $query->whereIn('company_id', $companiesAccess);
            })
            ->with(['students'])
            ->latest()
            ->where('active', 1)
            ->take(10)
            ->get();

        $this->topStudentsFos = FactObserved::query()
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
        return view('livewire.discipline.panel.fault-observed-panel');
    }
}
