<?php

namespace App\Livewire\Discipline\FaultDisciplines\Pdfs;

use App\Models\Admin\Settings\Settings;
use App\Models\Discipline\FaultDiscipline;
use App\Models\Settings\Companies;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

use App\Traits\HandlesTmpUploads;
use Livewire\Attributes\On;

class Buttons extends Component
{
    public $title;
    public $status;
    public $supplements;
    public $supplement;
    public $years;
    public $year;
    public $companyId;
    public $companies;

    use HandlesTmpUploads;
    public function mount($status)
    {
        $this->year = date('Y');
        $this->status = $status;
        $this->companies = Companies::where('active', 1)->get();
        $this->companyId = 'all';

        // dd($this->year);

        $this->years = ['2026', '2025'];
    }

    public function updatedCompanyId($value)
    {
        $this->dispatch('company-selected', companyId: $value);
    }

    #[On('company-selected')]
    public function companySelected($companyId)
    {
        // $companyId terá o valor selecionado
        $this->companyId = $companyId;
        // dd($companyId);
    }

    public function render()
    {
        $this->supplements = FaultDiscipline::where('year', $this->year)
            ->whereNotNull('supplement_number')
            ->distinct()
            ->orderBy('supplement_number', 'desc') // ou 'desc' para ordem decrescente
            ->pluck('supplement_number');

        return view('livewire.discipline.fault-disciplines.pdfs.buttons');
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
        $query = FaultDiscipline::where('active', 1)
            ->where('year', $this->year)->orderByDesc('number');

        if ($this->companyId !== 'all') {
            $query->where('company_id', $this->companyId);
        }
        // dd($this->companyId, $query->get());
        $html = view(
            'livewire.discipline.fault-disciplines.pdfs.status-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Todas',
                'data'              => $query->get(),
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
        // $mpdf->WriteHTML($html);

        // 🔹 AQUI: Divide o HTML em partes menores antes de enviar ao mPDF
        ini_set("pcre.backtrack_limit", "10000000"); // aumenta o limite, só pra garantir
        ini_set("pcre.recursion_limit", "10000000");

        $chunks = str_split($html, 50000); // divide em blocos de 50 mil caracteres
        foreach ($chunks as $chunk) {
            $mpdf->WriteHTML($chunk);
        }

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
    //Justificativa
    public function justify()
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
            'margin_top'    => 15,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($mpdf);

        // dd($this->companyId);
        $query = FaultDiscipline::where('active', 1)
            ->whereNull('justification_date');


        if ($this->companyId !== 'all') {
            $query->where('company_id', $this->companyId);
        }
        $html = view(
            'livewire.discipline.fault-disciplines.pdfs.status-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Justificativa',
                'data'              => $query->get(),
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
            'format' => 'A4-P',
            'margin_left'   => 15,
            'margin_top'    => 15,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($mpdf);
        $query = FaultDiscipline::where('active', 1)
            ->where('justification_date', '!=', NULL)
            ->where('solution_date', NULL);
        if ($this->companyId !== 'all') {
            $query->where('company_id', $this->companyId);
        }
        $html = view(
            'livewire.discipline.fault-disciplines.pdfs.status-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Solução',
                'data'              => $query->get(),
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

        $query = FaultDiscipline::where('active', 1)
            ->where('justification_date', '!=', NULL)
            ->where('solution_date', '!=', NULL)
            ->where('bi_date', NULL)
            // ->where('bi_number', NULL)
            ->where('decision', '!=', NULL)
            ->where('decision', '!=', 'fo')
            ->where('decision', '!=', 'justificado')
            ->orderBy('decision', 'asc')
            ->orderBy('fact_date', 'asc');

        if ($this->companyId !== 'all') {
            $query->where('company_id', $this->companyId);
        }
        $html = view(
            'livewire.discipline.fault-disciplines.pdfs.status-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Publicação',
                'data'              => $query->get(),
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

        $query = FaultDiscipline::where('active', 1)
            ->where('year', $this->year)
            ->where('active', 1)
            ->where('supplement_number', $number)
            ->where('decision', '!=', 'fo')
            ->where('decision', '!=', 'justificado')
            ->orderBy('decision', 'asc')
            ->orderBy('fact_date', 'asc');

        if ($this->companyId !== 'all') {
            $query->where('company_id', $this->companyId);
        }
        $html = view(
            'livewire.discipline.fault-disciplines.pdfs.status-pdf',
            [
                'logoPath'          => $logoPath,
                'title'             => 'Aditamento',
                'data'              => $query->get(),
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
