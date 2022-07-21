<?php

namespace App\Http\Livewire;

use App\Models\BalanceLedger;
use App\Models\CreditLedger;
use App\Models\CreditSource;
use App\Models\CreditSources;
use App\Traits\RightInsightTrait;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Credit extends Component
{
    use RightInsightTrait;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    public $transaction_id = 'Credit';
    public $SourceSelected = NULL;
    public $Sources = NULL;
    public $SelectedSources = NULL;
    public $Date;
    public $Unit_Price;
    public $Quantity;
    public $Total_Amount = NULL;
    public $Amount_Paid;
    public $Balance;
    public $Description= 'Walk in Customer';
    public $Payment_Mode = 'Cash';
    public $Attachment ,$itteration;
    public $Old_Attachment,$New_Attachment;

    public $paginate = 10;
    public $Select_Date = NULL;
    public $filterby ="";
    public $Checked =[];
    public $FilterChecked =[];
    public $Single;
    public $collection = [];
    public $bal_id = NULL;
    public $update = 0;


    protected $rules = [
        'Sources' =>'required',
        'Date' =>'required',
        'Total_Amount' =>'required',
        'Amount_Paid' =>'required',
        'Description' =>'required',
        'Payment_Mode' =>'required',
    ];
    protected $messages = [
        'Sources.required' =>'Please Select the Credit Source.',
        'Date.required' =>'Date Field Cannot be empty.',
        'Total_Amount.required' =>'Please Enter the Total Amount.',
        'Amount_Paid.required' =>'Please Enter the Amount Received.',
        'Description.required' =>'Please Enter the Proper Description.',
        'Payment_Mode.required' =>'Please SelectPayment Method. ',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->transaction_id = 'CE'.time();
        $this->Date = date("Y-m-d");
        $this->Total = 0;
        $this->Quantity = 1;
        $this->Total_Amount = 0;
    }
    public function CreditEntry()
    {
        $this->validate();
        $this->Balance = ($this->Total_Amount - $this->Amount_Paid);
        $CategoryName = CreditSource::Wherekey($this->SourceSelected)->get();
            foreach($CategoryName as $key)
            {
                $CategoryName = $key['Name'];
            }
            if(!is_Null($this->Attachment))
            {
                $Attachment = 'storage/app/'. $this->Attachment->storeAs('Payments/Attachment/Credit Ledger', 'CE'.time().'.jpeg');
            }
            else
            {
                $Attachment = 'storage/app/Payments/Attachment/jpeg';
            }
        if($this->Balance>0)
        {
            $Desc = "Received Rs. ".$this->Amount_Paid."/- From  ".$this->Description." for ".$CategoryName.','.$this->SelectedSources. " , on ".$this->Date." by  ". $this->Payment_Mode.", Total: ".$this->Total_Amount.", Paid: ".$this->Amount_Paid.", Balance: ".$this->Balance;


            $creditentry  = new CreditLedger;
            $creditentry->Id = 'CE'.time();
            $creditentry->Client_Id = 'WC'.time();
            $creditentry->Date = $this->Date;
            $creditentry->Category = $CategoryName;
            $creditentry->Sub_Category = $this->SelectedSources;
            $creditentry->Total_Amount = $this->Total_Amount;
            $creditentry->Amount_Paid =$this->Amount_Paid;
            $creditentry->Balance = $this->Balance;
            $creditentry->Description =$Desc;
            $creditentry->Payment_Mode = $this->Payment_Mode;
            $creditentry->Attachment =$Attachment;
            $creditentry->save();//Credit Ledger Entry


            $save_balance = new BalanceLedger;
            $save_balance->Id = 'WC'.time();
            $save_balance->Client_Id = 'CE'.time();
            $save_balance->Date = $this->Date;
            $save_balance->Name = $this->Description;
            $save_balance->Mobile_No = 'WC'.time();
            $save_balance->Category = $CategoryName;
            $save_balance->Sub_Category = $this->SelectedSources;
            $save_balance->Total_Amount =$this->Total_Amount;
            $save_balance->Amount_Paid = $this->Amount_Paid;
            $save_balance->Balance = $this->Balance;
            $save_balance->Payment_Mode =$this->Payment_Mode;
            $save_balance->Attachment = $Attachment;
            $save_balance->Description = $this->Description;
            $save_balance->save(); // Balance Ledger Entry Saved

            session()->flash('SuccessMsg', 'Credit Entry Saved Successfully!, Balance Ledger Updated');
            return redirect('../credit_entry');
        }
        else
        {
            $Desc = "Received Rs. ".$this->Amount_Paid."/- From  ".$this->Description." for ".$CategoryName.','.$this->SelectedSources. " , on ".$this->Date." by  ". $this->Payment_Mode.", Total: ".$this->Total_Amount.", Paid: ".$this->Amount_Paid.", Balance: ".$this->Balance;
            $creditentry  = new CreditLedger;
            $creditentry->Id = 'CE'.time();
            $creditentry->Client_Id = 'WC'.time();
            $creditentry->Date = $this->Date;
            $creditentry->Category = $CategoryName;
            $creditentry->Sub_Category = $this->SelectedSources;
            $creditentry->Total_Amount = $this->Total_Amount;
            $creditentry->Amount_Paid =$this->Amount_Paid;
            $creditentry->Balance = $this->Balance;
            $creditentry->Description =$Desc;
            $creditentry->Payment_Mode = $this->Payment_Mode;
            $creditentry->Attachment = $Attachment;
            $creditentry->save();//Credit Ledger Entry
            session()->flash('SuccessMsg', 'Credit Entry Saved Successfully!');
            return redirect('../credit_entry');
        }
     }
     public function Edit($Id)
     {
         $this->update = 1;
        $fetch = CreditLedger::Where('Id',$Id)->get();

        foreach($fetch as $key)
        {
            $this->transaction_id = $key['Id'];
            $CategoryName = $key['Category'];
            $this->SelectedSources = $key['Sub_Category'];
            $this->Date = $key['Date'];
            $this->Total_Amount = $key['Total_Amount'];
            $this->Amount_Paid = $key['Amount_Paid'];
            $this->Balance = $key['Balance'];
            $this->Description = $this->Description;
            $this->Payment_Mode = $key['Payment_Mode'];
            $this->Old_Attachment = $key['Attachment'];
        }
        $CategoryName = CreditSource::Where('Name',$CategoryName)->get();
        foreach($CategoryName as $CS_Id)
        {
            $this->SourceSelected = $CS_Id['Id'];
        }


     }
     public function ResetFields()
     {
        $this->Total_Amount =NULL;
        $this->Quantity = 0;
        $this->Amount_Paid =NULL;
        $this->Balance =NULL;
        $this->Description = $this->Description;
        $this->Payment_Mode =NULL;
        $this->Old_Attachment =NULL;
        $this->Attachment =NULL;
        $this->itteration++;
     }
     public function Change($val)
     {
        $this->Attachment = Null;
        $this->itteration++;
     }
     public function Update($Id)
     {
        $CategoryName = CreditSource::Wherekey($this->SourceSelected)->get();
        foreach($CategoryName as $key)
        {
            $CategoryName = $key['Name'];
        }
        $Desc = "Received Rs. ".$this->Amount_Paid."/- From  ".$this->Description." for ".$CategoryName.','.$this->SelectedSources. " , on ".$this->Date." by  ". $this->Payment_Mode.", Total: ".$this->Total_Amount.", Paid: ".$this->Amount_Paid.", Balance: ".$this->Balance;


        if(!is_Null($this->Attachment))
        {
            if(!is_Null($this->Old_Attachment))
            {
                $Attachment = str_replace('storage/app/', '',$this->Old_Attachment);
                if(Storage::exists($Attachment))
                {
                    unlink(storage_path('app/'.$Attachment));
                    $this->New_Attachment = 'storage/app/'. $this->Attachment->storeAs('Payments/Attachment/Credit Ledger', 'CE'.time().'.jpeg');
                }
                else
                {
                    $this->New_Attachment = 'storage/app/'. $this->Attachment->storeAs('Payments/Attachment/Credit Ledger', 'CE'.time().'.jpeg');
                }
            }
            else
            {
                if($this->Payment_Mode!='Cash')
                {
                    $this->validate([
                        'Attachment'=>'required|image',
                    ]);
                }
            }
        }
        else
        {
            if(!is_Null($this->Old_Attachment))
            {
                $Attachment = str_replace('storage/app/', '',$this->Old_Attachment);
                if(Storage::exists($Attachment))
                {
                    $this->New_Attachment = $this->Old_Attachment;
                }
                else
                {
                    session()->flash('Error','File Does not Exist. Please Select New Attchment');
                    if($this->Payment_Mode!='Cash')
                    {
                        $this->validate([
                            'Attachment'=>'required|image',
                        ]);
                    }
                }
            }
            else
            {
                if($this->Payment_Mode!='Cash')
                {
                    $this->validate([
                        'Attachment'=>'required|image',
                    ]);
                }
        }

        $update = DB::update('update credit_ledger set Date = ?, Category = ?, Sub_Category = ?, Total_Amount = ?, Amount_Paid = ?, Balance = ?, Description = ?, Payment_Mode = ? , Attachment = ? where Id = ?', [$this->Date,$CategoryName,$this->SelectedSources, $this->Total_Amount, $this->Amount_Paid, $this->Balance, $Desc, $this->Payment_Mode, $this->New_Attachment, $Id]);
        if($update)
        {
            session()->flash('SuccessMsg', 'Credit Ledger Updated Successfully.');
            $this->update = 0;
        }
     }
     }
     public function Delete($Id)
     {
        $check_bal = BalanceLedger::Where('Client_Id', $Id)->get();
        if(sizeof($check_bal)>0)
        {
            $total_bal=0;
            foreach ($check_bal as $bal_count)
            {
                $total_bal = $bal_count['Balance'];
            }
            if($total_bal>0)
            {
                session()->flash('Error', 'The Selected Entery has balance Due Please Clear Due of '. $total_bal. ' for ID: '.$Id);
            }
            else
            {
                $credit = CreditLedger::wherekey($Id)->delete();
                $balance = BalanceLedger::wherekey($Id)->delete();
                if($credit && $balance)
                {
                    session()->flash('SuccessMsg', 'Record Deleted Successfully!! '.$Id);
                }
                else
                {
                    session()->flash('Error', 'Unable to Delete the Record! Please retry... '.$Id);
                }
            }
        }
        else
        {
            $credit = CreditLedger::wherekey($Id)->delete();
            if($credit)
                {
                    session()->flash('SuccessMsg', 'Record Deleted Successfully!! '.$Id);
                }
                else
                {
                    session()->flash('Error', 'Unable to Delete the Record! Please retry... '.$Id);
                }
        }

     }
     public function MultipleDelete()
     {

        $check_bal = BalanceLedger::WhereIn('Client_Id',$this->Checked)->get();
        if(sizeof($check_bal)>0)
        {
            $temp = collect([]);
            foreach($check_bal as $get_id )
            {
                $bal = 0;
                $bal_ids = $get_id['Client_Id'];
                $bal_id = $get_id['Id'];
                $desc = $get_id['Description'];
                $tot= $get_id['Total_Amount'];
                $paid = $get_id['Amount_Paid'];
                $bal += $get_id['Balance'];
                if($bal>0)
                {
                    $temp->push(['Id'=>$bal_ids,'Description'=>$desc, 'Total_Amount'=>$tot, 'Amount_Paid'=>$paid, 'Balance'=>$bal]);
                    $this->FilterChecked = [];
                    foreach ($temp as $key)
                    {
                        $id = $key['Id'];
                        array_push($this->FilterChecked, $id);
                    }
                }
            }
            $this->collection = $temp;
            $Checked= array_diff($this->Checked, $this->FilterChecked);
            $del_credit = CreditLedger::wherekey($Checked)->delete();
            if($del_credit)
            {
                session()->flash('SuccessMsg', count($Checked).' Records Deleted Successfully..');
            }
            else
            {
                session()->flash('Error', ' Records Unable to Delete..');
            }
        }
        else
        {
            $check_bal = CreditLedger::WhereIn('Id',$this->Checked)->get();

            $del_credit = CreditLedger::Wherekey($this->Checked)->delete();
            if($del_credit)
            {
                session()->flash('SuccessMsg', count($this->Checked).' Records Deleted Successfully..');
            }
            else
            {
                session()->flash('Error', count($del_credit).' Records Unable to Delete..');
            }

        }

     }

    public function UpdateBalance($Id)
    {
        $fetch = BalanceLedger::where('Id',$Id)->get();
        $amount = 0;
        foreach ($fetch as $key)
        {
            $amount = $key['Balance'];
        }
        $update_bal = DB::table('balance_ledger')->where('Client_Id',$Id)->update(['Balance'=>0]);
        $update_credit = DB::table('credit_ledger')->where('Id',$Id)->update(['Balance'=>0]);
        if($update_bal && $update_credit)
        {
           session()->flash('SuccessMsg', 'Balance Due of Rupees '.$amount. ' is Cleared'.$Id);
        }
        else
        {
            session()->flash('Error', 'unable to update');

        }
    }
    public function render()
    {
        if(!is_null($this->Select_Date))
        {
            $todays_list = CreditLedger::where('Date',$this->Select_Date)->filter(trim($this->filterby))->paginate($this->paginate);
            $sl_no = $todays_list->total();
            if(sizeof($todays_list)==0)
            {
                session()->flash('Error','Sorry!! No Record Available for '.$this->Select_Date);
            }
        }
        else
        {
            $todays_list = CreditLedger::where('Date',$this->today)->filter(trim($this->filterby))->paginate($this->paginate);
            $sl_no = $todays_list->total();
        }

        if(!is_null($this->SourceSelected))
        {
            $this->Sources = CreditSources::orderby('Source')->where('CS_Id',$this->SourceSelected)->get();
        }



        $Unit_Price = 0;
        if(!empty($this->SourceSelected))
        {
            if(!empty($this->SelectedSources))
            {
                $this->Unit_Price = CreditSources::where('Source','=',$this->SelectedSources)->get();
                foreach($this->Unit_Price as $unit)
                {
                    $Unit_Price += $unit['Unit_Price'];
                }
            }
        }
        $this->Unit_Price = $Unit_Price;
        $this->Total_Amount = ( intval($Unit_Price)* intval($this->Quantity));


        // Credit Insight Code
        $source = CreditLedger::Where('Sub_Category',$this->SelectedSources)->get();
        $prev_earning = CreditLedger::Where([['Date','=', $this->previous_day],['Sub_Category','=',$this->SelectedSources]])->paginate($this->paginate);
        $total_prev_earnings = 0;
        $source_total=0;
        $today_total=0;
        foreach($source as $key)
        {
            $source_total += $key['Amount_Paid'];
        }
        foreach($todays_list as $key)
        {
            $today_total += $key['Amount_Paid'];
        }
        foreach($prev_earning as $key)
        {
            $total_prev_earnings += $key['Amount_Paid'];
        }
        $total_revenue = $this->sum;

        $contribution =  (($source_total*100)/$total_revenue);
        $contribution = number_format($contribution, 2,);


        $percentage = number_format(($today_total/1500)*100) ;
        return view('livewire.credit',[
            'credit_source'=>$this->credit_source,'credit_sources'=>$this->Sources,
            'payment_mode'=>$this->payment_mode,
            'total_revenue'=>$this->sum,
            'previous_revenue'=>$this->previous_revenue,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'today'=>$this->today, 'total'=>$today_total, 'percentage'=>$percentage,'creditdata'=>$todays_list,
            'sl_no'=>$sl_no,'n'=>$this->n,'source_total'=>$source_total,'contribution'=>$contribution,
            'prev_earning'=>$total_prev_earnings,'Total' =>$this->Total_Amount,'Total_Amount'=>$this->Total_Amount,'Unit_Price'=>$Unit_Price,
        ]);
    }
}
