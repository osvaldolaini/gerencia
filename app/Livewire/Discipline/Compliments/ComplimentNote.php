<?php

namespace App\Livewire\Discipline\Compliments;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use App\Models\Admin\Settings\Settings;
use App\Models\Discipline\Compliments;
use App\Models\Settings\Companies;
use App\Traits\HandlesPdfUploads;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

class ComplimentNote extends Component
{
    use WithFileUploads;      // ⬅️ Necessário para lidar com uploads
    use HandlesPdfUploads;    // ⬅️ Sua trait personalizada

    public $uploadPdf;
    public $fafd;
    public $doc;
    public $rules;
    public $compliments;
    public $paste;

    public function mount(Compliments $compliments)
    {
        $this->compliments = $compliments;
    }
    public function render()
    {
        $this->paste = Storage::fileExists('public/fafd/' . $this->compliments->id . '/fafd_n_nota_' . $this->compliments->number . '.pdf');
        return view('livewire.discipline.compliments.compliment-note');
    }
    //Turmas
    public function print()
    {

        $config = Settings::find(1);
        $companies = Companies::where('active', 1)->first();
        // dd($this->compliments);
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
            'livewire.discipline.compliments.pdfs.note-pdf',
            [
                'compliments'  => $this->compliments,
                'config'            => $config,
                'companies'         => $companies,
                'title_postfix'     => 'NOTA DO ELOGIO Nº ' . $this->compliments->number . '/' . $this->compliments->year,
                'subtext'           => 'NOTA DO ELOGIO Nº ' . $this->compliments->number . '/' . $this->compliments->year,
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

    //pega o status do registro
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
