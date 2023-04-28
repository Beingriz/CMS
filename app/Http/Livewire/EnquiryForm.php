<?php

namespace App\Http\Livewire;

use App\Models\MainServices;
use Livewire\Component;

class EnquiryForm extends Component
{
    public function render()
    {
        $services = MainServices::where('Service_Type','Public')->get();
        return view('livewire.enquiry-form',compact('services'));
    }
}
