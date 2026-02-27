<?php

namespace App\Livewire\Discipline\Panel;

use App\Models\Discipline\FactObserved;
use App\Models\Discipline\FaultDiscipline;
use App\Models\Settings\Companies;
use App\Models\Settings\SchoolClassesYears;
use Livewire\Component;

class DisciplinePanelCard extends Component
{
    public $fo;
    public $fafd;
    public $title;
    public $actived;

    public function mount(Companies $companies)
    {
        $this->actived = now()->year;
        if (SchoolClassesYears::where("active", 1)->first()) {
            $this->actived = SchoolClassesYears::where("active", 1)->first()->year;
        }

        // dd($companies);
        if ($companies) {
            $this->fo = FactObserved::where("company_id", $companies->id)->where("active", 1)->where('year',  $this->actived)->get();
            $this->fafd = FaultDiscipline::where("company_id", $companies->id)->where("active", 1)->where('year',  $this->actived)->get();
            $this->title = $companies->nick;
        } else {
            $this->fo = FactObserved::where("active", 1)->where('year',  $this->actived)->get();
            $this->fafd = FaultDiscipline::where("active", 1)->where('year',  $this->actived)->get();
        }
    }
    public function render()
    {
        // $this->fo = FactObserved::where("active", 1)->where('fact_date', 'LIKE', '%' . date('Y') . '%')->get();
        // $this->fafd = FaultDiscipline::where('year', 'LIKE', '%' . date('Y') . '%')->get();
        return view('livewire.discipline.panel.discipline-panel-card');
    }
}
