<?php
namespace App\Traits;

use App\Http\Controllers\ClientRegistration;
use App\Models\Application;
use App\Models\Bookmark;
use App\Models\Bookmarks;
use App\Models\ClientRegister;
use App\Models\CreditLedger;
use App\Models\CreditSource;
use App\Models\CreditSources;
use App\Models\Debit;
use App\Models\DebitSource;
use App\Models\MainServices;
use Illuminate\Http\Request;
use App\Models\PaymentMode;
use App\Models\Status;
use App\Models\SubServices;
use Illuminate\Support\Facades\DB;


trait RightInsightTrait
{

    private $daily_applications;
    private $payment_mode;
    private $ForceDelete='Disable';
    private $application_type;
    private $status_list;
    private $applications_served;
    private $applications_delivered;
    private $previous_day_app;
    private $total_revenue;
    private $balance_due;
    private $daily_total;
    private $previous_revenue;
    private $previous_day;
    private $sl_no;
    private $today;
    private $daily_app_amount;
    private $previous_bal;
    private $info;
    private $yes;
    public  $sum;
    private $previous_sum;
    private $balance_due_sum;
    private $previous_bal_sum;
    private $new_user;
    private $new_clients;
    private $previous_day_new_clients;
    private $credit_source;
    private $credit_sources;
    private $status;
    private $bookmarks;
    private $MainServices;
    private $SubServices;

    public function __construct()
    {
        $this->today = date("Y-m-d");
        $this->no = 'No';
        $this->yes = 'Yes';
        $this->n=1;
        $this->info="";
        $status = 'Delivered';
        $this->status = Status::all();
        $this->bookmarks = Bookmark::all();
        $this->payment_mode= PaymentMode::all();
        $this->MainServices= MainServices::orderby('Order_By','asc')->get();
        $this->SubServices= SubServices::all();
        $this->application_type = DB::table('services')->get();
        $this->status_list =  Status::all();
        $this->applications_served = DB::table('digital_cyber_db')->count();
        $this->previous_day = date('Y-m-d', strtotime($this->today. ' - 1 days'));
        $this->previous_day_app = DB::table('digital_cyber_db')->where([ ['Received_Date','=' , $this->previous_day],['Recycle_Bin','=' ,$this->no] ])->count();
        $status = 'Delivered';
        $this->applications_delivered = DB::table('digital_cyber_db')->where([ ['Status','=',
        $status],['Recycle_Bin','=' ,$this->no] ])->count();
        $this->previous_day_app_delivered = DB::table('digital_cyber_db')->where([ ['Status','=',
         $status],['Recycle_Bin','=' ,$this->no],['Delivered_Date','=',$this->previous_day] ])->count();
        $this->total_revenue=CreditLedger::all();
        $this->balance_due=DB::table('digital_cyber_db')->where([['Recycle_Bin','=' ,$this->no] ])->get();
        $this->previous_revenue=DB::table('digital_cyber_db')->where([['Received_Date','=',$this->previous_day],['Recycle_Bin','=' ,$this->no] ])->get();
        $this->previous_bal=DB::table('digital_cyber_db')->where([['Received_Date','=',$this->previous_day],['Recycle_Bin','=' ,$this->no] ])->get();
        $this->sl_no=DB::table('digital_cyber_db')->where([ ['Received_Date','=' , $this->today],['Recycle_Bin','=' ,$this->no] ])->count();
        $this->daily_app_amount = DB::table('digital_cyber_db')->where([ ['Received_Date','=' , $this->today],['Recycle_Bin','=' ,$this->no] ])->get();
        $this->daily_applications=DB::table('digital_cyber_db')->where([ ['Received_Date','=' , $this->today],['Recycle_Bin','=' ,$this->no] ])->paginate(10);
        // $this->sum=0.00;
        $this->previous_sum=0.00;
        $this->balance_due_sum=0.00;
        $this->previous_bal_sum=0.00;

        $this->credit_source = CreditSource::orderby('Name')->get();
        $this->debit_source = DebitSource::orderby('Name')->get();
        $Id =  "DCA".date("Y") .date("m").mt_rand(100, 999);
        $this->daily_total=0;
        foreach ($this->daily_app_amount as $key)
        {
             $key  = get_object_vars($key);
            {
                $this->daily_total += $key['Amount_Paid'];
            }
        }

        $this->sum=0;
        foreach ($this->total_revenue as $key)
        {
            {
                $this->sum += $key['Amount_Paid'];
            }
        }
        $this->previous_sum=0.00;
        foreach ($this->previous_revenue as $key)
        {
             $key  = get_object_vars($key);
            {
                $this->previous_sum += $key['Amount_Paid'];
            }
        }


        $this->balance_due_sum=0.00;
        foreach ($this->balance_due as $key)
        {
             $key  = get_object_vars($key);
            {
                $this->balance_due_sum += $key['Balance'];
            }
        }

        $this->previous_bal_sum=0.00;
        foreach ($this->previous_bal as $key)
        {
             $key  = get_object_vars($key);
            {
                $this->previous_bal_sum += $key['Balance'];
            }
        }

        $this->status_list = Status::all();
    }

}




