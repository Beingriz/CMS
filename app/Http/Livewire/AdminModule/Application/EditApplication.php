<?php

namespace App\Http\Livewire\AdminModule\Application;

use App\Http\Livewire\UserModule\QuickApply;
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
use Exception;
use Illuminate\Support\Facades\Auth;
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
    public $PaymentMode, $PaymentModes, $Client_Type, $Confirmation, $whatsAppNotificatin=false,$Client_Image, $Old_Profile_Image;
    public $Received_Date, $Applied_Date, $Updated_Date, $old_Applicant_Image;
    public $ServiceName, $SubService;
    public $MainService, $MainServices;
    public $Application;
    public $Application_Type;
    public $Mobile_No = NULL;
    public $Status, $Payment_Receipt;
    public $Registered, $count_app = 0, $app_count, $app_pending, $app_delivered, $app_deleted;
    public $total, $paid, $balance = 0, $n = 1;
    public $filterby, $show = 0, $collection, $no = 'No';
    public $Select_Date, $Daily_Income = 0;
    public $show_app = [];
    public $Ack, $Doc, $Pay, $subservice, $mainservice, $SubServices;
    public $Ack_File, $Doc_File, $Payment_File, $Profile_Image, $RelativeName, $Gender;
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

    protected $listeners = ['delete' => 'deleteDocFile'];

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
            $this->Ack_File = $key['Ack_File'];
            $this->Doc_File = $key['Doc_File'];
            $this->Payment_File = $key['Payment_Receipt'];
            $this->old_Applicant_Image = $key['Applicant_Image'];
            $this->Client_Type = $key['Applicant_Image'];
            $this->paginate = 5;
        }
        if (empty($this->Applied_Date)) {
            $this->Applied_Date = date("Y-m-d");
        }

        $this->lastDocumentUpdateTime($this->Id);   // Get the last updated time
    }
    public function Capitalize()
    {
        $this->Name = strtolower($this->Name);
        $this->Name = ucwords($this->Name);
        $this->RelativeName = strtolower($this->RelativeName);
        $this->RelativeName = ucwords($this->RelativeName);
        $this->Ack_No = strtolower($this->Ack_No);
        $this->Ack_No = ucwords($this->Ack_No);
        $this->Document_No = strtolower($this->Document_No);
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

        // Fetch existing application data
        $application = Application::where('Id', $Id)->first();

        if (!$application) {
            session()->flash('Error', 'Application not found.');
            return redirect()->back();
        }

        // Get authenticated user details
        $user = Auth::user();
        $branchId = $user->branch_id;
        $empId = $user->Emp_Id;

        // Store old file paths
        $oldFiles = [
            'Ack_File' => $application->Ack_File,
            'Doc_File' => $application->Doc_File,
            'Payment_Receipt' => $application->Payment_Receipt,
            'Applicant_Image' => $application->Applicant_Image
        ];

        // Validation
        $this->validate();

        // Main Service and Sub Service
        $this->ServiceName = $this->MainService ? MainServices::where('key', $this->MainService)->value('Name') : $this->mainservice;
        $this->SubSelected = $this->SubService ?: $this->subservice;

        // Handle file uploads and deletions
        $this->handleFileUpload('Applicant_Image', $oldFiles['Applicant_Image']);
        $this->handleFileUpload('Ack_File', $oldFiles['Ack_File']);
        $this->handleFileUpload('Doc_File', $oldFiles['Doc_File']);
        $this->handleFileUpload('Payment_File', $oldFiles['Payment_Receipt']);

        // Calculate balance
        $this->Balance = intval($this->Total_Amount) - intval($this->Amount_Paid);

        // Ensure file paths are not null
        $this->Applicant_Image = $this->Applicant_Image ?? $oldFiles['Applicant_Image'];
        $this->Ack_File = $this->Ack_File ?? $oldFiles['Ack_File'];
        $this->Doc_File = $this->Doc_File ?? $oldFiles['Doc_File'];
        $this->Payment_File = $this->Payment_File ?? $oldFiles['Payment_Receipt'];


         // Trim all string inputs
        $this->Name = trim($this->Name);
        $this->RelativeName = trim($this->RelativeName);
        $this->Gender = trim($this->Gender);
        $this->Mobile_No = trim($this->Mobile_No);
        $this->ServiceName = trim($this->ServiceName);
        $this->SubSelected = trim($this->SubSelected);
        $this->Dob = trim($this->Dob);
        $this->Ack_No = trim($this->Ack_No);
        $this->Document_No = trim($this->Document_No);
        $this->Applied_Date = trim($this->Applied_Date);
        $this->Status = trim($this->Status);
        $this->Reason = trim($this->Reason);
        $this->PaymentMode = trim($this->PaymentMode);
        $this->Updated_Date = trim($this->Updated_Date);

        // Update Application record
        $updateData = [
            'Name' => $this->Name,
            'Relative_Name' => $this->RelativeName,
            'Gender' => $this->Gender,
            'Mobile_No' => $this->Mobile_No,
            'Application' => $this->ServiceName,
            'Application_Type' => $this->SubSelected,
            'Dob' => $this->Dob,
            'Ack_No' => $this->Ack_No,
            'Document_No' => $this->Document_No,
            'Applied_Date' => $this->Applied_Date,
            'Status' => $this->Status,
            'Reason' => $this->Reason,
            'Total_Amount' => $this->Total_Amount,
            'Amount_Paid' => $this->Amount_Paid,
            'Balance' => $this->Balance,
            'Payment_Mode' => $this->PaymentMode,
            'Ack_File' => $this->Ack_File,
            'Doc_File' => $this->Doc_File,
            'Payment_Receipt' => $this->Payment_File,
            'Delivered_Date' => $this->Updated_Date,
            'Applicant_Image' => $this->Applicant_Image,
            'Branch_Id' => $branchId,
            'Emp_Id' => $empId,
            'updated_at' => Carbon::now()
        ];

        Application::where('Id', $Id)->update($updateData);

        // Calculate the new amount to be credited
        $new_credit_entry = intval($this->Amount_Paid) - intval($this->previous_paid);

        if ($new_credit_entry > 0 && (intval($this->previous_paid) + intval($this->Amount_Paid) <= intval($this->Total_Amount))) {
            $this->updateCreditLedger($Id, $branchId, $empId, $new_credit_entry);
        }

        // Manually trigger the logTransaction
        $application = Application::find($Id);
        Application::logTransaction($application, 'Update');

        // Handle additional documents
        if ($this->Doc_Yes == 1) {
            $this->handleAdditionalDocuments($Id, $branchId, $empId);
        }

        if ($this->old_status != $this->Status) {
            if(!$this->whatsAppNotificatin){
            }
        }
         // Dispatch a browser event for SweetAlert
        $this->dispatchBrowserEvent('swal:success', [
            'title' => 'Updated Successfully!',
            'text' => 'Application Details for ' . $this->Name . ' have been updated successfully.',
            'icon' => 'success',
            'redirect-url' => route('view.application', $Id)
        ]);

    }

    /**
     * Handle file upload.
     */
    protected function handleFileUpload($fieldName, $oldFilePath)
    {

        if ($this->{$fieldName} instanceof \Illuminate\Http\UploadedFile) {
            $file = $this->{$fieldName};
            $path = 'Digital_Cyber/' . $this->Name . ' ' . $this->Client_Id . '/' . trim($this->Name) . '/' . trim($this->ServiceName) . '/' . trim($this->SubSelected);
            $filename = $fieldName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $this->{$fieldName} = $file->storePubliclyAs($path, $filename, 'public');

            // Delete old file if exists
            if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }
        } else {
            $this->{$fieldName} = $oldFilePath;
        }
    }

    /**
     * Update : New Credit Entry for balance update in Credit Ledger.
     */
    protected function updateCreditLedger($Id, $branchId, $empId, $new_credit_entry)
    {
        $desc  = "Update :  Rs. " . intval($new_credit_entry). "/- Received from  " . $this->Name . " bearing Client ID: " . $this->Client_Id . " & Mobile No: " . $this->Mobile_No . " for " . $this->ServiceName . " " . $this->SubSelected . ", on " . $this->Updated_Date . " by  " . $this->PaymentMode . ", Total: " . $this->Total_Amount . "| Previous Paid: " . $this->previous_paid . "| Received : " . intval($this->Amount_Paid) . " | Balance: " . (intval($this->Total_Amount) - (intval($this->Amount_Paid)+ intval($this->previous_paid)));

        $save_credit = new CreditLedger();
        $save_credit->Id = 'DC' . time();
        $save_credit->Client_Id = $this->Client_Id;
        $save_credit->Category = $this->ServiceName;
        $save_credit->Sub_Category = $this->SubSelected;
        $save_credit->Date = $this->Received_Date;
        $save_credit->Total_Amount = $this->Total_Amount;
        $save_credit->Amount_Paid = intval($new_credit_entry);
        $save_credit->Balance = $this->Balance;
        $save_credit->Description = $desc;
        $save_credit->Payment_Mode = $this->PaymentMode;
        $save_credit->Attachment = $this->Payment_File;
        $save_credit->Branch_Id = $branchId;
        $save_credit->Emp_Id = $empId;
        $save_credit->save(); // Credit Ledger Entry Saved
    }

    /**
     * Handle additional documents.
     */
    protected function handleAdditionalDocuments($Id, $branchId, $empId)
    {
        if (count($this->Document_Files) > 0) {
            if (empty($this->Doc_Names)) {
                $this->Doc_Names = [$this->Name . ' Document'];
            }

            foreach ($this->Document_Files as $index => $Path) {
                try {
                    // Validate file extension
                    $extension = $Path->getClientOriginalExtension();
                    if (!in_array($extension, ['jpg', 'jpeg', 'png', 'pdf', 'docx'])) {
                        throw new Exception('Invalid file type. Allowed types are: jpg, jpeg, png, pdf, docx.');
                    }

                    // Generate file path and name
                    $directory = 'Digital_Cyber/' . $this->Name . ' ' . $this->Client_Id . '/' . trim($this->Name) . '/' . trim($this->ServiceName) . '/' . trim($this->SubSelected);
                    if (!is_dir(storage_path('app/public/' . $directory))) {
                        mkdir(storage_path('app/public/' . $directory), 0777, true);
                    }

                    $filename = $this->Name . ' ' . $this->Doc_Names[$index] . '_' . time() . '.' . $extension;
                    $url = $Path->storePubliclyAs($directory, $filename, 'public');

                    // Insert document record into the database
                    DocumentFiles::create([
                        'Id' => 'DOC' . mt_rand(1000, 9999),
                        'App_Id' => $Id,
                        'Client_Id' => $this->Client_Id,
                        'Document_Name' => ucfirst($this->Doc_Names[$index]),
                        'Document_Path' => $url,
                        'Branch_Id' => $branchId,
                        'Emp_Id' => $empId
                    ]);
                } catch (Exception $e) {
                    $this->dispatchBrowserEvent('swal:error', [
                        'title' => 'Error!',
                        'text' => 'Error uploading document: ' . $e->getMessage()
                    ]);
                    return; // Stop further processing if an error occurs

                }
            }
        }

        // Handle single document upload
        if (!empty($this->Document_Name)) {
            try {
                // Validate file extension
                $extension = $this->Document_Name->getClientOriginalExtension();
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'pdf', 'docx'])) {
                    throw new Exception('Invalid file type. Allowed types are: jpg, jpeg, png, pdf, docx.');
                }

                // Generate file path and name
                $path = 'Digital_Cyber/' . $this->Name . ' ' . $this->Client_Id . '/' . trim($this->Name) . '/' . trim($this->ServiceName) . '/' . trim($this->SubSelected);
                if (!is_dir(storage_path('app/public/' . $path))) {
                    mkdir(storage_path('app/public/' . $path), 0777, true);
                }

                $filename = $this->Name . ' ' . $this->Doc_Name . '_' . time() . '.' . $extension;
                $url = $this->Document_Name->storePubliclyAs($path, $filename, 'public');

                // Insert document record into the database
                DocumentFiles::create([
                    'Id' => 'DOC' . mt_rand(1000, 9999),
                    'App_Id' => $Id,
                    'Client_Id' => $this->Client_Id,
                    'Document_Name' => $this->Doc_Name,
                    'Document_Path' => $url,
                    'Branch_Id' => $branchId,
                    'Emp_Id' => $empId
                ]);

                session()->flash('SuccessMsg', 'Document Uploaded Successfully!');
            } catch (Exception $e) {
                session()->flash('ErrorMsg', 'Error uploading document: ' . $e->getMessage());
            }
        }
    }




    public function ShowApplications($mobile)
    {
        $this->ShowTable = true;
        $this->key = $mobile;
    }


    // Delete Document -- Working
    public function deleteDocFile($Id)
    {
        // Fetch the document record
        $document = DocumentFiles::find($Id);

        // Check if document exists
        if (!$document) {
            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Not Found!',
                'text' => 'The selected document does not exist.',
                'icon' => 'error',
                'redirect-url' => route('edit_application', $this->Id)
            ]);
            return;
        }
        // Get the document path and name
        $path = $document->Document_Path;
        $name = $document->Document_Name;
        // Delete the file from storage
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            DocumentFiles::where('Id', $Id)->delete();
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Deleted Successfully!',
                'text' => $name . ' has been deleted successfully.',
                'icon' => 'success',
                'redirect-url' => route('edit_application', $this->Id)
            ]);
        } else {
            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Error!',
                'text' => 'File not found.',
                'icon' => 'error',
                'redirect-url' => route('edit_application', $this->Id)

            ]);
        }
    }


    // Delete multiple documents -- Working
    public function MultipleDelete()
    {
        if (empty($this->Checked)) {
            session()->flash('Error', 'No files selected for deletion.');
            return redirect()->route('edit_application', $this->Id);
        }

        $files = DocumentFiles::whereIn('Id', $this->Checked)->get();

        if ($files->isEmpty()) {
            session()->flash('Error', 'No matching files found.');
            return redirect()->route('edit_application', $this->Id);
        }

        $fileNotFound = false;

        foreach ($files as $fileRecord) {
            $filePath = $fileRecord->Document_Path;

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            } else {
                $fileNotFound = true;
            }

            DocumentFiles::where('Id', $fileRecord->Id)->delete();
        }

        if ($fileNotFound) {
            session()->flash('Error', 'Some files were not found, but their records have been removed.');
        } else {
            session()->flash('SuccessMsg', 'Selected files have been successfully deleted.');
        }

        return redirect()->route('edit_application', $this->Id);
    }

    // Last Document Updated Time
    public function lastDocumentUpdateTime($id)
    {
        $latest_doc = DocumentFiles::where('App_Id',$id)->latest('created_at')->first();
        if (!is_Null($latest_doc)) {
            $this->created = Carbon::parse($latest_doc['created_at'], $latest_doc['updated_at'])->diffForHumans();
            $this->updated = Carbon::parse($latest_doc['updated_at'])->diffForHumans();
        }
    }

    // Refresh Page
    public function RefreshPage(){
        $this->resetpage();
    }

    // Render the view
    public function render()
    {

        $this->Capitalize();
        $this->lastDocumentUpdateTime($this->Id);   // Get the last document updated time

        // Fetch main services and set service name if MainService is selected
        $this->MainServices = MainServices::all();
        if (!is_null($this->MainService)) {
            $mainService = MainServices::find($this->MainService);
            if ($mainService) {
                $this->ServiceName = $mainService->Name;
            }
        }

        // Fetch sub-services based on the selected main service
        $this->SubServices = SubServices::where('Service_Id', $this->MainService)->get();

        // Fetch applicant data
        $applicantData = DB::table('digital_cyber_db')
            ->where('Client_Id', $this->Client_Id)
            ->where('Recycle_Bin', $this->no)
            ->get();

        $mobile = optional($applicantData->first())->Mobile_No;

        if ($mobile) {
            $applications = DB::table('digital_cyber_db')->where('Mobile_No', $mobile)->get();
            $this->count_app = $applications->count();
            $this->app_delivered = $applications
                ->where('Recycle_Bin', $this->no)
                ->where('Status', $this->Status)
                ->count();
            $this->app_pending = $this->count_app - $this->app_delivered;
            $this->app_deleted = $applications
                ->where('Recycle_Bin', 'Yes')
                ->count();

            $latestApplication = $applicantData->first();
            if ($latestApplication) {
                $this->total = $latestApplication->Total_Amount;
                $this->paid = $latestApplication->Amount_Paid;
                $this->balance = $latestApplication->Balance;
            }
        }

        // Fetch status and payment modes
        $status = DB::table('status')
            ->where('Relation', $this->mainservice)
            ->orWhere('Relation', 'General')
            ->orderBy('Orderby', 'asc')
            ->get();

        $paymentModes = PaymentMode::all();

        // Calculate balance
        $this->Balance = intval($this->Total_Amount) - intval($this->Amount_Paid);

        // Fetch document files and status details with pagination
        $docFiles = DocumentFiles::where([
            ['App_Id', $this->Id],
            ['Client_Id', $this->Client_Id]
        ])->paginate(5);

        $statusDetails = Application::where([
            ['Mobile_No', $this->key],
            ['Recycle_Bin', 'No']
        ])
            ->filter(trim($this->filterby))
            ->orderBy('Received_Date', 'desc')
            ->paginate($this->paginate);

        return view('livewire.admin-module.application.edit-application', compact('paymentModes', 'status', 'docFiles', 'statusDetails'));
    }

}
