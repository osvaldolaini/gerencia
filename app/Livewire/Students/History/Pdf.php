<?php

namespace App\Livewire\Students\History;

use App\Models\Peoples;

// use App\Services\LaiGuz\TableService;
// use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;


use Illuminate\Support\Facades\Storage;

use App\Models\Admin\Settings\Settings;
use App\Traits\HandlesTmpUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Pdf extends Component
{
    use WithPagination;
    use HandlesTmpUploads;
    public $student;

    public function mount(Peoples $student)
    {
        $this->student = $student;
    }
    public function render()
    {
        return view('livewire.students.history.pdf');
    }

    public function history()
    {
        // dd($this->student);
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        $config = Settings::find(1);
        $company = $this->student?->al_class?->classGrade?->getCompany ?? false;
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


        $studentImage = Storage::exists('public/student/' . $this->student->id)
            ? url('storage/student/' . $this->student->id . '/' . $this->student->code_image . '_list.png')
            : $logoPath;

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
            'livewire.settings.pdf.student-history-pdf',
            [
                'logoPath'          => $logoPath,
                'studentImage'      => $studentImage,
                'signature'         => $signature,
                'student'           => $this->student,
                'config'            => $config,
                'companies'         => $company,
                'subtext'           => 'Aluno da ' . ($company ? $company->nick : ''),
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
        $file = trim('ficha_individual_' . $this->student->number . '_' . $this->student->nick . '_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTabRegister', pdfPath: $pdfPath);
    }
}
