<?php

namespace App\Http\Livewire;

use App\Models\Application;
use App\Models\MainServices;
use App\Traits\RightInsightTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AppStatusList extends Component
{
    use RightInsightTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public $service;
    public $ChangeStatus;
    public $Checked_Id =[];
    public $Select_Date;
    public $application_types;
    public $total_revenues;
    public $sl_nos;
    public $no='';
    public $paginate=10;
    public $filterby;

    public function mount($service)
    {
        $this->ChangeStatus = $service;
    }

    public function MultipleStatusUpdate($status)
    {
        DB::table('digital_cyber_db')->whereIn('Id',$this->Checked_Id)->update(array('Status'=>$status));
        session()->flash('SuccessMsg','Status of '.count($this->Checked_Id).' Applications Changed ');
        $this->Checked_Id = [];

        // Code to Updte Notification Counter After Every Status Change
        $MainServices = MainServices::all();
        $today = date("Y-m-d");
        foreach($MainServices as $service)
        {
            $notification = 0;
            $No='No';
            $app = $service['Name'];
            $chechk_status = DB::table('digital_cyber_db')->where([['Application',$service['Name']],['Status','Received'],['Recycle_Bin',$No]])->get();
            DB::update('update service_list set Temp_Count = ? where Name = ?', [$notification,$app]);
            foreach($chechk_status as $count)
            {

                $count = get_object_vars($count);
                $received_date = $count['Received_Date'];
                $start_time = new Carbon($received_date);
                $finish_time = new Carbon($today);
                $diff_days = $start_time->diffInDays($finish_time);
                if(($diff_days)>=2)
                {
                    $notification += 1;
                    DB::update('update service_list set Temp_Count = ? where Name = ?', [$notification,$app]);
                }
            }
        }

        if($this->applications_served>0)
        {

            foreach($this->MainServices as $key)
            {
                $application_total_count = DB::table('digital_cyber_db')->where ('Application', '=', $key['Name'])->count();
                DB::update('update service_list set Total_Count=? where Id=?',[$application_total_count, $key['Id']]);
                $application_amount = DB::table('digital_cyber_db')->where('Application','=', $key['Name'])->count();
                $total_amount = 0;
                if($application_amount>0)
                {
                     $add_amount = DB::table('digital_cyber_db')->where('Application','=', $key['Name'])->get();
                     foreach($add_amount as $total)
                     {
                         $total  = get_object_vars($total);
                         {
                             $total_amount+= $total['Amount_Paid'];
                         }
                     }
                }
                DB::update('update service_list set Total_Amount=? where Id=?',[$total_amount, $key['Id']]);
            }

        }


    }
    public function render()
    {
        $app_status_list = Application::Where([['Status',$this->ChangeStatus],['Recycle_Bin',$this->no]])
                                        ->filter(trim($this->filterby))->Paginate($this->paginate);
        $amount = Application::Where([['Status',$this->ChangeStatus],['Recycle_Bin',$this->no]])->get();
        $sl_no = Application::Where([['Status',$this->ChangeStatus],['Recycle_Bin',$this->no]])->count();
        $sum = 0;
        foreach($amount as $key)
        {
            $sum += $key['Total_Amount'];
        }
        $balance = 0;
        foreach($amount as $key)
        {
            $balance += $key['Balance'];
        }

        return view('livewire.app-status-list',[
            'StatusLists'=>$this->status,
            'total_revenue'=>$sum,
            'Balance'=>$balance,
            'sl_no'=>$sl_no,'n'=>$this->n,
            'app_list'=>$app_status_list,
        ]);
    }
    public function MultipleDelete($id)
    {
        # code...
    }
}
