<?php

namespace App\Livewire\Settings\SchoolClassroomSeats;

use App\Models\Settings\ClassroomSeats;
use App\Models\Settings\SchoolClasses;
use Livewire\Attributes\On;
use Livewire\Component;

use App\Models\Peoples;
use App\Models\Settings\SchoolClassesYears;


use App\Models\Admin\Settings\Settings;
use App\Traits\HandlesTmpUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;

class SchoolClassroomSeatForm extends Component
{

    use HandlesTmpUploads;
    public $breadcrumb = 'Turma: ';

    public $school_classes;
    //Fields
    public $school_classes_id;
    public $rows;
    public $columns;
    public $door_side;


    public $title;
    public $year;
    public $otherClasses;

    public $modalSearch = false;
    public $inputSearch;
    public $results;
    public $people;
    public $field;

    public $selectColumn;
    public $selectRow;

    public $seats; // Collection de posições com info do aluno

    public function mount(SchoolClasses $school_classes)
    {
        if ($school_classes->getAttributes()) {
            $school_classes_year_id = $school_classes->classYears->id;
            $this->otherClasses = SchoolClassesYears::find($school_classes_year_id)->classes
                ->where('school_grade_id', $school_classes->school_grade_id);

            $this->title        = $school_classes->title;
            $this->year         = $school_classes->school_classes_year_id;
            $this->school_classes = $school_classes;

            $this->school_classes_id = $school_classes->id;
            $this->field = $school_classes->school_grade_id;
            $this->rows = $school_classes->rows;
            $this->columns = $school_classes->columns;
            $this->door_side = $school_classes->door_side;
            $this->breadcrumb .= $school_classes->title . ' / ' . $school_classes->classYears->year;
        }
    }

    public function render()
    {
        if ($this->inputSearch != '') {
            if ($this->field) {
                $pluckStudents = [];

                $pluckStudents = $this->school_classes->studentsPivot->pluck('people_id')->toArray();
                $this->results = Peoples::select('id', 'name', 'number', 'nick', 'sex', 'logo_path')
                    ->where('nick', 'LIKE', '%' . $this->inputSearch . '%')
                    ->whereIn('id', $pluckStudents)
                    ->orwhere('number', 'LIKE', '%' . $this->inputSearch . '%')
                    ->where('type', 1)
                    ->orderBy('nick', 'asc')
                    ->where('active', 1)
                    ->limit(5)
                    ->get();
            }
        }
        $this->seats = ClassroomSeats::with('students')
            ->where('school_classes_id', $this->school_classes_id)
            ->get();
        // dd($this->seats);

        return view('livewire.settings.school-classroom-seats.school-classroom-seat-form');
    }
    #[On('resetSeats')]
    public function resetSeats()
    {
        $school_classes = SchoolClasses::find($this->school_classes_id);

        $this->rows = $school_classes->rows;
        $this->columns = $school_classes->columns;
        $this->door_side = $school_classes->door_side;
        $this->seats = ClassroomSeats::with('students')
            ->where('school_classes_id', $this->school_classes_id)
            ->get();
        // dd($this->seats);
    }
    public function openModalSearch($r, $c)
    {
        $this->modalSearch = true;
        $this->selectColumn = $c;
        $this->selectRow = $r;
    }
    public function selectPeople($id)
    {
        $people = Peoples::find($id);
        $this->people = $people->setTitle();

        $this->inputSearch = '';
        $this->results = '';

        $this->modalSearch = false;

        ClassroomSeats::updateOrCreate([
            'column'            => $this->selectColumn,
            'row'               => $this->selectRow,
            'school_classes_id' => $this->school_classes_id,
        ], [
            'people_id' => $id,
        ]);
    }
    public function remove(ClassroomSeats $seats)
    {
        $seats->delete();
        $msg = 'Removido com sucesso.';

        $this->dispatch('resetSeats');
        $this->openAlert('success', $msg);
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }

    //PDF
    public function classroom(SchoolClasses $school_classes)
    {
        //Apagar itens do diretório temporário
        $this->clearTmpDirectory('public/pdf-tmp');

        // dd($this->school_classes);
        $config = Settings::find(1);

        $company = $school_classes->classGrade->getCompany;

        $logoPath = Storage::exists('public/companies/' . $company->id)
            ? url('storage/companies/' . $company->id . '/' . $company->code_image . '_list.png')
            : url('storage/logos-school/logo-header.png');

        // $seats = ClassroomSeats::with('students')
        //     ->where('school_classes_id', $this->school_classes_id)
        //     ->get();
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
        // dd($this->school_classes->first()->seats);
        // dd($mpdf);
        $html = view(
            'livewire.settings.pdf.school-classrom-seats-pdf',
            [
                'logoPath'          => $logoPath,
                'school_classes'    => $school_classes,
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
}
