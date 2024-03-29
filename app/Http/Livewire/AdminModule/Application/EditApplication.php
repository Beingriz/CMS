<?php

namespace App\Http\Livewire\AdminModule\Application;

use App\Models\Application;
use App\Models\ApplyServiceForm;
use App\Models\CreditLedger;
use App\Models\DocumentFiles;
use App\Models\MainServices;
use App\Models\PaymentMode;
use App\Models\Status;
use App\Models\SubServices;
use App\Traits\RightInsightTrait;
use App\Traits\WhatsappTrait;
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
    use WhatsappTrait;

    protected $paginationTheme = 'bootstrap';
    public $Client_Id, $Id, $App_Id;
    public $Name, $Checked = [];
    public $Dob, $Applicant_Image, $Profile_Update, $main_service = [], $sub_service = [];
    public $Ack_No = 'Not Available';
    public $Document_No = 'Not Available';
    public $Total_Amount, $today;
    public $Amount_Paid, $Reason, $previous_paid = 0;
    public $Balance;
    public $PaymentMode, $PaymentModes, $Client_Type, $Confirmation, $Client_Image, $Old_Profile_Image;
    public $Received_Date, $Applied_Date, $Updated_Date, $old_Applicant_Image;
    public $ServiceName, $SubService;
    public $MainService, $MainServices;
    public $Application;
    public $Application_Type;
    public $Mobile_No = NULL;
    public $Status, $Ack_File, $Doc_File, $Payment_Receipt;
    public $Registered, $count_app = 0, $app_count, $app_pending, $app_delivered, $app_deleted;
    public $total, $paid, $balance = 0, $n = 1;
    public $filterby, $show = 0, $collection, $no = 'No';
    public $Select_Date, $Daily_Income = 0;
    public $show_app = [];
    public $Ack, $Doc, $Pay, $subservice, $mainservice, $SubServices;
    public $Ack_Path, $Doc_Path, $Payment_Path, $Profile_Image, $RelativeName, $Gender;
    public $created, $updated, $AckFileDownload = 'Disable', $DocFileDownload = 'Disable', $PayFileDownload = 'Disable', $SubSelected, $key, $ShowTable = false, $paginate, $Sub_Serv_Name;


    public $i = 1, $Pro_Yes = 'off';
    public $Check, $Doc_Yes = 0, $No, $test, $Format;
    public $Document_Name;
    public $Doc_Name;
    public $Document_Files = [];
    public $Doc_Names = [];
    public $NewTextBox = [];
    public $label = [];
    public $old_status, $old_service, $old_service_type;



    protected $rules = [
        'Name' => 'required',
        'RelativeName' => 'required',
        'Gender' => 'required',
        'Dob' => 'required',
        'Mobile_No' => 'required | Min:10',
        'Total_Amount' => 'required',
        'Amount_Paid' => 'required',
        'PaymentMode' => 'required',
        'Applied_Date' => 'required',
        'SubService' => 'required',
    ];
    protected $messages = [
        'name.required' => 'Applicant Name Cannot be Empty',
        'RelativeName.required' => 'Enter Relative Name',
        'Gender.required' => 'Please Select Gender',
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
        foreach ($fetch as $key) {
            $this->App_Id = $key['Id'];
            $this->Client_Id = $key['Client_Id'];
            $this->Name = $key['Name'];
            $this->RelativeName = $key['Relative_Name'];
            $this->Gender = $key['Gender'];
            $this->Application = $key['Application'];
            $this->mainservice = $key['Application'];
            $this->old_service = $key['Application'];
            $this->Application_Type = $key['Application_Type'];
            $this->old_service_type = $key['Application_Type'];
            $this->subservice = $key['Application_Type'];
            $this->SubService = $key['Application_Type'];
            $this->Dob = $key['Dob'];
            $this->Mobile_No = $key['Mobile_No'];
            $this->Received_Date = $key['Received_Date'];
            $this->Applied_Date = $key['Applied_Date'];
            $this->Ack_No = $key['Ack_No'];
            $this->Document_No = $key['Document_No'];
            $this->Total_Amount = $key['Total_Amount'];
            $this->Amount_Paid = $key['Amount_Paid'];
            $this->previous_paid = $key['Amount_Paid'];
            $this->Balance = $key['Balance'];
            $this->PaymentMode = $key['Payment_Mode'];
            $this->Status = $key['Status'];
            $this->old_status = $key['Status'];
            $this->Reason = $key['Reason'];
            $this->Updated_Date = $key['Delivered_Date'];
            $this->Registered = $key['Registered'];
            $this->Ack = $key['Ack_File'];
            $this->Doc = $key['Doc_File'];
            $this->Pay = $key['Payment_Receipt'];
            $this->old_Applicant_Image = $key['Applicant_Image'];
            $this->paginate = 5;
        }
        if (empty($this->Applied_Date)) {
            $this->Applied_Date = date("Y-m-d");
        }
    }
    public function Capitalize()
    {
        $this->Name = strtolower($this->Name);
        $this->Name = ucwords($this->Name);
        $this->RelativeName = ucwords($this->RelativeName);
        $this->Ack_No = ucwords($this->Ack_No);
        $this->Document_No = ucwords($this->Document_No);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function AddNewText($i)
    { {
            $i = $i + 1;
            $this->i = $i;
            array_push($this->NewTextBox, $i);
        }
    }
    public function Remove($value)
    {
        if (($key = array_search($value, $this->NewTextBox)) !== false) {
            unset($this->NewTextBox[$key]);
            array_pop($this->Document_Files);
            array_pop($this->Doc_Names);
        }
    }
    public function CheckFileExist($Id)
    {
        $data = Application::WhereKey($Id)->get();
        foreach ($data as $key) {
            $ack_file = $key['Ack_File'];
            $doc_file = $key['Doc_File'];
            $pay_file = $key['Payment_Receipt'];
        }

        if ($ack_file != 'Not Available') {
            if (Storage::disk('public')->exists($ack_file)) {
                $this->AckFileDownload = 'Enable';
            } else {
                $this->AckFileDownload = 'Disable';
            }
        }

        if ($doc_file != 'Not Available') {
            if (Storage::disk('public')->exists($doc_file)) {
                $this->DocFileDownload = 'Enable';
            } else {
                $this->DocFileDownload = 'Disable';
            }
        }
        if ($pay_file != 'Not Available') {
            if (Storage::disk('public')->exists($pay_file)) {
                $this->PayFileDownload = 'Enable';
            } else {
                $this->PayFileDownload = 'Disable';
            }
        }
    }

    public function Update($Id)
    {
        $today = date("d-m-Y");
        $time = strtotime("now");
        $fetch = Application::Wherekey($Id)->get();
        foreach ($fetch as $field) {
            $this->Client_Id = $field['Client_Id'];
            $name = $field['Name'];
            $client_Id = $field['Client_Id'];
            $old_Ack_File = $field['Ack_File'];
            $old_Doc_File = $field['Doc_File'];
            $old_Pay_File = $field['Payment_Receipt'];
            $old_App_Image = $field['Applicant_Image'];
        }

        $this->validate();
        if (!is_null($this->MainService)) {
            $fetch = MainServices::wherekey($this->MainService)->get();
            foreach ($fetch as $key) {
                $this->ServiceName = $key['Name'];
            }
        } else {
            $this->ServiceName = $this->mainservice;
        }


        if (!is_null($this->SubService)) {
            $this->SubSelected = $this->SubService;
        } else {
            $this->SubSelected = $this->subservice;
        }

        // Attept to Delete the Old file Before Updating New File for Perticular Application Id
        if (!empty($this->Applicant_Image)) {
            if ($old_App_Image != 'Not Available') {
                if (Storage::disk('public')->exists($old_App_Image)) // Check for existing File
                {
                    unlink(storage_path('app/public/' . $old_App_Image)); // Deleting Existing File
                    $url = 'Not Available';
                    $data = array();
                    $data['Applicant_Image'] = $url;
                    DB::table('digital_cyber_db')->where([['Id', '=', $Id], ['Client_Id', '=', $this->Client_Id]])->update($data);
                } else {
                    $this->Applicant_Image = 'Not Available';
                }
            } else {
                $extension = $this->Applicant_Image->getClientOriginalExtension();
                $path = 'Client_DB/' . $name . ' ' . $client_Id . '/' . trim($this->Name) . '/Photo';
                $filename = 'Profile' . $this->Name . '_' . time() . '.' . $extension;
                $url = $this->Applicant_Image->storePubliclyAs($path, $filename, 'public');
                $this->Applicant_Image = $url;
            }
        } else {
            $this->Applicant_Image = $old_App_Image;
        }


        // Ack File Upload.
        if (!empty($this->Ack_File)) {
            if ($old_Ack_File != 'Not Available') {
                if (Storage::disk('public')->exists($old_Ack_File)) { // Check for existing File
                    unlink(storage_path('app/public/' . $old_Ack_File)); // Deleting Existing File
                    $url = 'Not Available';
                    $data = array();
                    $data['Ack_File'] = $url;
                    DB::table('digital_cyber_db')->where([['Id', '=', $Id], ['Client_Id', '=', $this->Client_Id]])->update($data);
                } else {
                    $this->Ack_Path = 'Not Available';
                }
            } else {
                $extension = $this->Ack_File->getClientOriginalExtension();
                $path = 'Digtial Cyber/' . $name . ' ' . $client_Id . '/' . trim($this->Name) . '/' . trim($this->ServiceName) . '/' . trim($this->SubSelected);
                $filename = 'AF_' . $this->Ack_No . '_' . time() . '.' . $extension;
                $url = $this->Ack_File->storePubliclyAs($path, $filename, 'public');
                $this->Ack_Path = $url;
            }
        } else {
            $this->Ack_Path = $old_Ack_File;
        }

        // Doc File Upload.
        if (!empty($this->Doc_File)) {
            if ($old_Doc_File != 'Not Available') {
                if (Storage::disk('public')->exists($old_Doc_File)) { // Check for existing File
                    unlink(storage_path('app/public/' . $old_Doc_File)); // Deleting Existing File
                    $url = 'Not Available';
                    $data = array();
                    $data['Doc_File'] = $url;
                    DB::table('digital_cyber_db')->where([['Id', '=', $Id], ['Client_Id', '=', $this->Client_Id]])->update($data);
                } else {
                    $this->Doc_Path = 'Not Available';
                }
            } else {
                $extension = $this->Doc_File->getClientOriginalExtension();
                $path = 'Digtial Cyber/' . $name . ' ' . $client_Id . '/' . trim($this->Name) . '/' . trim($this->ServiceName) . '/' . trim($this->SubSelected);
                $filename = 'DF_' . $this->Document_No . '_' . time() . '.' . $extension;
                $url = $this->Doc_File->storePubliclyAs($path, $filename, 'public');
                $this->Doc_Path = $url;
            }
        } else {
            $this->Doc_Path = $old_Doc_File;
        }

        // Payment File Upload
        if (!empty($this->Payment_Receipt)) {
            if ($old_Pay_File != 'Not Available') {
                if (Storage::disk('public')->exists($old_Pay_File)) { // Check for existing File
                    unlink(storage_path('app/public/' . $old_Pay_File)); // Deleting Existing File
                    $url = 'Not Available';
                    $data = array();
                    $data['Payment_Receipt'] = $url;
                    DB::table('digital_cyber_db')->where([['Id', '=', $Id], ['Client_Id', '=', $this->Client_Id]])->update($data);
                } else {
                    $this->Payment_Path = 'Not Available';
                }
            } else {
                $extension = $this->Payment_Receipt->getClientOriginalExtension();
                $path = 'Digtial Cyber/' . $name . ' ' . $client_Id . '/' . trim($this->Name) . '/' . trim($this->ServiceName) . '/' . trim($this->SubSelected);
                $filename = 'PR_' . $this->PaymentMode . '_' . time() . '.' . $extension;
                $url = $this->Payment_Receipt->storePubliclyAs($path, $filename, 'public');
                $this->Payment_Path = $url;
            }
        } else {
            $this->Payment_Path = $old_Pay_File;
        }


        $this->Balance = (intval($this->Total_Amount) - intval($this->Amount_Paid));

        $Description = 'Updated ' . $this->Amount_Paid . '/- From  ' . $this->Name . ' Bearing Client ID: ' . $this->Client_Id . ' & Mobile No: ' . $this->Mobile_No . 'for ' . $this->Application . ',' . $this->Application_Type . ', on ' . $today . ' by ' . $this->PaymentMode;

        $update_data = array();
        $update_data['Name'] = $this->Name;
        $update_data['Relative_Name'] = $this->RelativeName;
        $update_data['Gender'] = $this->Gender;
        $update_data['Mobile_No'] = $this->Mobile_No;
        $update_data['Application'] = $this->ServiceName;
        $update_data['Application_Type'] = $this->SubSelected;
        $update_data['Dob'] = $this->Dob;
        $update_data['Ack_No'] = $this->Ack_No;
        $update_data['Document_No'] = $this->Document_No;
        $update_data['Applied_Date'] = $this->Applied_Date;
        $update_data['Status'] = $this->Status;
        $update_data['Reason'] = $this->Reason;
        $update_data['Total_Amount'] = $this->Total_Amount;
        $update_data['Amount_Paid'] = $this->Amount_Paid;
        $update_data['Balance'] = $this->Balance;
        $update_data['Payment_Mode'] = $this->PaymentMode;
        $update_data['Ack_File'] = $this->Ack_Path;
        $update_data['Doc_File'] = $this->Doc_Path;
        $update_data['Payment_Receipt'] = $this->Payment_Path;
        $update_data['Delivered_Date'] = $this->Updated_Date;
        $update_data['Applicant_Image'] = $this->Applicant_Image;
        $update_data['updated_at'] = Carbon::now();
        $update_App = Application::where([['Id', '=', $Id], ['Client_Id', '=', $this->Client_Id]])->Update($update_data);

        if ($this->Amount_Paid != $this->previous_paid) {
            $desc  = "Update :  Rs. " . intval($this->Amount_Paid)-intval($this->previous_paid) . "/- From  " . $this->Name . " Bearing Client ID: " . $client_Id . " & Mobile No: " . $this->Mobile_No . " for " . $this->ServiceName . " " . $this->SubSelected . ", on " . $this->Updated_Date . " by  " . $this->PaymentMode . ", Total: " . $this->Total_Amount . "| Previous Paid: " . $this->previous_paid . "| Received : " . intval($this->Amount_Paid)-intval($this->previous_paid) . " | Balance: " . (intval($this->Total_Amount) - ( intval($this->Amount_Paid)));

            $save_credit  = new CreditLedger();
            $save_credit->Id = 'DC' . time();
            $save_credit->Client_Id = $this->Client_Id;
            $save_credit->Category =  $this->ServiceName;
            $save_credit->Sub_Category = $this->SubSelected;
            $save_credit->Date =   $this->Received_Date ;
            $save_credit->Total_Amount =    $this->Total_Amount;
            $save_credit->Amount_Paid =  intval($this->Amount_Paid)-intval($this->previous_paid);
            $save_credit->Balance = $this->Balance;
            $save_credit->Description =    $desc;
            $save_credit->Payment_Mode = $this->PaymentMode;
            $save_credit->Attachment = $this->Payment_Path;
            $save_credit->save(); //Credit Ledger Entry Saved
        }
        $find = ApplyServiceForm::where('Id', $Id)->get();
        if (!empty($find)) {
            $data = array();
            $data['Name'] = $this->Name;
            $data['Application'] = $this->ServiceName;
            $data['Application_Type'] = $this->SubSelected;
            $data['Dob'] = $this->Dob;
            $data['Relative_Name'] = $this->RelativeName;
            $data['Mobile_No'] = $this->Mobile_No;
            $data['Status'] = $this->Status;
            $data['Reason'] = $this->Reason;
            $data['Profile_Image'] = $this->Applicant_Image;
            $data['updated_at'] = Carbon::now();
            ApplyServiceForm::where('Id', $Id)->Update($data);
        }

        // if more documents to upload
        if ($this->Doc_Yes == 1) {
            if (count($this->Document_Files) > 0) {
                if ($this->Doc_Names == '') {
                    $this->Doc_Names = $this->Name . ' Document';
                }
                foreach ($this->Document_Files as $Docs => $Path) {
                    $this->n++;
                    $extension = $Path->getClientOriginalExtension();
                    $directory = 'Digtial Cyber/' . $name . ' ' . $client_Id . '/' . trim($this->Name) . '/' . trim($this->ServiceName) . '/' . trim($this->SubSelected);
                    $filename = $this->Name . ' ' . $this->Doc_Names[$Docs] . '_' . time() . '.' . $extension;
                    $url = $Path->storePubliclyAs($directory, $filename, 'public');
                    $file = $url;

                    $save_doc = new DocumentFiles();
                    $save_doc->Id = 'DOC' . mt_rand(0, 9999);
                    $save_doc->App_Id = $Id;
                    $save_doc->Client_Id = $this->Client_Id;
                    $save_doc->Document_Name =  $this->Doc_Names[$Docs];
                    $save_doc->Document_Path =  $file;
                    $save_doc->save();
                }

                $extension =  $this->Document_Name->getClientOriginalExtension();
                $path = 'Digtial Cyber/' . $name . ' ' . $client_Id . '/' . trim($this->Name) . '/' . trim($this->ServiceName) . '/' . trim($this->SubSelected);
                $filename = $this->Name . ' ' . $this->Doc_Name . '_' . time() . '.' . $extension;
                $url = $this->Document_Name->storePubliclyAs($path, $filename, 'public');
                $file = $url;

                $save_doc = new DocumentFiles();
                $save_doc->Id = 'DOC' . mt_rand(0, 9999);
                $save_doc->App_Id = $Id;
                $save_doc->Client_Id = $this->Client_Id;
                $save_doc->Document_Path = $file;
                $save_doc->Document_Name =  $this->Doc_Name;
                $save_doc->save();
                session()->flash('SuccessMsg', $this->n . ' Documents Added to ' . $this->Name . ' Folder Successfully!');
            }
            //if only 1 document to be upload
            elseif (!empty($this->Document_Name)) {
                $extension =  $this->Document_Name->getClientOriginalExtension();
                $path = 'Digtial Cyber/' . $name . ' ' . $client_Id . '/' . trim($this->Name) . '/' . trim($this->ServiceName) . '/' . trim($this->SubSelected);
                $filename = $this->Name . ' ' . $this->Doc_Name . '_' . time() . '.' . $extension;
                $url = $this->Document_Name->storePubliclyAs($path, $filename, 'public');
                $file = $url;

                $save_doc = new DocumentFiles();
                $save_doc->Id = 'DOC' . mt_rand(0, 9999);
                $save_doc->App_Id = $Id;
                $save_doc->Client_Id = $this->Client_Id;
                $save_doc->Document_Path = $file;
                $save_doc->Document_Name =  $this->Doc_Name;
                $save_doc->save();
                session()->flash('SuccessMsg', 'Document Uploaded Successfully!');
            }
        }


        if ($update_App) {
            session()->flash('SuccessUpdate', 'Application Details for ' . $this->Name . ' Updated Successfully');
        }

        if (($this->old_status != $this->Status) ||  ($this->Application != $this->ServiceName) || ($this->Application_Type != $this->SubSelected)) {
            $this->ApplicaitonUpdateAlert($this->Mobile_No, $this->Name, $this->ServiceName, $this->SubSelected, $this->Status, $this->Reason);
        }
        return redirect()->route('view.application', $Id);
    }
    public function ShowApplications($mobile)
    {
        $this->ShowTable = true;
        $this->key = $mobile;
    }


    public function Delete_Doc($Id)
    {
        $fetch = DocumentFiles::Wherekey($Id)->get();
        foreach ($fetch as $key) {
            $path = $key['Document_Path'];
            $name = $key['Document_Name'];
        }
        if (Storage::exists($path)) {
            unlink(storage_path('app/' . $path));
            $delete = DocumentFiles::Wherekey($Id)->delete();
            if ($delete) {
                session()->flash('SuccessMsg', $name . ' Deleted Successfully!');
            } else {
                session()->flash('Error', 'Unable to Delete');
            }
        } else {
            session()->flash('Error', 'File Not Available');
        }
    }


    public function MultipleDelete()
    {
        $files  = DocumentFiles::WhereIn('Id', $this->Checked)->get();
        foreach ($files as $key) {
            $id = $key['Id'];
            $file = $key['Document_Path'];
            if (Storage::disk('public')->exists($file)) {
                storage::disk('public')->delete($file);
                DocumentFiles::Wherekey($id)->delete();
            } else {
                DocumentFiles::Wherekey($id)->delete();
                return session()->flash('Error', 'File Not Found, Record Removed');
            }
        }

        $notification = array(
            'message' => 'No Changes have been done!',
            'alert-type' => 'info'
        );
        return redirect()->route('edit_application', $this->Id)->with($notification);
    }


    public function LastUpdateTime()
    {

        $latest_doc = DocumentFiles::latest('created_at')->first();
        if (!is_Null($latest_doc)) {
            $this->created = Carbon::parse($latest_doc['created_at'], $latest_doc['updated_at'])->diffForHumans();
            $this->updated = Carbon::parse($latest_doc['updated_at'])->diffForHumans();
        }
    }

    
    public function render()
    {
        $this->Capitalize();
        $this->LastUpdateTime();

        $this->MainServices = MainServices::all();
        if (!is_null($this->MainService)) {
            $fetch = MainServices::wherekey($this->MainService)->get();
            foreach ($fetch as $key) {
                $this->ServiceName = $key['Name'];
            }
        }
        $this->SubServices = SubServices::Where('Service_Id', $this->MainService)->get();
        $yes = 'Yes';
        $applicant_data = DB::table('digital_cyber_db')->where([['Client_Id', '=', $this->Client_Id], ['Recycle_Bin', '=', $this->no]])->get();
        $mobile = '';
        foreach ($applicant_data as $field) {
            $field = get_object_vars($field); {
                $mobile = $field['Mobile_No'];
            }
        }
        $get_app = DB::table('digital_cyber_db')->where('Mobile_No', '=', $mobile)->get();
        $this->count_app = count($get_app);
        $this->app_delivered =  DB::table('digital_cyber_db')->where([['Mobile_No', '=', $mobile], ['Recycle_Bin', '=', $this->no], ['Status', '=', $this->Status]])->count();
        $this->app_pending =  $this->count_app - $this->app_delivered;
        $this->app_deleted =  DB::table('digital_cyber_db')->where([['Mobile_No', '=', $mobile], ['Recycle_Bin', '=', $yes]])->count();
        foreach ($applicant_data as $amt) {
            $amt = get_object_vars($amt); {
                $this->total =  $amt['Total_Amount'];
                $this->paid = $amt['Amount_Paid'];
                $this->balance =  $amt['Balance'];
            }
        }
        $status = DB::table('status')
            ->Where('Relation', $this->mainservice)
            ->orWhere('Relation', 'General')
            ->orderBy('Orderby', 'asc')
            ->get();
        $payment_mode = PaymentMode::all();
        $this->Balance = (intval($this->Total_Amount) - intval($this->Amount_Paid));

        $Doc_Files = DocumentFiles::Where([['App_Id', $this->Id], ['Client_Id', $this->Client_Id]])->paginate(5);


        $StatusDetails = Application::where([['Mobile_No', $this->key], ['Recycle_Bin', 'No']])
            ->filter(trim($this->filterby))->Orderby('Received_Date', 'desc')->paginate($this->paginate);
        return view('livewire.admin-module.application.edit-application', compact('payment_mode', 'status', 'Doc_Files', 'StatusDetails'));
    }
}
