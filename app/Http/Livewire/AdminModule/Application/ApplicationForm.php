<?php

namespace App\Http\Livewire\AdminModule\Application;

use App\Models\Application;
use App\Models\BalanceLedger;
use App\Models\ClientRegister;
use App\Models\CreditLedger;
use App\Models\MainServices;
use App\Models\PaymentMode;
use App\Models\Status;
use App\Models\SubServices;

use App\Models\User;
use App\Traits\WhatsappTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ApplicationForm extends Component
{
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    use WhatsappTrait;


    public $App_Id, $today, $payment_mode;
    public $Name, $username;
    public $Dob;
    public $Ack_No = 'Not Available';
    public $Document_No = 'Not Available';
    public $Total_Amount = 0, $Amount_Paid = 0, $Balance = 0;
    public $ServiceName, $Profile_Show = 0, $Profile_Update, $Records_Show = 0;
    public $PaymentMode = 'Cash', $Gender, $RelativeName, $Service_Fee = NULL;
    public $Received_Date, $Mobile_Num, $Confirmation;
    public $main_service, $Ack_File, $Doc_File, $Payment_Receipt = NULL, $Status = 'Received', $Client_Type;
    public $SubSelected;
    public $MainSelected, $Application, $ApplicationType, $ApplicationId, $Application_Type;
    public $Applicant_Image, $lastRecTime;
    public $sub_service = [], $old_Applicant_Image, $clear_button = 'Disable';
    public $Mobile_No = NULL;
    public $user_type = NULL,$Branch_Id,$Emp_Id;
    public $Checked = [];
    public $paginate = 5;
    public $filterby, $Bal = 0;
    public $collection;
    public $Select_Date = Null, $Daily_Income = 0;
    public $Edit_Window = 0;
    public $PaymentFile, $AckFile, $DocFile = 0, $FilterChecked;
    protected $daily_applications,$AppliedServices;



    public $Yes = 'off', $Client_Image, $Old_Profile_Image, $C_Id, $C_Name, $C_RName, $C_Gender, $C_Email, $C_Dob, $C_Mob, $C_Ctype, $C_Address, $Open = 0, $lastMobRecTime, $profileCreated, $lastProfUpdate, $status_list,$registerClient=false;


    protected $rules = [
        'Name' => 'required',
        'Gender' => 'required',
        'Dob' => 'required',
        'Client_Type' => 'required',
        'MainSelected' => 'required',
        'SubSelected' => 'required',
        'Mobile_No' => 'required | Min:10 | Max:10 ',
        'Total_Amount' => 'required',
        'Amount_Paid' => 'required',
        'PaymentMode' => 'required',
    ];
    protected $messages = [
        'name.required' => 'Applicant Name Cannot be Empty',
        'Gender.required' => 'Please Select Gender',
        'Client_Type.required' => 'Please Select Clinet',
        'dob.required' => 'Please Select Date of Birth',
        'MainSelected.required' => 'Please Select Application',
        'SubSelected.required' => 'Please Select Sub Category',
        'Mobile_No.required' => 'Mobile Number Cannot Be Empty',
        'total_amount.required' => 'Enter Total Amount',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function mount()
    {
        $this->App_Id  = 'DCA' . date('Y') . time();
        $this->Received_Date  = date('Y-m-d');
        $this->Branch_Id = Auth::user()->branch_id;
        $this->Emp_Id = Auth::user()->Client_Id;
    }
    public function Validation()
    {
        $this->validate(['Name' => 'required']);
    }


    // Function to Generate Random Username
    public function usernameGenrator($name, $dob)
    {
        // randomly creating username for new client registration,
        // it is the combinamtion of full name without space being first letter capital
        // ending with 2 letter of seconds of current time stamp and 2 letter of applicant date of birth.
        $username = strtolower($name); // to small case/
        $username = ucfirst($username); // first letter capital.
        $currentTimestamp = time(); // Get the current timestamp
        $timeString = date("His", $currentTimestamp); // Format timestamp as HHMMSS
        $sec = substr($timeString, -2); // Get the last two letters
        $dob = substr($dob, -2); // Get the last two letters
        $username = str_replace(' ', '', $username);
        $this->username = $username . $sec . $dob;
    }


    public function submit()
    {
        // Validate input data
        $this->validate();

        // Calculate balance
        $this->Balance = $this->Total_Amount - $this->Amount_Paid;

        // Fetch service name based on selected service
        $service = MainServices::where('Id', $this->MainSelected)->value('Name');
        $this->ServiceName = $service;

        // Check if client already exists
        $existingClient = ClientRegister::where('Mobile_No', $this->Mobile_No)->first();
        $existinguser = User::where('mobile_no', $this->Mobile_No)->first();

        if ($existingClient && $existinguser) {
            $this->registerClient = false;
            $client_Id = $existingClient->Id;
            // Existing client details
            $dob = $existingClient->DOB;
            $name = $existingClient->Name;
            $relative_name = $existingClient->Relative_Name;
            $gender = $existingClient->Gender;
            $profileimage = $existingClient->Profile_Image;
            $client_type = $existingClient->Client_Type;
        } else {
            $this->registerClient = true;
            $client_Id = 'DC' . date('Y') . strtoupper(Str::random(3)) . rand(000, 9999);
            $name = $this->Name;
            $profileimage = 'account.jpg';
        }

        // Handle file uploads
        $Applicant_Image = $this->handleFileUpload($this->Applicant_Image, $name, $client_Id, 'Applicant_Image');
        $this->Ack_File = $this->handleFileUpload($this->Ack_File, $name, $client_Id, 'Ack_File');
        $this->Doc_File = $this->handleFileUpload($this->Doc_File, $name, $client_Id, 'Doc_File');
        $this->Payment_Receipt = $this->handleFileUpload($this->Payment_Receipt, $name, $client_Id, 'Payment_Receipt');

        // Handle client image update
        $Client_Image = ($this->Profile_Update == 1 && !empty($this->Client_Image))
            ? $this->handleClientImageUpdate($name, $profileimage)
            : $Applicant_Image;

        // Prepare application data
        $app_field = new Application();
        $app_field->fill([
            'Id' => $this->App_Id,
            'Client_Id' => $client_Id,
            'Branch_Id' => $this->Branch_Id,
            'Emp_Id' => $this->Emp_Id,
            'Received_Date' => $this->Received_Date,
            'Application' => $service,
            'Application_Type' => $this->SubSelected,
            'Name' => $this->Name,
            'Gender' => $this->Gender,
            'Relative_Name' => $this->RelativeName,
            'Mobile_No' => $this->Mobile_No,
            'DOB' => $this->Dob,
            'Applied_Date' => NULL,
            'Total_Amount' => $this->Total_Amount,
            'Amount_Paid' => $this->Amount_Paid,
            'Balance' => $this->Balance,
            'Payment_Mode' => $this->PaymentMode,
            'Payment_Receipt' => $this->Payment_Receipt,
            'Status' => $this->Balance > 0 ? 'Pending' : 'Received',
            'Ack_No' => $this->Ack_No,
            'Ack_File' => $this->Ack_File,
            'Document_No' => $this->Document_No,
            'Doc_File' => $this->Doc_File,
            'Delivered_Date' => NULL,
            'Applicant_Image' => $Applicant_Image,
        ]);

        // Save application form
        $app_field->save();
        if($this->registerClient){
            $client = new ClientRegister();
            $client->fill([
                'Id' => $client_Id,
                'Branch_Id' => trim($this->Branch_Id),
                'Emp_Id' => trim($this->Emp_Id),
                'Name' => trim($this->Name),
                'Relative_Name' => trim($this->RelativeName),
                'Gender' => trim($this->Gender),
                'DOB' => trim($this->Dob),
                'Mobile_No' => trim($this->Mobile_No),
                'Email_Id' => trim($this->username . rand(00, 999) . '@gmail.com'),
                'Address' => 'Not Available',
                'Profile_Image' => $Client_Image,
                'Client_Type' => 'New Client',
            ]);
            $client->save();

            $this->usernameGenrator($this->Name, $this->Dob);
            $password = Hash::make(trim($this->username));
            User::create([
                'Client_Id' => $client_Id,
                'branch_id' => $this->Branch_Id,
                'Emp_Id' => $this->Emp_Id,
                'name' => trim($this->Name),
                'username' => trim($this->username),
                'mobile_no' => trim($this->Mobile_No),
                'Status' => trim('user'),
                'role' => trim('user'),
                'email' => trim($this->username . rand(00, 999) . '@gmail.com'),
                'profile_image' =>  $Client_Image,
                'password' => $password,
            ]);
            $this->userRegisterationAlert(trim($this->Mobile_No),trim($this->Name),trim($this->username),trim($this->username));
        }

        // Create or update balance ledger entry
        $this->saveBalanceLedger($client_Id, $service);

        // Update client details if necessary
        $this->updateClientDetails($existingClient, $client_Id, $name, $Client_Image);

        // Flash success message and redirect
        session()->flash('SuccessMsg', 'Application Saved Successfully! ' . ($this->Balance > 0 ? 'Balance Ledger Updated' : ''));
        $this->ApplicationRegisterAlert($this->Mobile_No, $this->Name, $this->Name, $service, $this->SubSelected);
        return redirect()->route('new.application');
    }


    private function handleFileUpload($fileType, $name, $client_Id, $prefix)
    {
        if (!empty($this->$fileType)) {
            $file = $this->$fileType;
            $extension = $file->getClientOriginalExtension();
            $path = 'Client_DB/' . $name . '_' . $client_Id . '/' . $this->Name . '/' . $this->ServiceName . '/' . trim($this->SubSelected);
            $filename = $prefix . '_' . time() . '.' . $extension;
            $url = $file->storePubliclyAs($path, $filename, 'public');
            return $url;
        }
        return 'Not Available';
    }

    private function handleClientImageUpdate($name, $profileimage)
    {
        $filename = $name . date('Ymd') . '_' . $this->Client_Image->getClientOriginalName();
        $filename = 'Client_DB/' . $this->Name . ' ' . time() . '/Profile Photo/' . $filename;
        Storage::disk('public')->delete($profileimage);
        $image = Image::make($this->Client_Image)->encode('jpg');
        Storage::disk('public')->put($filename, $image);
        return $filename;
    }

    private function saveBalanceLedger($client_Id, $service)
    {
        $Description = "Received Rs. " . $this->Amount_Paid . "/- From  " . $this->Name . " Bearing Client ID: " . $client_Id . " & Mobile No: " . $this->Mobile_No . " for " . $service . " " . $this->SubSelected . ", on " . $this->Received_Date . " by  " . $this->PaymentMode . ", Total: " . $this->Total_Amount . ", Paid: " . $this->Amount_Paid . ", Balance: " . $this->Balance;

        $save_credit = new CreditLedger();
        $save_credit->fill([
            'Id' => $this->App_Id,
            'Client_Id' => $client_Id,
            'Branch_Id' => $this->Branch_Id,
            'Emp_Id' => $this->Emp_Id,
            'Category' => $service,
            'Sub_Category' => $this->SubSelected,
            'Date' => $this->Received_Date,
            'Total_Amount' => $this->Total_Amount,
            'Amount_Paid' => $this->Amount_Paid,
            'Balance' => $this->Balance,
            'Description' => $Description,
            'Payment_Mode' => $this->PaymentMode,
            'Attachment' => $this->Payment_Receipt,
        ]);
        $save_credit->save();
    }

    private function updateClientDetails($existingClient, $client_Id, $name, $Client_Image)
    {
        if (!$existingClient) return;

        if ($existingClient->DOB === NULL && $this->Dob) {
            DB::table('client_register')->where('Id', $client_Id)->update(['DOB' => $this->Dob]);
        }
        if ($existingClient->Gender === NULL && $this->Gender) {
            DB::table('client_register')->where('Id', $client_Id)->update(['Gender' => $this->Gender]);
        }
        if ($existingClient->Relative_Name === NULL && $this->RelativeName) {
            DB::table('client_register')->where('Id', $client_Id)->update(['Relative_Name' => $this->RelativeName]);
        }
        if ($existingClient->Client_Type === NULL && $this->Client_Type) {
            DB::table('client_register')->where('Id', $client_Id)->update(['Client_Type' => $this->Client_Type]);
        }
        if ($this->Profile_Update == 1 && $Client_Image) {
            DB::table('client_register')->where('Id', $client_Id)->update(['Profile_Image' => $Client_Image]);
        }
    }

    public function Capitalize()
    {
        if (!is_null($this->Name)) {
            $this->Name = ucwords($this->Name);
        }

        if (!is_null($this->RelativeName)) {
            $this->RelativeName = ucwords($this->RelativeName);
        }

        if (!is_null($this->Ack_No)) {
            $this->Ack_No = ucwords($this->Ack_No);
        }

        if (!is_null($this->Document_No)) {
            $this->Document_No = ucwords($this->Document_No);
        }
    }


    public function UnitPrice()
    {
        $main_id = $this->MainSelected;
        $serv_name = $this->SubSelected;

        // Fetch the first matching service directly
        $service = SubServices::where('Service_Id', $main_id)
                              ->where('Name', $serv_name)
                              ->first();

        if ($service) {
            $this->Total_Amount = $service->Unit_Price;
            $this->Service_Fee = $service->Service_Fee;
        } else {
            // Handle the case where no matching service is found
            $this->Total_Amount = 0;
            $this->Service_Fee = 0;
            session()->flash('Error', 'No matching service found.');
        }
    }


    public function Clear()
    {
        $this->Dob = NULL;
        $this->old_Applicant_Image = 'Not Available';
        $this->Name = NULL;
        $this->RelativeName = NULL;
        $this->Gender = NULL;
        $this->Client_Type = NULL;
        $this->clear_button = 'Disable';
    }

    public function ResetDefaults()
    {
        $this->Open = 0;
        $this->Clear();
        $this->resetPage();
    }

    public function LatestUpdate()
    {
        // Get the latest application
        $latest_app = Application::latest('created_at')->first();
        if ($latest_app) {
            $this->lastRecTime = Carbon::parse($latest_app->created_at)->diffForHumans();
        }

        // Filter for branch admin role
        $applicationQuery = Application::where('Mobile_No', $this->Mobile_No);
        $clientQuery = ClientRegister::where('Mobile_No', $this->Mobile_No);

        if (Auth::user()->role == 'branch admin') {
            $applicationQuery->where('Branch_Id', $this->Branch_Id);
            $clientQuery->where('Branch_Id', $this->Branch_Id);
        }

        // Get applications related to the mobile number
        $applied = $applicationQuery->get();
        if ($applied->isNotEmpty() && !empty($this->Mobile_No)) {
            $latest_mob_app = $applicationQuery->latest('created_at')->first();
            $this->lastMobRecTime = Carbon::parse($latest_mob_app->created_at)->diffForHumans();
        }

        // Get client profile related to the mobile number
        $profile = $clientQuery->get();
        if ($profile->isNotEmpty() && !empty($this->Mobile_No)) {
            $profile_created = $clientQuery->latest('created_at')->first();
            $latest_profile_update = $clientQuery->latest('updated_at')->first();
            $this->profileCreated = Carbon::parse($profile_created->created_at)->diffForHumans();
            $this->lastProfUpdate = Carbon::parse($latest_profile_update->updated_at)->diffForHumans();
        }
    }



    public function Autofill()
    {
        $this->clear_button = 'Enable';
        $Mobile_No = NULL;
        $Mobile_No = ClientRegister::Where('Mobile_No', $this->Mobile_No)->get();
        if (sizeof($Mobile_No) == 1) {
            $Mobile_No = ClientRegister::Where('Mobile_No', $this->Mobile_No)->get();
            if (sizeof($Mobile_No) == 1) {
                foreach ($Mobile_No as $key) {
                    $this->Dob = $key['DOB'];
                    $this->C_Id = $key['Id'];
                    $this->old_Applicant_Image = $key['Profile_Image'];
                    $this->Name = $key['Name'];
                    $this->RelativeName = $key['Relative_Name'];
                    $this->Gender = $key['Gender'];
                    $this->Mobile_No = $key['Mobile_No'];
                    $this->Client_Type = $key['Client_Type'];
                }
            }
        }
    }

    public function RefreshPage(){
        $this->resetpage();
    }
    public function DatewiseList($Select_Date)
    {
        if (!is_null($Select_Date)) {
            $date = Carbon::parse($Select_Date)->format('Y-m-d'); // Corrected date format

            $query = Application::where('Received_Date', '=', $date)
                                ->where('Recycle_Bin', '=', 'No')
                                ->filter($this->filterby);

            if (Auth::user()->role == 'branch admin') {
                $query->where('Branch_Id', $this->Branch_Id);
            }

            $this->daily_applications = $query->paginate($this->paginate);
            $this->Daily_Income = $this->daily_applications->sum('Amount_Paid');

            if ($this->daily_applications->isEmpty()) {
                session()->flash('Error', 'Sorry!! No Record Available for ' . $date);
            }
        }
    }
    public function Delete($Id)
    {
        // Check balance due in digital_cyber_db
        $check_bal_app = DB::table('digital_cyber_db')
            ->where('Id', $Id)
            ->where('Balance', '>', 0)
            ->exists();

        // Check balance due in balance_ledger
        $check_bal = DB::table('balance_ledger')
            ->where('Client_Id', $Id)
            ->where('Balance', '>', 0)
            ->exists();

        // Check balance due in credit_ledger
        $check_bal_credit = DB::table('credit_ledger')
            ->where('Client_Id', $Id)
            ->where('Balance', '>', 0)
            ->exists();


        if ($check_bal_app && $check_bal && $check_bal_credit) {
            session()->flash('Error', 'Balance Due Found for this Application Id: ' . $Id . ' Please Clear Due and try again!');
        } elseif ($check_bal_app && $check_bal) {
            session()->flash('Error', 'Balance Due Found in Balance Ledger for this Application Id: ' . $Id . ' Please Clear Due and try again!');
        } elseif ($check_bal_app && $check_bal_credit) {
            session()->flash('Error', 'Balance Due Found in Credit Ledger for this Application Id: ' . $Id . ' Please Clear Due and try again!');
        } elseif ($check_bal_app) {
            session()->flash('Error', 'Balance Due Found only In Application for this Application Id: ' . $Id . ' Please Clear Due and try again!');
        } else {
            // Update record to recycle bin if no balance due found
            $recyble_app = DB::table('digital_cyber_db')->where('Id', $Id)->update(['Recycle_Bin' => 'Yes']);
            if ($recyble_app) {
                session()->flash('SuccessMsg', 'Record for Application Id: ' . $Id . ' Deleted!');
            }
             //check credit ledger to delete same entry
             $checkCreditLedger = CreditLedger::where('Client_Id',$Id)->exists();
             if($checkCreditLedger){
                 CreditLedger::where('Client_Id',$Id)->delete();
             }
        }
    }


// Multiple Delete
    public function MultipleDelete()
    {
        // Perform the delete operation on the selected IDs
        $this->DeleteMultiple($this->Checked);
    }
    public function DeleteMultiple(array $Ids)
    {
        foreach ($Ids as $Id) {
            // Check balance due in digital_cyber_db
            $check_bal_app = DB::table('digital_cyber_db')
                ->where('Id', $Id)
                ->where('Balance', '>', 0)
                ->exists();

            // Check balance due in balance_ledger
            $check_bal = DB::table('balance_ledger')
                ->where('Client_Id', $Id)
                ->where('Balance', '>', 0)
                ->exists();

            // Check balance due in credit_ledger
            $check_bal_credit = DB::table('credit_ledger')
                ->where('Client_Id', $Id)
                ->where('Balance', '>', 0)
                ->exists();

            if ($check_bal_app && $check_bal && $check_bal_credit) {
                session()->flash('Error', 'Balance Due Found for this Application Id: ' . $Id . '. Please Clear Due and try again!');
                continue; // Skip to the next ID in the loop
            } elseif ($check_bal_app && $check_bal) {
                session()->flash('Error', 'Balance Due Found in Balance Ledger for this Application Id: ' . $Id . '. Please Clear Due and try again!');
                continue; // Skip to the next ID in the loop
            } elseif ($check_bal_app && $check_bal_credit) {
                session()->flash('Error', 'Balance Due Found in Credit Ledger for this Application Id: ' . $Id . '. Please Clear Due and try again!');
                continue; // Skip to the next ID in the loop
            } elseif ($check_bal_app) {
                session()->flash('Error', 'Balance Due Found only in Application for this Application Id: ' . $Id . '. Please Clear Due and try again!');
                continue; // Skip to the next ID in the loop
            } else {
                // Update record to recycle bin if no balance due found
                $recycle_app = DB::table('digital_cyber_db')->where('Id', $Id)->update(['Recycle_Bin' => 'Yes']);
                $checkCreditLedger = CreditLedger::where('Id',$Id)->exists();
                if($checkCreditLedger){
                    CreditLedger::where('Id',$Id)->delete();
                }
                if ($recycle_app) {
                    session()->flash('SuccessMsg', 'Record for Application Id: ' . $Id . ' Deleted!');
                } else {
                    session()->flash('Error', 'Failed to delete Application Id: ' . $Id);
                }
            }
        }
    }


    public function render()
    {
        $this->initializeProperties();
        $this->loadServices();
        $this->loadClientData();
        $this->loadApplicationData();
        $this->loadStatusList();
        $this->calculateBalance();
        $this->calculateDailyIncome();

        if (!is_null($this->Select_Date)) {
            $this->DatewiseList($this->Select_Date);
        }

        return view('livewire.admin-module.application.application-form', [
            'today' => $this->today,
            'payment_mode' => $this->payment_mode,
            'daily_applications' => $this->daily_applications,
            'main_service' => $this->main_service,
            'sub_service' => $this->sub_service,
            'Application' => $this->Application,
            'user_type' => $this->user_type,
            'status_list' => $this->status_list,
            'AppliedServices' => $this->AppliedServices,
            'lastRecTime' => $this->lastRecTime,
        ]);
    }

    private function initializeProperties()
    {
        $this->LatestUpdate();
        $this->Capitalize();
        $this->today = date("Y-m-d");
        $this->payment_mode = PaymentMode::all();
        $this->Daily_Income = 0;
    }

    private function loadServices()
    {
        $this->main_service = MainServices::orderby('Name')->get();
        if (!empty($this->MainSelected)) {
            $this->sub_service = SubServices::orderby('Name')
                ->where('Service_Id', $this->MainSelected)
                ->get();
        }
    }

    private function loadClientData()
    {
        $global_query = ClientRegister::where('Mobile_No', $this->Mobile_No);

        $client = $global_query->first();

        if ($client) {
            $this->loadRegisteredClientData($client);
        } else {
            $this->loadUnregisteredClientData();
        }
    }

    private function loadRegisteredClientData($client)
    {
        $this->C_Dob = $client->DOB;
        $this->C_Id = $client->Id;
        $this->Old_Profile_Image = $client->Profile_Image;
        $this->C_Name = $client->Name;
        $this->C_RName = $client->Relative_Name;
        $this->C_Gender = $client->Gender;
        $this->C_Email = $client->Email_Id;
        $this->C_Mob = $client->Mobile_No;
        $this->C_Address = $client->Address;
        $this->C_Ctype = $client->Client_Type;

        $query = Application::where('Mobile_No', $this->Mobile_No);
        if (Auth::user()->role == 'branch admin') {
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $this->AppliedServices = $query->get();
        $count = $this->AppliedServices->count();
        $this->Open = 1;
        $this->user_type = "Registered User!! Availed {$count} Service from this Branch";
    }

    private function loadUnregisteredClientData()
    {
        $query = Application::where('Mobile_No', $this->Mobile_No);
        if (Auth::user()->role == 'branch admin') {
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $applications = $query->get();
        $count = $applications->count();

        if ($count > 0) {
            $this->user_type = "Unregistered User!! Availed {$count} Services";
        } else {
            $this->Open = 0;
            $this->Profile_Show = 0;
            $this->Records_Show = 0;
            $this->user_type = "New Client";
        }
    }

    private function loadApplicationData()
    {
        $this->ApplicationType = SubServices::where('Service_Id', $this->ApplicationId)->get();
        $service = MainServices::find($this->MainSelected);
        if ($service) {
            $this->ServiceName = $service->Name;
        }
    }

    private function loadStatusList()
    {
        $this->status_list = Status::where('Relation', $this->ServiceName)
            ->orWhere('Relation', 'General')
            ->orderBy('Orderby', 'asc')
            ->get();
    }

    private function calculateBalance()
    {
        $this->Bal = intval($this->Total_Amount) - intval($this->Amount_Paid);
    }

    private function calculateDailyIncome()
    {
        $today = date("Y-m-d");
        $query = Application::where('Received_Date', $today)
            ->where('Recycle_Bin', 'No')
            ->filter($this->filterby);

        if (Auth::user()->role == 'branch admin') {
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $this->daily_applications = $query->paginate($this->paginate);

        foreach ($this->daily_applications as $application) {
            $this->Daily_Income += $application->Amount_Paid;
        }
    }

}
