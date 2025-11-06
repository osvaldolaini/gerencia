<?php

namespace App\Livewire\StudentCorps;


use Livewire\Component;

use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Peoples;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\Settings\Settings;
use App\Models\StudentCorps\LegionOfHonor;
use App\Traits\HandlesTmpUploads;

class LegionOfHonorEdit extends Component
{
    public $local;
    public $year;
    public $bi_text;
    public $bi_number;
    public $supplement_number;
    public $bi_date;


    public $rules;

    public $legionary;

    public function mount(LegionOfHonor $legionary)
    {
        $this->legionary             = $legionary;

        $this->year           = $legionary->year;
        $this->local           = $legionary->local;
        $this->bi_text           = $legionary->bi_text;
        $this->bi_number         = $legionary->bi_number;
        $this->supplement_number = $legionary->supplement_number;
        $this->bi_date           = $legionary->bi_date;
    }

    public function render()
    {
        return view('livewire.student-corps.legion-of-honor-edit');
    }

    public function save()
    {
        $this->rules = [
            'year'               => 'required',
            'local'              => 'required',
            // 'bi_date'            => 'required',
            // 'bi_number'          => 'required',
            // 'supplement_number'  => 'required',
        ];

        $this->validate();

        LegionOfHonor::updateOrCreate([
            'id'    => $this->legionary->id,
        ], [
            'year'                  => $this->year,
            'local'                 => $this->local,
            'bi_date'               => $this->bi_date,
            'bi_text'               => $this->bi_text,
            'supplement_number'     => $this->supplement_number,
            'bi_number'             => $this->bi_number,
        ]);

        $msg = 'Registro editado com sucesso.';


        $this->openAlert('success', $msg);
        $this->dispatch('closeLegionary', 'success', 'Registro criado com sucesso');
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
