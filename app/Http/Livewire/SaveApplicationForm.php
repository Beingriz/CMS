<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Traits\RightInsightTrait;
use Illuminate\Support\Facades\Date;
use App\Models\Service_List;
use App\Models\Sub_Services;
use App\Models\ClientRegister;
use App\Models\BalanceLedger;
use App\Models\CreditLedger;
use App\Models\Application;
use App\Models\MainServices;
use App\Models\SubServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Intervention\Image\Facades\Image;


class SaveApplicationForm extends Component
{
    use RightInsightTrait;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    use WithPagination;



    public $App_Id;
    public $Name;
    public $Dob;
    public $Ack_No = 'Not Available';
    public $Document_No = 'Not Available';
    public $Total_Amount,$Amount_Paid,$Balance,$ServiceName, $Profile_Show=0,$Profile_Update,$Records_Show=0;
    public $PaymentMode,$Gender,$RelativeName;
    public $Received_Date,$Mobile_Num,$Confirmation;
    public $Ack_File,$Doc_File,$Payment_Receipt,$Status , $Client_Type;
    public $SubSelected ;
    public $MainSelected,$Application,$ApplicationType, $ApplicationId,$Application_Type  ;
    public $main_service,$Applicant_Image;
    public $sub_service = [];
    public $Mobile_No = NULL;
    public $user_type = NULL;
    public $Checked = [];
    public $paginate = 10;
    public $filterby ,$Bal=0;
    public $collection;
    public $Select_Date,$Daily_Income=0;
    public $Edit_Window =0;
    public $PaymentFile, $AckFile,$DocFile =0;

    public $Yes ='off',$Client_Image,$Old_Profile_Image, $C_Id, $C_Name,$C_RName,$C_Gender,$C_Email, $C_Dob, $C_Mob,$Open=0;


    protected $rules = [
         'Name' =>'required',
         'Gender' =>'required',
         'Dob' =>'required',
         'MainSelected' =>'required',
         'SubSelected' =>'required',
         'Mobile_No' =>'required | Min:10',
         'Total_Amount' =>'required',
         'Amount_Paid' =>'required',
         'PaymentMode' =>'required',
     ];
     protected $messages = [
        'name.required' => 'Applicant Name Cannot be Empty',
        'Gender.required' => 'Please Select Gender',
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
        $this->App_Id  = 'DCA'.date('Y').time();
        $this->Received_Date  = date('Y-m-d');
        $fetch = Application::Where('Received_Date','=',$this->Received_Date)->get();

        $this->Daily_Income = $this->daily_total;


    }
    public function Validation()
    {
        $this->validate(['Name'=>'required']);
    }

    public function submit()
    {
        $time = time();
        $this->validate();
        $this->Balance = ($this->Total_Amount - $this->Amount_Paid);
        $service = Service_List::Where('Id',$this->MainSelected)->get();
        foreach($service as $name)
        {
            $service = $name['Name'];
            $this->ServiceName = $service;
        }
        $exist = ClientRegister::Where('Mobile_No',$this->Mobile_No)->get();
        $client_Id=NULL;
        if(count($exist)>0)
        {
            foreach($exist as $key)
            {
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
        }
        else
        {
            $client_Id='DC'.time();
            $name = $this->Name;
        }

        if(!empty($this->Applicant_Image))
        {
            $filename = $this->Name.'_'.$client_Id.'.'.$this->Applicant_Image->getClientOriginalExtension();
            $url = 'Client_DB/'.$name.'_'.$client_Id.'/'.$this->ServiceName.'/'.trim($this->SubSelected).'/'.$filename;
            $file = Image::make($this->Applicant_Image)->encode('jpg');
            Storage::disk('public')->put($url,$file);
            $Applicant_Image = $url;
        }
        else
        {
            $Applicant_Image = 'Not Available';
        }
        if(!empty($this->Ack_File))
        {
            $extension = $this->Ack_File->getClientOriginalExtension();
            $path = 'Client_DB/'.$name.'_'.$client_Id.'/'.$this->ServiceName.'/'.trim($this->SubSelected).'/';
            $filename = 'AF_'.$this->Ack_No.'_'.$time.'.'.$extension;
            $url = $this->Ack_File->storePubliclyAs($path,$filename,'public');
            $this->Ack_File = $url;
        }
        else
        {
            $this->AckFile = 'Not Available';
        }
        if(!empty($this->Doc_File))
        {
            $extension = $this->Doc_File->getClientOriginalExtension();
            $path = 'Client_DB/'.$name.'_'.$client_Id.'/'.$this->ServiceName.'/'.trim($this->SubSelected).'/';
            $filename = 'DF_'.$this->Doc_File.'_'.$time.'.'.$extension;
            $url = $this->Doc_File->storePubliclyAs($path,$filename,'public');
            $this->Doc_File = $url;
        }
        else
        {
            $this->Doc_File = 'Not Available';
        }
        if(!empty($this->Payment_Receipt))
        {
            $extension = $this->Payment_Receipt->getClientOriginalExtension();
            $path = 'Client_DB/'.$name.'_'.$client_Id.'/'.$this->ServiceName.'/'.trim($this->SubSelected).'/';
            $filename = 'PR_'.$this->Payment_Receipt.'_'.$time.'.'.$extension;
            $url = $this->Payment_Receipt->storePubliclyAs($path,$filename,'public');
            $this->Payment_Receipt = $url;
        }
        else
        {
            $this->Payment_Receipt = 'Not Available';
        }
        if($this->Profile_Update==1)
        {
            if(!empty($this->Client_Image))
            {
                $filename = $name.date('Ymd').'_'.$this->Client_Image->getClientOriginalName();
                $filename = 'Client_DB/'.$this->Name.' '.time().'/Profile Photo'.$filename;
                Storage::disk('public')->delete($profileimage);
                $image = Image::make($this->Client_Image)->encode('jpg');
                Storage::disk('public')->put($filename,$image);
                $this->Client_Image = $filename;

            }
            else
            {
                $Client_Image = 'Not Available';

            }
        }
        else
        {
            $Client_Image = 'Not Available';

        }


        if(sizeof($exist)>0) // For Registered Users
        {
            if($this->Balance>0)
            {
                    $app_field = new Application;
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
                    $app_field->Payment_Mode= $this->PaymentMode;
                    $app_field->Payment_Receipt= $this->Payment_Receipt;
                    $app_field->Status= $this->Status;
                    $app_field->Ack_No= $this->Ack_No;
                    $app_field->Ack_File= $this->Ack_File;
                    $app_field->Document_No= $this->Document_No;
                    $app_field->Doc_File= $this->Doc_File;
                    $app_field->Delivered_Date= NULL;
                    $app_field->Applicant_Image= $Applicant_Image;
                    $app_field->save(); // Application Form Saved

                    $Description = "Received Rs. ".$this->Amount_Paid."/- From  ".$this->Name." Bearing Client ID: ".$client_Id ." & Mobile No: ".$this->Mobile_No." for ".$service. " ".$this->SubSelected.", on ".$this->Received_Date." by  ". $this->PaymentMode.", Total: ".$this->Total_Amount.", Paid: ".$this->Amount_Paid.", Balance: ".$this->Balance;
                    $save_credit  = new CreditLedger;
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
                    $save_credit->Attachment = $this->PaymentFile;
                    $save_credit->save(); //Credit Ledger Entry Saved

                    if($dob == NULL)
                    {
                        DB::update('update client_register set DOB=? where Id = ?', [$this->Dob,$client_Id]);
                    }
                    if($gender == NULL )
                    {
                        DB::update('update client_register set Gender=? where Id = ?', [$this->Gender,$client_Id]);
                    }
                    if($relative_name == NULL)
                    {
                        DB::update('update client_register set Relative_Name=? where Id = ?', [$this->RelativeName,$client_Id]);
                    }
                    if($client_type == NULL)
                    {
                        DB::update('update client_register set Client_Type=? where Id = ?', [$this->Client_Type,$client_Id]);
                    }
                    if($this->Profile_Update == 1)
                    {
                        DB::update('update client_register set Profile_Image=? where Id = ?', [$Client_Image,$client_Id]);
                    }


                    $save_balance = new BalanceLedger;
                    $save_balance->Id = $this->App_Id;
                    $save_balance->Client_Id = $client_Id;
                    $save_balance->Date = $this->Received_Date;
                    $save_balance->Name = $this->Name;
                    $save_balance->Mobile_No = $this->Mobile_No;
                    $save_balance->Category = $service;
                    $save_balance->Sub_Category = $this->SubSelected;
                    $save_balance->Total_Amount =$this->Total_Amount;
                    $save_balance->Amount_Paid = $this->Amount_Paid;
                    $save_balance->Balance = $this->Balance;
                    $save_balance->Payment_Mode =$this->PaymentMode;
                    $save_balance->Attachment = $this->PaymentFile;
                    $save_balance->Description = $Description;
                    $save_balance->save(); // Balance Ledger Entry Saved
                    session()->flash('SuccessMsg','Application Saved Successfully!, Balance Ledger Updated');
                    return redirect()->route('new_application');
                }
            else
            {

                $app_field = new Application;
                $app_field->Id = $this->App_Id;
                $app_field->Client_Id = $client_Id;
                $app_field->Received_Date = $this->Received_Date;
                $app_field->Application = $service;
                $app_field->Application_Type = $this->SubSelected;
                $app_field->Name = $this->Name;
                $app_field->Mobile_No =  $this->Mobile_No;
                $app_field->DOB = $this->Dob;
                $app_field->Applied_Date = NULL;
                $app_field->Total_Amount =  $this->Total_Amount;
                $app_field->Amount_Paid =  $this->Amount_Paid;
                $app_field->Balance =  $this->Balance;
                $app_field->Payment_Mode= $this->PaymentMode;
                $app_field->Payment_Receipt= $this->Payment_Receipt;
                $app_field->Status="Received";
                $app_field->Ack_No= $this->Ack_No;
                $app_field->Ack_File= $this->Ack_File;
                $app_field->Document_No= $this->Document_No;
                $app_field->Doc_File= $this->Doc_File;
                $app_field->Delivered_Date= NULL;
                $app_field->Applicant_Image= $Applicant_Image;
                $app_field->save(); // Application Form Saved

                if($dob == NULL)
                {
                    DB::update('update client_register set DOB=? where Id = ?', [$this->Dob,$client_Id]);
                }
                if($gender == NULL )
                {
                    DB::update('update client_register set Gender=? where Id = ?', [$this->Gender,$client_Id]);
                }
                if($relative_name == NULL)
                {
                    DB::update('update client_register set Relative_Name=? where Id = ?', [$this->RelativeName,$client_Id]);
                }
                if($client_type == NULL)
                {
                    DB::update('update client_register set Client_Type=? where Id = ?', [$this->Client_Type,$client_Id]);
                }
                if($this->Profile_Update == 1)
                {
                    DB::update('update client_register set Profile_Image=? where Id = ?', [$Client_Image,$client_Id]);
                }

                $Description = "Received Rs. ".$this->Amount_Paid."/- From  ".$this->Name." Bearing Client ID: ".$client_Id ." & Mobile No: ".$this->Mobile_No." for ".$service. " ".$this->SubSelected.", on ".$this->Received_Date." by  ". $this->PaymentMode.", Total: ".$this->Total_Amount.", Paid: ".$this->Amount_Paid.", Balance: ".$this->Balance;
                $save_credit  = new CreditLedger;
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
                $save_credit->Attachment = $this->PaymentFile;
                $save_credit->save(); //Credit Ledger Entry Saved
                session()->flash('SuccessMsg','Application Saved Successfully!!');
                return redirect()->route('new_application');
            }
        }
        else // For Unregistered or New Clients
        {
            $client_Id='DC'.time();

            if($this->Balance>0)
            {
                // Client Registration
                $user_data = new ClientRegister;
                $user_data->Id= $client_Id;
                $user_data->Name = $this->Name;
                $user_data->Relative_Name = $this->RelativeName;
                $user_data->Gender = $this->Gender;
                $user_data->Mobile_No = $this->Mobile_No;
                $user_data->Email_Id = $this->Name.'@gmail.com';
                $user_data->DOB = $this->Dob;
                $user_data->Address = "Chikkabasthi";
                $user_data->Profile_Image = $Client_Image;
                $user_data->Client_Type = $this->Client_Type;
                $user_data->save(); // Client Registered

                $app_field = new Application;
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
                $app_field->Payment_Mode= $this->PaymentMode;
                $app_field->Payment_Receipt= $this->Payment_Receipt;
                $app_field->Status= $this->Status;
                $app_field->Ack_No= $this->Ack_No;
                $app_field->Ack_File= $this->Ack_File;
                $app_field->Document_No= $this->Document_No;
                $app_field->Doc_File= $this->Doc_File;
                $app_field->Delivered_Date= NULL;
                $app_field->Applicant_Image= $Applicant_Image;
                $app_field->save(); // Application Form Saved

                $Description = "Received Rs. ".$this->Amount_Paid."/- From  ".$this->Name." Bearing Client ID: ".$client_Id ." & Mobile No: ".$this->Mobile_No." for ".$service. " ".$this->SubSelected.", on ".$this->Received_Date." by  ". $this->PaymentMode.", Total: ".$this->Total_Amount.", Paid: ".$this->Amount_Paid.", Balance: ".$this->Balance;
                $save_credit  = new CreditLedger;
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
                $save_credit->Attachment = $this->PaymentFile;
                $save_credit->save(); //Credit Ledger Entry Saved

                $save_balance = new BalanceLedger;
                $save_balance->Id = $this->App_Id;
                $save_balance->Client_Id = $client_Id;
                $save_balance->Date = $this->Received_Date;
                $save_balance->Name = $this->Name;
                $save_balance->Mobile_No = $this->Mobile_No;
                $save_balance->Category = $service;
                $save_balance->Sub_Category = $this->SubSelected;
                $save_balance->Total_Amount =$this->Total_Amount;
                $save_balance->Amount_Paid = $this->Amount_Paid;
                $save_balance->Balance = $this->Balance;
                $save_balance->Payment_Mode =$this->PaymentMode;
                $save_balance->Attachment = $this->PaymentFile;
                $save_balance->Description = $Description;
                $save_balance->save(); // Balance Ledger Entry Saved
                session()->flash('SuccessMsg','Client Registered! Application Saved Successfully!, Balance Ledgere Updated!');
                return redirect()->route('new_application');
            }
            else
            {
                // Client Registration
                $user_data = new ClientRegister;
                $user_data->Id= $client_Id;
                $user_data->Name = $this->Name;
                $user_data->Relative_Name = $this->RelativeName;
                $user_data->Gender = $this->Gender;
                $user_data->Mobile_No = $this->Mobile_No;
                $user_data->Email_Id = $this->Name.'@gmail.com';
                $user_data->DOB = $this->Dob;
                $user_data->Address = "Chikkabasthi";
                $user_data->Profile_Image = $Client_Image;
                $user_data->Client_Type = $this->Client_Type;
                $user_data->save(); // Client Registered

                $app_field = new Application;
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
                $app_field->Payment_Mode= $this->PaymentMode;
                $app_field->Payment_Receipt= $this->Payment_Receipt;
                $app_field->Status= $this->Status;
                $app_field->Ack_No= $this->Ack_No;
                $app_field->Ack_File= $this->Ack_File;
                $app_field->Document_No= $this->Document_No;
                $app_field->Doc_File= $this->Doc_File;
                $app_field->Delivered_Date= NULL;
                $app_field->Applicant_Image= $Applicant_Image;
                $app_field->save(); // Application Form Saved

                $Description = "Received Rs. ".$this->Amount_Paid."/- From  ".$this->Name." Bearing Client ID: ".$client_Id ." & Mobile No: ".$this->Mobile_No." for ".$service. " ".$this->SubSelected.", on ".$this->Received_Date." by  ". $this->PaymentMode.", Total: ".$this->Total_Amount.", Paid: ".$this->Amount_Paid.", Balance: ".$this->Balance;
                $save_credit  = new CreditLedger;
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
                $save_credit->Attachment = $this->PaymentFile;
                $save_credit->save(); //Credit Ledger Entry Saved
                session()->flash('SuccessMsg','Client Registered! Application Saved Successfully!,');
                return redirect()->route('new_application');

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
    public function ResetFields()
    {
        $this->Name = NULL;
        $this->Mobile_No = NULL;
        $this->Dob = NULL;
        $this->Client_Type = NULL;
        $this->Total_Amount = 0;
        $this->Amount_Paid = 0;
        $this->Status = 'Received';
        $this->Ack_No = 'Not Available';
        $this->Document_No = 'Not Available';
    }

    public function Edit($Client_Id)
    {
        $this->Edit_Window  = 1;
        $fetch = Application::Where('Client_Id',$Client_Id)->get();
        foreach($fetch as $field)
        {
            $this->Name = $field['Name'];
            $this->Application = $field['Application'];
            $this->Application_Type = $field['Application_Type'];
        }

    }
    public function Delete($Id)
    {
        $check_bal_app = DB::table('digital_cyber_db')->where('Id', '=', $Id)
           ->where(function ($query){  $query->where('Balance', '>', 0);  })->get();

        $check_bal = DB::table('balance_ledger')->where('Client_Id', '=', $Id)
           ->where(function ($query){  $query->where('Balance', '>', 0);  })->get();

        $check_bal_credit = DB::table('credit_ledger')->where('Client_Id', '=', $Id)
           ->where(function ($query){  $query->where('Balance', '>', 0);  })->get();

       if($check_bal && $check_bal_app && $check_bal_credit)
       {
           session()->flash('Error', 'Balance Due Found for this Application Id: '.$Id. ' Please Clear Due and try again!');
       }
       elseif($check_bal_app && $check_bal)
       {
            session()->flash('Error', 'Balance Due Found in Balance Ledger for this Application Id: '.$Id. ' Please Clear Due and try again!');
       }
       elseif($check_bal_app && $check_bal_credit)
       {
            session()->flash('Error', 'Balance Due Found in Credit Ledger for this Application Id: '.$Id. ' Please Clear Due and try again!');
       }
       elseif($check_bal_app)
       {
            session()->flash('Error', 'Balance Due Found only In Applicaiton for this Application Id: '.$Id. ' Please Clear Due and try again!');
       }
       else
       {
            $recyble_app = DB::table('digital_cyber_db')->where('Id', $Id)->update(['Recycle_Bin' => 'Yes']);
            if($recyble_app)
            {
                session()->flash('SuccessMsg', 'Record for Application Id: '.$Id. ' Deleted!');
            }
       }
    }

   public function MultipleDelete()
    {
       $check_bal = BalanceLedger::WhereIn('Id',$this->Checked)->get();
       if(sizeof($check_bal)>0)
       {
            $temp = collect([]);
           foreach($check_bal as $get_id )
           {
               $bal = 0;
               $bal_ids = $get_id['Client_Id'];
               $bal_id = $get_id['Id'];
               $desc = $get_id['Description'];
               $tot= $get_id['Total_Amount'];
               $paid = $get_id['Amount_Paid'];
               $bal += $get_id['Balance'];
               if($bal>0)
               {
                   $temp->push(['Id'=>$bal_ids,'Description'=>$desc, 'Total_Amount'=>$tot, 'Amount_Paid'=>$paid, 'Balance'=>$bal]);
                   $this->FilterChecked = [];
                   foreach ($temp as $key)
                   {
                       $id = $key['Id'];
                       array_push($this->FilterChecked, $id);
                   }
               }
           }

           $this->collection = $temp;

           $Checked= array_diff($this->Checked, $this->FilterChecked);
           $del_credit = CreditLedger::wherekey($Checked)->delete();
           $del_bal = BalanceLedger::wherekey($Checked)->delete();
           $del_app = Application::wherekey($Checked)->delete();
           if( $del_credit && $del_bal && $del_app)
           {
               session()->flash('SuccessMsg', count($Checked).' Records Deleted Successfully..');
           }
           else
           {
               session()->flash('Error', ' Records Unable to Delete..');
           }
       }
       else
       {
           $del_credit = CreditLedger::wherekey($this->Checked)->delete();
           $del_bal = BalanceLedger::wherekey($this->Checked)->delete();
           $del_app = Application::wherekey($this->Checked)->delete();
           if( $del_credit && $$del_bal && $del_app)
            {
               session()->flash('SuccessMsg', count($this->Checked).' Records Deleted Successfully..');
            }
            else
           {
               session()->flash('Error', count($this->Checked).' Records Unable to Delete..');
           }

       }

    }

   public function UpdateBalance($Id)
   {
       $fetch = BalanceLedger::where('Id',$Id)->get();
       $amount = 0;
       foreach ($fetch as $key)
       {
           $amount = $key['Balance'];
       }
       $update_bal = DB::table('balance_ledger')->where('Client_Id',$Id)->update(['Balance'=>0]);
       $update_credit = DB::table('credit_ledger')->where('Id',$Id)->update(['Balance'=>0]);
       if($update_bal && $update_credit)
       {
          session()->flash('SuccessMsg', 'Balance Due of Rupees '.$amount. ' is Cleared'.$Id);
       }
       else
       {
           session()->flash('Error', 'unable to update');

       }
   }


    public function render()
    {
        $this->Capitalize();

        $this->main_service = MainServices::orderby('Name')->get();
            if(!empty($this->MainSelected))
            {
                $this->sub_service = SubServices::orderby('Name')->Where('Service_Id', $this->MainSelected)->get();
            }

            $Mobile_No = NULL;
            $Mobile_No = ClientRegister::Where('Mobile_No',$this->Mobile_No)->get();
            if(sizeof($Mobile_No)==1)
            {
                $Mobile_No = ClientRegister::Where('Mobile_No',$this->Mobile_No)->get();
                if(sizeof($Mobile_No)==1)
                {
                    foreach($Mobile_No as $key)
                        {
                            $this->C_Dob = $key['DOB'];
                            $this->C_Id = $key['Id'];
                            $this->Old_Profile_Image = $key['Profile_Image'];
                            $this->C_Name = $key['Name'];
                            $this->C_RName = $key['Relative_Name'];
                            $this->C_Gender = $key['Gender'];
                            $this->C_Email = $key['Email'];
                            $this->C_Mob = $key['Mobile_No'];
                            $this->C_Address = $key['Address'];
                            $this->C_Ctype = $key['Client_Type'];
                        }
                    }
                $AppliedServices = Application::Where('Mobile_No',$this->Mobile_No)->get();
                $count = count($AppliedServices);

                $this->Open = 1;
                // $this->Client_Type = 'Old Client';
                // $this->Name = $this->C_Name;
                // $this->RelativeName = $this->C_RName;
                // $this->Gender = $this->C_Gender;
                // $this->Dob = $this->C_Dob;
                $this->user_type = "Registered User!! Availed ".$count." Services";
            }
            else
            {
                $Mobile_No = Application::Where('Mobile_No',$this->Mobile_No)->get();
                if(sizeof($Mobile_No)>0)
                {

                    $count = count($Mobile_No);
                    $this->user_type = "Unregistered User!! Availed ".$count."Services ";

                }
                else
                {
                    $this->user_type = "New Client";
                }
            }
            if(!is_null($this->Select_Date))
            {
                $daily_applications = Application::Where('Received_Date',$this->Select_Date)->filter($this->filterby)->paginate($this->paginate);
                $this->Daily_Income = 0;
                foreach($daily_applications as $key)
                {
                    $this->Daily_Income += $key['Amount_Paid'];
                }
                if(sizeof($daily_applications)==0)
                {
                    session()->flash('Error','Sorry!! No Record Available for '.$this->Select_Date);
                    $daily_applications = Application::Where('Received_Date',$this->today)->filter($this->filterby)->paginate($this->paginate);
                }
            }
            else
            {
                $daily_applications = Application::Where('Received_Date',$this->today)->filter($this->filterby)->paginate($this->paginate);
            }
            $this->ApplicationType = SubServices::where('Service_Id',$this->ApplicationId)->get();
            $service = Service_List::Where('Id',$this->MainSelected)->get();
            foreach($service as $name)
            {
                $service = $name['Name'];
                $this->ServiceName = $service;
            }
            $this->Bal = ($this->Total_Amount - $this->Amount_Paid);
            $AppliedServices = Application::latest()
                                            ->Where('Mobile_No',$this->Mobile_No)->paginate(5);


        return view('livewire.save-application-form',[
            'today'=>$this->today,'payment_mode'=>$this->payment_mode,
            'daily_total'=>$this->daily_total,'daily_applications'=>$daily_applications,
            'main_service'=>$this->main_service, 'sl_no'=>$this->sl_no, 'n'=>$this->n,
            'sub_service'=>$this->sub_service,'Application'=>$this->Application,
            'user_type'=>$this->user_type,'status_list'=>$this->status_list, 'AppliedServices'=>$AppliedServices,
        ]);
    }
}
