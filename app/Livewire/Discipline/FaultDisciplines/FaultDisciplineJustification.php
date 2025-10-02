<?php

namespace App\Livewire\Discipline\FaultDisciplines;

use App\Models\Discipline\FaultDiscipline;
use Livewire\Component;

use App\Models\Peoples;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use App\Models\Admin\Settings\Settings;
use App\Models\Discipline\Settings\Faults;
use App\Models\Settings\Companies;
use App\Traits\HandlesPdfUploads;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

class FaultDisciplineJustification extends Component
{
    use WithFileUploads;      // ⬅️ Necessário para lidar com uploads
    use HandlesPdfUploads;    // ⬅️ Sua trait personalizada

    public $uploadPdf;
    public $fafd;
    public $doc;
    public $rules;
    public $fault_discipline;
    public $paste;
    public $signature;

    public function mount(FaultDiscipline $fault_discipline)
    {
        $this->fault_discipline = $fault_discipline;
        if ($fault_discipline->id) {
            $this->fafd = Peoples::find($fault_discipline->id);
            $this->paste = Storage::fileExists('public/fafd/' . $this->fault_discipline->id . '/fafd_n_' . $this->fault_discipline->number . '.pdf');
            // dd($this->paste);
        }
        if ($fault_discipline->company_id) {
            $company = Companies::find($fault_discipline->company_id);
            $files = Storage::files('public/companies/' . $company->id . '/signature');
            if ($files) {
                $signature = explode('/', $files[0]);
                // dd($signature[4]);
                $this->signature = url('storage/companies/' . $company->id . '/signature/' . $signature[4]); // Nome do arquivo
            } else {
                $this->signature = false;
            }
        }
    }
    public function render()
    {
        $this->paste = Storage::fileExists('public/fafd/' . $this->fault_discipline->id . '/fafd_n_' . $this->fault_discipline->number . '.pdf');
        return view('livewire.discipline.fault-disciplines.fault-discipline-justification');
    }
    //Turmas
    public function print()
    {

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
        $allFaults = Faults::where('active', 1)->get();
        $selectedFaults = $allFaults
            ->filter(fn($case) => in_array($case->number, $this->fault_discipline->json_faults))
            ->mapWithKeys(fn($case) => [$case->number => $case->title]) // Usa 'number' como chave
            ->toArray();

        if ($this->fault_discipline->json_aggravating) {

            $selectedAggravating = collect(\App\Enums\Aggravating::cases())
                ->filter(fn($case) => in_array($case->value, $this->fault_discipline->json_aggravating))
                ->mapWithKeys(fn($case) => [$case->value => $case->label()])
                ->toArray();

            ksort($selectedAggravating); // Ordena os itens pela chave (crescente)
        } else {
            $selectedAggravating = false;
        }
        if ($this->fault_discipline->json_mitigating) {
            $selectedMitigating = collect(\App\Enums\Mitigating::cases())
                ->filter(fn($case) => in_array($case->value, $this->fault_discipline->json_mitigating))
                ->mapWithKeys(fn($case) => [$case->value => $case->label()])
                ->toArray();

            ksort($selectedMitigating); // Ordena os itens pela chave (crescente)
        } else {
            $selectedMitigating = false;
        }

        $html = view(
            'livewire.discipline.fault-disciplines.pdfs.justification-pdf',
            [
                'fault_discipline'  => $this->fault_discipline,
                'config'            => $config,
                'companies'         => $companies,
                'signature'         => $this->signature,
                'selectedFaults'    => $selectedFaults,
                'selectedMitigating'    => $selectedMitigating,
                'selectedAggravating'    => $selectedAggravating,
                'title_postfix'     => 'FAFD Nº ' . $this->fault_discipline->number . '/' . $this->fault_discipline->year,
                'subtext'           => 'FAFD Nº ' . $this->fault_discipline->number . '/' . $this->fault_discipline->year,
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

        $this->dispatch('openPdfInNewTab', pdfPath: $pdfPath);
    }


    public function changeDoc()
    {
        $this->dispatch('submitForm');
    }

    public function updated($property)
    {
        if ($property === 'uploadPdf') {
            $this->validate([
                'uploadPdf' => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            ]);

            $directory = 'public/fafd/' . $this->fault_discipline->id;
            $filename = 'fafd_n_' . $this->fault_discipline->number . '.pdf';
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
        Storage::delete('public/fafd/' . $this->fault_discipline->id . '/fafd_n_' . $this->fault_discipline->number . '.pdf');
        $this->paste = false;
    }
    //pega o status do registro
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
