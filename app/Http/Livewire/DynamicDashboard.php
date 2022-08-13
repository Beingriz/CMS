<?php

namespace App\Http\Livewire;

use App\Models\Application;
use App\Models\Bookmark;
use App\Models\Bookmarks;
use App\Models\MainServices;
use App\Models\Status;
use App\Models\SubServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DynamicDashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
   public  $servicename;
   public  $SubServices;
   public  $status;
   public  $MainServiceId;
   public  $Sub_Serv_Name;
   public  $Serv_Name;
   public  $status_count;
   protected  $StatusDetails=[];
   public  $n=1;
   public  $count;
   public  $temp_count=0;
   public  $ChangedStaus;
   public  $status_name;
   public function mount($MainServiceId)
   {
       $this->MainServiceId = $MainServiceId;


   }

    public function ChangeService($Sub_Serv_Name)
    {
        $servicename = MainServices::Where('Id',$this->MainServiceId)->get();
        foreach ($servicename as $name)
        {
            $this->Serv_Name = $name['Name'];
        }
        $this->Serv_Name;
        $this->Sub_Serv_Name = $Sub_Serv_Name;

        $this->status = DB::table('status')
                                ->Where('Relation',$this->Serv_Name)
                                ->orWhere('Relation','General')
                                ->orderBy('Orderby', 'asc')
                                ->get();
        if(count($this->status)>0)
        {
            $n=0;
            $No='No';
            foreach($this->status as $item)
            {
                $item  = get_object_vars($item);
                {

                    $status_name = $item['Status'];
                    DB::update('update status set Temp_Count=? where status=?',[$n, $status_name]);
                    $count = DB::table('digital_cyber_db')->Where([['Application',$this->Serv_Name],['Application_Type',$Sub_Serv_Name],['Status',$status_name],['Recycle_Bin',$No]])->count();
                    DB::update('update status set Temp_Count=? where status=?',[$count, $status_name]);
                }

            }
        }
        $this->count=0;
        $this->temp_count=1;

    }

    public function ShowDetails($name)
    {
        $fetch_details = NULL;
        $No = 'No';
        $fetch_details = Application::Where([['Application',$this->Serv_Name],['Application_Type',$this->Sub_Serv_Name],['Status',$name],['Recycle_Bin',$No]])->get();
        $this->StatusDetails = $fetch_details;
        $this->count = count($fetch_details);
        $this->status_name = $name;


    }
    public function UpdateStatus($Id,$pstatus,$ustatus)
    {

       DB::update('update digital_cyber_db set Status = ? where Id = ?', [$ustatus,$Id]);
       session()->flash('SuccessMsg', 'The Status has been Changed From '.$pstatus.' to ' .$ustatus.' Successfully');
       $this->count=0;

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

        return redirect('../dynamic_dashboard/'.$this->MainServiceId);


    }
    public function UpdateServiceType($Id,$ptype,$utype)
    {

       DB::update('update digital_cyber_db set Application_Type = ? where Id = ?', [$utype,$Id]);
       session()->flash('SuccessMsg', 'The Service Type has been Changed From '.$ptype. ' to ' .$utype.' Successfully');

       $notification = array(
        'message'=>'The Service Type has been Changed From '.$ptype. ' to ' .$utype.' Successfully',
        'alert-type' =>'success'
       );

       $this->count=0;
        return redirect()->route('DynamicDashboard')->with($notification);


    }

    public function render()
   {
        $servicename = MainServices::Where('Id',$this->MainServiceId)->get();
        foreach ($servicename as $name)
        {
            $this->Serv_Name = $name['Name'];
        }
        $this->Serv_Name;
        $this->SubServices = SubServices::Where('Service_Id',$this->MainServiceId)->get();

        $this->status = DB::table('status')
                                ->Where('Relation',$this->Serv_Name)
                                ->orWhere('Relation','General')
                                ->orderBy('Orderby', 'asc')
                                ->get();

        $bookmarks = Bookmark::Where('Relation',$this->Serv_Name)->orderby('Name','asc')->get();

        return view('livewire.dynamic-dashboard',[
           'status'=>$this->status, 'ServName'=>$this->Serv_Name,'bookmarks'=>$bookmarks,
           'SubServices'=>$this->SubServices, 'n'=>$this->n, 'StatusDetails' =>$this->StatusDetails
       ]);
   }


}
