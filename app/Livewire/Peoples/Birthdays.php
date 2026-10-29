<?php

namespace App\Livewire\Peoples;

use App\Models\Peoples;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Birthdays extends Component
{

    public $showModalRead = false;
    public $companyId = 'all';

    #[On('company-selected')]
    public function companySelected($companyId)
    {
        // $companyId terá o valor selecionado
        $this->companyId = $companyId;
    }
    public function mount()
    {
        $this->companyId = Cache::get(
            'students_company_filter_' . Auth::id(),
            'all'
        );
    }

    public function render()
    {
        $birthdays = Peoples::query()
            ->where('active', 1)
            ->where('type', 1)
            ->whereNotNull('birthday')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('school_classes_students')
                    ->join('school_classes', 'school_classes.id', '=', 'school_classes_students.school_classes_id')
                    ->whereColumn('school_classes_students.people_id', 'peoples.id')
                    ->where('school_classes_students.active', 1)
                    ->orderBy('school_classes_students.id', 'ASC')
                    ->limit(1);
            })

            ->whereRaw("DATE_FORMAT(birthday, '%m-%d') BETWEEN ? AND ?", [
                now()->startOfWeek()->format('m-d'),
                now()->endOfWeek()->format('m-d')
            ])
            ->orderByRaw('DAY(birthday) ASC')
            ->get()
            ->map(function ($person) {
                $birthDate = Carbon::parse($person->birthday);
                $person->birthday_day = $birthDate->format('d');
                $person->age = $birthDate->age;
                return $person;
            });


        return view('livewire.peoples.birthdays', [
            'birthdays' => $birthdays,
            'currentMonth' => now()->locale('pt_BR')->translatedFormat('F'),
        ]);
    }
    //Update
    public function showRead()
    {
        $this->showModalRead = true;
    }
    //Update
    public function closeRead()
    {
        $this->showModalRead = false;
    }
}
