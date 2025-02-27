<?php

namespace App\Livewire\Settings\Companies;

use App\Models\Settings\Companies;
use Livewire\Component;

class CompanyPage extends Component
{
    public $companies;
    public function mount(Companies $companies)
    {
        if ($companies) {
            $this->companies = $companies;
        }
    }

    public function render()
    {
        return view('livewire.settings.companies.company-page');
    }
}
