<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithProperties;

class PlanilhaExportView implements FromView, WithProperties
{
    public function __construct() {}
    public function view(): View
    {
        return view('livewire.students.planilha-inserir-alunos', [
            'title' =>  'Inserir alunos'
        ]);
    }
    public function properties(): array
    {
        return [
            'creator'        => Auth::user()->name,
        ];
    }
}
