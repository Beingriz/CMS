<?php

namespace App\Http\Livewire\Admin\DataMigration;

use App\Models\Application;
use App\Models\ClientRegister;
use App\Models\CreditLedger;
use App\Models\CreditSource;
use App\Models\CreditSources;
use App\Models\MainServices;
use App\Models\Old_CreditLedger;
use App\Models\Old_Cyber_Data;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Null_;

class DataMigration extends Component
{
    public $Table,$OldServiceList,$Application,$Application_Type,$App_Id,$clinetReg,$appReg,$UnitPrice;
    public $digitalcyber=false,$creditsource=false,$debitsource=false,$bookmarks=false,$creditledger=false,$debitledger=false;

    public function Migrate(){

        if($this->Table == 'old_digial_cyber_db'){

            $fetchserv = MainServices::where('Id',$this->Application)->get();
            foreach($fetchserv as $item){
                $this->Application = $item['Name'];
            }

            // Fetching the Records of old Digital cyber DB Based on Application Selected
            $records = Old_Cyber_Data::where('services',$this->OldServiceList)->get();
            foreach($records as $item){
                $mobile = $item['mobile_no'];
                if(empty($mobile) ||empty($item['customer_name']) ){
                    continue;
                }
                $client_record = ClientRegister::where('Mobile_No',$mobile)->first();
                // if Client is Not Registered, Register and Save Application
                if(is_Null($client_record)){
                    $Client_Id = 'DC'.date('Y').strtoupper(Str::random(3)).rand(000,9999);
                    $client = new ClientRegister();
                    $client['Id'] = $Client_Id;
                    $client['Name'] = $item['customer_name'];
                    $client['Relative_Name'] = 'Not Available';
                    $client['Gender'] = 'Not Declared';
                    if( $item['dob'] == '0000-00-00'){
                        $client['DOB'] = NULL;
                    }else{
                        $client['DOB'] = $item['dob'];
                    }
                    $client['Mobile_No'] = $item['mobile_no'];
                    $client['Email_Id'] = 'Not Available';
                    $client['Address'] = 'Not Available';
                    $client['Profile_Image'] = 'account.png';
                    $client['Client_Type'] = 'Old Client';
                    $client->save(); //  Client Registered
                    $this->clinetReg++;

                    // Applicaiton Registration
                    $App_Id  = 'DCA'.date('Y').strtoupper(Str::random(3)).rand(000,9999);
                    $data = new Application();
                    $data['Id'] = $App_Id;
                    $data['Client_Id'] = $Client_Id;
                    if( $item['received_on'] == '0000-00-00' || $item['received_on'] == NULL ){
                        $data['Received_Date'] = NULL;
                    }else{
                        $data['Received_Date'] = $item['received_on'];
                    }
                    $data['Name'] =  $item['customer_name'];
                    $data['Gender'] = 'Not Declared';
                    $data['Relative_Name'] = 'Not Available';
                    if( $item['dob'] == '0000-00-00' || $item['dob'] == NULL ){
                        $data['Dob'] = Null;
                    }else{
                        $data['Dob'] = $item['dob'];
                    }
                    $data['Mobile_No'] = $item['mobile_no'];
                    $data['Application'] = $this->Application;
                    $data['Application_Type'] = $this->Application_Type;
                    if( $item['applied_on'] == '0000-00-00' || $item['applied_on'] == NULL){
                        $data['Applied_Date'] = NULL;
                    }else{
                        $data['Applied_Date'] = $item['applied_on'];
                    }
                    $data['Total_Amount'] = $item['total_amount'];
                    $data['Amount_Paid'] = $item['amount_paid'];
                    $data['Balance'] = $item['balance'];
                    $data['Payment_Mode'] = $item['payment_mode'];
                    $data['Payment_Receipt'] = 'Not Available';
                    if( $item['status'] == ''){
                        $data['Status'] = 'Received';
                    }else{
                        $data['Status'] = $item['status'];
                    }
                    if( $item['ack_no'] == ''){
                        $data['Ack_No'] = 'Not Available';
                    }else{
                        $data['Ack_No'] = $item['ack_no'];
                    }
                    $data['Ack_File'] = 'Not Available';
                    if( $item['document_no'] == ''){
                        $data['Document_No'] = 'Not Available';
                    }else{
                        $data['Document_No'] = $item['document_no'];
                    }
                    $data['Doc_File'] = 'Not Available';
                    $data['Applicant_Image'] = 'account.png';
                    if( $item['delivered_on'] == '' ||  $item['delivered_on'] == '0000-00-00'){
                        $data['Delivered_Date'] = date('Y-m-d');
                    }else{
                        $data['Delivered_Date'] = $item['delivered_on'];
                    }
                    $data['Message'] = 'Not Available';
                    $data['Consent'] = 'No';
                    $data['Recycle_Bin'] = 'No';
                    $data['Registered'] = 'Yes';
                    $data->save();
                    $this->appReg++;
                }else{ // Registered just Save Application
                    $Client_Id = $client_record->Id;

                    $App_Id  = 'DCA'.date('Y').strtoupper(Str::random(3)).rand(000,9999);
                    $data = new Application();
                    $data['Id'] = $App_Id;
                    $data['Client_Id'] = $Client_Id;
                    if( $item['received_on'] == '0000-00-00' || $item['received_on'] == NULL ){
                        $data['Received_Date'] = NULL;
                    }else{
                        $data['Received_Date'] = $item['received_on'];
                    }
                    $data['Name'] =  $item['customer_name'];
                    $data['Gender'] = 'Not Declared';
                    $data['Relative_Name'] = 'Not Available';
                    if( $item['dob'] == '0000-00-00' || $item['dob'] == NULL ){
                        $data['Dob'] = Null;
                    }else{
                        $data['Dob'] = $item['dob'];
                    }
                    $data['Mobile_No'] = $item['mobile_no'];
                    $data['Application'] = $this->Application;
                    $data['Application_Type'] = $this->Application_Type;
                    if( $item['applied_on'] == '0000-00-00' || $item['applied_on'] == NULL){
                        $data['Applied_Date'] = NULL;
                    }else{
                        $data['Applied_Date'] = $item['applied_on'];
                    }
                    $data['Total_Amount'] = $item['total_amount'];
                    $data['Amount_Paid'] = $item['amount_paid'];
                    $data['Balance'] = $item['balance'];
                    $data['Payment_Mode'] = $item['payment_mode'];
                    $data['Payment_Receipt'] = '';
                    if( $item['status'] == ''){
                        $data['Status'] = 'Received';
                    }else{
                        $data['Status'] = $item['status'];
                    }
                    if( $item['ack_no'] == ''){
                        $data['Ack_No'] = 'Not Available';
                    }else{
                        $data['Ack_No'] = $item['ack_no'];
                    }
                    $data['Ack_File'] = '';
                    if( $item['document_no'] == ''){
                        $data['Document_No'] = 'Not Available';
                    }else{
                        $data['Document_No'] = $item['document_no'];
                    }
                    $data['Doc_File'] = '';
                    $data['Applicant_Image'] = 'account.png';
                    if( $item['delivered_on'] == '' ||  $item['delivered_on'] == '0000-00-00'){
                        $data['Delivered_Date'] = date('Y-m-d');
                    }else{
                        $data['Delivered_Date'] = $item['delivered_on'];
                    }
                    $data['Message'] = 'Not Available';
                    $data['Consent'] = 'No';
                    $data['Recycle_Bin'] = 'No';
                    $data['Registered'] = 'Yes';
                    $data->save();
                    $this->appReg++;
                }




            }
            session()->flash('SuccessMsg', 'Clients '.$this->clinetReg . '& Application '. $this->appReg. ' Registered');
            $data = array();
            $data['status'] = 'Done';
            DB::table('old_service_list')->where('service_name',$this->OldServiceList)->update($data);
            $this->clinetReg=0;
            $this->appReg=0;

        } // End of Digital Cyber DB

        if($this->Table == 'old_credit_ledger'){

            $fetchserv = CreditSources::where('Source',$this->Application_Type)
                                        ->where('CS_Id',$this->Application)->get();
            foreach($fetchserv as $item){
                $this->UnitPrice = $item['Unit_Price'];
            }
            $fetchserv = CreditSource::where('Id',$this->Application)->get();
            foreach($fetchserv as $item){
                $this->Application = $item['Name'];
            }


            // Fetching the Records of old Digital cyber DB Based on Application Selected
            $records = Old_CreditLedger::where('perticular',$this->OldServiceList)->get();
            foreach($records as $item){
                // Old Data of Each Record
                $id = $item['transaction_id'];
                $date = $item['date'];
                $perticular = $item['perticular'];
                $amount = $item['amount'];
                $desc = $item['description'];
                $paymentmode = $item['payment_mode'];

                // Migration to new Table
                $Client_Id = 'DC'.date('Y').strtoupper(Str::random(3)).rand(000,9999);
                $data = new CreditLedger();
                $data['Id'] = $id;
                $data['Client_Id'] = $Client_Id;
                $data['Date'] = $date;
                $data['Category'] = $this->Application;
                $data['Sub_Category'] = $this->Application_Type;
                $data['Unit_Price'] = $this->UnitPrice;
                $data['Quantity'] = ($amount / $this->UnitPrice);
                $data['Total_Amount'] = $amount;
                $data['Amount_Paid'] = $amount;
                $data['Balance'] = 0;
                $data['Description'] = $desc;
                $data['Payment_Mode'] = $paymentmode;
                $data['Attachment'] = 'no_image.jpg';
                $data->save();
                $this->appReg++;

            }
            session()->flash('SuccessMsg', 'Entries '. $this->appReg. ' Stored');
            $data = array();
            $data['Status'] = 'Done';
            DB::table('old_credit_sources')->where('particular',$this->OldServiceList)->update($data);
            $this->appReg=0;
        }
    }



    public function render()
    {
        // $this->App_Id  = 'DCA'.date('Y').strtoupper(Str::random(3)).rand(000,9999);
        if($this->Table == 'old_digial_cyber_db'){
            $this->digitalcyber = true;
            $this->creditsource = false;
            $this->debitsource=false;
            $this->bookmarks=false;
            $this->creditledger=false;
            $this->debitledger=false;
        }elseif($this->Table == 'old_credit_source'){
            $this->digitalcyber = false;
            $this->creditsource =true;
            $this->debitsource=false;
            $this->bookmarks=false;
            $this->creditledger=false;
            $this->debitledger=false;
        }elseif($this->Table == 'old_debit_source'){
            $this->digitalcyber = false;
            $this->creditsource =false;
            $this->debitsource=true;
            $this->bookmarks=false;
            $this->creditledger=false;
            $this->debitledger=false;
        }elseif($this->Table == 'old_credit_ledger'){
            $this->digitalcyber = false;
            $this->creditsource =false;
            $this->debitsource=false;
            $this->bookmarks=false;
            $this->creditledger=true;
            $this->debitledger=false;
        }elseif($this->Table == 'old_debit_ledger'){
            $this->digitalcyber = false;
            $this->creditsource =false;
            $this->debitsource=false;
            $this->bookmarks=false;
            $this->creditledger=false;
            $this->debitledger=true;
        }elseif($this->Table == 'old_bookmark'){
            $this->digitalcyber = false;
            $this->creditsource =false;
            $this->debitsource=false;
            $this->bookmarks=true;
            $this->creditledger=false;
            $this->debitledger=false;
        }
        $old_servicelist = DB::table('old_service_list')->where('status','!=','Done')->get();
        $old_creditsources = DB::table('old_credit_sources')->where('Status','!=','Done')->get();
        $mainservices = DB::table('service_list')->get();
        $newSources = DB::table('credit_source')->get();
        $subservices = DB::table('sub_service_list')->where('Service_Id',$this->Application)->get();
        $subSources = DB::table('credit_sources')->where('CS_Id',$this->Application)->get();
        return view('livewire.admin.data-migration.data-migration',compact('old_servicelist','mainservices','subservices','old_creditsources','newSources','subSources'));
    }
}
