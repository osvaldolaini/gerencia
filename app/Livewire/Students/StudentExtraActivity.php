<?php

namespace App\Livewire\Students;

use App\Models\Extracurricular\ExtraActivities;
use App\Models\Extracurricular\StudentActivities;
use App\Models\Peoples;
use Livewire\Component;

class StudentExtraActivity extends Component
{
    public $studentActivities;
    public $student;
    public $id;

    public $showJetModal = false;
    public $showModalForm = false;

    public $activities;
    public $gip = 0;
    public function mount(Peoples $student)
    {
        $this->activities = ExtraActivities::where("active", 1)->orderBy('title', 'asc')->get();
        $this->student  =  $student;
        $this->studentActivities   = $this->student->activities->where('active', 1)->sortByDesc('title');
    }

    public function render()
    {
        return view('livewire.students.student-extra-activity');
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

    //CREATE
    public function showNewActivity()
    {
        $this->showModalForm = true;
    }
    public function addActivity()
    {
        StudentActivities::updateOrCreate([
            'student_id'      => $this->students->id,
            'extra_activities_id' => $this->extra_activities_id,
        ], [
            'active'         => 1,
            'gip'            => $this->gip,
        ]);
        $this->showJetModal = true;
        $this->openAlert('success', 'Inclusão na atividade realizada com sucesso');
    }
    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
