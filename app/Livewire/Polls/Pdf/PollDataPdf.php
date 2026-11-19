<?php

namespace App\Livewire\Polls\Pdf;

use App\Models\Polls\PollOption;

use Livewire\Component;

use App\Models\Admin\Settings\Settings;
use App\Models\Polls\PollAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Traits\HandlesTmpUploads;


use Illuminate\Support\Facades\Storage;

class PollDataPdf extends Component
{
    use HandlesTmpUploads;
    public $option;
    public function mount(PollOption $option)
    {
        $this->option = $option;
    }
    public function render()
    {
        return view('livewire.polls.pdf.poll-data-pdf');
    }


    //Histórico
    public function seeData()
    {
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');
        $option = $this->option;
        // Respostas registradas nesta enquete

        $answers = PollAnswer::with('vote')
            ->where('poll_option_id', $this->option->id)
            // ->whereHas('vote', function ($query) {
            //     $query->where('poll_id', $this->pollId);
            // })
            ->get();

        $students = $answers->map(function ($answer) {
            return [
                'name' => $answer->vote->student_name,
                'number' => $answer->vote->student_number,
                'class' => $answer->vote->school_class_name,
                'voted_at' => $answer->vote->voted_at,
            ];
        })->values()->toArray();

        // dd($students);

        $config = Settings::find(1);
        $company = $student?->al_class?->classGrade?->getCompany ?? false;
        $signature = false;
        if ($company) {
            $logoPath = Storage::exists('public/companies/' . $company->id)
                ? url('storage/companies/' . $company->id . '/' . $company->code_image . '_list.png')
                : url('storage/logos-school/logo-header.png');

            $files = Storage::files('public/companies/' . $company->id . '/signature');
            if ($files) {
                $sign = explode('/', $files[0]);
                // dd($signature[4]);
                $signature = url('storage/companies/' . $company->id . '/signature/' . $sign[4]); // Nome do arquivo
            } else {
                $signature = false;
            }
        } else {
            $logoPath = url('storage/logos-school/logo-header.png');
        }

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
            'livewire.polls.pdf.poll-data-pdf-print',
            [
                'logoPath'          => $logoPath,
                'option'            => $this->option,
                'question'          => $this->option->question,
                'students'          => json_encode($students),
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
                        ' . ($company ? $company->name : '') . '<br>
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
        $file = trim('questão' . $option->id . '_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfData', pdfPath: $pdfPath);
    }
}
