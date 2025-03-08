<?php

namespace App\Http\Livewire\UserModule;

use App\Models\Application;
use App\Models\ApplyServiceForm;
use App\Models\Branches;
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
    public $Update = 0, $mainServiceId, $mainServiceName, $Signed = false, $Recived, $disabled, $DigitalSignature, $New_File, $Amount, $Branch, $branches;
    public $isProcessing = false; // Track form submission state
    protected $listeners = ['clearFile'];
    protected $rules = [
        'Branch' => 'required',
        'Name' => 'required|string|max:255',
        'FatherName' => 'required|string|max:255',
        'Dob' => 'required|date',
        'File' => 'nullable|mimes:jpg,png,pdf,docx|max:2048', // Allow more formats

    ];

    public $ConsentMatter;

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($Id, $Price)
    {
        $this->App_Id = 'AN' . time();
        $this->ServiceId = $Id;
        $this->Amount = $Price;
        $this->Profile();
        $this->mobile = Auth::user()->mobile_no;
        $this->branches = []; // Initialize to empty array
    }

    public function Sign()
    {
        $this->Signed = true;
        $this->signature = Carbon::now();
        $this->Recived = 'Consent Received';
        $this->Read_Consent = 1;
        $this->DigitalSignature = 1;
        $this->disabled = 'disabled';
    }
    public function SignDigitally()
    {
        $this->DigitalSignature = Carbon::now();
        $this->Signed = true;
        $this->Read_Consent = 1;
        $this->Recived = 'Consent Received';
        $this->disabled = 'disabled';
        $this->prepareConsent(); // Generate consent content

    }
    public function clearFile()
{
    $this->File = null;
}

    public function ApplyNow()
    {
        // Enhanced Validation Rules
        $this->validate();

        try {
            // Handle File Upload
            if ($this->File) {
                $rules['Read_Consent'] = 'accepted'; // Consent must be read
                $this->New_File = $this->uploadFile();
            }

            // Store in ApplyServiceForm
            $apply = new ApplyServiceForm();
            $apply->Id  = $this->App_Id;
                $apply->Client_Id       = Auth::id();
                $apply->Application     = $this->mainServiceName;
                $apply->Application_Type= $this->ServiceName;
                $apply->Name            = trim($this->Name);
                $apply->App_MobileNo    = trim($this->PhoneNo);
                $apply->Mobile_No       = trim($this->mobile);
                $apply->Relative_Name   = trim($this->FatherName);
                $apply->Dob             = trim($this->Dob);
                $apply->Message         = trim($this->Description) ?? 'No Description';
                $apply->File            = $this->New_File ?? 'No Document Shared';
                $apply->Profile_Image   = Auth::user()->profile_image;
                $apply->Branch_Id       = $this->Branch;
                $apply->Status          = 'Received';
                $apply->Amount          = $this->Amount;
            $apply->save();
            dd('saved');
            // Store in Application Table
            $app_field = new Application();
            $app_field->fill([
                'Id'              => $this->App_Id,
                'Client_Id'       => Auth::id(),
                'Received_Date'   => now(),
                'Application'     => $this->mainServiceName,
                'Application_Type'=> $this->ServiceName,
                'Name'            => trim($this->Name),
                'Relative_Name'   => trim($this->FatherName),
                'Gender'          => Auth::user()->gender,
                'Mobile_No'       => trim($this->mobile),
                'DOB'             => trim($this->Dob),
                'Total_Amount'    => $this->Amount,
                'Status'          => 'Received',
                'Consent'         => $this->ConsentMatter ?? 'No Document Shared',
                'Doc_File'        => $this->New_File ?? 'Not Available',
                'Applicant_Image' => Auth::user()->profile_image,
            ]);
            $app_field->save();
            dd('saved');
           // Redirect with Success Notification
            session()->flash('success', 'Application submitted successfully.');
            return redirect()->route('acknowledgment', $this->App_Id);
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong: ' . $e->getMessage());
        } finally {
            $this->isProcessing = false; // Unlock for new submission
        }
    }

    // Helper: File Upload Handling
    private function uploadFile()
    {
        $extension = $this->File->getClientOriginalExtension();
        $path = 'Client_DB/' . Auth::user()->Client_Id . '/' . $this->Name . '/Documents';
        $filename = 'Doc_' . time() . '.' . $extension;
        return $this->File->storePubliclyAs($path, $filename, 'public');
    }
    // ✅ Add the missing method
    public function CompleteApplication()
    {
        $this->Signed = true;  // Mark application as completed
        session()->flash('SuccessMsg', 'Document Concent Signed!');
    }
    // Helper: Dynamic Consent Generation
    public function prepareConsent()
    {
        $this->ConsentMatter = "I, {$this->Name} (C/o {$this->FatherName}),
        residing at {$this->Address}, and reachable via phone number {$this->PhoneNo},
        hereby provide my explicit and voluntary consent for sharing my personal information
        for the purpose of availing the '{$this->mainServiceName}' service, specifically under
        the '{$this->ServiceName}' category.

        I acknowledge that:
        1. My personal information will be used solely for the requested service.
        2. I have the right to withdraw my consent at any time by written request.
        3. The information will be handled in accordance with data protection laws.
        4. This consent is digitally signed and recorded.

        Signed on {$this->DigitalSignature}.

        Sincerely,
        {$this->Name}";
    }



    public function ResetFields()
    {
        $this->Name = Null;
        $this->PhoneNo = Null;
        $this->Dob = Null;
        $this->Description = Null;
        $this->Read_Consent = Null;
        $this->disabled = Null;
        $this->DigitalSignature = Null;
        $this->Signed = false;
        $this->Recived = Null;
        $this->Branch = Null;
        $this->New_File = Null;
        $this->File = Null;
    }

    public function Profile()
    {
        $this->Name = Auth::user()->name;
        $this->PhoneNo = Auth::user()->mobile_no;
        $this->Dob = Auth::user()->dob;
        $this->Address = Auth::user()->address;
    }

    public function Capitalize()
    {
        $this->Name = ucwords($this->Name);
        $this->Description = ucwords($this->Description);
        $this->FatherName = ucwords($this->FatherName);
    }

    public function render()
    {
        $this->Capitalize();
        $this->dispatchBrowserEvent('close-modal');
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



        // Fetching branch details to populate dropdown
        $this->branches = Branches::all();
        $services = MainServices::where('Service_Type', 'Public')->get();
        $applied = ApplyServiceForm::where('Client_Id', Auth::user()->Client_Id)->paginate(10);
        $service_count = $applied->total();
        return view('livewire.user-module.user-apply-now-form', compact('services', 'applied', 'service_count'));
    }
}
