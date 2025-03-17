<?php

namespace App\Livewire\Settings\Pdf;

use App\Models\Admin\Settings\Settings;
use App\Models\Settings\Companies;
use App\Models\Settings\SchoolBattalions;
use App\Models\Settings\SchoolClasses;
use App\Models\Settings\SchoolClassesStudent;
use App\Models\Settings\SchoolGrades;
use Livewire\Component;

use Illuminate\Support\Facades\Auth;

class Buttons extends Component
{
    public $print_classes   = false;
    public $print_call      = false;
    public $print_battalion = false;

    public $school_classes;
    public $grade;

    public $battalion_id;

    public function mount($button, $year, $grade)
    {
        $this->school_classes = SchoolClasses::where('active', 1)
            ->where('school_classes_year_id', $year)
            ->where('school_grade_id', $grade)
            ->get();
        $this->grade = SchoolGrades::find($grade);
        $this->print_classes    = $button == 'print_classes' ?? true;
        $this->print_call       = $button == 'print_call' ?? true;
        $this->print_battalion  = $button == 'print_battalion' ?? true;

        $this->battalion_id = SchoolBattalions::where('active', 1)->first();
    }
    public function render()
    {
        return view('livewire.settings.pdf.buttons');
    }
    //Turmas
    public function classes()
    {
        $school_classes = $this->school_classes;
        $config = Settings::find(1);
        $companies = Companies::where('active', 1)->first();
        // Crie uma instância do mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            // 'orientation'        => 'P', //[P,L]
            'format' => 'A4-L',
            'margin_left'   => 10,
            'margin_top'    => 10,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($mpdf);

        // Renderize a view do Livewire
        $html = view(
            'livewire.settings.pdf.school-classes-pdf',
            [
                'school_classes'    => $school_classes,
                'grade'             => $this->grade->name,
                'config'            => $config,
                'companies'         => $companies,
                'title_postfix'     => 'Comprovante',
                'subtext'           => 'Turmas do ' . $this->grade->name,
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

        // Salve o PDF temporariamente
        $down = storage_path('app/public/livewire-tmp/recibo.pdf');
        $pdfPath = url('storage/livewire-tmp/recibo.pdf');

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTab', pdfPath: $pdfPath);
    }
}
