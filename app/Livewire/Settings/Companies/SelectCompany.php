<?php

namespace App\Livewire\Settings\Companies;

use App\Models\Settings\Companies;
use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SelectCompany extends Component
{
    public $companyId  = 'all';
    public $companies;

    public function mount()
    {
        $this->companies = Companies::where('active', 1)->get();
        $this->companyId = Cache::get(
            'students_company_filter_' . Auth::id(),
            'all'
        );
        // dd($this->companyId);
    }
    public function render()
    {
        return view('livewire.settings.companies.select-company');
    }
    public function updatedCompanyId($value)
    {
        Cache::put(
            'students_company_filter_' . Auth::id(),
            $value,
            now()->addDays(30)
        );

        $this->dispatch('company-selected', companyId: $value);
    }

    public function selectCompany($companyId)
    {
        $this->companyId = (string) $companyId;

        Cache::put(
            'students_company_filter_' . Auth::id(),
            $this->companyId,
            now()->addDays(30)
        );

        $this->dispatch('company-selected', companyId: $this->companyId);
    }
}
