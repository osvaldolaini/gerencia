<?php

namespace App\Livewire\Settings\SchoolClasses;

use App\Models\Settings\SchoolClasses;
use App\Models\Settings\SchoolClassesStudent;
use App\Models\Settings\SchoolClassesYears;
use App\Models\Settings\SchoolGrades;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Validation\Rule;

use Illuminate\Support\Str;

class SchoolClassesList extends Component
{
    use WithPagination;
    public $search;
    public $school_grade_id = false;
    public $breadcrumb = 'Turmas de ';
    public $modal = true;
    public $showJetModal = false;
    public $showModalForm = false;
    public $showModalStudent = false;

    public $school_classes;

    public $back = 'school-classes-years-list';

    public $rules;
    public $detail;
    public $year;
    public $id;
    public $school_classes_year_id;
    public $school_grades;
    public $class;


    public $dataTable;

    public $list_students;

    public function mount(SchoolClassesYears $school_classes_years)
    {
        if ($school_classes_years->getAttributes()) {
            $this->school_classes_year_id           = $school_classes_years->id;
            $this->year         = $school_classes_years->year;
            $this->breadcrumb .= $this->year;
        }
        // $this->school_classes = $school_classes->school_classes->where('active', 1)->sortBy('order');
        $this->school_grades = SchoolGrades::where('active', 1)->orderBy('nick', 'asc')->get();
        $this->reOrder();
        $this->loadItems();
    }
    #[On('see_excluded')]
    public function render()
    {
        return view('livewire.settings.school-classes.school-classes-list');
    }

    public function updatedSearch()
    {
        $this->loadItems();
    }
    public function select_grade($grade)
    {
        $this->school_grade_id = $grade;
        $this->reOrder();
        $this->loadItems();
    }

    private function reOrder()
    {
        $this->dataTable = SchoolClasses::where('school_classes_year_id', $this->school_classes_year_id)->orderBy('order', 'asc')->get();
        // Enumerar a coluna 'order' de 1 até o último
        foreach ($this->dataTable as $index => $item) {
            // dd()
            $item->order = $index + 1; // Atualizar a coluna 'order'
            $item->save();             // Salvar no banco de dados
        }
    }

    private function loadItems()
    {
        $this->dataTable = SchoolClasses::where('school_classes_year_id', $this->school_classes_year_id)
            ->where('school_grade_id', $this->school_grade_id)
            ->where('active', 1)
            ->orderBy('order', 'asc')->get();
        // Filtra com base no campo de busca
        $this->dataTable = collect($this->dataTable)
            ->select(
                "id",
                "code",
                "active",
                "title",
                "order",
                "practice",
                "school_classes_year_id",
            )
            ->filter(fn($item) => str_contains(strtolower($item['title']), strtolower($this->search)))
            ->values()
            ->toArray();
        // dd($this->dataTable);
    }

    #[On('atualizarOrdem')]
    public function atualizarOrdem($newOrder)
    {
        foreach ($newOrder as $index => $item) {
            $schoolClasse = SchoolClasses::find($item['id']);
            $schoolClasse->order = $index + 1;
            $schoolClasse->save();
        }

        $this->openAlert('success', 'Ordem alterada com sucesso.');

        $this->loadItems();
    }

    public function addSchoolClass()
    {
        $last = SchoolClasses::where('school_classes_year_id', $this->school_classes_year_id)
            ->where('school_grade_id', $this->school_grade_id)
            ->orderBy('order', 'desc')
            ->first();
        if ($last) {
            $order = $last->order + 1;
        } else {
            $order = 1;
        }

        SchoolClasses::create([
            'active'                 => 1,
            'order'                  => $order,
            'school_classes_year_id' => $this->school_classes_year_id,
            'school_grade_id'        => $this->school_grade_id,
            'code'                   => Str::uuid(),
            'title'                  => SchoolGrades::find($this->school_grade_id)->nick,
        ]);
        $this->reOrder();
        $this->loadItems();
    }
    //CREATE
    public function showStudents($id)
    {
        if ($this->modal) {
            $this->showModalStudent = true;
            $this->class = SchoolClasses::find($id)->title;
            $this->list_students = SchoolClassesStudent::where('active', 1)->where('school_classes_id', $id)->get();
        } else {
            redirect()->route('school_classes-create', ['courses' => $this->school_classes_year_id]);
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
            $this->school_classes = SchoolClasses::find($id);
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
        $data = SchoolClasses::where('id', $id)->first();
        $data->active = 0;
        $data->save();
        $this->loadItems();
        $this->openAlert('success', 'Registro excluido com sucesso.');

        $this->showJetModal = false;
    }
    //ACTIVE
    public function buttonActive($id)
    {
        $data = SchoolClasses::where('id', $id)->first();
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
