<?php

namespace App\Livewire\Discipline\FaultDisciplines\Pdfs;

use App\Models\Admin\Settings\Settings;
use App\Models\Discipline\FaultDiscipline;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

class Buttons extends Component
{
    public $title;

    public function render()
    {
        return view('livewire.discipline.fault-disciplines.pdfs.buttons');
    }
    //Justificativa
    public function justify()
    {
        $config = Settings::find(1);

        $logoPath = url('storage/logos-school/logo-header.png');


        // Crie uma instância do mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            // 'orientation'        => 'P', //[P,L]
            'format' => 'A4-P',
            'margin_left'   => 15,
            'margin_top'    => 15,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($mpdf);
        $html = view(
            'livewire.discipline.fault-disciplines.pdfs.status-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Justificativa',
                'data'              => FaultDiscipline::where('active', 1)->where('justification_date', NULL)->get(),
                'config'            => $config,
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
        $file = trim('aguardando_justificativa_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTabClasses', pdfPath: $pdfPath);
    }
    //Justificativa
    public function solution()
    {
        $config = Settings::find(1);

        $logoPath = url('storage/logos-school/logo-header.png');


        // Crie uma instância do mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            // 'orientation'        => 'P', //[P,L]
            'format' => 'A4-P',
            'margin_left'   => 15,
            'margin_top'    => 15,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($mpdf);
        $html = view(
            'livewire.discipline.fault-disciplines.pdfs.status-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Solução',
                'data'              => FaultDiscipline::where('active', 1)
                    ->where('justification_date', '!=', NULL)
                    ->where('solution_date', NULL)->get(),
                'config'            => $config,
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
        $file = trim('aguardando_justificativa_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTabClasses', pdfPath: $pdfPath);
    }
}
