<?php

namespace App\Livewire\Faults\Charts;

use App\Models\Fault\SchoolFaults;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FaultsByWeek extends Component
{
    public $labels;
    public $data;
    public function render()
    {
        $this->chart();
        return view('livewire.faults.charts.faults-by-week');
    }

    public function chart()
    {
        $companiesAccess = Auth::user()->json_companies;
        $daysOfWeek = [
            1 => 'Segunda',
            2 => 'Terça',
            3 => 'Quarta',
            4 => 'Quinta',
            5 => 'Sexta',
            6 => 'Sábado',
        ];

        $faultsByWeekday = SchoolFaults::selectRaw('WEEKDAY(date) as weekday, SUM(qtd) as total')
            ->when(!in_array('all', $companiesAccess), function ($query) use ($companiesAccess) {
                $query->whereIn('companies_id', $companiesAccess);
            })
            ->groupBy('weekday')
            ->orderBy('weekday')
            ->pluck('total', 'weekday');

        $this->labels = [];
        $this->data = [];

        foreach ($daysOfWeek as $index => $day) {
            $this->labels[] = $day;
            $total = $faultsByWeekday[$index] ?? 0;
            $percent = $faultsByWeekday->sum() > 0
                ? number_format(($total / $faultsByWeekday->sum()) * 100, 2, '.', '')
                : 0;
            $this->data[] = $percent;
        }
    }
}
