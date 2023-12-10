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
use App\Traits\WhatsappTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ApplicationForm extends Component
{
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    use WhatsappTrait;


    public $App_Id, $today, $payment_mode;
    public $Name;
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
    public $user_type = NULL;
    public $Checked = [];
    public $paginate = 05;
    public $filterby, $Bal = 0;
    public $collection;
    public $Select_Date, $Daily_Income = 0;
    public $Edit_Window = 0;
    public $PaymentFile, $AckFile, $DocFile = 0, $FilterChecked;

    public $Yes = 'off', $Client_Image, $Old_Profile_Image, $C_Id, $C_Name, $C_RName, $C_Gender, $C_Email, $C_Dob, $C_Mob, $C_Ctype, $C_Address, $Open = 0, $lastMobRecTime, $profileCreated, $lastProfUpdate, $status_list;


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
    }
    public function Validation()
    {
        $this->validate(['Name' => 'required']);
    }
    public function submit()
    {

        $this->validate();
        $this->Balance = ($this->Total_Amount - $this->Amount_Paid);
        $service = MainServices::Where('Id', $this->MainSelected)->get();
        foreach ($service as $name) {
            $service = $name['Name'];
            $this->ServiceName = $service;
        }
        $exist = ClientRegister::Where('Mobile_No', $this->Mobile_No)->get();
        $client_Id = NULL;
        if (count($exist) > 0) {
            foreach ($exist as $key) {
                $client_Id = $key['Id'];
                $dob = $key['DOB'];
                $name = $key['Name'];
                $relative_name = $key['Relative_Name'];
                $gender = $key['Gender'];
                $mobile = $key['Mobile'];
                $email = $key['Email_Id'];
                $address = $key['Address'];
                $client_type = $key['Cliednt_Type'];
                $profileimage = $key['Profile_Image'];
            }
        } else {
            $client_Id = 'DC' . time();
            $name = $this->Name;
            $profileimage =  'noimage';
        }

        if (!empty($this->Applicant_Image)) {
            $filename = $this->Name . '_' . $client_Id . '.' . $this->Applicant_Image->getClientOriginalExtension();
            $url = 'Client_DB/' . $name . '_' . $client_Id . '/' . $this->Name . '/' . $this->ServiceName . '/' . trim($this->SubSelected) . '/' . $filename;
            $file = Image::make($this->Applicant_Image)->encode('jpg');
            Storage::disk('public')->put($url, $file);
            $Applicant_Image = $url;
        } else {
            $Applicant_Image = 'storage/no_image.jpg';
        }
        if (!empty($this->Ack_File)) {
            $extension = $this->Ack_File->getClientOriginalExtension();
            $path = 'Client_DB/' . $name . '_' . $client_Id . '/' . $this->Name . '/' . $this->ServiceName . '/' . trim($this->SubSelected);
            $filename = 'AF_' . $this->Ack_No . '_' . time() . '.' . $extension;
            $url = $this->Ack_File->storePubliclyAs($path, $filename, 'public');
            $this->Ack_File = $url;
        } else {
            $this->Ack_File = 'Not Available';
        }
        if (!empty($this->Doc_File)) {
            $extension = $this->Doc_File->getClientOriginalExtension();
            $path = 'Client_DB/' . $name . '_' . $client_Id . '/' . $this->Name . '/' . $this->ServiceName . '/' . trim($this->SubSelected);
            $filename = 'DF_' . $this->Document_No . '_' . time() . '.' . $extension;
            $url = $this->Doc_File->storePubliclyAs($path, $filename, 'public');
            $this->Doc_File = $url;
        } else {
            $this->Doc_File = 'Not Available';
        }
        if (!empty($this->Payment_Receipt)) {
            $extension = $this->Payment_Receipt->getClientOriginalExtension();
            $path = 'Client_DB/' . $name . '_' . $client_Id . '/' . $this->Name . '/' . $this->ServiceName . '/' . trim($this->SubSelected);
            $filename = 'PR_' . $this->PaymentMode . '_' . time() . '.' . $extension;
            $url = $this->Payment_Receipt->storePubliclyAs($path, $filename, 'public');
            $this->Payment_Receipt = $url;
        } else {
            $this->Payment_Receipt = 'Not Available';
        }
        if ($this->Profile_Update == 1) {
            if (!empty($this->Client_Image)) {
                $filename = $name . date('Ymd') . '_' . $this->Client_Image->getClientOriginalName();
                $filename = 'Client_DB/' . $this->Name . ' ' . time() . '/Profile Photo' . $filename;
                Storage::disk('public')->delete($profileimage);
                $image = Image::make($this->Client_Image)->encode('jpg');
                Storage::disk('public')->put($filename, $image);
                $Client_Image = $filename;
            } else {
                $Client_Image = 'storage/no_image.jpg';
            }
        } else {
            $Client_Image =  $Applicant_Image;
        }


        if (sizeof($exist) > 0) // For Registered Users
        {
            if ($this->Balance > 0) {
                $app_field = new Application();
                $app_field->Id = $this->App_Id;
                $app_field->Client_Id = $client_Id;
                $app_field->Received_Date = $this->Received_Date;
                $app_field->Application = $service;
                $app_field->Application_Type = $this->SubSelected;
                $app_field->Name = $this->Name;
                $app_field->Gender = $this->Gender;
                $app_field->Relative_Name = $this->RelativeName;
                $app_field->Mobile_No =  $this->Mobile_No;
                $app_field->DOB = $this->Dob;
                $app_field->Applied_Date = NULL;
                $app_field->Total_Amount =  $this->Total_Amount;
                $app_field->Amount_Paid =  $this->Amount_Paid;
                $app_field->Balance =  $this->Balance;
                $app_field->Payment_Mode = $this->PaymentMode;
                $app_field->Payment_Receipt = $this->Payment_Receipt;
                $app_field->Status = $this->Status;
                $app_field->Ack_No = $this->Ack_No;
                $app_field->Ack_File = $this->Ack_File;
                $app_field->Document_No = $this->Document_No;
                $app_field->Doc_File = $this->Doc_File;
                $app_field->Delivered_Date = NULL;
                $app_field->Applicant_Image = $Applicant_Image;
                $app_field->save(); // Application Form Saved

                $Description = "Received Rs. " . $this->Amount_Paid . "/- From  " . $this->Name . " Bearing Client ID: " . $client_Id . " & Mobile No: " . $this->Mobile_No . " for " . $service . " " . $this->SubSelected . ", on " . $this->Received_Date . " by  " . $this->PaymentMode . ", Total: " . $this->Total_Amount . ", Paid: " . $this->Amount_Paid . ", Balance: " . $this->Balance;
                $save_credit  = new CreditLedger();
                $save_credit->Id = $this->App_Id;
                $save_credit->Client_Id = $client_Id;
                $save_credit->Category =  $service;
                $save_credit->Sub_Category = $this->SubSelected;
                $save_credit->Date =   $this->Received_Date;
                $save_credit->Total_Amount =    $this->Total_Amount;
                $save_credit->Amount_Paid =  $this->Amount_Paid;
                $save_credit->Balance = $this->Balance;
                $save_credit->Description = $Description;
                $save_credit->Payment_Mode = $this->PaymentMode;
                $save_credit->Attachment = $this->Payment_Receipt;
                $save_credit->save(); //Credit Ledger Entry Saved

                if ($dob == NULL) {
                    DB::update('update client_register set DOB=? where Id = ?', [$this->Dob, $client_Id]);
                }
                if ($gender == NULL) {
                    DB::update('update client_register set Gender=? where Id = ?', [$this->Gender, $client_Id]);
                }
                if ($relative_name == NULL) {
                    DB::update('update client_register set Relative_Name=? where Id = ?', [$this->RelativeName, $client_Id]);
                }
                if ($client_type == NULL) {
                    DB::update('update client_register set Client_Type=? where Id = ?', [$this->Client_Type, $client_Id]);
                }
                if ($this->Profile_Update == 1) {
                    DB::update('update client_register set Profile_Image=? where Id = ?', [$Client_Image, $client_Id]);
                }


                $save_balance = new BalanceLedger();
                $save_balance->Id = $this->App_Id;
                $save_balance->Client_Id = $client_Id;
                $save_balance->Date = $this->Received_Date;
                $save_balance->Name = $this->Name;
                $save_balance->Mobile_No = $this->Mobile_No;
                $save_balance->Category = $service;
                $save_balance->Sub_Category = $this->SubSelected;
                $save_balance->Total_Amount = $this->Total_Amount;
                $save_balance->Amount_Paid = $this->Amount_Paid;
                $save_balance->Balance = $this->Balance;
                $save_balance->Payment_Mode = $this->PaymentMode;
                $save_balance->Attachment = $this->Payment_Receipt;
                $save_balance->Description = $Description;
                $save_balance->save(); // Balance Ledger Entry Saved
                session()->flash('SuccessMsg', 'Application Saved Successfully!, Balance Ledger Updated');
                $this->ApplicaitonRegisterAlert($this->Mobile_No,$name, $this->Name, $service, $this->SubSelected );
                return redirect()->route('new.application');
            } else {

                $app_field = new Application();
                $app_field->Id = $this->App_Id;
                $app_field->Client_Id = $client_Id;
                $app_field->Received_Date = $this->Received_Date;
                $app_field->Application = $service;
                $app_field->Application_Type = $this->SubSelected;
                $app_field->Name = $this->Name;
                $app_field->Gender = $this->Gender;
                $app_field->Mobile_No =  $this->Mobile_No;
                $app_field->DOB = $this->Dob;
                $app_field->Applied_Date = NULL;
                $app_field->Total_Amount =  $this->Total_Amount;
                $app_field->Amount_Paid =  $this->Amount_Paid;
                $app_field->Balance =  $this->Balance;
                $app_field->Payment_Mode = $this->PaymentMode;
                $app_field->Payment_Receipt = $this->Payment_Receipt;
                $app_field->Status = "Received";
                $app_field->Ack_No = $this->Ack_No;
                $app_field->Ack_File = $this->Ack_File;
                $app_field->Document_No = $this->Document_No;
                $app_field->Doc_File = $this->Doc_File;
                $app_field->Delivered_Date = NULL;
                $app_field->Applicant_Image = $Applicant_Image;
                $app_field->save(); // Application Form Saved

                if ($dob == NULL) {
                    DB::update('update client_register set DOB=? where Id = ?', [$this->Dob, $client_Id]);
                }
                if ($gender == NULL) {
                    DB::update('update client_register set Gender=? where Id = ?', [$this->Gender, $client_Id]);
                }
                if ($relative_name == NULL) {
                    DB::update('update client_register set Relative_Name=? where Id = ?', [$this->RelativeName, $client_Id]);
                }
                if ($client_type == NULL) {
                    DB::update('update client_register set Client_Type=? where Id = ?', [$this->Client_Type, $client_Id]);
                }
                if ($this->Profile_Update == 1) {
                    DB::update('update client_register set Profile_Image=? where Id = ?', [$Client_Image, $client_Id]);
                }

                $Description = "Received Rs. " . $this->Amount_Paid . "/- From  " . $this->Name . " Bearing Client ID: " . $client_Id . " & Mobile No: " . $this->Mobile_No . " for " . $service . " " . $this->SubSelected . ", on " . $this->Received_Date . " by  " . $this->PaymentMode . ", Total: " . $this->Total_Amount . ", Paid: " . $this->Amount_Paid . ", Balance: " . $this->Balance;
                $save_credit  = new CreditLedger();
                $save_credit->Id = $this->App_Id;
                $save_credit->Client_Id = $client_Id;
                $save_credit->Category =  $service;
                $save_credit->Sub_Category = $this->SubSelected;
                $save_credit->Date =   $this->Received_Date;
                $save_credit->Total_Amount =    $this->Total_Amount;
                $save_credit->Amount_Paid =  $this->Amount_Paid;
                $save_credit->Balance = $this->Balance;
                $save_credit->Description = $Description;
                $save_credit->Payment_Mode = $this->PaymentMode;
                $save_credit->Attachment = $this->Payment_Receipt;
                $save_credit->save(); //Credit Ledger Entry Saved
                session()->flash('SuccessMsg', 'Application Saved Successfully!!');
                $this->ApplicaitonRegisterAlert($this->Mobile_No,$name, $this->Name, $service, $this->SubSelected );
                return redirect()->route('new.application');
            }
        } else // For Unregistered or New Clients
        {
            $client_Id = 'DC' . time();

            if ($this->Balance > 0) {
                // Client Registration
                $user_data = new ClientRegister();
                $user_data->Id = $client_Id;
                $user_data->Name = $this->Name;
                $user_data->Relative_Name = $this->RelativeName;
                $user_data->Gender = $this->Gender;
                $user_data->Mobile_No = $this->Mobile_No;
                $user_data->Email_Id = $this->Name . '@gmail.com';
                $user_data->DOB = $this->Dob;
                $user_data->Address = "Chikkabasthi";
                $user_data->Profile_Image = $Client_Image;
                $user_data->Client_Type = $this->Client_Type;
                $user_data->save(); // Client Registered

                $app_field = new Application();
                $app_field->Id = $this->App_Id;
                $app_field->Client_Id = $client_Id;
                $app_field->Received_Date = $this->Received_Date;
                $app_field->Application = $service;
                $app_field->Application_Type = $this->SubSelected;
                $app_field->Name = $this->Name;
                $app_field->Relative_Name = $this->RelativeName;
                $app_field->Gender = $this->Gender;
                $app_field->Mobile_No =  $this->Mobile_No;
                $app_field->DOB = $this->Dob;
                $app_field->Applied_Date = NULL;
                $app_field->Total_Amount =  $this->Total_Amount;
                $app_field->Amount_Paid =  $this->Amount_Paid;
                $app_field->Balance =  $this->Balance;
                $app_field->Payment_Mode = $this->PaymentMode;
                $app_field->Payment_Receipt = $this->Payment_Receipt;
                $app_field->Status = $this->Status;
                $app_field->Ack_No = $this->Ack_No;
                $app_field->Ack_File = $this->Ack_File;
                $app_field->Document_No = $this->Document_No;
                $app_field->Doc_File = $this->Doc_File;
                $app_field->Delivered_Date = NULL;
                $app_field->Applicant_Image = $Applicant_Image;
                $app_field->save(); // Application Form Saved

                $Description = "Received Rs. " . $this->Amount_Paid . "/- From  " . $this->Name . " Bearing Client ID: " . $client_Id . " & Mobile No: " . $this->Mobile_No . " for " . $service . " " . $this->SubSelected . ", on " . $this->Received_Date . " by  " . $this->PaymentMode . ", Total: " . $this->Total_Amount . ", Paid: " . $this->Amount_Paid . ", Balance: " . $this->Balance;
                $save_credit  = new CreditLedger();
                $save_credit->Id = $this->App_Id;
                $save_credit->Client_Id = $client_Id;
                $save_credit->Category =  $service;
                $save_credit->Sub_Category = $this->SubSelected;
                $save_credit->Date =   $this->Received_Date;
                $save_credit->Total_Amount =    $this->Total_Amount;
                $save_credit->Amount_Paid =  $this->Amount_Paid;
                $save_credit->Balance = $this->Balance;
                $save_credit->Description = $Description;
                $save_credit->Payment_Mode = $this->PaymentMode;
                $save_credit->Attachment = $this->Payment_Receipt;
                $save_credit->save(); //Credit Ledger Entry Saved

                $save_balance = new BalanceLedger();
                $save_balance->Id = $this->App_Id;
                $save_balance->Client_Id = $client_Id;
                $save_balance->Date = $this->Received_Date;
                $save_balance->Name = $this->Name;
                $save_balance->Mobile_No = $this->Mobile_No;
                $save_balance->Category = $service;
                $save_balance->Sub_Category = $this->SubSelected;
                $save_balance->Total_Amount = $this->Total_Amount;
                $save_balance->Amount_Paid = $this->Amount_Paid;
                $save_balance->Balance = $this->Balance;
                $save_balance->Payment_Mode = $this->PaymentMode;
                $save_balance->Attachment = $this->Payment_Receipt;
                $save_balance->Description = $Description;
                $save_balance->save(); // Balance Ledger Entry Saved
                session()->flash('SuccessMsg', 'Client Registered! Application Saved Successfully!, Balance Ledgere Updated!');
                $this->ApplicaitonRegisterAlert($this->Mobile_No, $this->Name, $this->Name, $service, $this->SubSelected );
                return redirect()->route('new.application');
            } else {
                // Client Registration
                $user_data = new ClientRegister();
                $user_data->Id = $client_Id;
                $user_data->Name = $this->Name;
                $user_data->Relative_Name = $this->RelativeName;
                $user_data->Gender = $this->Gender;
                $user_data->Mobile_No = $this->Mobile_No;
                $user_data->Email_Id = $this->Name . '@gmail.com';
                $user_data->DOB = $this->Dob;
                $user_data->Address = "Chikkabasthi";
                $user_data->Profile_Image = $Client_Image;
                $user_data->Client_Type = $this->Client_Type;
                $user_data->save(); // Client Registered

                $app_field = new Application();
                $app_field->Id = $this->App_Id;
                $app_field->Client_Id = $client_Id;
                $app_field->Received_Date = $this->Received_Date;
                $app_field->Application = $service;
                $app_field->Application_Type = $this->SubSelected;
                $app_field->Name = $this->Name;
                $app_field->Relative_Name = $this->RelativeName;
                $app_field->Gender = $this->Gender;
                $app_field->Mobile_No =  $this->Mobile_No;
                $app_field->DOB = $this->Dob;
                $app_field->Applied_Date = NULL;
                $app_field->Total_Amount =  $this->Total_Amount;
                $app_field->Amount_Paid =  $this->Amount_Paid;
                $app_field->Balance =  $this->Balance;
                $app_field->Payment_Mode = $this->PaymentMode;
                $app_field->Payment_Receipt = $this->Payment_Receipt;
                $app_field->Status = $this->Status;
                $app_field->Ack_No = $this->Ack_No;
                $app_field->Ack_File = $this->Ack_File;
                $app_field->Document_No = $this->Document_No;
                $app_field->Doc_File = $this->Doc_File;
                $app_field->Delivered_Date = NULL;
                $app_field->Applicant_Image = $Applicant_Image;
                $app_field->save(); // Application Form Saved

                $Description = "Received Rs. " . $this->Amount_Paid . "/- From  " . $this->Name . " Bearing Client ID: " . $client_Id . " & Mobile No: " . $this->Mobile_No . " for " . $service . " " . $this->SubSelected . ", on " . $this->Received_Date . " by  " . $this->PaymentMode . ", Total: " . $this->Total_Amount . ", Paid: " . $this->Amount_Paid . ", Balance: " . $this->Balance;
                $save_credit  = new CreditLedger();
                $save_credit->Id = $this->App_Id;
                $save_credit->Client_Id = $client_Id;
                $save_credit->Category =  $service;
                $save_credit->Sub_Category = $this->SubSelected;
                $save_credit->Date =   $this->Received_Date;
                $save_credit->Total_Amount =    $this->Total_Amount;
                $save_credit->Amount_Paid =  $this->Amount_Paid;
                $save_credit->Balance = $this->Balance;
                $save_credit->Description = $Description;
                $save_credit->Payment_Mode = $this->PaymentMode;
                $save_credit->Attachment = $this->Payment_Receipt;
                $save_credit->save(); //Credit Ledger Entry Saved
                session()->flash('SuccessMsg', 'Client Registered! Application Saved Successfully!,');
                $this->ApplicaitonRegisterAlert($this->Mobile_No, $this->Name, $this->Name, $service, $this->SubSelected );
                return redirect()->route('new.application');
            }
        }
    }
    public function Capitalize()
    {
        $this->Name = ucwords($this->Name);
        $this->RelativeName = ucwords($this->RelativeName);
        $this->Ack_No = ucwords($this->Ack_No);
        $this->Document_No = ucwords($this->Document_No);
    }
    public function UnitPrice()
    {
        $main_id = $this->MainSelected;
        $serv_name = $this->SubSelected;
        $unitprice = SubServices::where([['Service_Id', '=', $main_id], ['Name', '=', $serv_name]])->get();
        foreach ($unitprice as $key) {
            $this->Total_Amount = $key['Unit_Price'];
            $this->Service_Fee = $key['Service_Fee'];
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
    }
    public function LatestUpdate()
    {
        $latest_app = Application::latest('created_at')->first();
        $this->lastRecTime =  Carbon::parse($latest_app['created_at'])->diffForHumans();

        $applied = Application::Where('Mobile_No', $this->Mobile_No)->get();
        if (count($applied) > 0) {
            if (!empty($this->Mobile_No)) {
                $latest_mob_app = Application::where('Mobile_No', $this->Mobile_No)->latest('created_at')->first();
                $this->lastMobRecTime =  Carbon::parse($latest_mob_app['created_at'])->diffForHumans();
            }
        }
        $profile = ClientRegister::Where('Mobile_No', $this->Mobile_No)->get();
        if (count($profile) > 0) {
            if (!empty($this->Mobile_No)) {
                $profile_created = ClientRegister::where('Mobile_No', $this->Mobile_No)->latest('created_at')->first();
                $latest_profile_update = ClientRegister::where('Mobile_No', $this->Mobile_No)->latest('updated_at')->first();
                $this->profileCreated =  Carbon::parse($profile_created['created_at'])->diffForHumans();
                $this->lastProfUpdate =  Carbon::parse($latest_profile_update['updated_at'])->diffForHumans();
            }
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

    public function Delete($Id)
    {
        $check_bal_app = DB::table('digital_cyber_db')->where('Id', '=', $Id)
            ->where(function ($query) {
                $query->where('Balance', '>', 0);
            })->get();

        $check_bal = DB::table('balance_ledger')->where('Client_Id', '=', $Id)
            ->where(function ($query) {
                $query->where('Balance', '>', 0);
            })->get();

        $check_bal_credit = DB::table('credit_ledger')->where('Client_Id', '=', $Id)
            ->where(function ($query) {
                $query->where('Balance', '>', 0);
            })->get();

        if ($check_bal && $check_bal_app && $check_bal_credit) {
            session()->flash('Error', 'Balance Due Found for this Application Id: ' . $Id . ' Please Clear Due and try again!');
        } elseif ($check_bal_app && $check_bal) {
            session()->flash('Error', 'Balance Due Found in Balance Ledger for this Application Id: ' . $Id . ' Please Clear Due and try again!');
        } elseif ($check_bal_app && $check_bal_credit) {
            session()->flash('Error', 'Balance Due Found in Credit Ledger for this Application Id: ' . $Id . ' Please Clear Due and try again!');
        } elseif ($check_bal_app) {
            session()->flash('Error', 'Balance Due Found only In Applicaiton for this Application Id: ' . $Id . ' Please Clear Due and try again!');
        } else {
            $recyble_app = DB::table('digital_cyber_db')->where('Id', $Id)->update(['Recycle_Bin' => 'Yes']);
            if ($recyble_app) {
                session()->flash('SuccessMsg', 'Record for Application Id: ' . $Id . ' Deleted!');
            }
        }
    }

    public function MultipleDelete()
    {
        $check_bal = BalanceLedger::WhereIn('Id', $this->Checked)->get();
        if (sizeof($check_bal) > 0) {
            $temp = collect([]);
            foreach ($check_bal as $get_id) {
                $bal = 0;
                $bal_ids = $get_id['Client_Id'];
                $bal_id = $get_id['Id'];
                $desc = $get_id['Description'];
                $tot = $get_id['Total_Amount'];
                $paid = $get_id['Amount_Paid'];
                $bal += $get_id['Balance'];
                if ($bal > 0) {
                    $temp->push(['Id' => $bal_ids, 'Description' => $desc, 'Total_Amount' => $tot, 'Amount_Paid' => $paid, 'Balance' => $bal]);
                    $this->FilterChecked = [];
                    foreach ($temp as $key) {
                        $id = $key['Id'];
                        array_push($this->FilterChecked, $id);
                    }
                }
            }

            $this->collection = $temp;

            $Checked = array_diff($this->Checked, $this->FilterChecked);
            $del_credit = CreditLedger::wherekey($Checked)->delete();
            $del_bal = BalanceLedger::wherekey($Checked)->delete();
            $del_app = Application::wherekey($Checked)->delete();
            if ($del_credit && $del_bal && $del_app) {
                session()->flash('SuccessMsg', count($Checked) . ' Records Deleted Successfully..');
            } else {
                session()->flash('Error', ' Records Unable to Delete..');
            }
        } else {
            $del_credit = CreditLedger::wherekey($this->Checked)->delete();
            $del_bal = BalanceLedger::wherekey($this->Checked)->delete();
            $del_app = Application::wherekey($this->Checked)->delete();
            if ($del_credit && $$del_bal && $del_app) {
                session()->flash('SuccessMsg', count($this->Checked) . ' Records Deleted Successfully..');
            } else {
                session()->flash('Error', count($this->Checked) . ' Records Unable to Delete..');
            }
        }
    }

    public function UpdateBalance($Id)
    {
        $fetch = BalanceLedger::where('Id', $Id)->get();
        $amount = 0;
        foreach ($fetch as $key) {
            $amount = $key['Balance'];
        }
        $update_bal = DB::table('balance_ledger')->where('Client_Id', $Id)->update(['Balance' => 0]);
        $update_credit = DB::table('credit_ledger')->where('Id', $Id)->update(['Balance' => 0]);
        if ($update_bal && $update_credit) {
            session()->flash('SuccessMsg', 'Balance Due of Rupees ' . $amount . ' is Cleared' . $Id);
        } else {
            session()->flash('Error', 'unable to update');
        }
    }

    public function render()
    {
        $this->LatestUpdate();
        $this->Capitalize();


        $this->main_service = MainServices::orderby('Name')->get();
        if (!empty($this->MainSelected)) {
            $this->sub_service = SubServices::orderby('Name')->Where('Service_Id', $this->MainSelected)->get();
        }

        $Mobile_No = NULL;
        $Mobile_No = ClientRegister::Where('Mobile_No', $this->Mobile_No)->get();
        if (sizeof($Mobile_No) == 1) //for Registered Clients
        {
            $Mobile_No = ClientRegister::Where('Mobile_No', $this->Mobile_No)->get();
            if (sizeof($Mobile_No) == 1) {
                foreach ($Mobile_No as $key) {
                    $this->C_Dob = $key['DOB'];
                    $this->C_Id = $key['Id'];
                    $this->Old_Profile_Image = $key['Profile_Image'];
                    $this->C_Name = $key['Name'];
                    $this->C_RName = $key['Relative_Name'];
                    $this->C_Gender = $key['Gender'];
                    $this->C_Email = $key['Email'];
                    $this->C_Mob = $key['Mobile_No'];
                    // $this->C_Address = $key['Address'];
                    // $this->C_Ctype = $key['Client_Type'];
                }
            }
            $AppliedServices = Application::Where('Mobile_No', $this->Mobile_No)->get();
            $count = count($AppliedServices);
            $this->Open = 1;
            $this->user_type = "Registered User!! Availed " . $count . " Services";
        } else // for Unregistered clients
        {
            $Mobile_No = Application::Where('Mobile_No', $this->Mobile_No)->get();
            if (sizeof($Mobile_No) > 0) {
                $count = count($Mobile_No);
                $this->user_type = "Unregistered User!! Availed " . $count . "Services ";
            } else {
                $this->Open = 0;
                $this->Profile_Show = 0;
                $this->Records_Show = 0;
                $this->user_type = "New Client";
            }
        }

        if (!is_null($this->Select_Date)) //Report on form page for Searh by Date
        {
            $date = Carbon::parse($this->Select_Date)->format('d-M-Y');
            $daily_applications = Application::Where('Received_Date', $this->Select_Date)->filter($this->filterby)->paginate($this->paginate);
            $this->Daily_Income = 0;
            foreach ($daily_applications as $key) {
                $this->Daily_Income += $key['Amount_Paid'];
            }
            if (sizeof($daily_applications) == 0) {
                session()->flash('Error', 'Sorry!! No Record Available for ' . $date);
                $daily_applications = Application::Where('Received_Date', $this->today)->filter($this->filterby)->paginate($this->paginate);
            }
        } else {
            $daily_applications = Application::Where('Received_Date', $this->today)->filter($this->filterby)->paginate($this->paginate);
        }


        $this->ApplicationType = SubServices::where('Service_Id', $this->ApplicationId)->get();
        $service = MainServices::Where('Id', $this->MainSelected)->get();
        foreach ($service as $name) {
            $service = $name['Name'];
            $this->ServiceName = $service;
        }
        $this->Bal = (intval($this->Total_Amount) - intval($this->Amount_Paid));
        $AppliedServices = Application::latest()
            ->Where('Mobile_No', $this->Mobile_No)->paginate(8);
        $this->status_list = Status::Where('Relation', $this->ServiceName)
            ->orWhere('Relation', 'General')
            ->orderBy('Orderby', 'asc')
            ->get();

        $today = date("Y-m-d");
        $status_list = $this->status_list;
        $this->payment_mode = PaymentMode::all();

        $daily_applications = Application::Where('Received_Date', $today)->filter($this->filterby)->paginate($this->paginate);

        $this->main_service = MainServices::orderby('Name')->get();
        if (!empty($this->MainSelected)) {
            $this->sub_service = SubServices::orderby('Name')->Where('Service_Id', $this->MainSelected)->get();
        }
        $this->today = date("Y-m-d");
        return view('livewire.admin-module.application.application-form', [
            'today' => $this->today, 'payment_mode' => $this->payment_mode,
            'daily_applications' => $daily_applications,
            'main_service' => $this->main_service,
            'sub_service' => $this->sub_service, 'Application' => $this->Application,
            'user_type' => $this->user_type, 'status_list' => $this->status_list, 'AppliedServices' => $AppliedServices, 'lastRecTime' => $this->lastRecTime
        ]);
    }
}
