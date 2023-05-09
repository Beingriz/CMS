<?php

namespace App\Http\Livewire;

use App\Models\EnquiryDB;
use App\Models\MainServices;
use Livewire\Component;

class EnquiryForm extends Component
{
    public $Id,$Name,$Email,$Message,$Service,$Phone_No,$Callback='No',$Feedback='Not Available',$Action='No',$Amount,$Conversion='No';
    public $Msg_template;
    protected $rules = [
        'Name'=>'Required',
        'Email'=>'Required|email',
        'Phone_No'=>'Required | min:10 | max:10',
        'Service'=>'Required',
        'Message'=>'Required | min:20'
    ];

    protected $message = [
        'Name'=>'Name cannot be blank',
        'Email'=>'Please enter valid email',
        'Phone_No'=>'Mobile Number is Mandatory',
        'Service'=>'Please select the Service type for callback',
        'Message'=>'Please Write your message'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function mount()
    {
        # code...
        $this->Id = "DC".time().rand(99,9999);

    }
    public function Save(){
        $this->validate();
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
            'message'=>$this->Name.' your Callback Request is Sent Seccessfully',
            'alert-type'=>'info'
        );
        return redirect()->route('home')->with($notification);

    }
    public function Capitalize(){
        $this->Name = ucwords($this->Name);
    }
    public function render()
    {
        $this->Capitalize();
        $name="";
        if($this->Name!="") {
            $name = "!";
        }
        $this->Msg_template = "Thank you ".ucwords($this->Name).$name." for your interest in contacting us! Please use the this form to send us your message and we will get back to you as soon as possible. Please provide as much detail as possible so that we can assist you effectively. Thank you for taking the time to contact us, and we look forward to hearing from you!";
        $services = MainServices::where('Service_Type','Public')->get();
        return view('livewire.enquiry-form',compact('services'));
    }
}
