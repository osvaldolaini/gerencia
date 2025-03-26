<?php

namespace App\Livewire\Students;

use Livewire\Component;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlanilhaExportView;

class SheetsExport extends Component
{
    public function render()
    {
        return view('livewire.students.sheets-export');
    }
    public function downloadExcel()
    {
        return Excel::download(new PlanilhaExportView(), 'planilha_inserir_alunos_novos.xlsx');
    }
}
