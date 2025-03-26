<?php

namespace App\Livewire\Students;

use App\Imports\PlanilhaImport;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Component;

use Livewire\WithFileUploads;

class SheetsImport extends Component
{
    use WithFileUploads;

    public $sheet;
    public $alertSession = false;
    public $import = false;
    //Fecha a caixa da mensagem
    public function closeAlert()
    {
        $this->alertSession = false;
    }
    public function render()
    {
        return view('livewire.students.sheets-import');
    }
    public function showModal()
    {
        $this->import = $this->import == false ? true : false;
    }

    public function importExcel()
    {
        $this->validate([
            'sheet' => 'required|file|mimes:xlsx|max:2048',
        ]);

        $xlsx = $this->sheet->getClientOriginalName();
        $this->sheet->storeAs('imports/' . $xlsx);
        Excel::import(new PlanilhaImport($xlsx), storage_path('app/imports/' . $xlsx));

        $this->reset(
            'sheet'
        );
        $this->import = false;
        $this->dispatch('importUpdateStudents');
        $this->openAlert('success', 'Planilha inserida com sucesso');
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
