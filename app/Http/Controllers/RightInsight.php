<?php

namespace App\Http\Controllers;

use App\Models\MainServices;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\PaymentMode;
use App\Models\Service;
use App\Models\Status;

class RightInsight extends Controller
{
    private $daily_applications;
    private $payment_mode;
    private $application_type;
    private $status_list;
    private $applications_served;
    private $applications_delivered;
    private $previous_day_app;
    private $total_revenue;
    private $balance_due;
    private $previous_revenue;
    private $previous_day;
    private $sl_no;
    private $today;
    private $daily_app_amount;
    private $previous_bal;
    private  $info;
    private  $yes;

    public function __construct()
    {   $this->today = date("Y-m-d");
        $this->no = '';
        $this->yes = 'Yes';
        $this->n=1;
        $this->info="";
        $status = 'Delivered';
        $this->payment_mode= PaymentMode::all();
        $this->application_type = DB::table('service_list')->get();
        $this->status_list =  Status::all();
        $this->applications_served = DB::table('digital_cyber_db')->count();
        $this->previous_day = date('Y-m-d', strtotime($this->today. ' - 1 days'));
        $this->previous_day_app = DB::table('digital_cyber_db')->where([ ['Received_Date','=' , $this->previous_day],['Recycle_Bin','=' ,$this->no] ])->count();
        $status = 'Delivered';
        $this->applications_delivered = DB::table('digital_cyber_db')->where([ ['Status','=',
        $status],['Recycle_Bin','=' ,$this->no] ])->count();
        $this->previous_day_app_delivered = DB::table('digital_cyber_db')->where([ ['Status','=',
         $status],['Recycle_Bin','=' ,$this->no],['Delivered_Date','=',$this->previous_day] ])->count();
        $this->total_revenue=DB::table('digital_cyber_db')->where([['Recycle_Bin','=' ,$this->no] ])->get();
        $this->balance_due=DB::table('digital_cyber_db')->where([['Recycle_Bin','=' ,$this->no] ])->get();
        $this->previous_revenue=DB::table('digital_cyber_db')->where([['Received_Date','=',$this->previous_day],['Recycle_Bin','=' ,$this->no] ])->get();
        $this->previous_bal=DB::table('digital_cyber_db')->where([['Received_Date','=',$this->previous_day],['Recycle_Bin','=' ,$this->no] ])->get();
        $this->sl_no=DB::table('digital_cyber_db')->where([ ['Received_Date','=' , $this->today],['Recycle_Bin','=' ,$this->no] ])->count();
        $this->daily_app_amount = DB::table('digital_cyber_db')->where([ ['Received_Date','=' , $this->today],['Recycle_Bin','=' ,$this->no] ])->get();
        $this->daily_applications=DB::table('digital_cyber_db')->where([ ['Received_Date','=' , $this->today],['Recycle_Bin','=' ,$this->no] ])->paginate(10);
    }
    public function Home()
    {
        $Id =  "DCA".date("Y") .date("m").mt_rand(100, 999);
        $total=0;
        foreach ($this->daily_app_amount as $key)
        {
             $key  = get_object_vars($key);
            {
                $total += $key['Amount_Paid'];
            }
        }

        // Code for insight Data Records

        $sum=0.00;
        foreach ($this->total_revenue as $key)
        {
             $key  = get_object_vars($key);
            {
                $sum += $key['Amount_Paid'];
            }
        }
        $previous_sum=0.00;
        foreach ($this->previous_revenue as $key)
        {
             $key  = get_object_vars($key);
            {
                $previous_sum += $key['Amount_Paid'];
            }
        }


        $balance_due_sum=0.00;
        foreach ($this->balance_due as $key)
        {
             $key  = get_object_vars($key);
            {
                $balance_due_sum += $key['Balance'];
            }
        }

        $previous_bal_sum=0.00;
        foreach ($this->previous_bal as $key)
        {
             $key  = get_object_vars($key);
            {
                $previous_bal_sum += $key['Balance'];
            }
        }

        // Returns the Values to New Form
        return view('Layouts.right_insight',['daily_applications'=>$this->daily_applications, 'total'=>$total,'application_type'=>$this->application_type,'payment_mode'=>$this->payment_mode, 'Id'=>$Id,'sl_no'=>$this->sl_no,'n'=>$this->n,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$sum,'previous_revenue'=>$previous_sum,'balance_due'=>$balance_due_sum,'previous_bal'=>$previous_bal_sum,'today'=>$this->today]);
    }

}
