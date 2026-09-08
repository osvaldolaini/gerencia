<?php

namespace App\Livewire\Settings\Companies;

use App\Models\Settings\Companies;
use Livewire\Component;

class SelectCompany extends Component
{
    public $companyId  = 'all';
    public $companies;
    public function mount()
    {
        $this->companies = Companies::where('active', 1)->get();
    }
    public function render()
    {
        return view('livewire.settings.companies.select-company');
    }
    public function updatedCompanyId($value)
    {
        $this->dispatch('company-selected', companyId: $value);
    }
    public function selectCompany($companyId)
    {
        $this->companyId = (string) $companyId;

        $this->dispatch('company-selected', companyId: $this->companyId);
    }
}
