<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithProperties;

class PlanilhaFaultsView implements FromView, WithProperties
{
    public $students;
    public $config;

    public function __construct($students, $config)
    {
        $this->students = $students;
        $this->config = $config;
    }

    public function view(): View
    {
        return view('livewire.settings.docs.student-faults-list', [
            'title'           => 'Alunos com mais de 7,5% de faltas',
            'students'  => $this->students,
            'config'          => $this->config,
        ]);
    }

    public function properties(): array
    {
        return [
            'creator'        => Auth::user()->name,
        ];
    }
}
