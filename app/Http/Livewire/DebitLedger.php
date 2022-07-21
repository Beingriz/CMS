<?php

namespace App\Http\Livewire;

use App\Models\Debit;
use App\Models\DebitSource;
use App\Models\DebitSources;
use App\Traits\RightInsightTrait;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use phpDocumentor\Reflection\Types\Null_;

class DebitLedger extends Component
{
    use RightInsightTrait;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    public $transaction_id = 'Debit';
    public $ParticularSelected = NULL, $Category='Expenses';
    public $Sources = NULL,$Source= NULL;
    public $SelectedSources  = NULL;
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
    public $SourceFormDisplay=0,$DebitFormDisplay=1;


    public $Name,$Category_Type,$Type, $Budget,$UpdateId;

    protected  $DSList = [];
    public $paginate = 10;
    public $Select_Date = NULL;
    public $filterby ="";
    public $Checked =[];
    public $FilterChecked =[];
    public $Single;
    public $collection = [];
    public $bal_id = NULL;
    public $UpdateButton = 0;


    protected $rules = [
        'Sources' =>'required',
        'Date' =>'required',
        'Total_Amount' =>'required',
        'Description' =>'required',
        'Category' =>'required',
        'Name' =>'required',
        'Budget' =>'required',
    ];
    protected $messages = [
        'Sources.required' =>'Please Select the Debit Source.',
        'Date.required' =>'Date Field Cannot be empty.',
        'Total_Amount.required' =>'Please Enter the Total Amount.',
        'Description.required' =>'Please Enter the Proper Description.',
        'Payment_Mode.required' =>'Please SelectPayment Method. ',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function mount()
    {
        $this->transaction_id = 'DE'.time();
        $this->Date = date("Y-m-d");
        $this->Total = 0;
        $this->Quantity = 1;
        $this->Total_Amount = 0;
    }
    public function DebitEntry()
    {
        $this->validate(['Amount_Paid' => 'required | numeric']);
        $this->Balance = ($this->Total_Amount - $this->Amount_Paid);
        $CategoryName = DebitSource::Wherekey($this->ParticularSelected)->get();
            foreach($CategoryName as $key)
            {
                $CategoryName = $key['Name'];
            }
            if(!is_Null($this->Attachment))
            {
                $Attachment = 'storage/app/'. $this->Attachment->storeAs('Payments/Attachment/Debit Ledger', 'DE'.time().'.jpeg');
            }
            else
            {
                $Attachment = 'storage/app/Payments/Attachment/jpeg';
            }
        if($this->Balance>0)
        {
            $Desc = "Spent Rs. ".$this->Amount_Paid."/- For  ".$this->Description." for ".$CategoryName.','.$this->SelectedSources. " , on ".$this->Date." by  ". $this->Payment_Mode.", Total: ".$this->Total_Amount.", Paid: ".$this->Amount_Paid.", Balance: ".$this->Balance;


            $debitentry  = new Debit();
            $debitentry->Id = 'DE'.time();
            $debitentry->Client_Id = 'EX'.time();
            $debitentry->Date = $this->Date;
            $debitentry->Category = $this->Category;
            $debitentry->Source = $CategoryName;
            $debitentry->Name = $this->SelectedSources;
            $debitentry->Total_Amount = $this->Total_Amount;
            $debitentry->Amount_Paid =$this->Amount_Paid;
            $debitentry->Balance = $this->Balance;
            $debitentry->Description =$Desc;
            $debitentry->Payment_Mode = $this->Payment_Mode;
            $debitentry->Attachment =$Attachment;
            $debitentry->save();//Debit Ledger Entry


            // $save_balance = new BalanceLedger;
            // $save_balance->Id = 'WC'.time();
            // $save_balance->Client_Id = 'CE'.time();
            // $save_balance->Date = $this->Date;
            // $save_balance->Name = $this->Description;
            // $save_balance->Mobile_No = 'WC'.time();
            // $save_balance->Category = $CategoryName;
            // $save_balance->Sub_Category = $this->SelectedSources;
            // $save_balance->Total_Amount =$this->Total_Amount;
            // $save_balance->Amount_Paid = $this->Amount_Paid;
            // $save_balance->Balance = $this->Balance;
            // $save_balance->Payment_Mode =$this->Payment_Mode;
            // $save_balance->Attachment = $Attachment;
            // $save_balance->Description = $this->Description;
            // $save_balance->save(); // Balance Ledger Entry Saved

            session()->flash('SuccessMsg', 'Debit Transaction Saved Successfully!');
            return redirect('../debit_entry');
        }
        else
        {
            $Desc = "Received Rs. ".$this->Amount_Paid."/- From  ".$this->Description." for ".$CategoryName.','.$this->SelectedSources. " , on ".$this->Date." by  ". $this->Payment_Mode.", Total: ".$this->Total_Amount.", Paid: ".$this->Amount_Paid.", Balance: ".$this->Balance;
            $debitentry  = new Debit();
            $debitentry->Id = 'DE'.time();
            $debitentry->Client_Id = 'EX'.time();
            $debitentry->Date = $this->Date;
            $debitentry->Category = $this->Category;
            $debitentry->Source = $CategoryName;
            $debitentry->Name = $this->SelectedSources;
            $debitentry->Total_Amount = $this->Total_Amount;
            $debitentry->Amount_Paid =$this->Amount_Paid;
            $debitentry->Balance = $this->Balance;
            $debitentry->Description =$Desc;
            $debitentry->Payment_Mode = $this->Payment_Mode;
            $debitentry->Attachment =$Attachment;
            $debitentry->save();//Debit Ledger Entry
            session()->flash('SuccessMsg', 'Debit Entry Saved Successfully!');
            return redirect('../debit_entry');
        }
     }

    public function OpenSourceForm($ans)
    {
        if($ans == 'Source')
        {
            $this->SourceFormDisplay = 1;
            $this->DebitFormDisplay = 0;
            $this->Name = NULL;
            $this->ParticularSelected = NULL;
            $this->Category_Type = '';
            $this->Type = 'Debit Source';
       }
       elseif($ans = 'Particular')
       {
            $this->Type = 'Particular';

            $this->SourceFormDisplay = 1;
            $this->DebitFormDisplay = 0;
            $this->Name = NULL;
            $this->ParticularSelected = NULL;
            $this->Category_Type = '';

       }

    }
    public function CloseSourceForm($ans)
    {
        if($ans == 'No')
        {
            $this->SourceFormDisplay = 0;
            $this->DebitFormDisplay = 1;
            $this->Name = NULL;
            $this->ParticularSelected = NULL;
            $this->Category_Type = '';
            $this->Type = NULL;
            $this->UpdateButton = 0;
            $this->UpdateId=NULL;
        }
    }
    public function SaveSource()
    {
        if($this->Type == 'Debit Source')
        {
            $this->validate(['Name' => 'required | unique:debit_source', 'Category_Type'=>'required']);
            $time = substr(time() , 6 ,8 );
            $source = new DebitSource();
            $source->Id = 'DS'.$time;
            $source->Name = $this->Name;
            $source->Category = $this->Category_Type;
            $source->Thumbnail = 'Not Available';
            $source->save();
            session()->flash('SuccessMsg', 'Debit Source Saved Successfully!');
            $this->Name = NULL;
            $this->Category_Type = '';

        }
        elseif($this->Type == 'Particular')
        {
            $this->validate(['Name' => 'required | unique:debit_sources', 'Category_Type'=>'required']);
            $name = DebitSource::where('Id','=',$this->ParticularSelected)->get();
            foreach($name as $key)
            {
                $Name = $key['Name'];
            }
            $time = substr(time() , 6 ,8 );
            $source = new DebitSources();
            $source->Id = 'DP'.$time;
            $source->DS_Id = $this->ParticularSelected; // Returns DS ID
            $source->DS_Name = $Name;
            $source->Name = $this->Name;
            $source->Total = $this->Budget;
            $source->save();
            session()->flash('SuccessMsg', 'Debit Particular Added to '.$Name. ' Successfully!');
            $this->Name = NULL;
            $this->Category_Type = '';
        }
    }
    public function Edit($Id)
    {
        if($this->Type == 'Debit Source')
        {
            $this->UpdateId = $Id;
            $this->UpdateButton = 1;
            $data = DebitSource::where('Id','=',$Id)->get();
            foreach($data as $key)
            {
                $this->Category_Type = $key['Category'];
                $this->Name =$key['Name'];
            }
        }
        elseif($this->Type == 'Particular')
        {
            $this->UpdateId = $Id;
            $this->UpdateButton = 1;
            $data = DebitSources::where('Id','=',$Id)->get();
            foreach($data as $key)
            {
                $this->Name =$key['Name'];
                $this->Budget = $key['Total'];
            }
        }

    }
    public function ChangeSource($val)
    {
        if($this->Type == 'Debit Source')
        {
            $this->UpdateId=Null;
            $this->UpdateButton =0;
            $this->Name=Null;
            $this->Category_Type ='';
            $this->Total=Null;
        }
        elseif($this->Type== 'Particular')
        {
            $this->UpdateId=Null;
            $this->UpdateButton =0;
            $this->Name=Null;
            $this->Category_Type ='';
        }
    }
    public function UpdateSource($Id)
    {
        if($this->Type == 'Debit Source')
        {
            $data = array();
        }
        elseif($this->Type == 'Particular')
        {
            dd($Id);
        }
    }

    public function Delete($Id)
    {
        if($this->Type == 'Debit Source')
        {
            $sources = DebitSources::where('DS_Id','=',$Id)->get();
            if(count($sources)>=1)
            {
                $delete = DebitSources::Where('DS_Id', '=',$Id)->get();
                foreach($sources as $key)
                {
                    DebitSources::Where('DS_Id', '=',$Id)->delete();
                }
                DebitSource::Where('Id','=',$Id)->delete();
                session()->flash('SuccessMsg', 'Debit Source & '.count($delete).' Particulars Deleted Successfully!');
            }
            else
            {
                $delete = DebitSource::Where('Id', '=',$Id)->get();
                DebitSource::Where('Id', '=',$Id)->delete();
                session()->flash('Error', ''.count($delete).' Debit Source  Deleted Successfully!');
            }
        }
        elseif($this->Type== 'Particular')
        {
            $delete = DebitSources::Where('Id', '=',$Id)->get();
            DebitSources::Where('Id', '=',$Id)->delete();
            session()->flash('Error', ''.count($delete).' Particulars Deleted Successfully!');
        }
    }








































































































    public function render()
    {
        if(!is_null($this->Select_Date))
        {
            $todays_list = Debit::where('Date',$this->Select_Date)->filter(trim($this->filterby))->paginate($this->paginate);
            $sl_no = $todays_list->total();
            if(sizeof($todays_list)==0)
            {
                session()->flash('Error','Sorry!! No Record Available for '.$this->Select_Date);
            }
        }
        else
        {
            $todays_list = Debit::where('Date',$this->today)->filter(trim($this->filterby))->paginate($this->paginate);
            $sl_no = $todays_list->total();
        }
        // To Fetch Debit Source / Particular based on Category Selected
        if(!is_null($this->Category))
        {
            $this->Source = DebitSource::orderby('Name')->where('Category','=',$this->Category_Type)->get();
        }
        // To Fetch Sources based on Selected Debit Source
        if(!is_null($this->ParticularSelected))
        {
            $this->Sources = DebitSources::orderby('Name')->where('DS_Id',$this->ParticularSelected)->get();
        }

        $Unit_Price = 0;
        if(!empty($this->ParticularSelected))
        {
            if(!empty($this->SelectedSources))
            {
                $this->Unit_Price = DebitSources::where('Name','=',$this->SelectedSources)->get();
                foreach($this->Unit_Price as $unit)
                {
                    $Unit_Price += $unit['Outstanding'];
                }
            }
        }
        $this->Unit_Price = $Unit_Price;
        $this->Total_Amount = ( intval($Unit_Price)* intval($this->Quantity));
        // Credit Insight Code
        $name = Debit::Where('Name',$this->ParticularSelected)->get();
        $prev_earning = Debit::Where([['Date','=', $this->previous_day],['Name','=',$this->ParticularSelected]])->paginate($this->paginate);
        $total_prev_earnings = 0;
        $source_total=0;
        $today_total=0;
        foreach($name as $key)
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
        $debit_source = DebitSource::all();
        if($this->Type == 'Debit Source')
        {
            $this->DSList = DebitSource::Paginate(5);
        }
        elseif($this->Type == 'Particular')
        {
            $this->DSList = DebitSources::Where('DS_Id',$this->ParticularSelected)->Paginate(10);
        }

        return view('livewire.debit-ledger',[
            'source'=>$this->Source,'debit_source'=>$debit_source,'debit_sources'=>$this->Sources,
            'payment_mode'=>$this->payment_mode,'DSList'=>$this->DSList,
            'total_revenue'=>$this->sum,
            'previous_revenue'=>$this->previous_revenue,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'today'=>$this->today, 'total'=>$today_total, 'percentage'=>$percentage,'creditdata'=>$todays_list,
            'sl_no'=>$sl_no,'n'=>$this->n,'source_total'=>$source_total,'contribution'=>$contribution,
            'prev_earning'=>$total_prev_earnings,'Total' =>$this->Total_Amount,'Total_Amount'=>$this->Total_Amount,
        ]);
    }
}
