<?php

namespace App\Http\Livewire\AdminModule\Marketing;

use Livewire\Component;

class MarketingDashboard extends Component
{
    public function show()  {
        dd('working');
    }
    public function render()
    {
        return view('livewire.admin-module.marketing.marketing-dashboard');
    }
}
