<?php

namespace App\Http\Livewire;

use App\Models\MainServices;
use Livewire\Component;

class ApplyNowForm extends Component
{
    public $Name,$FatherName,$Phone_No,$Aadhar,$selectedservice,$Service;

    public function mount($ServiceName){
        $this->selectedservice = $ServiceName;
    }
    public function render()
    {
        $services = MainServices::all();
        return view('livewire.apply-now-form',compact('services'));
    }
}
