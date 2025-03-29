<?php

namespace App\Livewire\Settings\SchoolBattalion;

use App\Models\Settings\Companies;
use App\Models\Settings\SchoolBattalions;
use Livewire\Component;

use App\Models\Admin\Settings\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SchoolBattalionView extends Component
{
    public $school_battalion;
    public $companies;
    public $grade;
    public function mount(SchoolBattalions $school_battalion)
    {
        $this->school_battalion = $school_battalion;
        $this->companies = Companies::where('active', 1)->get();
    }

    public function render()
    {
        return view('livewire.settings.school-battalion.school-battalion-view');
    }
    //Turmas
    public function printBattalion()
    {
        $config = Settings::find(1);

        $logoPath = Storage::exists('public/logos-school/logo-header.png')
            ? url('storage/logos-school/logo-header.png')
            : url('storage/logos/logo-pdf.png');
        // Crie uma instância do mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            // 'orientation'        => 'P', //[P,L]
            'format' => 'A4-L',
            'margin_left'   => 15,
            'margin_top'    => 15,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($mpdf);
        $html = view(
            'livewire.settings.pdf.school-battalions-pdf',
            [
                'school_battalion'  => $this->school_battalion,
                'companies'         => $this->companies,
                'responsible'       => Auth::user()->name,
            ]
        )->render();

        // Adicione o conteúdo HTML ao PDF
        $mpdf->SetHTMLHeader('
             <table width="100%">
                 <tr >
                     <td width="50%">
                         <img width="50" src="' . $logoPath . '" alt="Logo">
                     </td>
                     <td width="50%" style="text-align: right;">
                         <strong>' . $config->name . '</strong><br>
                     </td>
                 </tr>
             </table>
         ');
        $mpdf->SetHTMLFooter('
             <table width="100%">
                 <tr>
                     <td width="66%">Impressão realizada em {DATE j/m/Y} às {DATE H:i:s}</td>
                     <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
                 </tr>
             </table>');
        $mpdf->WriteHTML($html);

        // Salve o PDF temporariamente
        $file = 'batalhao_escolar_' . Str::uuid() . '.pdf';

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTab', pdfPath: $pdfPath);
    }
}
