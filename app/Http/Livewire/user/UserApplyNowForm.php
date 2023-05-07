<?php

namespace App\Http\Livewire\User;

use App\Models\ApplyServiceForm;
use App\Models\MainServices;
use App\Models\SubServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserApplyNowForm extends Component
{
    use WithFileUploads;
    public $App_Id,$Category_Type,$Service_Type,$Name,$PhoneNo,$FatherName,$Dob,$Description,$File,$ServiceId,$ServiceName,$subServices,$Read_Consent,$signature,$Address,$mobile;
    public $Update=0,$mainServiceId,$mainServiceName,$Signed=true,$Recived,$disabled;
    protected $rules = [
        'Name' =>'required',
        'PhoneNo' =>'required | min:10 | max:10',
        'FatherName' =>'required',
        'Dob' =>'required',
        'Description' =>'required',
    ];
    public $ConsentMatter;

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }
    public function mount($Id)
    {
        $this->App_Id = 'AN'.date('d-Y').rand(99,9999);
        $this->ServiceId = $Id;
        $this->Profile();
        $this->mobile = Auth::user()->mobile_no;

    }
    public function Sign()
    {
       $this->Signed = false;
       $this->signature = Carbon::now();
       $this->Recived = 'Consent Received';
       $this->Read_Consent = 1;
       $this->disabled = 'disabled';
    }
    public function ApplyNow()
    {
        # code...
        if($this->File != Null){
            $this->validate([
                'Read_Consent'=>'required',
                'Read_Consent.required'=>'Please give your consent',
            ]);
        }
        $this->validate();
        $consent = "";
        if($this->Read_Consent == 1 ){
            $consent ='Dear Sir I am' .$this->Name.' C/o '.$this->FatherName. ' Phone No '.$this->PhoneNo. ' hereby give my explicit consent for sharing my Aadhaar related information for the following purpose ' .$this->mainServiceName.',  ' .$this->ServiceName. ' I understand that the information shared will be used only for the purpose mentioned above and will not be shared with any other party without my explicit permission I also understand that I have the right to withdraw my consent at any time and that the withdrawal process will be similar to the consent process Thank you for your assistance Sincerely , this is Digitally Signed on ' .$this->signature;
        }
        $apply = new ApplyServiceForm();

        $apply->Id = $this->App_Id;
        $apply->Service = $this->mainServiceName;
        $apply->Service_Type = $this->ServiceName;
        $apply->Name = trim($this->Name);
        $apply->App_MobileNo = trim($this->PhoneNo);
        $apply->Mobile_No = trim($this->mobile);
        $apply->Father_Name = trim($this->FatherName);
        $apply->Dob = trim($this->Dob);
        $apply->Message = trim($this->Description);
        $apply->File = $this->File;
        $apply->Consent = $consent;
        $apply->save();
        session()->flash('SuccessMsg', 'Application Submitted Successfully!');
        $notification = array(
            'message'=>'Application Submitted Sucessfully',
            'info-type' => 'success'
        );
        return redirect()->route('acknowledgment',$this->App_Id)->with($notification);



    }
    public function ResetFields(){
        $this->Name = Null;
        $this->PhoneNo = Null;
        $this->Dob = Null;
        $this->Description = Null;
        $this->Read_Consent = Null;
    }
    public function Profile(){
        $this->Name = Auth::user()->name;
        $this->PhoneNo = Auth::user()->mobile_no;
        $this->Dob = Auth::user()->dob;
        $this->Address = Auth::user()->address;
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
        $this->ConsentMatter = 'Dear Sir I am' .$this->Name. ' hereby give my explicit consent for sharing my Aadhaar related information for the following purpose ' .$this->mainServiceName.',  ' .$this->ServiceName. ' I understand that the information shared will be used only for the purpose mentioned above and will not be shared with any other party without my explicit permission I also understand that I have the right to withdraw my consent at any time and that the withdrawal process will be similar to the consent process Thank you for your assistance Sincerely';

        $services = MainServices::where('Service_Type','Public')->get();
        return view('livewire.user.user-apply-now-form',compact('services'));
    }

}
