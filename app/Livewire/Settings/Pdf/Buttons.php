<?php

namespace App\Livewire\Settings\Pdf;

use App\Models\Admin\Settings\Settings;
use App\Models\Settings\SchoolBattalions;
use App\Models\Settings\SchoolClasses;
use App\Models\Settings\SchoolGrades;
use App\Traits\HandlesTmpUploads;
use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlanilhaGrauView;

class Buttons extends Component
{

    use HandlesTmpUploads;

    public $print_classes   = false;
    public $print_classes_sex   = false;
    public $print_call      = false;
    public $print_battalion = false;
    public $print_classroom = false;
    public $print_grau = false;
    public $print_grau_plan = false;

    public $school_classes;
    public $grade;

    public $battalion_id;
    public $school_classes_year_id;
    public $company;

    public function mount($button, $year, $grade)
    {
        $this->school_classes_year_id = $year;
        $this->school_classes = SchoolClasses::where('active', 1)
            ->with(['seats'])
            ->where('school_classes_year_id', $year)
            ->where('school_grade_id', $grade)
            ->get();
        $this->grade = SchoolGrades::find($grade);

        $this->print_classes        = $button == 'print_classes' ?? true;
        $this->print_classes_sex    = $button == 'print_classes_sex' ?? true;
        $this->print_call           = $button == 'print_call' ?? true;
        $this->print_battalion      = $button == 'print_battalion' ?? true;
        $this->print_classroom      = $button == 'print_classroom' ?? true;
        $this->print_grau           = $button == 'print_grau' ?? true;
        $this->print_grau_plan      = $button == 'print_grau_plan' ?? true;

        $this->battalion_id = SchoolBattalions::where('active', 1)->first();
        $this->company = $this->grade->getCompany;
    }
    public function render()
    {
        return view('livewire.settings.pdf.buttons');
    }
    //Turmas
    public function classes()
    {
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        $config = Settings::find(1);

        $logoPath = Storage::exists('public/companies/' . $this->company->id)
            ? url('storage/companies/' . $this->company->id . '/' . $this->company->code_image . '_list.png')
            : url('storage/logos-school/logo-header.png');


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
            'livewire.settings.pdf.school-grade-pdf',
            [
                'logoPath'          => $logoPath,
                'school_classes'    => $this->school_classes,
                'grade'             => $this->grade->name,
                'config'            => $config,
                'companies'         => $this->company,
                'subtext'           => 'Turmas do ' . $this->grade->name,
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
                        ' . $this->company->name . '<br>
                        Turmas do ' . $this->grade->name . '
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
        $file = trim('chamada_' . $this->grade->name . '_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTabClasses', pdfPath: $pdfPath);
    }
    //Turmas
    public function classes_sex()
    {
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        $config = Settings::find(1);

        $logoPath = Storage::exists('public/companies/' . $this->company->id)
            ? url('storage/companies/' . $this->company->id . '/' . $this->company->code_image . '_list.png')
            : url('storage/logos-school/logo-header.png');


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
            'livewire.settings.pdf.school-classes-sex-pdf',
            [
                'logoPath'          => $logoPath,
                'school_classes'    => $this->school_classes,
                'grade'             => $this->grade->name,
                'config'            => $config,
                'companies'         => $this->company,
                'subtext'           => 'Turmas do ' . $this->grade->name,
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
                         ' . $this->company->name . '<br>
                         Turmas do ' . $this->grade->name . '
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
        $file = trim('chamada_' . $this->grade->name . '_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTabClasses', pdfPath: $pdfPath);
    }
    //PDF
    public function classroom()
    {

        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        // dd($this->school_classes);
        $config = Settings::find(1);

        $logoPath = Storage::exists('public/companies/' . $this->company->id)
            ? url('storage/companies/' . $this->company->id . '/' . $this->company->code_image . '_list.png')
            : url('storage/logos-school/logo-header.png');

        // $seats = ClassroomSeats::with('students')
        //     ->where('school_classes_id', $this->school_classes_id)
        //     ->get();
        // Crie uma instância do mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            // 'orientation'        => 'P', //[P,L]
            'format' => 'A4-' . $this->school_classes->first()->orientation,
            'margin_left'   => 15,
            'margin_top'    => 15,
            'default_font_size'  => 9,
            'default_font'  => 'arial',
        ]);
        // dd($this->school_classes->first()->seats);
        // dd($mpdf);
        $html = view(
            'livewire.settings.pdf.school-classrom-seats-pdf',
            [
                'logoPath'          => $logoPath,
                'school_classes'    => $this->school_classes,
                // 'seats'             => $seats,
                'grade'             => $this->grade->name,
                'config'            => $config,
                'companies'         => $this->company,
                'subtext'           => 'Turmas do ' . $this->grade->name,
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
                         ' . $this->company->name . '<br>
                         Turmas do ' . $this->grade->name . '
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
        $file = trim('chamada_' . $this->grade->name . '_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTabClasses', pdfPath: $pdfPath);
    }
    //Turmas
    public function grau()
    {
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        $config = Settings::find(1);

        $logoPath = Storage::exists('public/companies/' . $this->company->id)
            ? url('storage/companies/' . $this->company->id . '/' . $this->company->code_image . '_list.png')
            : url('storage/logos-school/logo-header.png');


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
            'livewire.settings.pdf.student-grau-pdf',
            [
                'logoPath'          => $logoPath,
                'school_classes'    => $this->school_classes,
                'grade'             => $this->grade,
                'config'            => $config,
                'companies'         => $this->company,
                'subtext'           => 'Comportamento do ' . $this->grade->name,
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
                         ' . $this->company->name . '<br>
                         Turmas do ' . $this->grade->name . '
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
        $file = trim('chamada_' . $this->grade->name . '_' . Str::uuid() . '.pdf');

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTabClasses', pdfPath: $pdfPath);
    }
    //Turmas
    public function grau_plan()
    {
        return Excel::download(
            new PlanilhaGrauView(
                $this->school_classes,
                $this->grade,
                $this->company,
                Settings::find(1)
            ),
            'planilha_comportamento_' . $this->grade->name . '.xlsx'
        );
    }
}
