<?php

namespace App\Livewire\App;

use App\Models\Peoples;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class StudentPhoto extends Component
{
    public $student;
    public $old_photo;
    use WithFileUploads;

    protected $listeners = ['fotoCortada' => 'setFotoFinal'];

    public $foto;
    public $fotoFinal;

    public function setFotoFinal($base64)
    {
        $this->fotoFinal = $base64;
    }

    #[On('getStudent')]
    public function mount(Peoples $student)
    {
        $this->student = $student;
        $this->old_photo = $this->student->id . '/' . $this->student->logo_path;
    }
    public function render()
    {
        return view('livewire.app.student-photo');
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }


    protected function saveBase64Image($base64, $path)
    {
        $image = explode(',', $base64)[1]; // remove header
        file_put_contents($path, base64_decode($image));
    }
    public function save()
    {
        if ($this->fotoFinal) {
            $filename = 'foto_' . time() . '.jpg';
            $path = storage_path('app/public/alunos/' . $filename);
            $this->saveBase64Image($this->fotoFinal, $path);
        }

        // continue o restante do cadastro...
    }
}
