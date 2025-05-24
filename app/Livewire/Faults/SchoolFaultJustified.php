<?php

namespace App\Livewire\Faults;

use App\Models\Fault\SchoolFaults;
use Livewire\Component;
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Storage;

//Realiza o upload
use App\Traits\HandlesPdfUploads;

class SchoolFaultJustified extends Component
{
    use WithFileUploads;      // ⬅️ Necessário para lidar com uploads
    use HandlesPdfUploads;    // ⬅️ Sua trait personalizada

    public $back = 'school-faults-list';
    public $route = 'school-faults';

    public $breadcrumb = 'Justificativa';

    public $uploadPdf;
    public $school_faults;
    public $paste = false;
    public $rules;

    public $id;
    public $justified;
    public $logo_path;

    public $directory;



    public function mount(SchoolFaults $school_faults)
    {
        if ($school_faults->getAttributes()) {
            $this->id               = $school_faults->id;
            $this->justified        = $school_faults->justified;
            $this->school_faults    = $school_faults;
            $this->logo_path        = $school_faults->logo_path;
            //pasta que irá ser feito o upload
            $this->directory = 'public/school_faults/' . $this->school_faults->id;

            if (Storage::fileExists($this->directory . '/' . $this->logo_path)) {
                $this->paste = true;
            }
        }
        // dd($this->paste);
    }

    public function render()
    {

        return view('livewire.faults.school-fault-justified');
    }

    public function updated($property)
    {
        if ($property === 'uploadPdf') {
            $this->validate([
                'uploadPdf' => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            ]);

            $directory = $this->directory;

            $filename = $this->handlePdfUpload($this->uploadPdf, $directory);

            $this->school_faults->logo_path = $filename;
            $this->school_faults->save();
            $this->paste = true;
        }
    }
    public function excluirDoc()
    {
        $this->paste = $this->deletePdfDirectory($this->directory);
    }

    public function excluirTemp()
    {
        $this->uploadPdf = '';
    }


    public function save()
    {
        $id = $this->real_save();
        if ($id) {
            redirect()->route($this->route . '-edit', $id)->with('success', 'Registro criado com sucesso.');
        }
    }
    public function save_out()
    {
        $this->real_save();
        redirect()->route($this->route . '-list')->with('success', 'Registro criado com sucesso.');
    }

    public function real_save()
    {
        SchoolFaults::updateOrCreate([
            'id'    => $this->id,
        ], [
            // 'name'                  => $this->name,
            'id'                    => $this->id,
            'justified'            => $this->justified,
        ]);

        $msg = 'Registro editado com sucesso.';


        $this->openAlert('success', $msg);
        // return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
