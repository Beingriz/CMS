<?php

namespace App\Http\Livewire\AdminModule\Ledger\Debit;

use App\Models\BalanceLedger;
use App\Models\Debit;
use App\Models\DebitSource;
use App\Models\DebitSources;
use App\Models\PaymentMode;
use App\Traits\RightInsightTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
    public $Category, $SubCategory, $Particular;
    public $Date, $Name, $Source;
    public $Unit_Price;
    public $Quantity;
    public $Total_Amount = NULL;
    public $Amount_Paid;
    public $Balance;
    public $Description;
    public $Payment_Mode = 'Cash';
    public $Attachment, $itteration;
    public $Old_Attachment, $New_Attachment, $balamount, $balId, $balCollection;

    public $total;
    protected  $DSList = [];
    public $paginate = 10;
    public $Select_Date = NULL;
    public $filterby = "";
    public $Checked = [];
    public $FilterChecked = [];
    public $Single;
    public $collection = [];
    public $bal_id = NULL;
    public $UpdateButton = 0;
    public $update = false;
    public $clearButton = false, $lastRecTime;




    protected $rules = [
        'Category' => 'required',
        'SubCategory' => 'required',
        'Particular' => 'required',
        'Date' => 'required',
        'Amount_Paid' => 'required',
        'Description' => 'required',
        'Quantity' => 'required',
        'Payment_Mode' => 'required',
    ];
    protected $messages = [
        'Category.required' => 'Please Select the Category.',
        'Particular.required' => 'Please Select the Category.',
        'Date.required' => 'Date Field Cannot be empty.',
        'Amount_Paid.required' => 'Please enter amount to pay',
        'Description.required' => 'Please Enter the Proper Description.',
        'Payment_Mode.required' => 'Please SelectPayment Method. ',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function mount($EditData, $DeleteData)
    {
        $this->transaction_id = 'DE' . time();
        $this->Date = date("Y-m-d");
        $this->today = date("Y-m-d");
        $this->Quantity = 1;

        if (!empty($EditData)) {
            $this->Edit($EditData);
        }
        if (!empty($DeleteData)) {
            $this->Delete($DeleteData);
        }
    }



    public function ImageUpload()
    {

        if (!empty($this->Attachment)) // Check if new image is selected
        {
            if (!empty($this->Old_Attachment)) {
                if (Storage::disk('public')->exists($this->Old_Attachment)) {
                    unlink(storage_path('app/public/' . $this->Old_Attachment));
                    $extension = $this->Thumbnail->getClientOriginalExtension();
                    $path = 'Digital Ledger/Debit Book/Attachments' . time();
                    $filename = 'BM_' . $this->Name . '_' . time() . '.' . $extension;
                    $url = $this->Thumbnail->storePubliclyAs($path, $filename, 'public');
                    $this->New_Attachment = $url;
                } else {
                    $extension = $this->Thumbnail->getClientOriginalExtension();
                    $path = 'Digital Ledger/Debit Book/Attachments' . time();
                    $filename = 'BM_' . $this->Name . '_' . time() . '.' . $extension;
                    $url = $this->Thumbnail->storePubliclyAs($path, $filename, 'public');
                    $this->New_Attachment = $url;
                }
            } else {
                if ($this->Payment_Mode != 'Cash') {
                    $this->validate([
                        'Attachment' => 'required|image',
                    ]);
                }
            }
        } else // check old is exist
        {

            if (!empty($this->Old_Attachment)) {
                if (Storage::disk('public')->exists($this->Old_Attachment)) {
                    $this->New_Attachment = $this->Old_Attachment;
                }
            } else {

                if ($this->Payment_Mode != 'Cash') {
                    $this->validate([
                        'Attachment' => 'required|image',
                    ]);
                }
            }
        }
    }
    public function deleteImage($Id)
    {
        $fetch = Debit::Where('Id', $Id)->get();
        foreach ($fetch as $key) {
            $file = $key['Attachment'];
        }
        if (!empty($file)) {
            if (Storage::disk('public')->exists($file)) {
                unlink(storage_path('app/public/' . $file));
            }
        }
    }

    public function Save()
    {
        $this->validate();
        $debitsource = DebitSources::where('Id', $this->Particular)->get();
        foreach ($debitsource as $item) {
            $this->Source = $item->DS_Name;
            $this->Name = $item->Name;
        }
        $Desc = "Spent Rs. " . $this->Amount_Paid . "/- From  " . $this->Description . " for " . $this->Source . ',' . $this->Name . " , on " . $this->Date . " by  " . $this->Payment_Mode . ", Total: " . $this->Total_Amount . ", Paid: " . $this->Amount_Paid . ", Balance: " . $this->Balance;

        if ($this->Balance > 0) {
            $this->ImageUpload();
            $save_balance = new BalanceLedger();
            $save_balance->Id = $this->transaction_id;
            $save_balance->Client_Id = $this->transaction_id;
            $save_balance->Date = $this->Date;
            $save_balance->Name = $this->Description;
            $save_balance->Mobile_No = 'Not Available';
            $save_balance->Category = $this->Source;
            $save_balance->Sub_Category = $this->Name;
            $save_balance->Total_Amount = $this->Total_Amount;
            $save_balance->Amount_Paid = $this->Amount_Paid;
            $save_balance->Balance = $this->Balance;
            $save_balance->Payment_Mode = $this->Payment_Mode;
            $save_balance->Attachment = $this->New_Attachment;
            $save_balance->Description = $this->Description;
            $save_balance->save(); // Balance Ledger Entry Saved

            $debitentry  = new Debit();
            $debitentry->Id = $this->transaction_id;
            $debitentry->Client_Id = $this->transaction_id;
            $debitentry->Date = $this->Date;
            $debitentry->Category = $this->Category;
            $debitentry->Source =  $this->Source;
            $debitentry->Name = $this->Name;
            $debitentry->Unit_Price = $this->Unit_Price;
            $debitentry->Quantity = $this->Quantity;
            $debitentry->Total_Amount = $this->Total_Amount;
            $debitentry->Amount_Paid = $this->Amount_Paid;
            $debitentry->Balance = $this->Balance;
            $debitentry->Description = $Desc;
            $debitentry->Payment_Mode = $this->Payment_Mode;
            $debitentry->Attachment = $this->New_Attachment;;
            $debitentry->save(); //Debit Ledger Entry
            $notification = array(
                'message' => 'Transaction Saved, Balance Updated!',
                'alert-type' => 'success'
            );
            return redirect()->route('Debit')->with($notification);
        } else {
            $this->ImageUpload();
            $debitentry  = new Debit();
            $debitentry->Id = 'DE' . time();
            $debitentry->Client_Id = 'EX' . time();
            $debitentry->Date = $this->Date;
            $debitentry->Category = $this->Category;
            $debitentry->Source =  $this->Source;
            $debitentry->Name = $this->Name;
            $debitentry->Unit_Price = $this->Unit_Price;
            $debitentry->Quantity = $this->Quantity;
            $debitentry->Total_Amount = $this->Total_Amount;
            $debitentry->Amount_Paid = $this->Amount_Paid;
            $debitentry->Balance = $this->Balance;
            $debitentry->Description = $Desc;
            $debitentry->Payment_Mode = $this->Payment_Mode;
            $this->ImageUpload();
            $debitentry->Attachment = $this->New_Attachment;;
            $debitentry->save(); //Debit Ledger Entry
            $notification = array(
                'message' => 'Transaction Saved!',
                'alert-type' => 'success'
            );
            return redirect()->route('Debit')->with($notification);
        }
    }

    public function Edit($Id)
    {
        $fetch = Debit::where('Id', $Id)->get();

        foreach ($fetch as $item) {
            $this->transaction_id = $item['Id'];
            $this->Date = $item['Date'];
            $this->Category = $item['Category'];
            $this->SubCategory = $item['Source'];
            $this->Unit_Price = $item['Unit_Price'];
            $this->Quantity = $item['Quantity'];
            $this->Total_Amount = $item['Total_Amount'];
            $this->Amount_Paid = $item['Amount_Paid'];
            $this->Balance = $item['Balance'];
            $this->Payment_Mode = $item['Payment_Mode'];
            $debsource = DebitSources::where('DS_Name', '=', trim($this->SubCategory))->get();
            foreach ($debsource as $item) {
                $this->SubCategory = $item['DS_Id'];
            }
        }
        $this->update = true;
    }
    public function UpdateLedger($Id)
    {


        $this->ImageUpload();
        $debitsource = DebitSources::where('Id', $this->Particular)->get();
        foreach ($debitsource as $item) {
            $this->Source = $item->DS_Name;
            $this->Name = $item->Name;
        }
        $Desc = "Spent Rs. " . $this->Amount_Paid . "/- From  " . $this->Description . " for " . $this->Source . ',' . $this->Name . " , on " . $this->Date . " by  " . $this->Payment_Mode . ", Total: " . $this->Total_Amount . ", Paid: " . $this->Amount_Paid . ", Balance: " . $this->Balance;
        $this->validate();
        if ($this->Balance > 0) {

            $data = array();
            $data['Date'] = $this->Date;
            $data['Category'] = $this->Category;
            $data['Source'] = $this->Source;
            $data['Name'] = $this->Name;
            $data['Unit_Price'] = $this->Unit_Price;
            $data['Quantity'] = $this->Quantity;
            $data['Total_Amount'] = $this->Total_Amount;
            $data['Amount_Paid'] = $this->Amount_Paid;
            $data['Balance'] = $this->Balance;
            $data['Description'] = $Desc;
            $data['Attachment'] = $this->New_Attachment;
            $data['Payment_Mode'] = $this->Payment_Mode;
            $data['updated_at'] = Carbon::now();
            DB::table('debit_ledger')->Where('Id', $Id)->Update($data);

            $bal = array();
            $bal['Date'] = $this->Date;
            $bal['Category'] = $this->Category;
            $bal['Sub_Category'] = $this->Source;
            $bal['Total_Amount'] = $this->Total_Amount;
            $bal['Amount_Paid'] = $this->Amount_Paid;
            $bal['Balance'] = $this->Balance;
            $bal['Description'] = $Desc;
            $bal['Payment_Mode'] = $this->Payment_Mode;
            $bal['Attachment'] = $this->New_Attachment;
            $bal['updated_at'] = Carbon::now();
            DB::table('balance_ledger')->Where('Id', $Id)->Update($bal);

            $notification = array(
                'message' => 'Transaction Details & Balance Updated!.',
                'alert-type' => 'info'
            );
            return redirect()->route('Debit')->with($notification);
        } else {
            $data = array();
            $data['Date'] = $this->Date;
            $data['Category'] = $this->Category;
            $data['Source'] = $this->Source;
            $data['Name'] = $this->Name;
            $data['Unit_Price'] = $this->Unit_Price;
            $data['Quantity'] = $this->Quantity;
            $data['Total_Amount'] = $this->Total_Amount;
            $data['Amount_Paid'] = $this->Amount_Paid;
            $data['Balance'] = $this->Balance;
            $data['Description'] = $this->Description;
            $data['Attachment'] = $this->New_Attachment;
            $data['Payment_Mode'] = $this->Payment_Mode;
            $data['updated_at'] = Carbon::now();
            DB::table('debit_ledger')->Where('Id', $Id)->Update($data);
            $notification = array(
                'message' => 'Transaction Details Updated!.',
                'alert-type' => 'info'
            );
            return redirect()->route('Debit')->with($notification);
        }
    }

    public function Delete($Id)
    {
        $getbal =  DB::table('Balance_ledger')->Where('Id', $Id)->SUM('Balance');
        if ($getbal > 0) {
            $this->clearButton = true;
            $this->balId = $Id;
            $this->balamount = $getbal;

            $notification = array(
                'message' => 'The Selected Entery has balance Due Please Clear Due of ' . $getbal . ' For Id ' . $Id,
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {
            $this->deleteImage($Id);
            $Debit = Debit::wherekey($Id)->delete();
            $balance = BalanceLedger::wherekey($Id)->delete();
            if ($Debit > 0) {
                $notification = array(
                    'message' => 'Debit Transaction Deleted!',
                    'alert-type' => 'info'
                );
                return redirect()->back()->with($notification);
            } elseif ($balance > 0 && $Debit > 0) {
                $notification = array(
                    'message' => 'Debit & Balance Ledger Entry Deleted!',
                    'alert-type' => 'info'
                );
                return redirect()->back()->with($notification);
            } else {
                $notification = array(
                    'message' => 'Unable to Delete!. retry',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
        }
    }
    public function UpdateBalance($Id)
    {
        $fetch = BalanceLedger::where('Id', $Id)->get();
        foreach ($fetch as $key) {
            $total = $key['Total_Amount'];
            $paid = $key['Amount_Paid'];
            $bal = $key['Balance'];
        }
        $fetch = Debit::where('Id', $Id)->get();
        foreach ($fetch as $key) {
            $desc = $key['Description'];
        }
        $baldata = array();
        $baldata['Amount_Paid'] = $total;
        $baldata['Balance'] = 0;

        $debitdata = array();
        $debitdata['Amount_Paid'] = $total;
        $debitdata['Balance'] = 0;
        $desc = $desc . ' Balance Updated @' . Carbon::now();
        $debitdata['Balance'] = 0;
        $debitdata['Description'] = $desc;

        $update_bal = DB::table('balance_ledger')->where('Id', $Id)->update($baldata);
        $update_debit = DB::table('debit_ledger')->where('Id', $Id)->update($debitdata);
        if ($update_bal && $update_debit) {
            $notification = array(
                'message' => 'Balance Clered, No Due.!',
                'alert-type' => 'success'
            );
            return redirect()->route('Debit')->with($notification);
        } else {
            $notification = array(
                'message' => 'Unable to Clear the Balance! Please retry',
                'alert-type' => 'danger'
            );
            return redirect()->route('Credit')->with($notification);
        }
    }
    public function LastUpdate()
    {
        # code...
        $latest_app = Debit::latest('created_at')->first();
        $this->lastRecTime =  Carbon::parse($latest_app['created_at'])->diffForHumans();
    }


    public function render()
    {
        $this->LastUpdate();
        if (!is_null($this->Select_Date)) {
            $Transactions = Debit::where('Date', $this->Select_Date)->filter(trim($this->filterby))->paginate($this->paginate);
            if (sizeof($Transactions) == 0) {
                session()->flash('Error', 'Sorry!! No Record Available for ' . $this->Select_Date);
            }
        } else {
            $Transactions = Debit::whereDate('created_at', DB::raw('CURDATE()'))->filter(trim($this->filterby))->paginate($this->paginate);
        }



        $DebitSource = DebitSource::where('Category', $this->Category)->get();
        $DebitSources = DebitSources::where('DS_Id', $this->SubCategory)->get();
        $PaymentMode = PaymentMode::all();

        if (!empty($this->Particular)) {
            $debitsources = DebitSources::where('Id', $this->Particular)->get();
            foreach ($debitsources as $item) {
                $this->Unit_Price = $item->Unit_Price;
            }
            $this->Total_Amount = intval($this->Unit_Price) * intval($this->Quantity);
            $this->Balance = intval($this->Total_Amount) - intval($this->Amount_Paid);
        }
        $today_total = 0;
        foreach ($Transactions as $key) {
            $today_total += $key['Amount_Paid'];
        }
        $this->total = $today_total;
        $this->balCollection = BalanceLedger::where('Id', $this->balId)->get();

        return view('livewire.admin-module.ledger.debit.debit-ledger', compact('DebitSource', 'DebitSources', 'PaymentMode', 'Transactions'), ['today' => $this->today,]);
    }
}
