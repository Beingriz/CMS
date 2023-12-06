<?php

namespace App\Http\Livewire\Admin\Marketing;

use Livewire\Component;

class MarketingDashboard extends Component
{
    public function show()  {
        dd('working');
    }
    public function render()
    {
        return view('livewire.admin.marketing.marketing-dashboard');
    }
}
