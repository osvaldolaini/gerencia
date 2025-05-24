<?php

namespace App\Livewire\Faults;

use App\Models\Fault\SchoolFaults;
use Livewire\Component;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

use Barryvdh\DomPDF\Facade\Pdf;

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

    public $diretory;



    public function mount(SchoolFaults $school_faults)
    {
        if ($school_faults->getAttributes()) {
            $this->id               = $school_faults->id;
            $this->justified        = $school_faults->justified;
            $this->school_faults    = $school_faults;
            $this->logo_path        = $school_faults->logo_path;
            $this->diretory = 'public/school_faults/' . $this->school_faults->id;

            if (Storage::fileExists($this->diretory . '/' . $this->logo_path)) {
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

            $directory = $this->diretory;

            if (Storage::directoryMissing($directory)) {
                Storage::makeDirectory($directory, 0755, true, true);
            }
            Storage::deleteDirectory($directory);

            Storage::makeDirectory($directory, 0755, true, true);

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

        $html = "<html><body style='margin:0;padding:0;'>
                    <img src='{$base64Image}' style='width:100%;height:auto;'>
                 </body></html>";

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output($outputPath, \Mpdf\Output\Destination::FILE); // salva no disco
    }

    public function excluirTemp()
    {
        $this->uploadPdf = '';
    }
    public function excluirDoc()
    {
        if (Storage::directoryMissing($this->diretory)) {
            Storage::makeDirectory($this->diretory);
        }
        Storage::deleteDirectory($this->diretory);
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
