<?php

namespace App\Http\Livewire\User;

use App\Models\MainServices;
use App\Models\SubServices;
use Livewire\Component;
use phpDocumentor\Reflection\Types\Null_;

class ApplyNowForm extends Component
{
    public $App_Id,$Category_Type,$Service_Type,$Name,$phoneNo,$FatherName,$Dob,$Description,$File,$ServiceId,$ServiceName,$subServices;
    public $Update=0,$mainServiceId,$mainServiceName;
    protected $rules = [
        'Name' =>'required',
        'PhoneNo' =>'required | min:10 | max:10',
        'FatherName' =>'required',
        'Dob' =>'required',
        'Description' =>'required',
        'Category_Type' =>'required',
        'Service_Type' =>'required',
    ];

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }
    public function mount($Id)
    {
        $this->App_Id = 'AN'.date('dd').time();
        $this->ServiceId = $Id;
    }
    public function ApplyNow()
    {
        # code...
        $this->validate();
        


    }
    public function render()
    {
        $fetch = SubServices::where('Id',$this->ServiceId)->get();
        foreach($fetch as $key){
            $this->ServiceName = $key['Name'];
            $this->mainServiceId = $key['Service_Id'];
        }
        $this->subServices = SubServices::where('Service_Id',$this->mainServiceId)->get();
        $fetchmain = MainServices::where('Id',$this->mainServiceId)->get();
        foreach($fetchmain as $key){
            $this->mainServiceName = $key['Name'];

        }
        $services = MainServices::where('Service_Type','Public')->get();
        return view('livewire.user.apply-now-form',compact('services'));
    }
}
