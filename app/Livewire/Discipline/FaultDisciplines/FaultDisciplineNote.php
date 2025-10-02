<?php

namespace App\Livewire\Discipline\FaultDisciplines;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use App\Models\Admin\Settings\Settings;
use App\Models\Discipline\fault_discipline;
use App\Models\Discipline\FaultDiscipline;
use App\Models\Settings\Companies;
use App\Traits\HandlesPdfUploads;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

class FaultDisciplineNote extends Component
{
    use WithFileUploads;      // ⬅️ Necessário para lidar com uploads
    use HandlesPdfUploads;    // ⬅️ Sua trait personalizada

    public $uploadPdf;
    public $fafd;
    public $doc;
    public $rules;
    public $fault_discipline;
    public $paste;

    public function mount(FaultDiscipline $fault_discipline)
    {
        $this->fault_discipline = $fault_discipline;
    }
    public function render()
    {
        $this->paste = Storage::fileExists('public/fafd/' . $this->fault_discipline->id . '/fafd_n_nota_' . $this->fault_discipline->number . '.pdf');
        return view('livewire.discipline.fault-disciplines.fault-discipline-note');
    }
    //Turmas
    public function printNote()
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
        $html = view(
            'livewire.discipline.fault-disciplines.pdfs.note-pdf',
            [
                'fault_discipline'  => $this->fault_discipline,
                'config'            => $config,
                'companies'         => $companies,
                'title_postfix'     => 'NOTA DO FAFD Nº ' . $this->fault_discipline->number . '/' . $this->fault_discipline->year,
                'subtext'           => 'NOTA DO FAFD Nº ' . $this->fault_discipline->number . '/' . $this->fault_discipline->year,
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

        $this->dispatch('openPdfInNewTabNote', pdfPath: $pdfPath);
    }

    //pega o status do registro
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
