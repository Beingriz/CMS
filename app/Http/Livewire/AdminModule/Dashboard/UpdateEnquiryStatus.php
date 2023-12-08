<?php

namespace App\Http\Livewire\AdminModule\Dashboard;

use App\Models\Callback_Db;
use App\Models\EnquiryDB;
use App\Models\MainServices;
use App\Models\Status;
use App\Models\SubServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class UpdateEnquiryStatus extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $Name, $d, $Service, $SubService, $Message, $Status, $ServiceName, $lastRecTime, $Id;
    public $Amount, $LeadStatus, $Feedback, $Conversion, $Mobile_No;
    public function mount($Key, $Id, $EditId)
    {
        $this->Name = $Key;
        $this->Id = $Id;
        // $this->Id = $Id;
        $this->Edit($Id);
        if (!empty($EditId)) {
            $this->Edit($EditId);
        }
    }
    public function Edit($Id)
    {
        $this->Id = $Id;
        $fetch = EnquiryDB::where('Id', $Id)->get();
        foreach ($fetch as $item) {
            $this->Service = $item['Service'];
            $this->SubService = $item['Service_Type'];
            $this->Message = $item['Message'];
            $this->Mobile_No = $item['Phone_No'];
            $this->Status = $item['Status'];
            $this->Feedback = $item['Feedback'];
            $this->LeadStatus = $item['Lead_Status'];
            $this->Conversion = $item['Conversion'];
            $this->Amount = $item['Amount'];
        }
    }
    public function Update($Id)
    {
        $data = array();
        $data['Service'] = $this->Service;
        $data['Service_Type'] = $this->SubService;
        $data['Status'] = $this->Status;
        $data['Feedback'] = $this->Feedback;
        $data['Lead_Status'] = $this->LeadStatus;
        $data['Conversion'] = $this->Conversion;
        $data['Amount'] = $this->Amount;
        $data['updated_at'] = Carbon::now();

        DB::table('enquiry_form')->where('Id', $Id)->Update($data);
        $notification = array(
            'message' => 'Status Updated!.',
            'alert-type' => 'info'
        );
        return redirect()->route('update.enquiry.dashboard', $Id)->with($notification);
    }
    public function LastUpdate()
    {
        # code...
        $latest_app = EnquiryDB::latest('created_at')->first();
        $this->lastRecTime =  Carbon::parse($latest_app['created_at'])->diffForHumans();
    }
    public function render()
    {
        $this->LastUpdate();
        $MainServices = MainServices::all();
        $SubServices = SubServices::Where('Service_Id', $this->Service)->get();
        $status = Status::where('Relation', 'Callback')->get();
        $requests = EnquiryDB::where('Phone_No', $this->Mobile_No)->paginate(5);
        return view('livewire.admin.admin.update-enquiry-status', compact('MainServices', 'SubServices', 'status', 'requests'));
    }
}
