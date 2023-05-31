<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\DebitSource;
use App\Models\Debit;
use App\Models\PaymentMode;
use App\Traits\RightInsightTrait;

class DebitEntryController extends Controller
{
 use RightInsightTrait;
   public function Home()
    {
        $EditData='';$DeleteData='';
        return view('DigitalLedger.DebitLedger.debit_entry' ,['EditData'=>$EditData,'DeleteData'=>$DeleteData]);
    }
   public function EditDebit($Id)
    {
        $EditData=$Id;$DeleteData='';
        return view('DigitalLedger.DebitLedger.debit_entry' ,['EditData'=>$EditData,'DeleteData'=>$DeleteData]);
    }
   public function DeleteDebit($Id)
    {
        $EditData='';$DeleteData=$Id;
        return view('DigitalLedger.DebitLedger.debit_entry' ,['EditData'=>$EditData,'DeleteData'=>$DeleteData]);
    }

// Finction to save the Entry
      public function save(Request $request)
    {   $today = date("d-m-Y");
        $year = date("Y");
        $transaction_id = $year ."Debit".mt_rand(100000, 999999);
        $desc = $request->Amount."/- Spent on  ".$request->Description . " for ". $request->Particular.", on ".$today." by  ". $request->Payment_mode;
        $this->validate($request,
            ['Particular'=>'required','Date'=>'required','Amount'=>'required','Description'=>'required','Payment_mode'=>'required']);
        $debitentry  = new Debit;
        $debitentry->Id= $transaction_id;
        $debitentry->Source = $request->Particular;
        $debitentry->Date = $request->Date;
        $debitentry->Amount = $request->Amount;
        $debitentry->Description = $desc;
        $debitentry->Payment_Mode = $request->Payment_mode;
        $debitentry->save();
        return redirect('debit_entry')->with('SuccessMsg', 'Debit Entry Saved Successfully');


    }
// Function to count the Daily Total
    public function Daily_Count()
    {   $total = 0;
        $n = 1;
        $today = date("Y-m-d");
        $total_list_data = Debit::where('Date',$today)->get();
        $list_data = Debit::where('Date',$today)->paginate(5);
        $debit_source = DebitSource::all();
        $payment_mode = PaymentMode::all();
        foreach ($total_list_data as $key)
        {
            {
                $total += $key['Amount'];
            }

        }
        $percentage = ($total*100)/1000;
        $sl_no = Debit::where('date',$today)->count();
        return view('DigitalLedger.DebitLedger.debit_entry' , ['list_data'=>$list_data ,'total'=>$total , 'sl_no'=>$sl_no, 'n'=>$n, 'debit_source'=>$debit_source, 'date'=>$today,'payment_mode'=>$payment_mode, 'percentage'=>$percentage,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'today'=>$this->today, ]);

    }
    public function Previous()
    {   $total = 0;
        $n = 1;
        $date= date("Y-m-d");
        $previous = date('Y-m-d', strtotime($date. ' - 1 days'));
        $tota_Previous_list_data = Debit::where('Date',$previous)->get();
        $Previous_list_data = Debit::where('Date',$previous)->paginate(5);
        $Previous_day = Debit::where('Date',$previous)->count();
        if($Previous_day>0)
        {
        $debit_source = DebitSource::all();
        $payment_mode = PaymentMode::all();
        foreach ($tota_Previous_list_data as $key)
        {
            {
                $total += $key['Amount'];
            }

        }
        $percentage = ($total*100)/1000;
        $sl_no = Debit::where('date',$previous)->count();

        return view('DigitalLedger.DebitLedger.debit_entry' , ['list_data'=>$Previous_list_data ,'total'=>$total ,  'date'=>$previous,'sl_no'=>$sl_no, 'n'=>$n, 'debit_source'=>$debit_source, 'payment_mode'=>$payment_mode, 'percentage'=>$percentage  ]);
        }
        else
        {
            return redirect('debit_entry')->with('Error', 'No Records Available for Previous Day');
        }

    }
    public function Selected_Date($date)
    {   $total = 0;
        $n = 1;
        $total_Selected_date_list = Debit::where('Date',$date)->get();
        $Selected_date_list = Debit::where('Date',$date)->paginate(5);
        $Selected_day = Debit::where('Date',$date)->count();
        if($Selected_day>0)
        {
        $debit_source = DebitSource::all();
        $payment_mode = PaymentMode::all();
        foreach ($total_Selected_date_list as $key)
        {
            {
                $total += $key['Amount'];
            }

        }
        $percentage = ($total*100)/1000;
        $sl_no = Debit::where('date',$date)->count();

        return view('DigitalLedger.DebitLedger.debit_entry' , ['list_data'=>$Selected_date_list ,'total'=>$total , 'sl_no'=>$sl_no, 'n'=>$n, 'debit_source'=>$debit_source,'date'=>$date, 'payment_mode'=>$payment_mode, 'percentage'=>$percentage  ]);
    }
    else
        {
            return redirect('debit_entry')->with('Error', 'No Records Available for Selected Day i.e'.$date);
        }

    }
// Function to View Debit Entry Details

    public function View($transaction_id)
        {
            $n = 1;
            $total = 0;
            $today = date("Y-m-d");
            $data = Debit::where('Date',$today)->get();
            foreach ($data as $key)
            {
                {
                    $total += $key['Amount'];
                }

            }
            $debit_source = DebitSource::all();
            $sl_no = Debit::where('Date',$today)->count();
            $percentage = ($total*100)/1000;
            $payment_mode = PaymentMode::all();

            $view_debit_info = DB::table('debit_ledger')->where('Id', $transaction_id)->get();
            return view('DigitalLedger.DebitLedger.view_debit_entry',
            ['view_debit_info'=>$view_debit_info, 'Id'=>$transaction_id, 'total'=>$total, 'sl_no'=>$sl_no, 'n'=>$n, 'payment_mode'=>$payment_mode, 'percentage'=>$percentage, 'debit_source'=>$debit_source ]);

        }

//  Function to Update the Data in Debit Ledger

    public function UpdateDebit(Request $request, $id)
    {
        $today = date("Y-m-d");
        $desc = $request->Amount."/- Spent on  ".$request->Description . " for ". $request->Particular.", on ".$today." by  ". $request->Payment_mode;
        $validate = $request->input();
        $validate_rules = ['Particular'=>'required','Date'=>'required','Amount'=>'required','Description'=>'required','Payment_mode'=>'required'];
        $validation = Validator::make($request->all(), $validate_rules);
        if($validation->fails())
        {
            return redirect('/view_debit_entry/'.$transaction_id)->withInput()->withErrors($validation);
        }
        else
        {
            try
            {
                DB::update('update debit_ledger set Source=?,Date=?,Amount=?,Description=?,Payment_Mode=? where Id=?',[$validate['Particular'],$validate['Date'],$validate['Amount'],$validate['Description'],$validate['Payment_mode'],$id]);
                return redirect('debit_entry')->with('SuccessUpdate', 'Debit Entry Data Updated Successfully');
            }
            catch (Exception $e)
            {
                return reditrect('debit_entry')->with('FailMessage' ,$e);
            }
        }
        // return "this is update fucntion for ID".$transaction_id;
    }


// Function to delete the transactopm
    public function delete($transaction_id)
    {
       DB::delete('delete from debit_ledger where Id = ?',[$transaction_id]);
         return redirect('debit_entry');

    }
}
