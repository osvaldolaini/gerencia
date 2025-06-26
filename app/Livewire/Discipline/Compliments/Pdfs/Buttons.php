<?php

namespace App\Livewire\Discipline\Compliments\Pdfs;


use App\Models\Admin\Settings\Settings;
use App\Models\Discipline\Compliments;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

use App\Traits\HandlesTmpUploads;

class Buttons extends Component
{
    public $title;
    public $status;
    public $supplements;
    public $supplement;

    use HandlesTmpUploads;
    public function mount($status)
    {
        // dd($this->status);
        $this->status = $status;
        $this->supplements = Compliments::where('supplement_number', '!=', NULL)->pluck('supplement_number');
    }

    public function render()
    {
        return view('livewire.discipline.compliments.pdfs.buttons');
    }
    //Todas
    public function allData()
    {
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        $config = Settings::find(1);
        $logoPath = url('storage/logos-school/logo-header.png');


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
            'livewire.discipline.compliments.pdfs.status-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Todas',
                'data'              => Compliments::orderBy('number')->get(),
                'config'            => $config,
                'responsible'       => Auth::user()->name,
            ]
        )->render();

        // Adicione o conteúdo HTML ao PDF
        $mpdf->SetHTMLHeader('
             <table width="100%" style="padding-top:20px;>
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
        $file = trim('todas_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');
        $this->dispatch('openPdfInNewTabClasses', pdfPath: $pdfPath);
    }

    //Solução
    public function solution()
    {
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        $config = Settings::find(1);

        $logoPath = url('storage/logos-school/logo-header.png');


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
            'livewire.discipline.compliments.pdfs.status-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Solução',
                'data'              => Compliments::where('active', 1)
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
    //Publicação
    public function publi()
    {
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        $config = Settings::find(1);

        $logoPath = url('storage/logos-school/logo-header.png');


        // Crie uma instância do mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            // 'orientation'        => 'P', //[P,L]
            'format' => 'A4-P',
            'margin_left'   => 15,
            'margin_top'    => 25,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($mpdf);
        $html = view(
            'livewire.discipline.compliments.pdfs.status-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Publicação',
                'data'              => Compliments::where('active', 1)
                    ->where('solution_date', '!=', NULL)
                    ->where('bi_date', NULL)
                    ->orderBy('fact_date', 'asc')
                    ->get(),
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
        $file = trim('aguardando_publicacao_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTabClasses', pdfPath: $pdfPath);
    }
    //Aditamentos
    public function published()
    {
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');
        $number = $this->supplement;
        $this->supplement = '';
        $config = Settings::find(1);

        $logoPath = url('storage/logos-school/logo-header.png');

        // Crie uma instância do mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            // 'orientation'        => 'P', //[P,L]
            'format' => 'A4-P',
            'margin_left'   => 15,
            'margin_top'    => 25,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($mpdf);
        $html = view(
            'livewire.discipline.compliments.pdfs.status-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Aditamento',
                'data'              => Compliments::where('active', 1)
                    ->where('supplement_number', $number)
                    ->orderBy('fact_date', 'asc')
                    ->get(),
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
        $file = trim('publicados_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTabClasses', pdfPath: $pdfPath);
    }
}
