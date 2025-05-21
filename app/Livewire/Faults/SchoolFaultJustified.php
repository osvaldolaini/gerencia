<?php

namespace App\Livewire\Faults;

use App\Models\Fault\SchoolFaults;
use Livewire\Component;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

use Spatie\Browsershot\Browsershot;

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
    {
        if ($property === 'uploadPdf') {
            $this->validate([
                'uploadPdf' => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:10240'], // até 10MB
            ]);

            $directory = 'public/school_faults/' . $this->school_faults->id;
            Storage::deleteDirectory($directory);
            $path = storage_path('app/public/school_faults/' . $this->school_faults->id);

            Storage::makeDirectory($directory, 0755, true, true);
            chmod($path, 0755);

            // Aplica permissão aos arquivos existentes também
            foreach (glob($path . '/*') as $file) {
                chmod($file, 0644);
            }

            $extension = $this->uploadPdf->getClientOriginalExtension();
            $filename = Str::random(20) . '.pdf';
            $outputPath = storage_path('app/' . $directory . '/' . $filename);

            if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                $this->convertImageToPdf($this->uploadPdf->getRealPath(), $outputPath);
            } else {
                // Move PDF original
                $this->uploadPdf->storeAs($directory, $filename);
                // $originalPath = storage_path("app/{$directory}/{$filename}");
                // $this->compressPdfWithBrowsershot($originalPath, $outputPath);
            }

            $this->school_faults->logo_path = $filename;
            $this->school_faults->save();
            $this->paste = true;
        }
    }

    public function convertImageToPdf($imagePath, $outputPath)
    {
        $imageData = base64_encode(file_get_contents($imagePath));
        $mime = mime_content_type($imagePath);
        $base64Image = "data:$mime;base64,$imageData";

        $html = "<html><body style='margin:0;padding:0;'><img src='{$base64Image}' style='width:100%;height:auto;'></body></html>";

        Browsershot::html($html)
            ->showBackground()
            ->margins(0, 0, 0, 0)
            ->deviceScaleFactor(1)
            ->setOption('quality', 60)
            ->save($outputPath);
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
