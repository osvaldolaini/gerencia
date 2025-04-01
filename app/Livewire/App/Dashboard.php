<?php

namespace App\Livewire\App;

use App\Models\Admin\Settings\Settings;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


use App\Models\Settings\Companies;
use App\Models\Settings\SchoolClassesYears;
use App\Models\Settings\SchoolGrades;

use Illuminate\Support\Facades\File;
use Parsedown;

class Dashboard extends Component
{
    public $fo = false;
    public $fault = false;
    // Define o layout a ser usado
    protected $layout = 'app';

    public $config;
    public $darkMode;
    public $readmeContent;

    public $school_years;
    public $school_grade;
    public $companies;
    public $school_classes_year_id;

    public function mount()
    {
        $this->config = Settings::find(1);
        $this->darkMode = Auth::user()->dark;

        $this->school_years = SchoolClassesYears::where('active', 1)->first();
        $this->school_classes_year_id           = $this->school_years->id;
        $this->school_grade = SchoolGrades::where('active', 1)->orderby('nick', 'desc')->get();
        $companiesAccess = Auth::user()->json_companies;
        if (in_array('all', $companiesAccess)) {
            $this->companies = Companies::where('active', 1)->get();
        } else {
            $this->companies = Companies::where('active', 1)->whereIn('id', Auth::user()->json_companies)->get();
        }

        $path = base_path('VERSIONS.md'); // Caminho do arquivo
        $this->readmeContent = File::exists($path)
            ? (new Parsedown())->text(File::get($path))
            : 'Arquivo README.md não encontrado.';
    }
    public function render()
    {
        if (request()->userAgent() && str_contains(request()->userAgent(), 'Mobile')) {
            return view('livewire.app.dashboard-mobile')->layout('layouts.' . $this->layout . '-mobile');
        } else {
            return view('livewire.app.dashboard')->layout('layouts.' . $this->layout);
        }
    }
    public function fo_form()
    {
        $this->fo = true;
    }
    public function fault_form()
    {
        $this->fault = true;
    }

    //configs user
    public function toggleDarkMode()
    {
        $user = Auth::user();
        $user->dark = !$user->dark;
        $user->save();

        $this->darkMode = $user->dark;
        $this->dispatch('darkModeToggled', $this->darkMode);
    }
}
