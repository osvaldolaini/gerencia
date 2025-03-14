<?php

namespace App\Livewire\Settings\SchoolBattalionStudents;

use App\Models\Settings\SchoolBattalions;
use App\Models\Settings\SchoolBattalionStudents;
use App\Models\Settings\SchoolGrades;
use Livewire\Component;

use Livewire\Attributes\On;
use Livewire\WithPagination;

use App\Enums\Rank;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SchoolBattalionStudentList extends Component
{
    use WithPagination;
    public $search;
    public $school_grade_id = false;
    public $breadcrumb = 'Alunos do ';
    public $modal = true;
    public $showJetModal = false;
    public $showModalForm = false;
    public $showModalStudent = false;

    public $school_classes;

    public $school_battalions;
    public $school_grades;
    public $companies;

    public $back = 'school-battalion-students-grade';

    public $rules;
    public $detail;
    public $year;
    public $id;
    public $school_battalion_student;
    public $class;

    public $dataTables;
    public $dataTable;

    public $list_students;

    public function mount(SchoolBattalions $school_battalions, SchoolGrades $school_grades)
    {
        $this->school_battalions = $school_battalions;
        $this->school_grades = $school_grades;
        $this->companies = $this->school_grades->company->id;
        $this->breadcrumb .= $this->school_grades->name;
        // $this->school_classes = $school_classes->school_classes->where('active', 1)->sortBy('order');
        // $this->school_grades = SchoolGrades::where('active', 1)->orderBy('nick', 'asc')->get();
        $this->loadItems();
        // dd($this->dataTables);
    }


    public function render()
    {
        return view('livewire.settings.school-battalion-students.school-battalion-student-list');
    }

    // public function updatedSearch()
    // {
    //     $this->loadItems();
    // }
    // public function select_grade($grade)
    // {
    //     $this->school_grade_id = $grade;
    //     $this->reOrder();
    //     $this->loadItems();
    // }

    #[On('updateItens')]
    public function reOrder()
    {
        $this->dataTables = SchoolBattalionStudents::select(
            "id",
            "code",
            "active",
            "people_id",
            "order",
            "school_battalions_id",
            "school_grades_id",
        )
            ->where('school_battalions_id', $this->school_battalions->id)
            ->where('school_grades_id', $this->school_grades->id)
            ->where('active', 1)
            ->orderBy('order', 'asc')->get();
        // Enumerar a coluna 'order' de 1 até o último

        foreach ($this->dataTables as $index => $item) {
            // dd()
            $item->order = $index + 1; // Atualizar a coluna 'order'
            $item->save();             // Salvar no banco de dados
        }
        $this->loadItems();
    }

    private function loadItems()
    {
        $this->dataTables = SchoolBattalionStudents::select(
            "id",
            "posto_grad",
            "code",
            "active",
            "people_id",
            "order",
            "school_battalions_id",
            "school_grades_id",
        )
            ->where('school_battalions_id', $this->school_battalions->id)
            ->where('school_grades_id', $this->school_grades->id)
            ->where('active', 1)
            ->orderBy('order', 'asc')->get();

        $this->dataTable = [];
        foreach ($this->dataTables as $value) {
            $this->dataTable[] = [
                "active" => $value->active,
                "posto_grad" => ($value->posto_grad ? Rank::fromDb($value->posto_grad)->label() : 'Patente'),
                // 'image' => $value->posto_grad ? Rank::fromDb($value->posto_grad)?->image() : Storage::url('ranks/fundo/default.png'),
                'image' => $value->posto_grad ? Rank::fromDb($value->posto_grad)?->imageBg() : Storage::url('ranks/fundo/default.png'),
                "order" => $value->order,
                "id" => $value->id,
                "code" => $value->code,
                "nick" => ($value->people_id ? $value->students->setTitle() : ''),
                "name" => ($value->people_id ? $value->students->name : ''),
                "number" => ($value->people_id ? $value->students->number : '')
            ];
        };
        // dd($this->dataTable);
    }

    #[On('atualizarOrdem')]
    public function atualizarOrdem($newOrder)
    {
        foreach ($newOrder as $index => $item) {
            $schoolClasse = SchoolBattalionStudents::find($item['id']);
            $schoolClasse->order = $index + 1;
            $schoolClasse->save();
        }

        $this->openAlert('success', 'Ordem alterada com sucesso.');

        $this->loadItems();
    }

    public function addSchoolClass()
    {
        $last = SchoolBattalionStudents::where('school_grades_id', $this->school_grades->id)
            ->where('school_battalions_id', $this->school_battalions)
            ->orderBy('order', 'desc')
            ->first();
        if ($last) {
            $order = $last->order + 1;
        } else {
            $order = 1;
        }

        SchoolBattalionStudents::create([
            'active'                 => 1,
            'order'                  => $order,
            'school_battalions_id'   => $this->school_battalions->id,
            'school_grades_id'       => $this->school_grades->id,
            'code'                   => Str::uuid(),
            // 'title'                  => SchoolGrades::find($this->school_grade_id)->nick,
        ]);
        $this->reOrder();
        $this->loadItems();
        $this->openAlert('success', 'Registro inserido com sucesso.');
    }
    //CREATE
    public function showStudents($id)
    {
        if ($this->modal) {
            $this->showModalStudent = true;
            $this->class = SchoolBattalionStudents::find($id)->title;
            $this->list_students = SchoolBattalionStudents::where('active', 1)->where('school_grades_id', $this->school_grades->id)
                ->where('school_battalions_id', $this->school_battalions)->get();
        }
    }
    #[On('closeModal')]
    public function closeModal()
    {
        $this->showModalForm = false;
    }
    //Update
    public function showUpdate($id)
    {
        if ($this->modal) {
            $this->showModalForm = true;
            $this->school_battalion_student = SchoolBattalionStudents::find($id);
        } else {
            redirect()->route('school-classes-edit', ['school_classes' => $id]);
        }
    }
    public function addStudent($id)
    {
        redirect()->route('school-classes-students', ['school_classes' => $id]);
    }

    //DELETE
    public function showModalDelete($id)
    {
        $this->showJetModal = true;
        if (isset($id)) {
            $this->id = $id;
        } else {
            $this->id = '';
        }
    }
    public function delete($id)
    {
        $data = SchoolBattalionStudents::find($id);
        $data->delete();
        $this->loadItems();
        $this->openAlert('success', 'Registro excluido com sucesso.');

        $this->showJetModal = false;
    }
    //ACTIVE
    public function buttonActive($id)
    {
        $data = SchoolBattalionStudents::where('id', $id)->first();
        if ($data->active == 1) {
            $data->active = 0;
            $data->save();
        } else {
            $data->active = 1;
            $data->save();
        }

        $this->loadItems();
        $this->openAlert('success', 'Registro atualizado com sucesso.');
    }

    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
