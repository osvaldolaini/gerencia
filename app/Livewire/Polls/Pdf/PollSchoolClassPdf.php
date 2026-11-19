<?php

namespace App\Livewire\Polls\Pdf;

use App\Models\Polls\PollOption;

use Livewire\Component;

use App\Models\Admin\Settings\Settings;
use App\Models\Peoples;
use App\Models\Polls\Poll;
use App\Models\Polls\PollAnswer;
use App\Models\Polls\PollVote;
use App\Models\Settings\SchoolClasses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Traits\HandlesTmpUploads;


use Illuminate\Support\Facades\Storage;

class PollSchoolClassPdf extends Component
{
    use HandlesTmpUploads;
    public $class;
    public $poll;

    public function mount($class, Poll $poll)
    {
        $this->class = SchoolClasses::find($class);
        $this->poll = $poll;
    }
    public function render()
    {
        return view('livewire.polls.pdf.poll-school-class-pdf');
    }

    //Histórico
    public function seeSchoolClass()
    {
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        $classId = $this->class->id;

        $votedStudents = PollVote::where('poll_id', $this->poll->id)
            ->where('school_class_id', $classId)
            ->pluck('people_id')
            ->toArray();


        $students = $this->class->studentsPivot
            ->map(function ($student) use ($votedStudents) {
                return [
                    'id' => $student->students->id,
                    'number' => $student->students->number,
                    'name' => $student->students->name,
                    'status' => in_array($student->students->id, $votedStudents)
                        ? 'Votou'
                        : 'Não votou',
                ];
            })
            ->values()
            ->toArray();

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
            'livewire.polls.pdf.poll-school-class-pdf-print',
            [
                'logoPath'          => $logoPath,
                'class'             => $this->class,
                'poll'              => $this->poll,
                'students'          => $students,
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
        $file = trim('alunos_da_turma' . $this->class->title . '_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');
        $this->dispatch('openPdfData', pdfPath: $pdfPath);
    }
}
