<?php

namespace App\Http\Livewire\UserModule;

use App\Models\ApplyServiceForm;
use App\Models\Branches;
use App\Models\DocumentList;
use App\Models\MainServices;
use App\Models\QuickApply as ModelsQuickApply;
use App\Models\SubServices;
use App\Traits\WhatsappTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class QuickApply extends Component
{
    use WithFileUploads;
    use WhatsappTrait;

    public $App_Id, $Category_Type, $Service_Type, $Name, $PhoneNo, $FatherName, $Dob, $Description, $File, $ServiceId, $ServiceName, $subServices, $Read_Consent, $signature, $Address, $mobile;
    public $Update = 0, $mainServiceId, $mainServiceName, $Signed = false, $Recived, $disabled, $DigitalSignature, $New_File, $Amount, $Branch, $branches;
    public $isProcessing = false; // Track form submission state
    protected $listeners = ['clearFile'];

    public $wantToUpload = 'no'; // Default value
    public $files = []; // Array to store multiple files
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
        $this->App_Id = 'QA' . date('Y') . time();
        $this->ServiceId = $Id;
        $this->Amount = $Price;
        $this->Profile();
        $this->mobile = Auth::user()->mobile_no;
        $this->branches = []; // Initialize to empty array
    }

    public function removeFile($index)
    {
        unset($this->files[$index]);
        $this->files = array_values($this->files); // Re-index array
    }
    public function ApplyNow()
    {
        // Enhanced Validation Rules
        $this->validate();

        // Handle File Upload
        if ($this->File) {
            $rules['Read_Consent'] = 'accepted'; // Consent must be read
            $this->New_File = $this->uploadFile();
        }

        // Create and save the record
        $user = Auth::user();
        $apply = new ModelsQuickApply();
        $apply->id = $this->App_Id;
        $apply->client_id = $user->Client_Id;
        $apply->branch_id = $this->Branch;
        $apply->application = $this->mainServiceName;
        $apply->application_type = $this->ServiceName;
        $apply->name = trim($this->Name);
        $apply->mobile_no = trim($this->PhoneNo);
        $apply->relative_name = trim($this->FatherName);
        $apply->dob = date('Y-m-d', strtotime(trim($this->Dob))); // Ensure date format
        $apply->additional_message = trim($this->Description ?? 'No Description');
        $apply->file = $this->New_File ?? 'No Document Shared';
        $apply->user_consent = $this->ConsentMatter ?? 'No Document Shared';
        $apply->profile_image = $user->profile_image ?? 'default.png';
        $apply->save();
        return redirect()->route('acknowledgment', $this->App_Id);
    }
        // Helper: File Upload Handling
        private function uploadFile()
        {
            $extension = $this->File->getClientOriginalExtension();
            $path = 'Client_DB/' . Auth::user()->Client_Id . '/' . $this->Name . '/Documents';
            $filename = 'Doc_' . time() . '.' . $extension;
            return $this->File->storePubliclyAs($path, $filename, 'public');
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
        $this->DigitalSignature = Null;
        $this->Signed = false;
        $this->Read_Consent = Null;
        $this->Recived = 'Consent Not Received';
        $this->disabled = Null;
        $this->New_File = Null;
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



        // $serviceName = MainServices::where('Id', $this->ServiceId)->get();
        // foreach ($serviceName as $key) {
        //     $this->ServiceName = $key['Name'];
        // }
        // $subservices = SubServices::where('Service_Id', $this->Id)->get();
        $documents = DocumentList::where('Sub_Service_Id', $this->ServiceId)->paginate(10);

        // Fetching branch details to populate dropdown
        $this->branches = Branches::all();
        $services = MainServices::where('Service_Type', 'Public')->get();
        $applied = ModelsQuickApply::where('client_id', Auth::user()->Client_Id)->paginate(10);
        $service_count = $applied->total();
        return view('livewire.user-module.quick-apply', compact('services', 'applied', 'service_count','documents'));

    }
}
