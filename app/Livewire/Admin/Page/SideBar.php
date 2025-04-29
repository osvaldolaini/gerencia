<?php

namespace App\Livewire\Admin\Page;

use App\Models\Discipline\FactObserved;
use Livewire\Component;
use Livewire\Attributes\On;

class SideBar extends Component
{
    public $fo;
    #[On('update')]
    public function render()
    {
        $this->fo = FactObserved::where('active', 1)->where('fact_type', '!=', 'informativo')->where('sincomil_date', null)->where('fafd_id', null)->get()->count();
        // dd($this->fo);
        return view('livewire.admin.page.side-bar');
    }
}
