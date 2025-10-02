<?php

namespace App\Livewire\Discipline\FaultDisciplines;

use App\Models\Discipline\FaultDiscipline;
use Livewire\Component;

use App\Models\Peoples;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use App\Models\Admin\Settings\Settings;
use App\Models\Settings\Companies;
use App\Traits\HandlesPdfUploads;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

class FaultDisciplineSolution extends Component
{
    use WithFileUploads;      // ⬅️ Necessário para lidar com uploads
    use HandlesPdfUploads;    // ⬅️ Sua trait personalizada

    public $uploadPdf;
    public $fafd;
    public $doc;
    public $rules;
    public $fault_discipline;
    public $paste;
    public $decision;

    public function mount(FaultDiscipline $fault_discipline)
    {
        $this->fault_discipline = $fault_discipline;
        if ($fault_discipline->id) {
            $this->fafd = Peoples::find($fault_discipline->id);
            $this->paste = Storage::fileExists('public/fafd/' . $fault_discipline->id . '/fafd_n_solucao_' . $fault_discipline->number . '.pdf');
            // dd($this->doc);
        }
    }
    public function render()
    {
        $this->paste = Storage::fileExists('public/fafd/' . $this->fault_discipline->id . '/fafd_n_solucao_' . $this->fault_discipline->number . '.pdf');
        return view('livewire.discipline.fault-disciplines.fault-discipline-solution');
    }
    //Turmas
    public function printSol()
    {
        $this->decision = $this->fault_discipline->decision;
        if (!$this->decision) {
            $this->openAlert('error', 'Selecione uma medida disciplinar');
            return;
        }

        $config = Settings::find(1);
        $companies = Companies::where('active', 1)->first();
        // dd($this->fault_discipline);
        // Crie uma instância do mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            // 'orientation'        => 'P', //[P,L]
            'format' => 'A4-P',
            'margin_left'   => 10,
            'margin_top'    => 10,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($mpdf);

        // Renderize a view do Livewire
        $html = view(
            'livewire.discipline.fault-disciplines.pdfs.solution-pdf',
            [
                'fault_discipline'  => $this->fault_discipline,
                'config'            => $config,
                'companies'         => $companies,
                'title_postfix'     => 'SOLUÇÃO DA FAFD Nº ' . $this->fault_discipline->number . '/' . $this->fault_discipline->year,
                'subtext'           => 'SOLUÇÃO DA FAFD Nº ' . $this->fault_discipline->number . '/' . $this->fault_discipline->year,
                'responsible'       => Auth::user()->name,
            ]
        )->render();
        // dd($html);


        // Adicione o conteúdo HTML ao PDF
        $mpdf->WriteHTML($html);
        $mpdf->SetHTMLFooter('
             <table width="100%">
                 <tr>
                     <td width="66%">Impressão realizada em {DATE j/m/Y} às {DATE H:i:s}</td>
                     <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
                 </tr>
             </table>');

        $file = Str::uuid() . '.pdf';
        // Salve o PDF temporariamente
        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');
        // dd();

        $this->dispatch('openPdfInNewTabSol', pdfPath: $pdfPath);
    }



    public function changeDoc()
    {
        $this->dispatch('submitForm');
    }
    // public function updated($property)
    // // public function uploaddoc()
    // {
    //     if ($property === 'uploadPdf') {
    //         $this->rules = [
    //             'uploadPdf'   => ['nullable', 'mimes:pdf', 'max:1024'],
    //         ];

    //         $this->validate();
    //         if (Storage::directoryMissing('public/fafd/' . $this->fault_discipline->id)) {
    //             Storage::makeDirectory('public/fafd/' . $this->fault_discipline->id, 0755, true, true);
    //         }
    //         Storage::delete('public/fafd/' . $this->fault_discipline->id . '/fafd_n_solucao_' . $this->fault_discipline->number . '.pdf');
    //         if (isset($this->uploadPdf)) {
    //             $ext = $this->uploadPdf->getClientOriginalExtension();
    //             $new_name = 'fafd_n_solucao_' . $this->fault_discipline->number . '.pdf';

    //             $this->uploadPdf->storeAs('public/fafd/' . $this->fault_discipline->id, $new_name);
    //         }
    //     }
    //     $this->paste = true;
    // }
    public function updated($property)
    {
        if ($property === 'uploadPdf') {
            $this->validate([
                'uploadPdf' => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            ]);

            $directory = 'public/fafd/' . $this->fault_discipline->id;
            $filename = 'fafd_n_solucao_' . $this->fault_discipline->number . '.pdf';
            $filename = $this->handlePdfUpload($this->uploadPdf, $directory, $filename, false);

            $this->paste = true;
        }
    }
    public function excluirTemp()
    {
        $this->uploadPdf = '';
    }
    public function excluirDoc()
    {
        if (Storage::directoryMissing('public/fafd/' . $this->fault_discipline->id)) {
            Storage::makeDirectory('public/fafd/' . $this->fault_discipline->id);
        }
        Storage::delete('public/fafd/' . $this->fault_discipline->id . '/fafd_n_solucao_' . $this->fault_discipline->number . '.pdf');
        $this->paste = false;
    }
    //pega o status do registro
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
