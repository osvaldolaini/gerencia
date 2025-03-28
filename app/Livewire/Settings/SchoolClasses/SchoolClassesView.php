<?php

namespace App\Livewire\Settings\SchoolClasses;

use App\Models\Admin\Settings\Settings;
use App\Models\Settings\Companies;
use App\Models\Settings\SchoolClasses;
use App\Models\Settings\SchoolGrades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;



use Illuminate\Support\Str;

class SchoolClassesView extends Component
{
    public $company;
    public $id;
    public $classes;
    public $print;
    public $title;

    public function mount(SchoolGrades $school_grades)
    {
        if ($school_grades->getAttributes()) {
            $this->title    = $school_grades->name;
            $this->id      = $school_grades->id;
            $this->company = $school_grades->getCompany;
            $this->classes = $school_grades->getClasses;
            $this->print = $school_grades->getClasses->pluck('id')->toArray();
        }
    }
    public function render()
    {
        return view('livewire.settings.school-classes.school-classes-view');
    }
    public function changeClass($id, $value)
    {
        if (in_array($value, $this->print)) {
            unset($this->print[$id]);
        } else {
            $this->print[$id] = $value; // Reinsere no índice 1
        }
    }
    //Turmas
    public function printClasses()
    {
        $school_classes = SchoolClasses::whereIn('id', $this->print)->get();
        // dd($school_classes);
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
            'livewire.settings.pdf.school-classes-pdf',
            [
                'logoPath'          => $logoPath,
                'school_classes'    => $school_classes,
                'grade'             => $this->title,
                'config'            => $config,
                'companies'         => $this->company,
                'title_postfix'     => 'Turmas do ' . $this->company,
                'subtext'           => 'Turmas do ' . $this->company,
                'responsible'       => Auth::user()->name,
            ]
        )->render();

        // Adicione o conteúdo HTML ao PDF
        $mpdf->SetHTMLHeader('
        <table width="100%">
            <tr >
                <td width="22%">
                    <img width="50" src="' . $logoPath . '" alt="Logo">
                </td>
                <td width="25%" style="text-align: right;">
                    <strong>' . $config->name . '</strong><br>
                    ' . $this->company->name . '<br>
                    Turmas do ' . $this->title . '
                </td>
                 <td width="6%">

                </td>

                <td width="22%">
                    <img width="50" src="' . $logoPath . '" alt="Logo">
                </td>
                <td width="25%" style="text-align: right;">
                    <strong>' . $config->name . '</strong><br>
                    ' . $this->company->name . '<br>
                    Turmas do ' . $this->title . '
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
        $file = 'chamada_' . $this->title . '_' . Str::uuid() . '.pdf';
        $down = storage_path('livewire-tmp/' . $file);
        $pdfPath = url('storage/livewire-tmp/' . $file);
        // dd($file);
        // $mpdf->Output($file, '');
        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTab', pdfPath: $pdfPath);
    }
}
