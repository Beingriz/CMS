<?php

namespace App\Http\Livewire;

use App\Models\Application;
use App\Models\DocumentFiles;
use App\Models\MainServices;
use App\Models\PaymentMode;
use App\Models\Status;
use App\Models\SubServices;
use App\Traits\RightInsightTrait;
use Carbon\Carbon;
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
    public $Name, $Checked = [];
    public $Dob,$Applicant_Image,$Profile_Update,$main_service=[],$sub_service=[];
    public $Ack_No = 'Not Available';
    public $Document_No = 'Not Available';
    public $Total_Amount,$today;
    public $Amount_Paid;
    public $Balance;
    public $PaymentMode, $PaymentModes,$Client_Type,$Confirmation,$Client_Image,$Old_Profile_Image;
    public $Received_Date,$Applied_Date,$Updated_Date,$old_Applicant_Image ;
    public $ServiceName,$SubService ;
    public $MainService,$MainServices ;
    public $Application;
    public $Application_Type ;
    public $Mobile_No = NULL;
    public $Status,$Ack_File,$Doc_File,$Payment_Receipt;
    public $Registered,$count_app=0, $app_count,$app_pending,$app_delivered,$app_deleted;
    public $total,$paid,$balance = 0,$n=1;
    public $filterby,$show = 0 , $collection, $no='No';
    public $Select_Date,$Daily_Income=0;
    public $show_app=[];
    public $Ack,$Doc,$Pay;
    public $Ack_Path,$Doc_Path,$Payment_Path,$Profile_Image,$RelativeName,$Gender;
    public $created,$updated,$AckFileDownload='Disable',$DocFileDownload='Disable',$PayFileDownload='Disable'  ;


    public $i=1,$Pro_Yes='off' ;
    public $Check,$Doc_Yes=0, $No,$test,$Format ;
    public $Document_Name;
    public $Doc_Name;
    public $Document_Files=[];
    public $Doc_Names=[];
    public $NewTextBox = [];
    public $label=[];



    protected $rules = [
        'Name' =>'required',
        'RelativeName' =>'required',
        'Gender' =>'required',
        'Dob' =>'required',
        'Mobile_No' =>'required | Min:10',
        'Total_Amount' =>'required',
        'Amount_Paid' =>'required',
        'PaymentMode' =>'required',
        'Applied_Date' =>'required',
        'MainService' =>'required',
        'SubService' =>'required',
    ];
    protected $messages = [
       'name.required' => 'Applicant Name Cannot be Empty',
       'RelativeName.required' => 'Enter Relative Name',
       'Gender.required' => 'Please Select Gender',
       'MainService.required' => 'Please Select Service',
       'SubService.required' => 'Please Select Service Category',
       'dob.required' => 'Please Select Date of Birth',
       'Mobile_No.required' => 'Mobile Number Cannot Be Empty',
       'total_amount.required' => 'Enter Total Amount',
       'Amount_Paid.required' => 'Enter Amount Received',
       'PaymentMode.required' => 'Please Select Payment Mode',

   ];
    public function mount($Id)
    {
        $this->today = today();
        $this->Updated_Date = date("Y-m-d");
        $this->PaymentModes = "Cash";
        $this->Id = $Id;
        $this->CheckFileExist($Id);
        $fetch = Application::Wherekey($Id)->get();
        foreach($fetch as $key)
        {
            $this->App_Id = $key['Id'];
            $this->Client_Id = $key['Client_Id'];
            $this->Name = $key['Name'];
            $this->RelativeName = $key['Relative_Name'];
            $this->Gender = $key['Gender'];
            $this->Application = $key['Application'];
            $this->Application_Type = $key['Application_Type'];
            $this->SubService = $key['Application_Type'];
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
            $this->old_Applicant_Image = $key['Applicant_Image'];
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
    public function CheckFileExist($Id)
    {
        $data = Application::WhereKey($Id)->get();
        foreach($data as $key)
        {
            $ack_file = $key['Ack_File'];
            $doc_file = $key['Doc_File'];
            $pay_file = $key['Payment_Receipt'];
        }

        if($ack_file != 'Not Available')
        {
            if(Storage::disk('public')->exists($ack_file))
            {
                $this->AckFileDownload = 'Enable';
            }
            else
            {
                $this->AckFileDownload = 'Disable';
            }
        }

        if($doc_file != 'Not Available')
        {
            if(Storage::disk('public')->exists($doc_file))
            {
                $this->DocFileDownload = 'Enable';
            }
            else
            {
                $this->DocFileDownload = 'Disable';
            }
        }
        if($pay_file != 'Not Available')
        {
            if(Storage::disk('public')->exists($pay_file))
            {
                $this->PayFileDownload = 'Enable';
            }
            else
            {
                $this->DocFiPayFileDownloadleDownload = 'Disable';
            }
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
            $name = $field['Name'];
            $client_Id = $field['Client_Id'];
            $old_Ack_File = $field['Ack_File'];
            $old_Doc_File = $field['Doc_File'];
            $old_Pay_File = $field['Payment_Receipt'];
            $old_App_Image = $field['Applicant_Image'];
        }

        $this->validate();
        if(!is_null($this->MainService))
        {
            $fetch = MainServices::wherekey($this->MainService)->get();
            foreach($fetch as $key)
            {
                $this->ServiceName = $key['Name'];
            }
        }
        if(!is_null($this->SubService))
        {

            $this->SubSelected = $this->SubService;
        }
            // Attept to Delete the Old file Before Updating New File for Perticular Application Id
        if(!empty($this->Applicant_Image))
        {
            if($old_App_Image != 'Not Available' )
            {
                if (Storage::disk('public')->exists($old_App_Image)) // Check for existing File
                {
                    dd($old_App_Image);
                    unlink(storage_path('app/public/'.$old_App_Image)); // Deleting Existing File
                    $url='Not Available';
                    $data = array();

                    $data['Applicant_Image']=$url;
                    DB::table('digital_cyber_db')->where([['Id','=',$Id],['Client_Id','=',$this->Client_Id]])->update($data);
                }
                else
                {
                    $this->Applicant_Image = 'Not Available';
                }
            }
            else
            {
                $extension = $this->Applicant_Image->getClientOriginalExtension();
                $path = 'Client_DB/'.$name.'_'.$client_Id.'/'.$this->Name.'/Photo';
                $filename = 'Profile'.$this->Name.'_'.time().'.'.$extension;
                $url = $this->Applicant_Image->storePubliclyAs($path,$filename,'public');
                $this->Applicant_Image = $url;
            }
        }
        else
        {
            $this->Applicant_Image = $old_App_Image;
        }
        if(!empty($this->Ack_File))
        {
            if($old_Ack_File != 'Not Available'  )
            {
                dd($old_Ack_File);
                if (Storage::disk('public')->exists($old_Ack_File)) // Check for existing File
                {

                    unlink(storage_path('app/public/'.$old_Ack_File)); // Deleting Existing File
                    $url='Not Available';
                    $data = array();

                    $data['Ack_File']=$url;
                    DB::table('digital_cyber_db')->where([['Id','=',$Id],['Client_Id','=',$this->Client_Id]])->update($data);
                }
                else
                {
                    $this->Ack_Path='Not Available';
                }
            }
            else
            {
                $extension = $this->Ack_File->getClientOriginalExtension();
                $path = 'Client_DB/'.$name.'_'.$client_Id.'/'.$this->Name.'/'.$this->ServiceName.'/'.trim($this->SubSelected);
                $filename = 'AF_'.$this->Ack_No.'_'.time().'.'.$extension;
                $url = $this->Ack_File->storePubliclyAs($path,$filename,'public');
                $this->Ack_Path = $url;
            }
        }
        else
        {
            $this->Ack_Path = $old_Ack_File;
        }

        if(!empty($this->Doc_File))
        {
            if($old_Doc_File != 'Not Available' )
            {
                if (Storage::disk('public')->exists($old_Doc_File)) // Check for existing File
                {
                    unlink(storage_path('app/public/'.$old_Doc_File)); // Deleting Existing File
                    $url='Not Available';
                    $data = array();

                    $data['Doc_File']=$url;
                    DB::table('digital_cyber_db')->where([['Id','=',$Id],['Client_Id','=',$this->Client_Id]])->update($data);
                }
                else
                {
                    $this->Doc_Path='Not Available';
                }
            }
            else
            {
                $extension = $this->Doc_File->getClientOriginalExtension();
                $path = 'Client_DB/'.$name.'_'.$client_Id.'/'.$this->Name.'/'.$this->ServiceName.'/'.trim($this->SubSelected);
                $filename = 'DF_'.$this->Document_No.'_'.time().'.'.$extension;
                $url = $this->Doc_File->storePubliclyAs($path,$filename,'public');
                $this->Doc_Path = $url;
            }
        }
        else
        {
            $this->Doc_Path = $old_Doc_File;
        }

        if(!empty($this->Payment_Receipt))
        {
            if($old_Pay_File != 'Not Available' )
            {
                if (Storage::disk('public')->exists($old_Pay_File)) // Check for existing File
                {
                    unlink(storage_path('app/public/'.$old_Pay_File)); // Deleting Existing File
                    $url='Not Available';
                    $data = array();

                    $data['Payment_Receipt']=$url;
                    DB::table('digital_cyber_db')->where([['Id','=',$Id],['Client_Id','=',$this->Client_Id]])->update($data);
                }
                else
                {
                    $this->Payment_Path='Not Available';
                }
            }
            else
            {
                $extension = $this->Payment_Receipt->getClientOriginalExtension();
                $path = 'Client_DB/'.$name.'_'.$client_Id.'/'.$this->Name.'/'.$this->ServiceName.'/'.trim($this->SubSelected);
                $filename = 'PR_'.$this->PaymentMode.'_'.time().'.'.$extension;
                $url = $this->Payment_Receipt->storePubliclyAs($path,$filename,'public');
                $this->Payment_Path = $url;
            }
        }
        else
        {
            $this->Payment_Path = $old_Pay_File;
        }


        $this->Balance = (intval($this->Total_Amount) - intval($this->Amount_Paid));

        $Description = 'Updated '.$this->Amount_Paid.'/- From  '.$this->Name.' Bearing Client ID: '.$this->Client_Id.' & Mobile No: '.$this->Mobile_No.'for '.$this->Application.','.$this->Application_Type.', on '.$today.' by '. $this->PaymentMode;

        $update_data = array();
        $update_data['Name']=$this->Name;
        $update_data['Relative_Name']=$this->RelativeName;
        $update_data['Gender']=$this->Gender;
        $update_data['Mobile_No']=$this->Mobile_No;
        $update_data['Application']=$this->ServiceName;
        $update_data['Application_Type']=$this->SubService;
        $update_data['Dob']=$this->Dob;
        $update_data['Ack_No']=$this->Ack_No;
        $update_data['Document_No']=$this->Document_No;
        $update_data['Applied_Date']=$this->Applied_Date;
        $update_data['Status']=$this->Status;
        $update_data['Total_Amount']=$this->Total_Amount;
        $update_data['Amount_Paid']=$this->Amount_Paid;
        $update_data['Balance']=$this->Balance;
        $update_data['Payment_Mode']=$this->PaymentMode;
        $update_data['Ack_File']=$this->Ack_Path;
        $update_data['Doc_File']=$this->Doc_Path;
        $update_data['Payment_Receipt']=$this->Payment_Path;
        $update_data['Delivered_Date']=$this->Updated_Date;
        $update_data['Applicant_Image']=$this->Applicant_Image;
        $update_App = DB::table('digital_cyber_db')->where([['Id','=',$Id],['Client_Id','=',$this->Client_Id]])->Update($update_data);

        if($this->Doc_Yes == 1 ) // if more documents to upload
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
                    $extension = $Path->getClientOriginalExtension();
                    $directory = 'Client_DB/'.$name.'_'.$client_Id.'/'.$this->Name.'/'.$this->ServiceName.'/'.trim($this->SubSelected);
                    $filename = $this->Name.' '.$this->Doc_Names[$Docs].'_'.time().'.'.$extension;
                    $url = $Path->storePubliclyAs($directory,$filename,'public');
                    $file = $url;


                    $save_doc = new DocumentFiles();
                    $save_doc->Id = 'DOC'.mt_rand(0, 9999);
                    $save_doc->App_Id = $Id;
                    $save_doc->Client_Id = $this->Client_Id;
                    $save_doc->Document_Name =  $this->Doc_Names[$Docs];
                    $save_doc->Document_Path =  $file;
                    $save_doc->save();
                }

                $extension =  $this->Document_Name->getClientOriginalExtension();
                $path = 'Client_DB/'.$name.'_'.$client_Id.'/'.$this->Name.'/'.$this->ServiceName.'/'.trim($this->SubSelected);
                $filename = $this->Name.' '.$this->Doc_Name.'_'.time().'.'.$extension;
                $url = $this->Document_Name->storePubliclyAs($path,$filename,'public');
                $file = $url;

                $save_doc = new DocumentFiles();
                $save_doc->Id = 'DOC'.mt_rand(0, 9999);
                $save_doc->App_Id = $Id;
                $save_doc->Client_Id = $this->Client_Id;
                $save_doc->Document_Path = $file;
                $save_doc->Document_Name =  $this->Doc_Name;
                $save_doc->save();
                session()->flash('SuccessMsg', $this->n.' Documents Added to '.$this->Name.' Folder Successfully!');
            }
            elseif(!empty($this->Document_Name)) //if only 1 document to be upload
            {
                $extension =  $this->Document_Name->getClientOriginalExtension();
                $path = 'Client_DB/'.$name.'_'.$client_Id.'/'.$this->Name.'/'.$this->ServiceName.'/'.trim($this->SubSelected);
                $filename = $this->Name.' '.$this->Doc_Name.'_'.time().'.'.$extension;
                $url = $this->Document_Name->storePubliclyAs($path,$filename,'public');
                $file = $url;

                $save_doc = new DocumentFiles();
                $save_doc->Id = 'DOC'.mt_rand(0, 9999);
                $save_doc->App_Id = $Id;
                $save_doc->Client_Id = $this->Client_Id;
                $save_doc->Document_Path = $file;
                $save_doc->Document_Name =  $this->Doc_Name;
                $save_doc->save();
                session()->flash('SuccessMsg', 'Document Uploaded Successfully!');
            }
        }
        if( $update_App)
        {
            session()->flash('SuccessUpdate', 'Application Details for '.$this->Name.' is Updated Successfully');
        }

        $bal_data = array();
        $bal_data['Name']=$this->Name;
        $bal_data['Mobile_No']=$this->Mobile_No;
        $bal_data['Category']=$this->Application;
        $bal_data['Sub_Category']=$this->Application_Type;
        $bal_data['Sub_Category']=$this->Application_Type;
        $bal_data['Total_Amount']=$this->Total_Amount;
        $bal_data['Amount_Paid']=$this->Amount_Paid;
        $bal_data['Balance']=$this->Balance;
        $bal_data['Payment_Mode']=$this->PaymentMode;
        $bal_data['Attachment']=$this->Payment_Path;
        $bal_data['Description']=$Description;

        $update_Bal = DB::table('balance_ledger')->where([['Id','=',$Id],['Client_Id','=',$this->Client_Id]])->Update($bal_data);

        if($update_Bal)
        {
            session()->flash('SuccessMsg', 'Balance Ledger Updated for '.$this->Name);
        }

        $update_Credit = DB::update('update credit_ledger set Category=?, Sub_Category=?,Total_Amount =?, Amount_Paid=?, Balance=?,Payment_Mode=?,Attachment=?, Description=? where Id = ? && Client_Id=?', [$this->Application,$this->Application_Type,$this->Total_Amount,$this->Amount_Paid,$this->Balance,$this->PaymentMode, $this->Payment_Path,$Description,$Id, $this->Client_Id]);
        if($update_Credit)
        {
            session()->flash('SuccessMsg', 'Credit Ledger Updated for '.$this->Name);
        }
        return redirect()->route('edit_application',$Id);
        // if($update_App && $update_Bal)
        // {
        //     session()->flash('SuccessUpdate', 'Application Details for '.$this->Name.' is Updated Successfully');
        //
        // }
    }
    public function Capitalize()
    {
        $this->Name = ucwords($this->Name);
        $this->RelativeName = ucwords($this->RelativeName);
        $this->Ack_No = ucwords($this->Ack_No);
        $this->Document_No = ucwords($this->Document_No);
        $this->Doc_Name = ucwords($this->Doc_Name);

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
    public function MultipleDelete()
    {
        $files  = DocumentFiles::WhereIn('Id',$this->Checked)->get();
        foreach($files as $key)
        {
            $id = $key['Id'];
            $file = $key['Document_Path'];
            if (Storage::disk('public')->exists($file))
            {
                storage::disk('public')->delete($file);
                DocumentFiles::Wherekey($id)->delete();
            }
            else
            {
                DocumentFiles::Wherekey($id)->delete();
                return session()->flash('Error', 'File Not Found, Record Removed');
            }
        }

            $notification = array(
                'message'=>'No Changes have been done!',
                'alert-type' =>'info'
            );
        return redirect()->route('edit_application',$this->Id)->with($notification);
    }
    public function LastUpdateTime()
    {

        $latest_doc = DocumentFiles::latest('created_at')->first();
        $this->created = Carbon::parse($latest_doc['created_at'] , $latest_doc['updated_at'])->diffForHumans();
        $this->updated = Carbon::parse($latest_doc['updated_at'])->diffForHumans();

    }
    public function render()
    {
        $this->Capitalize();
        $this->LastUpdateTime();

        $this->MainServices = MainServices::all();
        if(!is_null($this->MainService))
        {
            $fetch = MainServices::wherekey($this->MainService)->get();
            foreach($fetch as $key)
            {
                $this->ServiceName = $key['Name'];
            }
        }
        $this->SubServices = SubServices::Where('Service_Id',$this->MainService)->get();
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
        $status_list = DB::table('status')
        ->Where('Relation',$this->ServiceName)
        ->orWhere('Relation','General')
        ->orderBy('Orderby', 'asc')
        ->get();
        $payment_mode = PaymentMode::all();
        $this->Balance = (intval($this->Total_Amount) - intval($this->Amount_Paid));

        $Doc_Files = DocumentFiles::Where([['App_Id',$this->Id],['Client_Id',$this->Client_Id]])->paginate(5);
        return view('livewire.edit-application',compact('payment_mode','status_list','Doc_Files'));
    }

}
