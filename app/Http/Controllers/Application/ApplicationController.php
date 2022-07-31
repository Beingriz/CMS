<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\DocumentFiles;
use App\Models\SubServices;
use App\Traits\RightInsightTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    use RightInsightTrait;

    public function index()
    {
        return view('Application.new_app');
    }
    public function Home()
    {

        return view('Application\app_dashboard',);
    }
    public function UpdateService()
    {

        return view('DigitalLedger\CreditLedger\update',);
    }
    public function Temp()
    {
        return view('Application\new_template');
    }
    public function Dashboard()
    {
        if($this->applications_served>0)
        {

            foreach($this->MainServices as $key)
            {
                $application_total_count = DB::table('digital_cyber_db')->where ('Application', '=', $key['Name'])->count();
                DB::update('update service_list set  Total_Count = ? where Id = ?',[$application_total_count, $key['Id']]);
                $application_amount = DB::table('digital_cyber_db')->where('Application','=', $key['Name'])->count();
                $notification = 0;
                $No='No';
                $app = $key['Name'];
                $chechk_status = DB::table('digital_cyber_db')->where([['Application',$key['Name']],['Status','Received'],['Recycle_Bin',$No]])->get();
                DB::update('update service_list set Temp_Count = ? where Name = ?', [$notification,$app]);
                foreach($chechk_status as $count)
                {

                    $count = get_object_vars($count);
                    $received_date = $count['Received_Date'];
                    $start_time = new Carbon($received_date);
                    $finish_time = new Carbon($this->today);
                    $diff_days = $start_time->diffInDays($finish_time);
                    if(($diff_days)>=2)
                    {
                        $notification += 1;
                        DB::update('update service_list set Temp_Count = ? where Name = ?', [$notification,$app]);
                    }
                }

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
        // Code for insight Data Records are fetched from RightInsight Trait
        return view('Application\app_dashboard',['total_applicaiton'=>$this->applications_served,'total_amount'=>$total_amount,'Mainservices'=>$this->MainServices,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered,'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'new_clients'=>$this->new_clients,'previous_day_new_clients'=>$this->previous_day_new_clients,'bookmarks'=>$this->bookmarks,]);
    }
    public function DynamicDashboard($MainServiceId)
    {
        $No='No';
        $Sub_Services = SubServices::Where('Service_Id',$MainServiceId)->get();
        if(count($Sub_Services)>0)
        {
            foreach($Sub_Services as $item)
            {
                {
                    $name = $item['Name'];
                    $count = Application::Where([['Application_Type',$name],['Recycle_Bin',$No]])->count();
                    DB::update('update sub_service_list set Total_Count=?  where Name = ?', [$count,$name]);
                }
            }
        }
        $a=0;$b=1;


        DB::update('update status set Temp_Count=?  where?', [$a,$b]);
        return view('Application\app_dynamic_dashboard',[
           'MainServiceId'=>$MainServiceId,
       ]);

    }
    public function Edit($Id)
    {

        return view('Application.edit_app',['application_type'=>$this->application_type,'payment_mode'=>$this->payment_mode,'sl_no'=>$this->sl_no, 'n'=>$this->n,'daily_applications'=>$this->daily_applications,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'Id'=>$Id,'ForceDelete'=>$this->ForceDelete]);
    }
    public function Download_Ack($Id)
    {
        $fetch = Application::wherekey($Id)->get();
        foreach ($fetch as $key)
        {
            $file = $key['Ack_File'];

        }
        if (Storage::exists($file))
        {
            $file = 'storage/app/'.$file;
            return response()->download($file);
        }
        else
        {
            return redirect('/open_app/'.$Id)->with('Error','Acknowledgement Not Available!');

        }
    }
    public function Download_Doc($Id)
    {
        $fetch = Application::wherekey($Id)->get();
        foreach ($fetch as $key)
        {
            $file = $key['Doc_File'];
        }
        if (Storage::exists($file))
        {
            $file = 'storage/app/'.$file;
            return response()->download($file);
        }
        else
        {
            return redirect('/open_app/'.$Id)->with('Error','Document File Not Available!');

        }
    }
    public function Download_Files($Doc_Id)
    {

        $fetch = DocumentFiles::wherekey($Doc_Id)->get();
        foreach ($fetch as $key)
        {
            $file = $key['Document_Path'];
            $Id = $key['App_Id'];
        }
        if (Storage::exists($file))
        {
            $file = 'storage/app/'.$file;
            return response()->download($file);
        }
        else
        {
            return redirect('/edit_app/'.$Id)->with('Error','Document File Not Available!');

        }
    }
    public function Download_Pay($Id)
    {
        $fetch = Application::wherekey($Id)->get();
        foreach ($fetch as $key)
        {
            $file = $key['Payment_Receipt'];
        }
        if (Storage::exists($file))
        {
            $file = 'storage/app/'.$file;
            return response()->download($file);
        }
        else
        {
            return redirect('/open_app/'.$Id)->with('Error','Payment File Not Available!');

        }
    }
    public function Delete_File($Id)
    {
        $check = DocumentFiles::wherekey($Id)->get();
        foreach($check as $key)
        {
            $name = $key['Document_Name'];
            $file = $key['Document_Path'];
        }
        // dd($file);
        if (Storage::disk('public')->exists($file))
        {
            // dd('found file');
            unlink('storage/'.$file);
            DocumentFiles::wherekey($Id)->delete();
            session()->flash('SuccessMsg',$name.' File Deleted Successfully');
            return redirect()->back();
        }
        else
        {
            session()->flash('Error',$name.' File Not Exist');
            return redirect()->back();


        }
    }

    public function Update(Request $request, $Id)
    {

        $rule = ['Name'=>'required', 'Mobile_No'=>['required', 'min:10'],'Application_Type'=>'required','DOB'=>'required','Total_Amount'=>'required','Amount_Paid'=>'required','Balance'=>'required','Payment_Mode'=>'required'];
        $validation = Validator::make($request->input(), $rule);
        if($validation->fails())
        {
             return redirect('/update_app/'.$Id)->withInput()->withErrors($validation);
        }
        // Application will save in Digital Cyber DB , Pan Card , and Credit Ledger
        elseif($request->Application_Type =="New Pan Card" || $request->Application_Type =="Pan Card Correction" || $request->Application_Type =="Reprint Pan Card")
        {
            $validate=$request->input();
            // Update application in Digital Cyber DB and Pan Card DB
            // Digital Cyber DB
            DB::update('update digital_cyber_db set Application_Type = ?,Name=?,Mobile_No=?,Dob=?,Ack_No=?,Document_No=?,Total_Amount=?,Amount_Paid=?,Balance=?,Payment_Mode=? where Id = ?',[$validate['Application_Type'],$validate['Name'],$validate['Mobile_No'],$validate['DOB'],$validate['Ack_No'],$validate['Document_No'],$validate['Total_Amount'],$validate['Amount_Paid'],$validate['Balance'],$validate['Payment_Mode'],$Id]);
            // Pan Card Db
            DB::update('update pan_card set Application_Type = ?,Name=?,Mobile_No=?,Dob=?,Ack_No=?,Pan_No=?,Total_Amount=?,Amount_Paid=?,Balance=?,Payment_Mode=? where Id = ?',[$validate['Application_Type'],$validate['Name'],$validate['Mobile_No'],$validate['DOB'],$validate['Ack_No'],$validate['Document_No'],$validate['Total_Amount'],$validate['Amount_Paid'],$validate['Balance'],$validate['Payment_Mode'],$Id]);
            // Credit Ledger
            $desc = "Received Rs. ".$validate['Amount_Paid']."/- From  ".$validate['Name']." for ".$validate['Application_Type'].", on ".$this->today." by  ". $validate['Payment_Mode'];

            DB::update('update credit_ledger set Source = ?,Date=?,Amount=?,Description=?,Payment_Mode=? where Id = ?',[$validate['Application_Type'],$this->today,$validate['Amount_Paid'],$desc,$validate['Payment_Mode'],$Id]);

            return redirect('/edit_app/'.$Id)->with('SuccessUpdate','Applicatin Updated Successfully');
        }
        // Application will save only in Digital Cyber and Credit Ledger
        else
        {
            $validate=$request->input();
            // Update application only in Digital Cyber DB

            // Digital Cyber DB
            DB::update('update digital_cyber_db set Application_Type = ?,Name=?,Mobile_No=?,Dob=?,Ack_No=?,Document_No=?,Total_Amount=?,Amount_Paid=?,Balance=?,Payment_Mode=? where Id = ?',[$validate['Application_Type'],$validate['Name'],$validate['Mobile_No'],$validate['DOB'],$validate['Ack_No'],$validate['Document_No'],$validate['Total_Amount'],$validate['Amount_Paid'],$validate['Balance'],$validate['Payment_Mode'],$Id]);

            // Credit Ledger
            $desc = "Received Rs. ".$validate['Amount_Paid']."/- From  ".$validate['Name']." for ".$validate['Application_Type'].", on ".$this->today." by  ". $validate['Payment_Mode'];

            DB::update('update credit_ledger set Source = ?,Date=?,Amount=?,Description=?,Payment_Mode=? where Id = ?',[$validate['Application_Type'],$this->today,$validate['Amount_Paid'],$desc,$validate['Payment_Mode'],$Id]);
            return redirect('/edit_app/'.$Id)->with('SuccessUpdate','Applicatin Updated Successfully');
        }
    }

    public function List()
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

        // Code for insight Data Records are fetched from Right Insight Traits


        // Returns the Values to New Form
        return view('Application\new_app',['daily_applications'=>$this->daily_applications, 'daily_total'=>$total,'application_type'=>$this->application_type,'payment_mode'=>$this->payment_mode, 'Id'=>$Id,'sl_no'=>$this->sl_no,'n'=>$this->n,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'today'=>$this->today]);
    }
    public function PreviousDay()
    {
        $Id =  "DCA".date("Y") .date("m").mt_rand(100, 999);
        $previous_day_app=DB::table('digital_cyber_db')->where([ ['Received_Date','=' , $this->previous_day],['Recycle_Bin','=' ,$this->no] ])->paginate(5);
        $sl_no=DB::table('digital_cyber_db')->where([ ['Received_Date','=' , $this->previous_day],['Recycle_Bin','=' ,$this->no] ])->count();
        if($sl_no>0)
        {
            $total=0;
            foreach ($previous_day_app as $key)
            {
                $key  = get_object_vars($key);
                {
                    $total += $key['Amount_Paid'];
                }
            }


            return view('Application\new_app',['daily_applications'=>$previous_day_app, 'total'=>$total,'application_type'=>$this->application_type,'payment_mode'=>$this->payment_mode, 'Id'=>$Id,'sl_no'=>$sl_no,'n'=>$this->n,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'today'=>$this->today]);
        }
        else
        {
            return redirect('app_form')->with('Error', 'No Records Available for Selected Day i.e'.$this->today);
        }
    }
    public function SelectedDateList($date)
    {
        $Id =  "DCA".date("Y") .date("m").mt_rand(100, 999);
        $daily_applications=DB::table('digital_cyber_db')->where([ ['Received_Date','=' , $date],['Recycle_Bin','=' ,$this->no] ])->paginate(5);
        $sl_no=DB::table('digital_cyber_db')->where([ ['Received_Date','=' , $date],['Recycle_Bin','=' ,$this->no] ])->count();
        if($sl_no>0)
        {
            $total=0;
            foreach ($daily_applications as $key)
            {
                $key  = get_object_vars($key);
                {
                    $total += $key['Amount_Paid'];
                }
            }

            // Code for insight Data Records


            return view('Application\new_app',['daily_applications'=>$daily_applications, 'total'=>$total,'application_type'=>$this->application_type,'payment_mode'=>$this->payment_mode, 'Id'=>$Id,'sl_no'=>$sl_no,'n'=>$this->n,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'today'=>$this->today]);
        }
        else
        {
            return redirect('app_form')->with('Error', 'No Records Available for Selected Day i.e'.$date);
        }
    }
    public function BalanceList()
    {

        $balance_list = DB::table('digital_cyber_db')->where([['Balance','>',0],['Recycle_Bin','=',$this->no]])->paginate(10);
        $sl_no = DB::table('digital_cyber_db')->where([['Balance','>',1],['Recycle_Bin','=',$this->no]])->count();
         // Code for insight Data Records


        return view('Application\balance_list',['balance_list'=>$balance_list,'sl_no'=>$sl_no,'n'=>$this->n,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'application_type'=>$this->application_type,'info'=>$this->info]);
    }
    public function Bookmarks()
    {
        return view('Admin.Bookmark.bookmarks',['n'=>$this->n,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'application_type'=>$this->application_type,'info'=>$this->info,]);
    }
    public function StatusModule()
    {
        return view('Admin.Status Module.status',['n'=>$this->n,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'application_type'=>$this->application_type,'info'=>$this->info,]);
    }
    public function AppStatusList($service)
    {

        $app_list = DB::table('digital_cyber_db')->where([['Status','=',$service],['Recycle_Bin','=',$this->no]])->Paginate(15);
        $sl_no = DB::table('digital_cyber_db')->where([['Status','=',$service],['Recycle_Bin','=',$this->no]])->count();

         // Code for insight Data Records


        return view('Application\app_status_list',['app_list'=>$app_list,'sl_no'=>$sl_no,'n'=>$this->n,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'application_type'=>$this->application_type,'info'=>$this->info,'service'=>$service]);
    }
    public function Selected_Ser_Balance_List($value)
    {

        $selected_ser_balance_list = DB::table('digital_cyber_db')->where([['Balance','>',1],['Recycle_Bin','=',$this->no],['Application_Type','=',$value]])->paginate(10);
        $sl_count = DB::table('digital_cyber_db')->where([['Balance','>',1],['Recycle_Bin','=',$this->no],['Application_Type','=',$value]])->count();
        $count_bal=0;
        foreach($selected_ser_balance_list as $key)
        {
            $key = get_object_vars($key);
            {
                $count_bal += $key['Balance'];
            }
        }


        $info = $sl_count.' '.$value.' Applications Found Due for ₹ '.$count_bal.'/-  as on '.date("Y-m-d");

         // Code for insight Data Records

        return view('Application\balance_list',['balance_list'=>
        $selected_ser_balance_list,'sl_no'=>$sl_count,'n'=>$this->n,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'application_type'=>$this->application_type,'info'=>$info]);
    }
    public function Open_Application($Client_Id)
    {
        $yes = 'Yes';
        $sl_no = DB::table('digital_cyber_db')->where([['Client_Id','=',$Client_Id],['Recycle_Bin','=',$this->no]])->count();
        $applicant_data = DB::table('digital_cyber_db')->where([['Client_Id','=',$Client_Id],['Recycle_Bin','=',$this->no]])->get();
        $mobile='';
        foreach ($applicant_data as $field)
        {
            $field = get_object_vars($field);
            {
                $mobile = $field['Mobile_No'];
            }
        }
        $get_app = DB::table('digital_cyber_db')->where('Mobile_No','=',$mobile)->get();
        $count_app = DB::table('digital_cyber_db')->where('Mobile_No','=',$mobile)->count();
        $app_delivered =  DB::table('digital_cyber_db')->where([['Mobile_No','=',$mobile],['Recycle_Bin','=',$this->no],['Status','=','Delivered']])->count();
        $app_pending =  DB::table('digital_cyber_db')->where([['Mobile_No','=',$mobile],['Recycle_Bin','=',$this->no],['Status','=','Pending']])->count();
        $app_deleted =  DB::table('digital_cyber_db')->where([['Mobile_No','=',$mobile],['Recycle_Bin','=',$yes]])->count();
        $tot = 0;
        $amnt = 0;
        $bal = 0;
        foreach ($get_app as $amt)
        {
            $amt = get_object_vars($amt);
            {
                $tot +=  $amt['Total_Amount'];
                $amnt += $amt['Amount_Paid'];
                $bal +=  $amt['Balance'];
            }
        }


        return view('Application\open_application',['applicant_data'=>$applicant_data,'sl_no'=>$sl_no,'n'=>$this->n,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'info'=>$this->info,'indi_total'=>$tot,'indi_amount'=>$amnt,'indi_bal'=>$bal,'indi_count'=>$count_app,'indi_data'=>$get_app,'indi_delivered'=>$app_delivered,'indi_pending'=>$app_pending,'indi_deleted'=>$app_deleted,'Client_Id'=>$Client_Id ]);
    }
    public function Update_Application($Id)
    {

        $sl_no = DB::table('digital_cyber_db')->where([['Id','=',$Id],['Recycle_Bin','=',$this->no]])->count();
        $applicant_data = DB::table('digital_cyber_db')->where([['Id','=',$Id],['Recycle_Bin','=',$this->no]])->get();

        // Code for Individual Customer Data Insight
        foreach ($applicant_data as $field)
        {
            $field = get_object_vars($field);
            {
                $mobile = $field['Mobile_No'];
            }
        }
        $get_app = DB::table('digital_cyber_db')->where('Mobile_No','=',$mobile)->get();
        $count_app = DB::table('digital_cyber_db')->where('Mobile_No','=',$mobile)->count();
        $app_delivered =  DB::table('digital_cyber_db')->where([['Mobile_No','=',$mobile],['Recycle_Bin','=',$this->no],['Status','=','Delivered']])->count();
        $app_pending =  DB::table('digital_cyber_db')->where([['Mobile_No','=',$mobile],['Recycle_Bin','=',$this->no],['Status','=','Pending']])->count();
        $app_deleted =  DB::table('digital_cyber_db')->where([['Mobile_No','=',$mobile],['Recycle_Bin','=',$this->yes]])->count();
        $tot = 0;
        $amnt = 0;
        $bal = 0;
        foreach ($get_app as $amt)
        {
            $amt = get_object_vars($amt);
            {
                $tot +=  $amt['Total_Amount'];
                $amnt += $amt['Amount_Paid'];
                $bal +=  $amt['Balance'];
            }
        }
        // End of Data Insight Code

         // Code for insight Data Records
         $applications_served = DB::table('digital_cyber_db')->count();
         $previous_day = date('Y-m-d', strtotime($this->today. ' - 1 days'));
         $previous_day_app = DB::table('digital_cyber_db')->where([ ['Received_Date','=' , $previous_day],['Recycle_Bin','=' ,$this->no] ])->count();
         $status = 'Delivered';
         $applications_delivered = DB::table('digital_cyber_db')->where([ ['Status','=',
         $status],['Recycle_Bin','=' ,$this->no] ])->count();
         $previous_day_app_delivered = DB::table('digital_cyber_db')->where([ ['Status','=',
         $status],['Recycle_Bin','=' ,$this->no],['Delivered_Date','=',$previous_day] ])->count();

         $total_revenue=DB::table('digital_cyber_db')->where([['Recycle_Bin','=' ,$this->no] ])->get();
         $sum=0.00;
         foreach ($total_revenue as $key)
         {
              $key  = get_object_vars($key);
             {
                 $sum += $key['Amount_Paid'];
             }
         }

         $previous_revenue=DB::table('digital_cyber_db')->where([['Received_Date','=',$previous_day],['Recycle_Bin','=' ,$this->no] ])->get();

         $previous_sum=0.00;
         foreach ($previous_revenue as $key)
         {
              $key  = get_object_vars($key);
             {
                 $previous_sum += $key['Amount_Paid'];
             }
         }


        //  End of Data Insight Code

        return view('Application\update_open_app',['applicant_data'=>$applicant_data,'sl_no'=>$sl_no,'n'=>$this->n,'applications_served'=>$applications_served,'previous_day_app'=>$previous_day_app,'applications_delivered'=>$applications_delivered,'previous_day_app_delivered'=>$previous_day_app_delivered, 'total_revenue'=>$sum,'previous_revenue'=>$previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'info'=>$this->info,'indi_total'=>$tot,'indi_amount'=>$amnt,'indi_bal'=>$bal,'indi_count'=>$count_app,'indi_data'=>$get_app,'indi_delivered'=>$app_delivered,'indi_pending'=>$app_pending,'application_type'=>$this->application_type,'payment_mode'=>$this->payment_mode,'id'=>$Id,'status_list'=>$this->status_list,'indi_deleted'=>$app_deleted]);
    }

    public function Search($key)
    {

        $search = $key;
        $search_data = DB::table('digital_cyber_db')
                    ->where([['Mobile_No', '=', $search],['Recycle_Bin','=',$this->no]])
                    ->orWhere('Name', '=', $search)
                    ->orWhere('Ack_No', '=', $search)
                    ->get();

        $fetched_data_count = DB::table('digital_cyber_db')
                            ->where([['Mobile_No', '=', $search],['Recycle_Bin','=',$this->no]])
                            ->orWhere('Name', '=', $search)
                            ->orWhere('Ack_No', '=', $search)
                    ->count();
        $total=0;
        foreach ($search_data as $key)
        {
             $key  = get_object_vars($key);
            {
                $total += $key['Amount_Paid'];
            }
        }
        // code for Isnight Data


        return view('Application\search',['search_data'=>$search_data, 'count'=>$fetched_data_count, 'sl_no'=>$fetched_data_count, 'n'=>$this->n, 'search'=>$search,'total'=>$total,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered,'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum]);

    }

    public function Delete($id)
    {
        DB::table('digital_cyber_db')->where('Id', $id)->update(['Recycle_Bin' => $this->yes]);
        DB::table('pan_card')->where('Id', $id)->update(['Recycle_Bin' => $this->yes]);

        return redirect('app_form')->with('RecycleMsg','Apllication Moved to Recycle Bin');
    }
    public function DeletePermanently($id)
    {
        DB::table('digital_cyber_db')->where('Id', $id)->delete();
        DB::table('pan_card')->where('Id', $id)->delete();

        return redirect('view_recycle_bin')->with('RecycleMsg','Apllication Deleted Permanently');
    }
    public function Restore($id)
    {   $value = "No";
        DB::table('digital_cyber_db')->where('Id', $id)->update(['Recycle_Bin' => $value]);
        DB::table('pan_card')->where('Id', $id)->update(['Recycle_Bin' => $value]);

        return redirect('view_recycle_bin');
    }
    public function ViewRecycleBin()
    {

        $No = "Yes";
        $recycle_data = DB::table('digital_cyber_db')->where('Recycle_Bin','=',$No)->paginate(10);
        $total_recycle_data = DB::table('digital_cyber_db')->where('Recycle_Bin','=',$No)->get();
        $sl_no = DB::table('digital_cyber_db')->where('Recycle_Bin','=',$No)->count();
        $total=0;
        $n=1;
        foreach ($total_recycle_data as $key)
        {
             $key  = get_object_vars($key);
            {
                $total += $key['Amount_Paid'];
            }
        }
        return view('Application\recycle_bin',['recycle_data'=>$recycle_data, 'count'=>$sl_no, 'sl_no'=>$sl_no, 'n'=>$n, 'total'=>$total]);
    }

}
