<?php

namespace App\Http\Livewire;

use App\Models\EnquiryDB;
use App\Models\MainServices;
use Livewire\Component;

class EnquiryForm extends Component
{
    public $Id,$Name,$Email,$Message,$Service,$Phone_No,$Callback='No',$Feedback='Not Available',$Action='No',$Amount,$Conversion='No';
    public function mount()
    {
        # code...
        $this->Id = "DC".time().rand(99,9999);
    }
    public function Save(){
        $save = new EnquiryDB();
        $save->Id = $this->Id;
        $save->Name = $this->Name;
        $save->Phone_No = $this->Phone_No;
        $save->Email = $this->Email;
        $save->Message = $this->Message;
        $save->Service = $this->Service;
        $save->Callback = $this->Callback;
        $save->Feedback = $this->Feedback;
        $save->Amount = $this->Amount;
        $save->Conversion = $this->Conversion;
        $save->save();

        $notification = array(
            'message'=>'Callback Request is Sent Seccessfully',
            'alert-type'=>'info'
        );

        return redirect()->route('User-Home')->with($notification);

    }
    public function render()
    {
        $services = MainServices::where('Service_Type','Public')->get();
        return view('livewire.enquiry-form',compact('services'));
    }
}
