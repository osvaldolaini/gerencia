<?php

namespace App\Livewire\StudentCorps;

use App\Models\Peoples;
use App\Models\StudentCorps\LegionOfHonor;
use Livewire\Component;
use Illuminate\Validation\Rule;

use Illuminate\Support\Str;
use Livewire\Attributes\On;

class LegionOfHonorInsert extends Component
{

    public $id;
    public $student_id;
    public $year;
    public $bi_text;
    public $bi_number;
    public $supplement_number;
    public $b_date;
    public $bi_date;
    public $local;

    public $rules;
    public $student;

    public function mount()
    {
        $this->student = '';
    }
    public function render()
    {
        return view('livewire.student-corps.legion-of-honor-insert');
    }

    public function save()
    {
        $this->rules = [
            'student_id'         => 'required|' . Rule::unique('legion_of_honors')->ignore($this->id),
            'year'               => 'required',
            'local'              => 'required',
            // 'bi_date'            => 'required',
            // 'bi_number'          => 'required',
            // 'supplement_number'  => 'required',
        ];

        $this->validate();

        LegionOfHonor::create([
            'active'                => 1,
            'student_id'            => $this->student_id,
            'year'                  => $this->year,
            'local'                 => $this->local,
            'bi_date'               => $this->bi_date,
            'bi_text'               => $this->bi_text,
            'supplement_number'     => $this->supplement_number,
            'bi_number'             => $this->bi_number,
            'code'                  => Str::uuid(),
        ]);

        $msg = 'Registro editado com sucesso.';


        $this->openAlert('success', $msg);
        $this->dispatch('closeLegionary', 'success', 'Registro criado com sucesso');
    }

    #[On('updateStudent')]
    public function addStudents($student_id)
    {
        $this->student = '';
        $student = Peoples::find($student_id);
        $this->student_id = $student_id;
        $this->student = [
            'id' => $student->id,
            'code_image' => $student->code_image,
            'number' => $student->number,
            'nick' => $student->nick,
            'sex' => $student->sex,
            'class' => ($student->al_Class ? $student->al_Class->title : ''),
        ];
        // dd($this->student);
    }

    public function removeStudents()
    {
        $this->student = '';
        $this->student_id = '';
    }

    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
