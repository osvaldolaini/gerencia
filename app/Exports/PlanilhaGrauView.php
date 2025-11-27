<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithProperties;

class PlanilhaGrauView implements FromView, WithProperties
{
    public $school_classes;
    public $grade;
    public $company;
    public $config;

    public function __construct($school_classes, $grade, $company, $config)
    {
        $this->school_classes = $school_classes;
        $this->grade = $grade;
        $this->company = $company;
        $this->config = $config;
    }

    public function view(): View
    {
        return view('livewire.settings.docs.student-grau-plan', [
            'title'           => 'Grau de comportamento',
            'school_classes'  => $this->school_classes,
            'grade'           => $this->grade,
            'company'         => $this->company,
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
