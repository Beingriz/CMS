<?php

namespace App\Http\Livewire;

use App\Models\Application;
use App\Models\DocumentFiles;
use App\Models\MainServices;
use App\Models\PaymentMode;
use App\Models\Status;
use App\Models\SubServices;
use App\Traits\RightInsightTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EditApplication extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $Client_Id,$Id,$App_Id;
    public $Name;
    public $Dob;
    public $Ack_No = 'Not Available';
    public $Document_No = 'Not Available';
    public $Total_Amount;
    public $Amount_Paid;
    public $Balance;
    public $PaymentMode, $PaymentModes;
    public $Received_Date,$Applied_Date,$Updated_Date ;
    public $SubServices,$SubService ;
    public $MainServices,$MainService ;
    public $Application;
    public $Application_Type ;
    public $Mobile_No = NULL;
    public $Status,$Ack_File,$Doc_File,$Payment_Receipt;
    public $Registered,$count_app=0, $app_count,$app_pending,$app_delivered,$app_deleted;
    public $total,$paid,$balance = 0,$n=1;
    public $filterby,$show = 0 , $Checked, $collection, $no='No';
    public $Select_Date,$Daily_Income=0;
    public $show_app=[];
    public $Ack,$Doc,$Pay;
    public $Ack_Path,$Doc_Path,$Payment_Path,$Profile_Image;


    public $i=1,$Pro_Yes='off' ;
    public $Check,$Doc_Yes='off', $No,$test,$Format ;
    public $Document_Name;
    public $Doc_Name;
    public $Document_Files=[];
    public $Doc_Names=[];
    public $NewTextBox = [];
    public $Doc_Files;
    public $label=[];



    protected $rules = [
        'Name' =>'required',
        'Dob' =>'required',
        'Mobile_No' =>'required | Min:10',
        'Total_Amount' =>'required',
        'Amount_Paid' =>'required',
        'PaymentMode' =>'required',
        'Applied_Date' =>'required',
    ];
    protected $messages = [
       'name.required' => 'Applicant Name Cannot be Empty',
       'dob.required' => 'Please Select Date of Birth',
       'Mobile_No.required' => 'Mobile Number Cannot Be Empty',
       'total_amount.required' => 'Enter Total Amount',
       'Amount_Paid.required' => 'Enter Amount Received',
       'PaymentMode.required' => 'Please Select Payment Mode',

   ];
    public function mount($Id)
    {

        $this->Updated_Date = date("Y-m-d");
        $this->PaymentModes = "Cash";
        $this->Id = $Id;

        $fetch = Application::Wherekey($Id)->get();
        foreach($fetch as $key)
        {
            $this->App_Id = $key['Id'];
            $this->Client_Id = $key['Client_Id'];
            $this->Name = $key['Name'];
            $this->Application = $key['Application'];
            $this->Application_Type = $key['Application_Type'];
            $this->Dob = $key['Dob'];
            $this->Mobile_No = $key['Mobile_No'];
            $this->Received_Date = $key['Received_Date'];
            $this->Applied_Date = $key['Applied_Date'];
            $this->Ack_No = $key['Ack_No'];
            $this->Document_No = $key['Document_No'];
            $this->Status = $key['Status'];
            $this->Document_No = $key['Document_No'];
            $this->Total_Amount = $key['Total_Amount'];
            $this->Amount_Paid = $key['Amount_Paid'];
            $this->Balance = $key['Balance'];
            $this->PaymentMode = $key['Payment_Mode'];
            $this->Status = $key['Status'];
            $this->Delivered_Date = $key['Delivered_Date'];
            $this->Registered = $key['Registered'];
            $this->Ack = $key['Ack_File'];
            $this->Doc = $key['Doc_File'];
            $this->Pay = $key['Payment_Receipt'];
            $this->Profile_Image = $key['Profile_Image'];
        }
        if(empty($this->Applied_Date))
        {
            $this->Applied_Date = date("Y-m-d");
        }

    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function AddNewText($i)
    {
        {
            $i = $i + 1;
            $this->i = $i;
            array_push($this->NewTextBox ,$i);
        }
    }
    public function Remove($value)
    {
        if (($key = array_search($value, $this->NewTextBox)) !== false)
        {
            unset($this->NewTextBox[$key]);
            array_pop($this->Document_Files);
            array_pop($this->Doc_Names);
        }
    }

    public function Update($Id)
    {
        $today = date("d-m-Y");
        $time = strtotime("now");
        $fetch = Application::Wherekey($Id)->get();
        foreach($fetch as $field)
        {
            $this->Client_Id = $field['Client_Id'];
            $Ack = $field['Ack_File'];
            $Doc = $field['Doc_File'];
            $Pay = $field['Payment_Receipt'];
        }
        $this->validate();
        if(!is_null($this->MainService))
        {
            $fetch = MainServices::wherekey($this->MainService)->get();
            foreach($fetch as $key)
            {
                $this->Application = $key['Name'];
            }
        }
        if(!is_null($this->SubService))
        {

            $this->Application_Type = $this->SubService;
        }
        if(!empty($this->Ack_File))
        {
            // Attept to Delete the Old file Before Updating New File for Perticular Application Id
            if($Ack != 'Not Available' )
            {
                if (Storage::exists($Ack))
                {
                    $delete_file =  unlink(storage_path('app/'.$Ack));
                    $Ack = 'Not Available';
                    DB::update('update digital_cyber_db set Ack_File = ? where Id = ? && Client_Id=?', [$Ack,$Id,$this->Client_Id]);
                    $this->Ack_Path = $this->Ack_File->storeAs('Client_DB/'.$this->Name.' '.$this->Client_Id.'/'.trim($this->Application).'/'.trim($this->Application_Type).'/Ack Files', 'Ack '.$this->Name.'_'.$this->Ack_No.' '.$today.$time.'.pdf');
                }
                else
                {
                    $Ack = 'Not Available';
                    DB::update('update digital_cyber_db set Ack_File = ? where Id = ? && Client_Id=?', [$Ack,$Id,$this->Client_Id]);
                    $this->Ack_Path = $this->Ack_File->storeAs('Client_DB/'.$this->Name.' '.$this->Client_Id.'/'.trim($this->Application).'/'.trim($this->Application_Type).'/Ack Files', 'Ack '.$this->Name.'_'.$this->Ack_No.' '.$today.$time.'.pdf');
                }
            }
            else
            {
                $this->Ack_Path = $this->Ack_File->storeAs('Client_DB/'.$this->Name.' '.$this->Client_Id.'/'.trim($this->Application).'/'.trim($this->Application_Type).'/Ack Files', 'Ack '.$this->Name.'_'.$this->Ack_No.' '.$today.$time.'.pdf');
            }
        }
        else
        {
            $this->Ack_Path = $Ack;
        }

        if(!empty($this->Doc_File))
        {
            // Attept to Delete the Old file Before Updating New File for Perticular Application Id
            if($Doc != 'Not Available' )
            {
                if (Storage::exists($Doc))
                {
                    $delete_file =  unlink(storage_path('app/'.$Doc));
                    $Doc = 'Not Available';
                    DB::update('update digital_cyber_db set Doc_File = ? where Id = ? && Client_Id=?', [$Doc,$Id,$this->Client_Id]);
                    $this->Doc_Path = $this->Doc_File->storeAs('Client_DB/'.$this->Name.' '.$this->Client_Id.'/'.trim($this->Application).'/'.trim($this->Application_Type).'/Document Files', 'Doc '.$this->Name.' '.$this->Document_No.' '.$today.$time.'.pdf');
                }
                else
                {
                    $Doc = 'Not Available';
                    DB::update('update digital_cyber_db set Doc_File = ? where Id = ? && Client_Id=?', [$Doc,$Id,$this->Client_Id]);
                    $this->Doc_Path = $this->Doc_File->storeAs('Client_DB/'.$this->Name.' '.$this->Client_Id.'/'.trim($this->Application).'/'.trim($this->Application_Type).'/Document Files', 'Doc '.$this->Name.' '.$this->Document_No.' '.$today.$time.'.pdf');
                }
            }
            else
            {
                $this->Doc_Path = $this->Doc_File->storeAs('Client_DB/'.$this->Name.' '.$this->Client_Id.'/'.trim($this->Application).'/'.trim($this->Application_Type).'/Document Files', 'Doc '.$this->Name.' '.$this->Document_No.' '.$today.$time.'.pdf');
            }
        }
        else
        {
            $this->Doc_Path = $Doc;
        }
        if(!empty($this->Payment_Receipt))
        {
            // Attept to Delete the Old file Before Updating New File for Perticular Application Id
            if($Pay != 'Not Available' )
            {
                if (Storage::exists($Pay))
                {
                    $delete_file =  unlink(storage_path('app/'.$Pay));
                    $Pay = 'Not Available';
                    DB::update('update digital_cyber_db set Payment_Receipt = ? where Id = ? && Client_Id=?', [$Pay,$Id,$this->Client_Id]);
                    $this->Payment_Path = $this->Payment_Receipt->storeAs('Client_DB/'.$this->Name.' '.$this->Client_Id.'/'.trim($this->Application).'/'.trim($this->Application_Type).'/Payment Files', 'Pay '.$this->Name.' '.$this->PaymentMode.' '.$today.$time.'.jpeg');
                }
                else
                {
                    dd('in no');
                    $Pay = 'Not Available';
                    DB::update('update digital_cyber_db set Payment_Receipt = ? where Id = ? && Client_Id=?', [$Pay,$Id,$this->Client_Id]);
                    $this->Payment_Path = $this->Payment_Receipt->storeAs('Client_DB/'.$this->Name.' '.$this->Client_Id.'/'.trim($this->Application).'/'.trim($this->Application_Type).'/Payment Files', 'Pay '.$this->Name.' '.$this->PaymentMode.' '.$today.$time.'.jpeg');
                }
            }
            else
            {
                $this->Payment_Path = $this->Payment_Receipt->storeAs('Client_DB/'.$this->Name.' '.$this->Client_Id.'/'.trim($this->Application).'/'.trim($this->Application_Type).'/Payment Files', 'Pay '.$this->Name.' '.$this->PaymentMode.' '.$today.$time.'.jpeg');
            }
        }
        else
        {
            $this->Payment_Path = $Pay;
        }
        $this->Balance = ($this->Total_Amount - $this->Amount_Paid);

        $Description = 'Updated '.$this->Amount_Paid.'/- From  '.$this->Name.' Bearing Client ID: '.$this->Client_Id.' & Mobile No: '.$this->Mobile_No.'for '.$this->Application.','.$this->Application_Type.', on '.$today.' by '. $this->PaymentMode;

        $update_App = DB::update('update digital_cyber_db set Name=?, Mobile_No=?, Application =?, Application_Type=?, Dob=?, Ack_No=?, Document_No=?, Applied_Date=?,Status=?,Total_Amount=?,Amount_Paid=?,Balance=?,Payment_Mode=?,Ack_File=?,Doc_File=?,	Payment_Receipt =?,Delivered_Date=? where Id = ? && Client_Id=? ', [$this->Name,$this->Mobile_No,$this->Application,$this->Application_Type,$this->Dob,$this->Ack_No,$this->Document_No,$this->Applied_Date,$this->Status,$this->Total_Amount,$this->Amount_Paid,$this->Balance,$this->PaymentMode,$this->Ack_Path,$this->Doc_Path,$this->Payment_Path,$this->Updated_Date,$Id,$this->Client_Id ]);
        if($this->Check = 'on' )
        {
            if(count($this->Document_Files)>0)
            {
                if($this->Doc_Names =='')
                    {
                        $this->Doc_Names = $this->Name.' Document';
                    }
                foreach($this->Document_Files as $Docs => $Path)
                {
                    $this->n++;

                    $file = $Path->storeAs('Client_DB/'.$this->Name.' '.$this->Client_Id.'/'.trim($this->Application).'/'.trim($this->Application_Type).'/Document Files', $this->Name.' '.$this->Doc_Names[$Docs].' '.$Id.' '.$today.$time.'.pdf');
                    $save_doc = new DocumentFiles();
                    $save_doc->Id = 'DOC'.mt_rand(0, 9999);
                    $save_doc->App_Id = $Id;
                    $save_doc->Client_Id = $this->Client_Id;
                    $save_doc->Document_Name =  $this->Doc_Names[$Docs];
                    $save_doc->Document_Path =  $file;
                    $save_doc->save();
                }
                $save_doc = new DocumentFiles();
                $save_doc->Id = 'DOC'.mt_rand(0, 9999);
                $save_doc->App_Id = $Id;
                $save_doc->Client_Id = $this->Client_Id;
                $save_doc->Document_Path = $this->Document_Name->storeAs('Client_DB/'.$this->Name.' '.$this->Client_Id.'/'.trim($this->Application).'/'.trim($this->Application_Type).'/Document Files', $this->Name.' '.$this->Doc_Name.' '.$today.$time.'.pdf');
                $save_doc->Document_Name =  $this->Doc_Name;
                $save_doc->save();
                session()->flash('SuccessMsg', $this->n.' Documents Added to '.$this->Name.' Folder Successfully!');
            }
            elseif(!empty($this->Document_Name))
            {
                $save_doc = new DocumentFiles();
                $save_doc->Id = 'DOC'.mt_rand(0, 9999);
                $save_doc->App_Id = $Id;
                $save_doc->Client_Id = $this->Client_Id;
                $save_doc->Document_Path = $this->Document_Name->storeAs('Client_DB/'.$this->Name.' '.$this->Client_Id.'/'.trim($this->Application).'/'.trim($this->Application_Type).'/Document Files', $this->Doc_Name.' '.$Id.' '.$today.$time.'.pdf');
                $save_doc->Document_Name =  $this->Doc_Name;
                $save_doc->save();
                session()->flash('SuccessMsg', 'Document Uploaded Successfully!');
            }
        }
        if( $update_App)
        {
            session()->flash('SuccessUpdate', 'Application Details for '.$this->Name.' is Updated Successfully');
        }
        $update_Bal = DB::update('update balance_ledger set Name=?, Mobile_No=?, Category=?, Sub_Category=?,Total_Amount =?, Amount_Paid=?, Balance=?,Payment_Mode=?,Attachment=?, Description=? where Id = ? && Client_Id=?', [$this->Name, $this->Mobile_No,$this->Application,$this->Application_Type,$this->Total_Amount,$this->Amount_Paid,$this->Balance,$this->PaymentMode, $this->Payment_Path,$Description,$Id, $this->Client_Id]);
        if($update_Bal)
        {
            session()->flash('SuccessMsg', 'Balance Ledger Updated for '.$this->Name);
        }

        $update_Credit = DB::update('update credit_ledger set Category=?, Sub_Category=?,Total_Amount =?, Amount_Paid=?, Balance=?,Payment_Mode=?,Attachment=?, Description=? where Id = ? && Client_Id=?', [$this->Application,$this->Application_Type,$this->Total_Amount,$this->Amount_Paid,$this->Balance,$this->PaymentMode, $this->Payment_Path,$Description,$Id, $this->Client_Id]);
        if($update_Credit)
        {
            session()->flash('SuccessMsg', 'Credit Ledger Updated for '.$this->Name);
        }
        return redirect('../open_app'.'/'.$Id);
        // if($update_App && $update_Bal)
        // {
        //     session()->flash('SuccessUpdate', 'Application Details for '.$this->Name.' is Updated Successfully');
        //
        // }
    }
    public function Capitalize()
    {
        $this->Name = ucwords($this->Name);
        $this->Ack_No = ucwords($this->Ack_No);
        $this->Document_No = ucwords($this->Document_No);
        foreach($this->Doc_Names as $Doc)
        {
            $Doc = ucwords($Doc);

        }
    }
    public function Delete_Doc($Id)
    {
        $fetch = DocumentFiles::Wherekey($Id)->get();
        foreach($fetch as $key)
        {
            $path = $key['Document_Path'];
            $name = $key['Document_Name'];
        }
        if (Storage::exists($path))
        {
            unlink(storage_path('app/'.$path));
            $delete = DocumentFiles::Wherekey($Id)->delete();
            if($delete)
            {
                session()->flash('SuccessMsg', $name.' Deleted Successfully!');
            }
            else
            {
                session()->flash('Error', 'Unable to Delete');
            }
        }
        else
        {
            session()->flash('Error', 'File Not Available');
        }
    }
    public function render()
    {
        $this->Capitalize();
        $this->MainServices = MainServices::all();
        $this->SubServices = SubServices::Where('Service_Id',$this->MainService)->get();
        $Payment_Modes = PaymentMode::all();
        $StatusList = Status::all();
        $yes = 'Yes';
        $applicant_data = DB::table('digital_cyber_db')->where([['Client_Id','=',$this->Client_Id],['Recycle_Bin','=',$this->no]])->get();
        $mobile='';
        foreach ($applicant_data as $field)
        {
            $field = get_object_vars($field);
            {
                $mobile = $field['Mobile_No'];
            }
        }
        $get_app = DB::table('digital_cyber_db')->where('Mobile_No','=',$mobile)->get();
        $this->count_app = count($get_app);
        $this->app_delivered =  DB::table('digital_cyber_db')->where([['Mobile_No','=',$mobile],['Recycle_Bin','=',$this->no],['Status','=',$this->Status]])->count();
        $this->app_pending =  $this->count_app - $this->app_delivered;
        $this->app_deleted =  DB::table('digital_cyber_db')->where([['Mobile_No','=',$mobile],['Recycle_Bin','=',$yes]])->count();
        foreach ($applicant_data as $amt)
        {
            $amt = get_object_vars($amt);
            {
                $this->total =  $amt['Total_Amount'];
                $this->paid = $amt['Amount_Paid'];
                $this->balance =  $amt['Balance'];
            }
        }


        $this->Doc_Files = DocumentFiles::Where([['App_Id',$this->Id],['Client_Id',$this->Client_Id]])->get();
        return view('livewire.edit-application',['Payment_Modes'=>$Payment_Modes,'StatusList'=>$StatusList]);
    }
}
