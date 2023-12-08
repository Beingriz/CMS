<?php

namespace App\Http\Livewire\UserModule;

use App\Models\EnquiryDB;
use App\Models\MainServices;
use App\Models\SubServices;
use Livewire\Component;
use Twilio\Rest\Client;


class EnquiryForm extends Component
{
    public $Id, $Name, $Email, $Message, $Service, $Phone_No, $Callback = 'No', $Feedback = 'Not Available', $Action = 'No', $Amount, $Conversion = 'No';
    public $Msg_template, $SubService;
    protected $rules = [
        'Name' => 'Required',
        'Email' => 'Required|email',
        'Phone_No' => 'Required | min:10 | max:10',
        'Service' => 'Required',
        'SubService' => 'Required',
        'Message' => 'Required | min:20'
    ];

    protected $message = [
        'Name' => 'Name cannot be blank',
        'Email' => 'Please enter valid email',
        'Phone_No' => 'Mobile Number is Mandatory',
        'Service' => 'Please select the Service for callback',
        'SubServices' => 'Please select the Service type for callback',
        'Message' => 'Please Write your message'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function mount()
    {
        # code...
        $this->Id = "DC" . time() . rand(99, 9999);
    }
    public function Save()
    {
        $this->validate();
        $mainservice = MainServices::where('Id', $this->Service)->get();
        foreach ($mainservice as $item) {
            $serviceName = $item['Name'];
        }
        $save = new EnquiryDB();
        $save->Id = $this->Id;
        $save->Name = $this->Name;
        $save->Phone_No = $this->Phone_No;
        $save->Email = $this->Email;
        $save->Message = $this->Message;
        $save->Service = $serviceName;
        $save->Service_Type = $this->SubService;
        $save->Status = 'Pending';
        $save->Feedback = $this->Feedback;
        $save->Amount = $this->Amount;
        $save->Conversion = $this->Conversion;
        $save->save();

        $notification = array(
            'message' => $this->Name . ' your Callback Request is Sent Seccessfully',
            'alert-type' => 'info'
        );
        $this->sendNotification($this->Phone_No, $this->Name, $serviceName);
        return redirect()->route('home')->with($notification);
    }
    public function sendNotification($mobile, $name, $service,)
    {
        $body = "Dear *" . $name . "* 👋🏻😍
        ,
        ▶ Thank you for reaching out to us through our website with your Enquiry on *" . $service . " * We appreciate your interest and would be more than happy to assist you.

        ▶ Our team is currently reviewing your inquiry and will provide you with a detailed response as soon as possible. We understand the importance of your questions and aim to address them thoroughly and accurately.


        Best regards,
        *Digital Cyber*
        _The power to Empowe_
        *Call : +91 8892988334*
        *Call : +91 8951775912*";

        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $from = getenv("TWILIO_PHONE_NUMBER");
        $twilio = new Client($sid, $token);

        $to_no = "whatsapp:+91" . $mobile;
        $from_no = "whatsapp:$from";
        $twilio->messages
            ->create(
                $to_no, // to
                array(
                    "from" => $from_no,
                    "body" => $body
                )
            );
    }
    public function Capitalize()
    {
        $this->Name = ucwords($this->Name);
    }
    public function render()
    {
        $this->Capitalize();
        $name = "";
        if ($this->Name != "") {
            $name = "!";
        }
        $this->Msg_template = "Thank you " . ucwords($this->Name) . $name . " for your interest in contacting us! Please use the this form to send us your message and we will get back to you as soon as possible. Please provide as much detail as possible so that we can assist you effectively. Thank you for taking the time to contact us, and we look forward to hearing from you!";
        $services = MainServices::where('Service_Type', 'Public')->get();
        $subservices = SubServices::where('Service_Id', $this->Service)->get();

        return view('livewire.user-module.enquiry-form', compact('services', 'subservices'));
    }
}
