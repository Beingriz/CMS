<?php

namespace App\Http\Livewire\AdminModule\Application;

use App\Models\Application;
use App\Models\DocumentFiles;
use App\Models\Status;
use App\Traits\RightInsightTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class OpenApplication extends Component
{
    use RightInsightTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $Client_Id, $Id;
    public $Name;
    public $Dob;
    public $Ack_No = 'Not Available';
    public $Document_No = 'Not Available';
    public $Total_Amount;
    public $Amount_Paid;
    public $Balance;
    public $PaymentMode;
    public $Received_Date, $Applied_Date, $Delivered_Date;
    public $SubSelected;
    public $MainSelected;
    public $Application;
    public $Application_Type;
    public $Mobile_No = NULL;
    public $Status;
    public $Registered, $count_app = 0, $app_count, $app_pending, $app_delivered, $app_deleted;
    public $total, $paid, $balance = 0, $n = 1;
    public $filterby, $show = 0, $Checked, $collection, $Profile_Image,$paginate=5;
    public $Select_Date, $Daily_Income = 0;
    protected $show_app;
    public $Doc_Files;

    public function mount($Id)
    {
        $fetch = Application::Wherekey($Id)->get();
        foreach ($fetch as $key) {
            $this->Client_Id = $key['Client_Id'];
            $this->Id = $key['Id'];
            $this->Name = $key['Name'];
            $this->Application = $key['Application'];
            $this->Application_Type = $key['Application_Type'];
            $this->Dob = $key['Dob'];
            $this->Mobile_No = $key['Mobile_No'];
            $this->Received_Date = $key['Received_Date'];
            $this->Applied_Date = $key['Applied_Date'];
            $this->Ack_No = $key['Ack_No'];
            $this->Document_No = $key['Document_No'];
            $this->Total_Amount = $key['Total_Amount'];
            $this->Amount_Paid = $key['Amount_Paid'];
            $this->Balance = $key['Balance'];
            $this->PaymentMode = $key['Payment_Mode'];
            $this->Status = $key['Status'];
            $this->Delivered_Date = $key['Delivered_Date'];
            $this->Registered = $key['Registered'];
            $this->Profile_Image = $key['Profile_Image'];
        }
    }
    public function ShowApplications($key)
    {
        $this->show = 1;
        $this->show_app  = Application::where([['Mobile_No', '=', $key], ['Recycle_Bin', '=', $this->no]])
        ->filter(trim($this->filterby))
        // ->when($this->Status, function ($query, $status) {
        //     return $query->where('Status', $status);
        // })
        ->paginate($this->paginate);
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
                session()->flash('SuccessMsg', $name . ' File Deleted Successfully!');
            } else {
                session()->flash('Error', 'Unable to Delete');
            }
        } else {
            session()->flash('Error', 'File Not Available');
        }
    }

    public function render()
    {
        $this->resetPage();
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
        $this->app_delivered =  DB::table('digital_cyber_db')->where([['Mobile_No', '=', $mobile], ['Recycle_Bin', '=', $this->no], ['Status', '=', 'Delivered to Client']])->count();
        $this->app_pending =  $this->count_app - $this->app_delivered;
        $this->app_deleted =  DB::table('digital_cyber_db')->where([['Mobile_No', '=', $mobile], ['Recycle_Bin', '=', $yes]])->count();
        foreach ($get_app as $amt) {
            $amt = get_object_vars($amt); {
                $this->total +=  $amt['Total_Amount'];
                $this->paid += $amt['Amount_Paid'];
                $this->balance +=  $amt['Balance'];
            }
        }
        $this->Doc_Files = DocumentFiles::Where([['App_Id', $this->Id], ['Client_Id', $this->Client_Id]])->get();
        $status_list = Status::all();

        return view('livewire.admin-module.application.open-application', ['show_app' => $this->show_app,'status_list' => $status_list]);
    }
}
