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
    public $extra_activities_id;
    public function mount(Peoples $student)
    {
        $this->activities = ExtraActivities::where("active", 1)->orderBy('title', 'asc')->get();
        $this->student  =  $student;
        $this->studentActivities = $this->student->activities->where('active', 1)->sortByDesc('title');
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
        $data->gip = 0;
        $data->save();
        $this->studentActivities   = $this->student->activities->where('active', 1)->sortByDesc('title');
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
        $arrray = [];
        if ($this->studentActivities->count() > 0) {
            $arrray = $this->studentActivities->pluck('extra_activities_id')->toArray();
        }

        dd($arrray);
        if (in_array($arrray, $this->extra_activities_id)) {
            $this->openAlert('success', 'O aluno já está na atividade');
        } else {
            StudentActivities::create([
                'active'    => 1,
                'student_id'      => $this->student->id,
                'extra_activities_id' => $this->extra_activities_id,
                'active'         => 1,
                'gip'            => $this->gip,
            ]);
            $this->showModalForm = false;
            $this->studentActivities   = $this->student->activities->where('active', 1)->sortByDesc('title');
        }
        $this->openAlert('success', 'Inclusão na atividade realizada com sucesso');
    }
    //ACTIVE
    public function buttonActive($id)
    {
        $data = StudentActivities::where('id', $id)->first();
        if ($data->gip == 1) {
            $data->gip = 0;
            $data->save();
        } else {
            $data->gip = 1;
            $data->save();
        }
        $this->studentActivities   = $this->student->activities->where('active', 1)->sortByDesc('title');

        $this->openAlert('success', 'Registro atualizado com sucesso.');
    }
    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
