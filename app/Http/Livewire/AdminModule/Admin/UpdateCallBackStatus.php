<?php

namespace App\Http\Livewire\Admin\Admin;

use App\Models\Callback_Db;
use App\Models\MainServices;
use App\Models\Status;
use App\Models\SubServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class UpdateCallBackStatus extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $Name,$Client_Id,$Service,$SubService,$Message,$Status,$ServiceName,$lastRecTime,$Id;
    public function mount($Key,$Client_Id,$Id,$DeleteId,$EditId){
        $this->Name = $Key;
        $this->Client_Id = $Client_Id;
        $this->Id = $Id;
        $this->Edit($Id);
        if(!empty($EditId)){
            $this->Edit($EditId);
        }
    }
    public function Edit($Id){
        $this->Id = $Id;
        $fetch= Callback_Db::where('Id',$Id)->get();
        foreach($fetch as $item){
            $this->Service = $item['Service'];
            $this->SubService = $item['Service_Type'];
            $this->Message = $item['Message'];
            $this->Status = $item['Status'];
        }
    }
    public function Update($Id){
        $data = array();
        $data['Service'] = $this->Service;
        $data['Service_Type'] = $this->SubService;
        $data['Message'] = $this->Message;
        $data['updated_at'] = Carbon::now();
        $data['Status'] = $this->Status;
        DB::table('callback')->where('Id',$Id)->Update($data);
        $notification = array(
            'message'=>'Status Updated!.',
            'alert-type'=>'info'
        );
        return redirect()->route('update.cb.status',[$Id,$this->Client_Id,$this->Name])->with($notification);
    }
    public function LastUpdate()
    {
        # code...
        $latest_app = Callback_Db::latest('created_at')->first();
        $this->lastRecTime =  Carbon::parse($latest_app['created_at'])->diffForHumans();

    }
    public function render()
    {
        $this->LastUpdate();
        $MainServices = MainServices::all();
        $SubServices = SubServices::Where('Service_Id',$this->Service)->get();
        $status = Status::where('Relation','Callback')->get();
        $requests = Callback_Db::where('Client_Id',$this->Client_Id)->paginate(5);
        return view('livewire.admin.admin.update-call-back-status',compact('MainServices','SubServices','status','requests'));
    }
}
