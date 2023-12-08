<?php

namespace App\Http\Livewire\UserModule;

use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FeedbackForm extends Component
{
    public $FB_Id, $Name, $Message;
    public function mount()
    {
        $time = Carbon::now();
        $this->FB_Id = 'FB' . $time->format('d-m-Y-H:i:s');
        $this->Name = Auth::user()->name;
    }
    protected $rules = [
        'Name' => 'required',
        'Message' => 'required'
    ];
    protected $message = [
        'Name' => 'Please Enter your Name',
        'Message' => 'Give us your valuable Feedbac!. Fill the Message Box'
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function Feedback()
    {
        $this->validate([
            'Message' => 'required',
        ]);
        $save = new Feedback();
        $save['Id'] = $this->FB_Id;
        $save['Name'] = $this->Name;
        $save['Phone_No'] = Auth::user()->mobile_no;
        $save['Message'] = $this->Message;
        $save->save();
        $notification = array(
            'message' => $this->Name . ' Thank you for your Valuable Feedback!',
            'alert-type' => 'info',
        );
        return redirect()->route('user.home', Auth::user()->id)->with($notification);
    }
    public function render()
    {
        return view('livewire.user.feedback-form');
    }
}
