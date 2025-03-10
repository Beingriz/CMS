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

    public $App_Id, $Category_Type, $Service_Type, $Name, $PhoneNo, $FatherName, $Dob, $Description, $File, $ServiceId, $ServiceName, $subServices, $Read_Consent=false, $signature, $Address, $mobile;
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


        if (!is_null($this->File)) {
            $this->rules['File'] = 'required|mimes:jpg,png,pdf,docx|max:2048';  // Update validation rule
            $this->rules['Read_Consent'] = 'required | accepted'; // Add new validation rule
            $this->New_File = $this->uploadFile();
        }
        $this->validate();

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
        $apply->dob = date('Y-m-d', strtotime(trim($this->Dob)));
        $apply->additional_message = trim($this->Description ?? 'No Description');
        $apply->file = $this->New_File ?? 'No Document Shared';
        $apply->user_consent = $this->ConsentMatter ?? 'No Document Shared';
        $apply->profile_image = $user->profile_image ?? 'default.png';
        $apply->save();

        $this->orderbyUserAlert($this->App_Id, $user->name);

        // ✅ Trigger SweetAlert FIRST before redirecting
        $this->dispatchBrowserEvent('swal:success', [
            'title' => 'Application Submitted!',
            'text' => 'Your application has been successfully submitted.',
            'icon' => 'success',
            'confirmButtonText' => 'OK',
            'redirectUrl' => route('acknowledgment', $this->App_Id) // Pass redirect URL
        ]);
    }



        // Helper: File Upload Handling
        private function uploadFile()
        {
            $extension = $this->File->getClientOriginalExtension();
            $path = 'Client_DB/' . Auth::user()->Client_Id . '/' . $this->Name . '/Orders/Documents';
            $filename = 'Doc_' . time() . '.' . $extension;
            return $this->File->storePubliclyAs($path, $filename, 'public');
        }

        // Helper: Dynamic Consent Generation
        public function prepareConsent()
        {
            $this->ConsentMatter = "I, {$this->Name} (C/o {$this->FatherName}), residing at {$this->Address}, and reachable at {$this->PhoneNo}, consent to sharing my personal information for the '{$this->mainServiceName}' service under the '{$this->ServiceName}' category.

        I acknowledge that my information will be used solely for this service, and I have the right to withdraw my consent anytime in writing. My data will be handled in compliance with applicable laws, and this consent is digitally signed and recorded.

        Signed on {$this->DigitalSignature}.

        Sincerely,
        {$this->Name}";
        }


    public function SignDigitally()
    {
        $this->DigitalSignature = Carbon::now();
        $this->Signed = true;
        $this->Read_Consent = true;
        $this->Recived = 'Consent Received';
        $this->disabled = 'disabled';
        $this->prepareConsent(); // Generate consent content

    }
    public function clearFile()
    {
        $this->File = null;
        $this->DigitalSignature = Null;
        $this->Signed = false;
        $this->Read_Consent = false;
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
        $this->Read_Consent = false;
        $this->FatherName = Null;
        $this->Address = Null;
        $this->mobile = Null;
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
        $applied = ModelsQuickApply::where('client_id', Auth::user()->Client_Id)
        ->orderBy('created_at', 'desc') // Sort by latest first
        ->paginate(10);

        $service_count = $applied->total();
        return view('livewire.user-module.quick-apply', compact('services', 'applied', 'service_count','documents'));

    }
}
