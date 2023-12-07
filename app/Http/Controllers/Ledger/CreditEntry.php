<?php

namespace App\Http\Controllers\Ledger;

use  App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\CreditSource;
use App\Models\PaymentMode;
use App\Models\CreditLedger;
use App\Models\CreditSources;
use App\Traits\RightInsightTrait;

class CreditEntry extends Controller
{
    use RightInsightTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Home()
    {
        $editId='';$DeleteData='';
        return view('DigitalLedger.CreditLedger.credit_entry',['EditData'=>$editId,'DeleteData'=>$DeleteData]);
    }
    public function CreditSource()
    {
        $EditData='';
        $DeleteData='';
        $editid='';
        $deleteid='';
        return view('DigitalLedger.CreditLedger.add-credit-source',['EditData'=>$EditData,'DeleteData'=>$DeleteData,'editid'=>$editid,'deleteid'=>$deleteid]);
    }
    public function EidtMainSource($Id)
    {
        $EditData=$Id;
        $DeleteData='';
        $editid='';
        $deleteid='';
        return view('DigitalLedger.CreditLedger.add-credit-source',['EditData'=>$EditData,'DeleteData'=>$DeleteData,'editid'=>$editid,'deleteid'=>$deleteid]);
    }
    public function DeleteMainSource($Id)
    {
        $EditData='';
        $DeleteData=$Id;
        $editid='';
        $deleteid='';
        return view('DigitalLedger.CreditLedger.add-credit-source',['EditData'=>$EditData,'DeleteData'=>$DeleteData,'editid'=>$editid,'deleteid'=>$deleteid]);
    }
    public function EditsSubSource($Id)
    {
        $EditData='';
        $DeleteData='';
        $editid=$Id;
        $deleteid='';
        return view('DigitalLedger.CreditLedger.add-credit-source',['EditData'=>$EditData,'DeleteData'=>$DeleteData,'editid'=>$editid,'deleteid'=>$deleteid]);
    }
    public function DeleteSubSource($Id)
    {
        $EditData='';
        $DeleteData='';
        $editid='';
        $deleteid=$Id;
        return view('DigitalLedger.CreditLedger.add-credit-source',['EditData'=>$EditData,'DeleteData'=>$DeleteData,'editid'=>$editid,'deleteid'=>$deleteid]);
    }
    public function AddCreditHome()
    {
        return view('DigitalLedger.CreditLedger.add-credit-source',[
            'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'today'=>$this->today,
        ]);
    }
    public function EditCreditSource($id)
    {
        $fetch = CreditSources::where('CS_Id','=',$id)->get();
        foreach($fetch as $key)
        {
            $CS_Id = $key['CS_Id'];
            $CS_Name = $key['CS_Name'];
            $Source = $key['Source'];
            $Unit_Price = $key['Unit_Price'];
        }
        return view('DigitalLedger.CreditLedger.add-credit-source',[
            'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'today'=>$this->today,'CS_Id'=>$CS_Id,
            'CS_Name'=>$CS_Name,'Source'=>$Source,'Unit_Price'=>$Unit_Price,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function save(Request $request)
    {   $today = date("d-m-Y");
        $year = date("Y");
        $transaction_id =  $year .mt_rand(100000, 999999);
        $desc = "Received Rs. ".$request->Amount."/- From  ".$request->Description . " for ". $request->Particular.", on ".$today." by  ". $request->Payment_mode;
        $this->validate($request,
        ['Particular'=>'required','Date'=>'required','Amount'=>'required','Description'=>'required','Payment_mode'=>'required']);
        $creditentry  = new CreditLedger;
        $creditentry->Id = $transaction_id;
        $creditentry->Client_Id = $transaction_id;
        $creditentry->Date = $request->Date;
        $creditentry->Source = $request->Particular;
        $creditentry->Total_Amount = $request->Amount;
        $creditentry->Amount_Paid = $request->Amount;
        $creditentry->Balance = $request->Amount;
        $creditentry->Description = $desc;
        $creditentry->Payment_Mode = $request->Payment_mode;
        $creditentry->Attachment = $request->Payment_mode;
        $creditentry->save();
        return redirect('credit_entry')->with('SuccessMsg', 'Credit Entry Saved Successfully');

    }
    public function EditCredit($Id){
        $DeleteData='';
        return view('DigitalLedger.CreditLedger.credit_entry',['EditData'=>$Id,'DeleteData'=>$DeleteData]);
    }
    public function DeleteCredit($DeleteData){
        $eidtData='';
        return view('DigitalLedger.CreditLedger.credit_entry',['EditData'=>$eidtData,'DeleteData'=>$DeleteData]);
    }

    public function Daily_count()
    {   $total = 0;
        $n = 1;
        $today = date("Y-m-d");
        $total_todays_list = CreditLedger::where('Date',$today)->get();
        $todays_list = CreditLedger::where('Date',$today)->paginate(5);
        $credit_source = CreditSource::all();
        $payment_mode = PaymentMode::all();
        foreach ($total_todays_list as $key)
        {
            {
                $total += $key['Amount'];
            }

        }
        $sl_no = CreditLedger::where('date',$today)->count();

        $percentage = ($total*100)/1500;
        $editId='';$DeleteData='';
        return view('DigitalLedger.CreditLedger.credit_entry' ,['EditData'=>$editId,'DeleteData'=>$DeleteData,
            'creditdata'=>$todays_list ,'total'=>$total ,
            'sl_no'=>$sl_no, 'n'=>$n, 'credit_source'=>$credit_source,
            'date'=>$today ,'payment_mode'=>$payment_mode,
            'percentage'=>$percentage,'applications_served'=>$this->applications_served,
            'previous_day_app'=>$this->previous_day_app,
            'applications_delivered'=>$this->applications_delivered,
            'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,

        ]);

    }
    public function Previous()
    {
        $total = 0;
        $n = 1;
        $date = date("Y-m-d");
        $previous = date('Y-m-d', strtotime($date. ' - 1 days'));
        $total_previous_day_list = CreditLedger::where('Date',$previous)->get();
        $previous_day_list = CreditLedger::where('Date',$previous)->paginate(5);
        $previous_day = CreditLedger::where('Date',$previous)->count();
        if($previous_day>0)
        {

            $credit_source = CreditSource::all();
            $payment_mode = PaymentMode::all();
            foreach ($total_previous_day_list as $key)
            {
                {
                    $total += $key['Amount'];
                }

            }
            $sl_no = CreditLedger::where('date',$previous_day_list)->count();

            $percentage = ($total*100)/1500;

            return view('DigitalLedger.CreditLedger.credit_entry' ,['creditdata'=>$previous_day_list ,'total'=>$total,'date'=>$previous, 'sl_no'=>$sl_no, 'n'=>$n, 'credit_source'=>$credit_source, 'payment_mode'=>$payment_mode, 'percentage'=>$percentage ]);
        }
        else
        {
            return redirect('credit_entry')->with('Error', 'No Records Available for Previous Day');
        }
    }
    public function Selected_Date($date)
    {
        $total = 0;
        $n = 1;
        $total_selected_date_list = CreditLedger::where('Date',$date)->get();
        $selected_date_list = CreditLedger::where('Date',$date)->paginate(5);
        $selected_day = CreditLedger::where('Date',$date)->count();
        if($selected_day>0)
        {

            $credit_source = CreditSource::all();
            $payment_mode = PaymentMode::all();
            foreach ($total_selected_date_list as $key)
            {
                {
                    $total += $key['Amount'];
                }

            }
            $sl_no = CreditLedger::where('date',$selected_date_list)->count();

            $percentage = ($total*100)/1500;

            return view('DigitalLedger.CreditLedger.credit_entry' ,['creditdata'=>$selected_date_list ,'total'=>$total,'date'=>$date, 'sl_no'=>$sl_no, 'n'=>$n, 'credit_source'=>$credit_source, 'payment_mode'=>$payment_mode, 'percentage'=>$percentage ]);
        }
        else
        {
            return redirect('credit_entry')->with('Error', 'No Records Available for Selected Day i.e'.$date);
        }
    }
    public function delete($transaction_id)
    {
       DB::delete('delete from credit_ledger where Id = ?',[$transaction_id]);
        return redirect('credit_entry');

    }

 public function View($id)
    {
        $n = 1;
        $total = 0;
        $today = date("Y-m-d");
        $todays_list = CreditLedger::where('Date',$today)->paginate(10);
        foreach ($todays_list as $key)
        {
            {
                $total += $key['Amount'];
            }

        }
        $credit_source = CreditSource::all();
        $sl_no = CreditLedger::where('Date',$today)->count();
        $percentage = ($total*100)/1000;
        $payment_mode = PaymentMode::all();
        $view_credit_info = DB::table('credit_ledger')->where('id', $id)->get();
        return view('DigitalLedger.CreditLedger.view_credit_entry',['view_credit_info'=>$view_credit_info ,'id'=>$id,'total'=>$total , 'sl_no'=>$sl_no, 'n'=>$n, 'payment_mode'=>$payment_mode, 'percentage'=>$percentage, 'credit_source'=>$credit_source ]);
    }

// Function to Update The Data In Credit Ledger

    public function Update(Request $request, $id)
    {
        $today = date("Y-m-d");
        $desc = "Received Rs. ".$request->Amount."/- From  ".$request->Description . " for ". $request->Particular.", on ".$today." by  ". $request->Payment_mode;
        if(!empty($this->Attachment)){

        }
        $validate_rules = ['Particular'=>'required','Date'=>'required','Amount'=>'required','Description'=>'required','Payment_mode'=>'required'];
        $validation = Validator::make($request->all(), $validate_rules);
        if($validation->fails())
        {
            return redirect('/view_credit_entry/'.$id)->withInput()->withErrors($validation);
        }
        else
        {

                DB::update('update credit_ledger set Source = ?,Date=?,Amount=?,Description=?,Payment_Mode=? where Id = ?',[$validate['Particular'],$validate['Date'],$validate['Amount'],$validate['Description'],$validate['Payment_mode'],$id]);

                return redirect('credit_entry')->with('SuccessUpdate', 'Credit Entry Data Updated Successfully');
   }



}
}
