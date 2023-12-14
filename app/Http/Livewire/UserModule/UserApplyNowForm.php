<?php

namespace App\Http\Livewire\UserModule;

use App\Models\Application;
use App\Models\ApplyServiceForm;
use App\Models\MainServices;
use App\Models\SubServices;
use App\Traits\WhatsappTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserApplyNowForm extends Component
{
    use WithFileUploads;
    use WhatsappTrait;



    public $App_Id, $Category_Type, $Service_Type, $Name, $PhoneNo, $FatherName, $Dob, $Description, $File, $ServiceId, $ServiceName, $subServices, $Read_Consent, $signature, $Address, $mobile;
    public $Update = 0, $mainServiceId, $mainServiceName, $Signed = true, $Recived, $disabled, $DigitallySigned, $New_File, $Amount;
    protected $rules = [
        'Name' => 'required',
        'PhoneNo' => 'required | min:10 | max:10',
        'FatherName' => 'required',
        'Dob' => 'required',
        'Description' => 'required',
    ];

    public $ConsentMatter;

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    } //End Function


    public function mount($Id, $Price)
    {
        $time = Carbon::now();
        $this->App_Id = 'AN' . $time->format('d-m-Y-H:i:s');
        $this->ServiceId = $Id;
        $this->Amount = $Price;
        $this->Profile();
        $this->mobile = Auth::user()->mobile_no;
    } //End Function


    public function Sign()
    {
        $this->Signed = false;
        $this->signature = Carbon::now();
        $this->Recived = 'Consent Received';
        $this->Read_Consent = 1;
        $this->DigitallySigned = 1;
        $this->disabled = 'disabled';
    } //End Function


    public function ApplyNow()
    {
        # code...
        if ($this->File != Null) {
            $this->validate(
                [
                    'Read_Consent' => 'required',
                    'DigitallySigned' => 'required'
                ],
                [
                    'Read_Consent.required' => 'The :attribute must Accept.',
                    'DigitallySigned.required' => 'Please Sign this consent :attribute.',
                ],
                [
                    'Read_Consent' => 'Consent',
                    'DigitallySigned' => 'Digitally'
                ],
            );
            $extension = $this->File->getClientOriginalExtension();
            $path = 'Client_DB/' . $this->Name . ' ' . Auth::user()->Client_Id . '/' . $this->Name . '/Direct Application/Documents';
            $filename = 'Doc ' . $this->Name . ' ' . time() . '.' . $extension;
            $url = $this->File->storePubliclyAs($path, $filename, 'public');
            $this->New_File = $url;
        }
        $this->validate();
        $consent = "";
        if ($this->Read_Consent == 1) {
            $consent = 'Dear Sir I am ' . $this->Name . ' C/o ' . $this->FatherName . ' Phone No ' . $this->PhoneNo . ' hereby give my explicit consent for sharing my Document for the following purpose ' . $this->mainServiceName . ',  ' . $this->ServiceName . ' I understand that the information shared will be used only for the purpose mentioned above and will not be shared with any other party without my explicit permission I also understand that I have the right to withdraw my consent at any time and that the withdrawal process will be similar to the consent process Thank you for your assistance Sincerely , this is Digitally Signed on ' . $this->signature;
        }
        $apply = new ApplyServiceForm();

        $apply->Id = $this->App_Id;
        $apply->Client_Id = Auth::user()->Client_Id;
        $apply->Application = $this->mainServiceName;
        $apply->Application_Type = $this->ServiceName;
        $apply->Name = trim($this->Name);
        $apply->App_MobileNo = trim($this->PhoneNo);
        $apply->Mobile_No = trim($this->mobile);
        $apply->Relative_Name = trim($this->FatherName);
        $apply->Dob = trim($this->Dob);
        $apply->Message = trim($this->Description);
        $apply->File = $this->New_File;
        $apply->Consent = $consent;
        $apply->Profile_Image = Auth::user()->profile_image;
        $apply->save();

        $app_field = new Application();
        $app_field->Id = $this->App_Id;
        $app_field->Client_Id = Auth::user()->Client_Id;
        $app_field->Received_Date = date('Y-m-d');;
        $app_field->Application = $this->mainServiceName;
        $app_field->Application_Type = $this->ServiceName;
        $app_field->Name = trim($this->Name);
        $app_field->Relative_Name = trim($this->FatherName);
        $app_field->Gender = Auth::user()->gender;
        $app_field->Mobile_No =  trim($this->mobile);
        $app_field->DOB = trim($this->Dob);
        $app_field->Applied_Date = NULL;
        $app_field->Total_Amount = $this->Amount;
        $app_field->Amount_Paid =  0;
        $app_field->Balance =  0;
        $app_field->Payment_Mode = 'Not Available';
        $app_field->Payment_Receipt = 'Not Available';
        $app_field->Status = 'Received';
        $app_field->Ack_No = 'Not Available';
        $app_field->Ack_File = 'Not Available';
        $app_field->Document_No = 'Not Available';
        $app_field->Message = trim($this->Description);
        $app_field->Consent = $consent;;
        $app_field->Doc_File = $this->New_File != Null?$this->New_File :'Not Available' ;
        $app_field->Delivered_Date = NULL;
        $app_field->Applicant_Image = Auth::user()->profile_image;
        $app_field->save(); // Application Form Saved

        $notification = array(
            'message' => 'Application Submitted Sucessfully',
            'info-type' => 'success'
        );
        $this->ApplicationbyUserAlert(Auth::user()->name,trim($this->mobile),trim($this->Name),$this->mainServiceName, $this->ServiceName );
        return redirect()->route('acknowledgment', $this->App_Id)->with($notification);
    } //End Function


    public function ResetFields()
    {
        $this->Name = Null;
        $this->PhoneNo = Null;
        $this->Dob = Null;
        $this->Description = Null;
        $this->Read_Consent = Null;
    } //End Function


    public function Profile()
    {
        $this->Name = Auth::user()->name;
        $this->PhoneNo = Auth::user()->mobile_no;
        $this->Dob = Auth::user()->dob;
        $this->Address = Auth::user()->address;
    } //End Function

    public function Capitalize()
    {
        $this->Name = ucwords($this->Name);
        $this->Description = ucwords($this->Description);
        $this->FatherName = ucwords($this->FatherName);
    }
    public function render()
    {
        $this->Capitalize();
        $fetch = SubServices::where('Id', $this->ServiceId)->get();
        foreach ($fetch as $key) {
            $this->ServiceName = $key['Name'];
            $this->mainServiceId = $key['Service_Id'];
        }
        $this->subServices = SubServices::where('Service_Id', $this->mainServiceId)->get();
        $fetchmain = MainServices::where('Id', $this->mainServiceId)->get();
        foreach ($fetchmain as $key) {
            $this->mainServiceName = $key['Name'];
        }
        $this->ConsentMatter = 'Dear Sir I am ' . $this->Name . ' hereby give my explicit consent for sharing my Documents for the following purpose ' . $this->mainServiceName . ',  ' . $this->ServiceName . ' I understand that the information shared will be used only for the purpose mentioned above and will not be shared with any other party without my explicit permission I also understand that I have the right to withdraw my consent at any time and that the withdrawal process will be similar to the consent process Thank you for your assistance Sincerely';

        $services = MainServices::where('Service_Type', 'Public')->get();
        $applied = ApplyServiceForm::where('Client_Id', Auth::user()->Client_Id)->paginate(10);
        $service_count = $applied->total();
        return view('livewire.user-module.user-apply-now-form', compact('services', 'applied'), ['service_count' => $service_count]);
    }
}
