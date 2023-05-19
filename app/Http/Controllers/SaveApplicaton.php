<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\CreditLedger;
use App\Models\ClientRegister;
use App\Models\BalanceLedger;
use App\Models\Service_List;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Traits\RightInsightTrait;

class SaveApplicaton extends Controller
{

    use RightInsightTrait;
    public $time;
     function __construct()
     {
        $this->time = time();
     }

    public function Home()
    {
        return view('Admin.Clients.registration');
    }

    public function Save(Request $request)
    {
        $Id =  "DCA".$this->time;

        $rule = ['Name'=>'required', 'Mobile_No'=>['required', 'min:10'],'Service'=>'required','Application_Type'=>'required','DOB'=>'required','Total_Amount'=>'required','Amount_Paid'=>'required','Balance'=>'required','Payment_Mode'=>'required'];
        $validation = Validator::make($request->input(), $rule);
        if($validation->fails())
        {
             return redirect('app_form')->withInput()->withErrors($validation);
        }
        else
        {
            $field = $request->input();
            $mobile = $field['Mobile_No'];
            $service = $field['Service'];
            $balance = $field['Balance'];
            $service = Service_List::Where('Id',$service)->get();
            foreach($service as $name)
            {
                $service = $name['Name'];
            }
            $exist = ClientRegister::Where('Mobile_No',$mobile)->get();
            if(sizeof($exist)>0) // For Registered Users
            {
                $client_id=NULL;
                foreach($exist as $key)
                {
                    $client_id = $key['Id'];
                }
                if($balance>0)
                {
                    $data=$request->input();
                    $app_field = new Application;
                    $app_field->Id = $Id;
                    $app_field->Client_Id = $client_id;
                    $app_field->Received_Date = $data['Received_Date'];
                    $app_field->Applicaiton = $service;
                    $app_field->Application_Type = $data['Application_Type'];
                    $app_field->Name = $data['Name'];
                    $app_field->Mobile_No = $data['Mobile_No'];
                    $app_field->DOB = $data['DOB'];
                    $app_field->Applied_Date = NULL;
                    $app_field->Total_Amount = $data['Total_Amount'];
                    $app_field->Amount_Paid = $data['Amount_Paid'];
                    $app_field->Balance = $data['Balance'];
                    $app_field->Payment_Mode=$data['Payment_Mode'];
                    $app_field->Status="Received";
                    $app_field->Ack_No=$data['Ack_No'];
                    $app_field->Document_No=$data['Document_No'];
                    $app_field->Delivered_Date= NULL;
                    $app_field->Recycle_Bin= "";
                    $app_field->save(); // Application Form Saved

                    $Description = "Received Rs. ".$data['Amount_Paid']."/- From  ".$data['Name']." Bearing Client ID: ".$client_id ." & Mobile No: ".$data['Mobile_No']." for ".$service. " ".$data['Application_Type'].", on ".$data['Received_Date']." by  ". $data['Payment_Mode'].", Total: ".$data['Total_Amount'].", Paid: ".$data['Amount_Paid'].", Balance: ".$data['Balance'];
                    $save_credit  = new CreditLedger;
                    $save_credit->Id = $Id;
                    $save_credit->Client_Id = $client_id;
                    $save_credit->Source =  $service. ''. $data['Application_Type'];
                    $save_credit->Date =    $data['Received_Date'];
                    $save_credit->Total_Amount =    $data['Total_Amount'];
                    $save_credit->Paid_Amount =  $data['Amount_Paid'];
                    $save_credit->Balance =  $data['Balance'];
                    $save_credit->Description = $Description;
                    $save_credit->Payment_Mode = $data['Payment_Mode'];
                    $save_credit->Attachment = "../Client/Payment/Attachements/..";
                    $save_credit->save(); //Credit Ledger Entry Saved

                    $save_balance = new BalanceLedger;
                    $save_balance->Id = $Id;
                    $save_balance->Client_Id = $client_id;
                    $save_balance->Date = $data['Received_Date'];
                    $save_balance->Name = $data['Name'];
                    $save_balance->Mobile_No = $data['Mobile_No'];
                    $save_balance->Service = $service." ".$data['Application_Type'];
                    $save_balance->Total_Amount =$data['Total_Amount'];
                    $save_balance->Amount_Paid = $data['Amount_Paid'];
                    $save_balance->Balance = $data['Balance'];
                    $save_balance->Payment_Mode = $data['Payment_Mode'];
                    $save_balance->Attachment = "./Client/Payments/Attachements/";
                    $save_balance->Description = $Description;
                    $save_balance->save(); // Balance Ledger Entry Saved
                    return redirect('app_form')->with('SuccessMsg','Application Saved Successfully!, Balance Ledger Updated');
                }
                else
                {

                    $data=$request->input();
                    $app_field = new Application;
                    $app_field->Id = $Id;
                    $app_field->Client_Id = $client_id;
                    $app_field->Received_Date = $data['Received_Date'];
                    $app_field->Applicaiton = $service;
                    $app_field->Application_Type = $data['Application_Type'];
                    $app_field->Name = $data['Name'];
                    $app_field->Mobile_No = $data['Mobile_No'];
                    $app_field->DOB = $data['DOB'];
                    $app_field->Applied_Date = NULL;
                    $app_field->Total_Amount = $data['Total_Amount'];
                    $app_field->Amount_Paid = $data['Amount_Paid'];
                    $app_field->Balance = $data['Balance'];
                    $app_field->Payment_Mode=$data['Payment_Mode'];
                    $app_field->Status="Received";
                    $app_field->Ack_No=$data['Ack_No'];
                    $app_field->Document_No=$data['Document_No'];
                    $app_field->Delivered_Date= NULL;
                    $app_field->Recycle_Bin= "";
                    $app_field->save(); // Application Form Saved

                    $Description = "Received Rs. ".$data['Amount_Paid']."/- From  ".$data['Name']." Bearing Client ID: ".$client_id ." & Mobile No: ".$data['Mobile_No']." for ".$service. " ".$data['Application_Type'].", on ".$data['Received_Date']." by  ". $data['Payment_Mode'].", Total: ".$data['Total_Amount'].", Paid: ".$data['Amount_Paid'].", Balance: ".$data['Balance'];
                    $save_credit  = new CreditLedger;
                    $save_credit->Id = $Id;
                    $save_credit->Client_Id = $client_id;
                    $save_credit->Source =  $service. ''. $data['Application_Type'];
                    $save_credit->Date =    $data['Received_Date'];
                    $save_credit->Total_Amount =    $data['Total_Amount'];
                    $save_credit->Paid_Amount =  $data['Amount_Paid'];
                    $save_credit->Balance =  $data['Balance'];
                    $save_credit->Description = $Description;
                    $save_credit->Payment_Mode = $data['Payment_Mode'];
                    $save_credit->Attachment = "../Client/Payment/Attachements/..";
                    $save_credit->save(); // Credit Ledger entry Saved

                    return redirect()->route('new.application')->with('SuccessMsg','Application Saved Successfully!!');
                }
            }
            else // For Unregistered or New Clients
            {
                $client_Id = 'DC'.$this->time;
                $data = $request->input();
                if($balance>0)
                {
                    // Client Registration
                    $user_data = new ClientRegister;
                    $user_data->Id= $client_Id;
                    $user_data->Name = $data['Name'];
                    $user_data->Mobile_No = $data['Mobile_No'];
                    $user_data->Email_Id = $data['Name'].'@gmail.com';
                    $user_data->DOB = $data['DOB'];
                    $user_data->Address = "Chikkabasthi";
                    $user_data->Profile_Image = "../Clinet/Profile_Image/img.jpg";
                    $user_data->Client_Type = "Old Client";
                    $user_data->Registered_On = $this->today;
                    $user_data->save(); // Client Registered

                    $app_field = new Application;
                    $app_field->Id = $Id;
                    $app_field->Client_Id = $client_Id;
                    $app_field->Received_Date = $data['Received_Date'];
                    $app_field->Applicaiton = $service;
                    $app_field->Application_Type = $data['Application_Type'];
                    $app_field->Name = $data['Name'];
                    $app_field->Mobile_No = $data['Mobile_No'];
                    $app_field->DOB = $data['DOB'];
                    $app_field->Applied_Date = NULL;
                    $app_field->Total_Amount = $data['Total_Amount'];
                    $app_field->Amount_Paid = $data['Amount_Paid'];
                    $app_field->Balance = $data['Balance'];
                    $app_field->Payment_Mode=$data['Payment_Mode'];
                    $app_field->Status="Received";
                    $app_field->Ack_No=$data['Ack_No'];
                    $app_field->Document_No=$data['Document_No'];
                    $app_field->Delivered_Date= NULL;
                    $app_field->Recycle_Bin= "";
                    $app_field->save(); //Application Form Saved

                    $Description = "Received Rs. ".$data['Amount_Paid']."/- From  ".$data['Name']." Bearing Client ID: ".$client_Id ." & Mobile No: ".$data['Mobile_No']." for ".$service. " ".$data['Application_Type'].", on ".$data['Received_Date']." by  ". $data['Payment_Mode'].", Total: ".$data['Total_Amount'].", Paid: ".$data['Amount_Paid'].", Balance: ".$data['Balance'];
                    $save_credit  = new CreditLedger;
                    $save_credit->Id = $Id;
                    $save_credit->Client_Id = $client_Id;
                    $save_credit->Source =  $service. ''. $data['Application_Type'];
                    $save_credit->Date =    $data['Received_Date'];
                    $save_credit->Total_Amount =    $data['Total_Amount'];
                    $save_credit->Paid_Amount =  $data['Amount_Paid'];
                    $save_credit->Balance =  $data['Balance'];
                    $save_credit->Description = $Description;
                    $save_credit->Payment_Mode = $data['Payment_Mode'];
                    $save_credit->Attachment = "../Client/Payment/Attachements/..";
                    $save_credit->save(); //Credit Ledger Saved

                    $save_balance = new BalanceLedger;
                    $save_balance->Id = $Id;
                    $save_balance->Client_Id = $client_Id;
                    $save_balance->Date = $data['Received_Date'];
                    $save_balance->Name = $data['Name'];
                    $save_balance->Mobile_No = $data['Mobile_No'];
                    $save_balance->Service = $service." ".$data['Application_Type'];
                    $save_balance->Total_Amount =$data['Total_Amount'];
                    $save_balance->Amount_Paid = $data['Amount_Paid'];
                    $save_balance->Balance = $data['Balance'];
                    $save_balance->Payment_Mode = $data['Payment_Mode'];
                    $save_balance->Attachment = "./Client/Payments/Attachements/";
                    $save_balance->Description = $Description;
                    $save_balance->save(); // Balance Ledgere Saved

                    return redirect()->route('new.application')->with('SuccessMsg','Client Registered! Application Saved Successfully!, Balance Ledgere Updated!');
                }
                else
                {
                    // Client Registration
                    $user_data = new ClientRegister;
                    $user_data->Id= $client_Id;
                    $user_data->Name = $data['Name'];
                    $user_data->Mobile_No = $data['Mobile_No'];
                    $user_data->Email_Id = $data['Name'].'@gmail.com';
                    $user_data->DOB = $data['DOB'];
                    $user_data->Address = "Chikkabasthi";
                    $user_data->Profile_Image = "../Clinet/Profile_Image/img.jpg";
                    $user_data->Client_Type = "Old Client";
                    $user_data->Registered_On = $this->today;
                    $user_data->save(); // Client Registered

                    $app_field = new Application;
                    $app_field->Id = $Id;
                    $app_field->Client_Id = $client_Id;
                    $app_field->Received_Date = $data['Received_Date'];
                    $app_field->Applicaiton = $service;
                    $app_field->Application_Type = $data['Application_Type'];
                    $app_field->Name = $data['Name'];
                    $app_field->Mobile_No = $data['Mobile_No'];
                    $app_field->DOB = $data['DOB'];
                    $app_field->Applied_Date = NULL;
                    $app_field->Total_Amount = $data['Total_Amount'];
                    $app_field->Amount_Paid = $data['Amount_Paid'];
                    $app_field->Balance = $data['Balance'];
                    $app_field->Payment_Mode=$data['Payment_Mode'];
                    $app_field->Status="Received";
                    $app_field->Ack_No=$data['Ack_No'];
                    $app_field->Document_No=$data['Document_No'];
                    $app_field->Delivered_Date= NULL;
                    $app_field->Recycle_Bin= "";
                    $app_field->save(); //Application Form Saved

                    $Description = "Received Rs. ".$data['Amount_Paid']."/- From  ".$data['Name']." Bearing Client ID: ".$client_Id ." & Mobile No: ".$data['Mobile_No']." for ".$service. " ".$data['Application_Type'].", on ".$data['Received_Date']." by  ". $data['Payment_Mode'].", Total: ".$data['Total_Amount'].", Paid: ".$data['Amount_Paid'].", Balance: ".$data['Balance'];
                    $save_credit  = new CreditLedger;
                    $save_credit->Id = $Id;
                    $save_credit->Client_Id = $client_Id;
                    $save_credit->Source =  $service. ''. $data['Application_Type'];
                    $save_credit->Date =    $data['Received_Date'];
                    $save_credit->Total_Amount =    $data['Total_Amount'];
                    $save_credit->Paid_Amount =  $data['Amount_Paid'];
                    $save_credit->Balance =  $data['Balance'];
                    $save_credit->Description = $Description;
                    $save_credit->Payment_Mode = $data['Payment_Mode'];
                    $save_credit->Attachment = "../Client/Payment/Attachements/..";
                    $save_credit->save(); //Credit Ledger Saved
                }

            }
        }
    }

}
