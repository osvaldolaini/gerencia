<?php

namespace App\Livewire\Settings\Pdf;

use App\Models\Settings\SchoolClasses;
use App\Models\Admin\Settings\Settings;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SchoolBattalionsPdf extends Component
{
    public function render()
    {
        return view('livewire.settings.pdf.school-battalions-pdf');
    }
}
