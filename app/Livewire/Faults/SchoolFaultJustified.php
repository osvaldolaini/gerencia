<?php

namespace App\Livewire\Faults;

use App\Models\Fault\SchoolFaults;
use Livewire\Component;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;


class SchoolFaultJustified extends Component
{
    use WithFileUploads;

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



    public function mount(SchoolFaults $school_faults)
    {
        if ($school_faults->getAttributes()) {
            $this->id               = $school_faults->id;
            $this->justified        = $school_faults->justified;
            $this->school_faults    = $school_faults;
            $this->logo_path        = $school_faults->logo_path;

            if (Storage::fileExists('public/school_faults/' . $this->school_faults->id . '/' . $this->logo_path)) {
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
    // public function uploaddoc()
    {
        if ($property === 'uploadPdf') {
            $this->rules = [
                'uploadPdf'   => ['nullable', 'mimes:pdf', 'max:1024'],
            ];
            $this->logo_path = 'teste';
            $this->validate();

            if (Storage::directoryMissing('public/school_faults/' . $this->school_faults->id)) {
                Storage::makeDirectory('public/school_faults/' . $this->school_faults->id, 755, true, true);
            } else {
                Storage::deleteDirectory('public/school_faults/' . $this->school_faults->id);
            }


            if (isset($this->uploadPdf)) {
                $new_name = $this->logo_path . '.pdf';
                $this->uploadPdf->storeAs('public/school_faults/' . $this->school_faults->id, $new_name);
            }
            $this->school_faults->logo_path = $new_name;
            $this->school_faults->save();
            $this->paste = true;
        }
    }
    public function excluirTemp()
    {
        $this->uploadPdf = '';
    }
    public function excluirDoc()
    {
        if (Storage::directoryMissing('public/school_faults/' . $this->school_faults->id)) {
            Storage::makeDirectory('public/school_faults/' . $this->school_faults->id);
        }
        Storage::deleteDirectory('public/school_faults/' . $this->school_faults->id);
        $this->paste = false;
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
