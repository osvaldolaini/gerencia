<?php

namespace App\Livewire\Faults\Panel;


use App\Models\Admin\Settings\Settings;
use App\Models\Fault\SchoolFaults;
use App\Models\Settings\Companies;
use App\Models\Settings\SchoolClasses;
use App\Models\Settings\SchoolClassesYears;
use App\Models\Settings\SchoolGrades;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Illuminate\Support\Str;
use Livewire\Component;

class SchoolFaultsFilter extends Component
{
    public $student_id;
    public $qtd;
    public $companies_id;
    public $school_grades_id;
    public $school_classes_id;
    public $school_classes_year_id;
    public $date;
    public $date_start;
    public $date_end;
    public $justified;

    public $companies = [];
    public $grades = [];
    public $classes = [];
    public $students = [];

    public function mount()
    {
        $companiesAccess = auth()->user()->json_companies;
        if (in_array('all', $companiesAccess)) {
            $this->companies = Companies::where('active', 1)->get();
        } else {
            $this->companies = Companies::where('active', 1)->whereIn('id', $companiesAccess)->get();
        }
    }

    public function updated($property)
    {
        if ($property === 'companies_id') {
            $this->grades = Companies::find($this->companies_id)?->grade?->sortBy('nick') ?? collect();
            $this->students = [];
            $this->dispatch('removeAll');
        }

        if ($property === 'school_grades_id') {
            $this->classes = SchoolGrades::find($this->school_grades_id)?->getClasses?->sortBy('order') ?? collect();
            $this->students = [];
            $this->dispatch('removeAll');
        }

        if ($property === 'school_classes_id') {
            $this->school_classes_year_id = SchoolClassesYears::where('active', 1)->first()?->id;
            $this->students = SchoolClasses::find($this->school_classes_id)?->students ?? collect();
            $this->dispatch('removeAll');
        }
    }

    #[On('updateStudent')]
    public function updateStudent($id)
    {
        $this->student_id = $id;
    }
    public function render()
    {
        $startOfYear = now()->startOfYear()->toDateString();
        $today = now()->toDateString();

        $dateStart = $this->date_start ?: $startOfYear;
        $dateEnd = $this->date_end ?: $today;

        // Coleta as faltas em ordem crescente para calcular acumulado
        $faultsOrdered = SchoolFaults::query()
            ->when($this->student_id, fn($q) => $q->where('student_id', $this->student_id))
            ->when($this->qtd, fn($q) => $q->where('qtd', $this->qtd))
            ->when($this->companies_id, fn($q) => $q->where('companies_id', $this->companies_id))
            ->when($this->school_grades_id, fn($q) => $q->where('school_grades_id', $this->school_grades_id))
            ->when($this->school_classes_id, fn($q) => $q->where('school_classes_id', $this->school_classes_id))
            ->whereBetween('date', [$dateStart, $dateEnd])
            ->with(['students', 'companies', 'grades', 'class', 'class_year'])
            ->orderBy('date') // crescente para somar corretamente
            ->get();

        // Calcula o acumulado
        $acumulados = [];
        foreach ($faultsOrdered as $fault) {
            $studentId = $fault->student_id;
            $acumulados[$studentId] = ($acumulados[$studentId] ?? 0) + $fault->qtd;
            $fault->acumulado = $acumulados[$studentId];
        }

        // Agora reordena para exibir decrescente
        $faults = $faultsOrdered->sortByDesc('date')->values();

        return view('livewire.faults.panel.school-faults-filter', [
            'faults' => $faults,
        ]);
    }
    public function exportPdf()
    {
        $startOfYear = now()->startOfYear()->toDateString();
        $today = now()->toDateString();

        $dateStart = $this->date_start ?: $startOfYear;
        $dateEnd = $this->date_end ?: $today;

        // Coleta as faltas em ordem crescente para calcular acumulado
        $faultsOrdered = SchoolFaults::query()
            ->when($this->student_id, fn($q) => $q->where('student_id', $this->student_id))
            ->when($this->qtd, fn($q) => $q->where('qtd', $this->qtd))
            ->when($this->companies_id, fn($q) => $q->where('companies_id', $this->companies_id))
            ->when($this->school_grades_id, fn($q) => $q->where('school_grades_id', $this->school_grades_id))
            ->when($this->school_classes_id, fn($q) => $q->where('school_classes_id', $this->school_classes_id))
            ->whereBetween('date', [$dateStart, $dateEnd])
            ->with(['students', 'companies', 'grades', 'class', 'class_year'])
            ->orderBy('date') // crescente para somar corretamente
            ->get();

        // Calcula o acumulado
        $acumulados = [];
        foreach ($faultsOrdered as $fault) {
            $studentId = $fault->student_id;
            $acumulados[$studentId] = ($acumulados[$studentId] ?? 0) + $fault->qtd;
            $fault->acumulado = $acumulados[$studentId];
        }

        // Agora reordena para exibir decrescente
        $faults = $faultsOrdered->sortByDesc('date')->values();

        // dd($school_classes);
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

        // dd($faults);
        $html = view(
            'livewire.settings.pdf.faults-report-pdf',
            [
                'faults' => $faults,
                'dateStart' => $dateStart,
                'dateEnd' => $dateEnd,
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
        $file = 'relatório_faltas' . Str::uuid() . '.pdf';

        if (!is_dir(storage_path('app/public/pdf-tmp'))) {
            mkdir(storage_path('app/public/pdf-tmp'), 0775, true); // Cria o diretório, incluindo os subdiretórios, se necessário
        }

        $down = storage_path('app/public/pdf-tmp/' . $file);
        $pdfPath = url('storage/pdf-tmp/' . $file);

        $mpdf->Output($down, 'F');

        $this->dispatch('openPdfInNewTab', pdfPath: $pdfPath);
    }
}
