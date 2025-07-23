<?php

namespace App\Livewire\Charts;

use App\Models\Settings\SchoolClassesStudent;
use App\Models\Settings\SchoolGrades;
use DateTime;
use Livewire\Component;

class Sex extends Component
{
    public $grades;
    public $school_classes_year_id;

    public $labels;
    public $color;
    public $data;

    public function mount(SchoolGrades $school_grade, $school_classes_year_id)
    {
        $this->grades = $school_grade;
        $this->school_classes_year_id = $school_classes_year_id;
    }
    public function render()
    {
        $this->chart();
        return view('livewire.charts.sex');
    }
    public function chart()
    {
        // Obtém os IDs das classes da grade
        $classIds = $this->grades->getClasses->pluck('id')->toArray();

        // Busca os estudantes ativos do ano letivo e classes específicas
        $students = SchoolClassesStudent::where('active', 1)
            ->where('school_classes_year_id', $this->school_classes_year_id)
            ->whereIn('school_classes_id', $classIds)
            ->get();

        // Contadores
        $maleCount = 0;
        $femaleCount = 0;

        // Conta quantos estudantes são do sexo M e F
        foreach ($students as $student) {
            if ($student?->students->sex == 'F') {
                $femaleCount++;
            } elseif ($student?->students->sex == 'M') {
                $maleCount++;
            }
        }

        $total = $students->count();

        // $this->data = [
        //     $maleCount
        // ];

        // Calcula a porcentagem
        $femalePercent = $total > 0 ? $femaleCount / $total : 0;
        $malePercent = $total > 0 ? $maleCount / $total : 0;

        // Monta as arrays de dados
        $this->labels = ['M', 'F'];
        $this->data = [
            number_format($malePercent * 100, 0, '.', ''),

            number_format($femalePercent * 100, 0, '.', ''), // multiplicado por 100 para percentual
        ];
    }
}
