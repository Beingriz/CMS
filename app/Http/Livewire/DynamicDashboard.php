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
   public  $ShowTable = false;
   public  $temp_count=0;
   public  $ChangedStaus;
   public  $status_name,$paginate=5,$filterby;
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
        $this->ShowTable=false;
        $this->temp_count=1;

    }

    public function ShowDetails($name)
    {
        // dd($name);
        $fetch_details = NULL;
        $No = 'No';
        // $fetch_details = Application::Where([['Application',$this->Serv_Name],['Application_Type',$this->Sub_Serv_Name],['Status',trim($name)],['Recycle_Bin',$No]])->get();
        // $this->StatusDetails = $fetch_details;
        // $this->count = count($fetch_details);
        $this->status_name = $name;
        $this->ShowTable = true;
    }
    public function UpdateStatus($Id,$pstatus,$ustatus,$subserv)
    {
        $data = array();
        $data['Status'] = $ustatus;
        $data['updated_at'] = Carbon::now();
        Application::where('Id',$Id)->update($data);
       session()->flash('SuccessMsg', 'The Status has been Changed From '.$pstatus.' to ' .$ustatus.' Successfully');
       $this->ShowTable=false;

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
        $this->ChangeService($subserv);
        $this->ShowDetails($pstatus);


    }
    public function UpdateServiceType($Id,$ptype,$utype,$pstatus)
    {
        // Updating the Applcation Database with New Sub Service.
        $data = array();
        $data['Application_Type'] = $utype;
        $data['updated_at'] = Carbon::now();
        Application::where('Id',$Id)->update($data);
        session()->flash('SuccessMsg', 'The Service Type has been Changed From '.$ptype. ' to ' .$utype.' Successfully');

        $this->updateMainSerivcesNotification();
        $this->updateSubServiceCount($this->MainServiceId);
        $this->ChangeService($ptype);
        $this->ShowDetails($pstatus);
        $this->ShowTable=true;
    }

    public function updateMainSerivcesNotification(){
        $MainServices = MainServices::all();
        $today = date("Y-m-d");
        foreach($MainServices as $service)
        {
            // Setting Notification to 0
            $notification = 0;
            $app = $service['Name'];
            $chechk_status = DB::table('digital_cyber_db')->where([['Application',$service['Name']],['Status','Received'],['Recycle_Bin','No']])->get();
            foreach($chechk_status as $count){
                $count = get_object_vars($count);
                $received_date = $count['Received_Date'];
                $start_time = new Carbon($received_date);
                $finish_time = new Carbon($today);
                $diff_days = $start_time->diffInDays($finish_time);
                if(($diff_days)>=2)
                {
                    $notification += 1;
                    $data = array();
                    $data['Temp_Count'] = $notification;
                    MainServices::where('Name',$app)->update($data);
                }
            }
        }
    }

    public function updateSubServiceCount($MainServiceId){
        $Sub_Services = SubServices::Where('Service_Id',$MainServiceId)->get();
        if(count($Sub_Services)>0)
        {
            foreach($Sub_Services as $item)
            {
                {
                    $name = $item['Name'];
                    $count = Application::Where([['Application_Type',$name],['Recycle_Bin','No']])->count();
                    $data = array();
                    $data['Total_Count'] = $count;
                    SubServices::where('Name',$name)->update($data);
                }
            }
        }
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

        $StatusDetails = Application::where([['Application',$this->Serv_Name],['Application_Type',$this->Sub_Serv_Name]])
                                ->Where([['Status',trim($this->status_name)],['Recycle_Bin','No']])
                                ->filter(trim($this->filterby))->Orderby('Received_Date', 'desc')->paginate($this->paginate);
        return view('livewire.dynamic-dashboard',compact('StatusDetails'),[
           'status'=>$this->status, 'ServName'=>$this->Serv_Name,'bookmarks'=>$bookmarks,
           'SubServices'=>$this->SubServices, 'n'=>$this->n,
       ]);
   }


}
