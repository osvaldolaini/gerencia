<?php

namespace App\Livewire\Extracurricular\StudentActivities;

use App\Models\Extracurricular\StudentActivities;
use App\Models\Peoples;
use Livewire\Component;

class StudentActivityList extends Component
{
    public $activities;
    public $student;
    public $id;

    public $showJetModal = false;
    public function mount(Peoples $student)
    {
        $this->student  =  $student;
        $this->activities   = $this->student->activities->sortByDesc('title');
    }

    public function render()
    {
        return view('livewire.extracurricular.student-activities.student-activity-list');
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
        $data = StudentActivities::where('id', $id)->first();
        $data->active = 0;
        $data->save();

        $this->openAlert('success', 'Registro excluido com sucesso.');

        $this->showJetModal = false;
    }
}
