<?php

namespace App\Livewire\Faults;

use App\Models\Fault\SchoolFaults;
use App\Models\Fault\SecondCall;
use Livewire\Component;
use Livewire\Attributes\On;

use Livewire\WithPagination;
use App\Models\Peoples;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\Settings\Settings;
use App\Models\Settings\Companies;
use App\Traits\HandlesTmpUploads;

class SecondChance extends Component
{
    use WithPagination;
    use HandlesTmpUploads;

    public $authorizations;
    public $school_faults;
    public $id;
    public $breadcrumb = 'Autorização de 2º chamada';

    public $number;
    public $discipline_call;
    public $signature;

    public function mount(SchoolFaults $school_faults)
    {
        $this->authorizations = $school_faults->secondCall;
        $this->school_faults = $school_faults;

        if ($school_faults->companies->id) {
            $company = Companies::find($school_faults->companies->id);
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
        return view('livewire.faults.second-chance');
    }
    public function addAuthorization()
    {
        SecondCall::create([
            'active'                => 1,
            'school_faults_id'      => $this->school_faults->id,
            'code'                  => Str::uuid(),
        ]);
        $this->school_faults = $this->school_faults;
        $this->authorizations = $this->school_faults->secondCall;
    }

    public function removeAuthorization(SecondCall $second_call)
    {
        $second_call->active = 0;
        $second_call->save();
        $this->school_faults = $second_call->fault;
        $this->authorizations = $this->school_faults->secondCall;
    }
    public function printAuthorization() //Imprimir relação

    {
        // dd($this->students);
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        $config = Settings::find(1);

        $logoPath = url('storage/logos/brasao-brasil-preto-e-branco.png');

        // Crie uma instância do mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            // 'orientation'        => 'P', //[P,L]
            'format' => 'A4-P',
            'margin_left'   => 15,
            'margin_top'    => 5,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($mpdf);
        $html = view(
            'livewire.faults.second-chance-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Autorizações de 2º chamada de AP',
                'authorizations'          => $this->authorizations,
                'config'            => $config,
                'signature'            => $this->signature,
                'responsible'       => Auth::user()->name,
            ]
        )->render();


        $mpdf->SetHTMLFooter('
           <table width="100%">
               <tr>
                   <td width="66%">Impressão realizada em {DATE j/m/Y} às {DATE H:i:s}</td>
                   <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
               </tr>
           </table>');
        $mpdf->WriteHTML($html);

        // Salve o PDF temporariamente
        $file = trim('segunda_chamada_ap_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfSecond', pdfPath: $pdfPath);
    }
}
