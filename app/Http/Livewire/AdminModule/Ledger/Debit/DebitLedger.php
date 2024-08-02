<?php

namespace App\Http\Livewire\AdminModule\Ledger\Debit;

use App\Models\BalanceLedger;
use App\Models\Debit;
use App\Models\DebitSource;
use App\Models\DebitSources;
use App\Models\PaymentMode;
use App\Traits\RightInsightTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
    public $Branch_Id, $Emp_Id;





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
        $this->Branch_Id = Auth::user()->branch_id;
        $this->Emp_Id = Auth::user()->Emp_Id;
    }



    public function ImageUpload()
    {
        if (!empty($this->Attachment)) {
            // New attachment is provided
            if (!empty($this->Old_Attachment)) {
                // Old attachment exists, delete it
                if (Storage::disk('public')->exists($this->Old_Attachment)) {
                    Storage::disk('public')->delete($this->Old_Attachment);
                }
            }

            // Process new attachment
            $this->validate([
                'Attachment' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Ensure it's an image and within size limits
            ]);

            $extension = $this->Attachment->getClientOriginalExtension();
            $path = 'Digital Ledger/Debit Book/Attachments/' . time(); // Ensure '/' is used to separate folders
            $filename = 'BM_' . $this->Name . '_' . time() . '.' . $extension;
            $url = $this->Attachment->storePubliclyAs($path, $filename, 'public');
            $this->New_Attachment = $url;

        } else {
            // No new attachment provided, use old one if available
            if (!empty($this->Old_Attachment) && Storage::disk('public')->exists($this->Old_Attachment)) {
                $this->New_Attachment = $this->Old_Attachment;
            } else {
                // No old attachment, validate if payment mode is not 'Cash'
                if ($this->Payment_Mode != 'Cash') {
                    $this->validate([
                        'Attachment' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Ensure it's an image and within size limits
                    ]);
                }
                $this->New_Attachment = null; // No attachment provided
            }
        }
    }

    public function deleteImage($Id)
    {
        // Fetch the single record by ID
        $record = Debit::find($Id);

        if ($record) {
            $file = $record->Attachment; // Get the attachment field

            if (!empty($file) && Storage::disk('public')->exists($file)) {
                // Delete the file using Laravel's Storage facade
                Storage::disk('public')->delete($file);
            }
        } else {
            // Handle the case where the record with the given ID doesn't exist
            session()->flash('Error', 'Record not found.');
        }
    }


    public function Save()
    {
        // Validate input data
        $rules = [
            'Particular' => 'required',
            'Amount_Paid' => 'required|numeric',
            'Description' => 'required|string',
            'Date' => 'required|date',
            'Category' => 'required|string',
            'Payment_Mode' => 'required|string',
        ];

        if ($this->Payment_Mode != 'Cash') {
            $rules['Attachment'] = 'required|image';
        }

        $this->validate($rules);

        // Trim input values
        $this->Particular = trim($this->Particular);
        $this->Amount_Paid = trim($this->Amount_Paid);
        $this->Description = trim($this->Description);
        $this->Date = trim($this->Date);
        $this->Category = trim($this->Category);
        $this->Payment_Mode = trim($this->Payment_Mode);

        // Fetch debit source record
        $debitsource = DebitSources::find($this->Particular);
        if (!$debitsource) {
            session()->flash('Error', 'Debit source not found.');
            return redirect()->route('Debit');
        }

        $this->Source = $debitsource->DS_Name;
        $this->Name = $debitsource->Name;

        // Prepare description
        $Desc = sprintf(
            "Spent Rs. %s on %s for %s - %s. Date: %s. Payment Mode: %s. Total: %s, Paid: %s, Balance: %s.",
            trim($this->Amount_Paid),
            trim($this->Description),
            trim($this->Source),
            trim($this->Name),
            trim($this->Date),
            trim($this->Payment_Mode),
            trim($this->Total_Amount),
            trim($this->Amount_Paid),
            trim($this->Balance)
        );
        // Upload image if necessary
        $this->ImageUpload();

        if ($this->Balance > 0) {
            // Save balance ledger entry
            $save_balance = new BalanceLedger();
            $save_balance->Id = $this->transaction_id;
            $save_balance->Client_Id = $this->transaction_id;
            $save_balance->Branch_Id = $this->Branch_Id;
            $save_balance->Emp_Id = $this->Emp_Id;
            $save_balance->Date = trim($this->Date);
            $save_balance->Name = trim($this->Description);
            $save_balance->Mobile_No = 'Not Available';
            $save_balance->Category = trim($this->Source);
            $save_balance->Sub_Category = trim($this->Name);
            $save_balance->Total_Amount = trim($this->Total_Amount);
            $save_balance->Amount_Paid = trim($this->Amount_Paid);
            $save_balance->Balance = trim($this->Balance);
            $save_balance->Payment_Mode = trim($this->Payment_Mode);
            $save_balance->Attachment = $this->New_Attachment;
            $save_balance->Description = trim($this->Description);
            $save_balance->save(); // Balance Ledger Entry Saved

            // Save debit ledger entry
            $debitentry = new Debit();
            $debitentry->Id = $this->transaction_id;
            $debitentry->Client_Id = $this->transaction_id;
            $debitentry->Branch_Id = $this->Branch_Id;
            $debitentry->Emp_Id = $this->Emp_Id;
            $debitentry->Date = trim($this->Date);
            $debitentry->Category = trim($this->Category);
            $debitentry->Source = trim($this->Source);
            $debitentry->Name = trim($this->Name);
            $debitentry->Unit_Price = trim($this->Unit_Price);
            $debitentry->Quantity = trim($this->Quantity);
            $debitentry->Total_Amount = trim($this->Total_Amount);
            $debitentry->Amount_Paid = trim($this->Amount_Paid);
            $debitentry->Balance = trim($this->Balance);
            $debitentry->Description = $Desc;
            $debitentry->Payment_Mode = trim($this->Payment_Mode);
            $debitentry->Attachment = $this->New_Attachment;
            $debitentry->save(); // Debit Ledger Entry

            $notification = [
                'message' => 'Transaction Saved, Balance Updated!',
                'alert-type' => 'success'
            ];
        } else {
            // Save debit ledger entry
            $debitentry = new Debit();
            $debitentry->Id = 'DE' . time();
            $debitentry->Client_Id = 'EX' . time();
            $debitentry->Branch_Id = $this->Branch_Id;
            $debitentry->Emp_Id = $this->Emp_Id;
            $debitentry->Date = trim($this->Date);
            $debitentry->Category = trim($this->Category);
            $debitentry->Source = trim($this->Source);
            $debitentry->Name = trim($this->Name);
            $debitentry->Unit_Price = trim($this->Unit_Price);
            $debitentry->Quantity = trim($this->Quantity);
            $debitentry->Total_Amount = trim($this->Total_Amount);
            $debitentry->Amount_Paid = trim($this->Amount_Paid);
            $debitentry->Balance = trim($this->Balance);
            $debitentry->Description = $Desc;
            $debitentry->Payment_Mode = trim($this->Payment_Mode);
            $debitentry->Attachment = $this->New_Attachment;
            $debitentry->save(); // Debit Ledger Entry

            $notification = [
                'message' => 'Transaction Saved!',
                'alert-type' => 'success'
            ];
        }

        return redirect()->route('Debit')->with($notification);
    }


    public function Edit($Id)
    {
        // Fetch the debit record by Id
        $item = Debit::where('Id', $Id)->first();
        if (!$item) {
            session()->flash('Error', 'Record not found.');
            return;
        }

        // Assign values to class properties
        $this->transaction_id = $item->Id;
        $this->Date = $item->Date;
        $this->Category = $item->Category;
        $this->SubCategory = $item->Source;
        $this->Unit_Price = $item->Unit_Price;
        $this->Quantity = $item->Quantity;
        $this->Total_Amount = $item->Total_Amount;
        $this->Amount_Paid = $item->Amount_Paid;
        $this->Balance = $item->Balance;
        $this->Payment_Mode = $item->Payment_Mode;

        // Fetch the DebitSources record for the SubCategory
        $debsource = DebitSources::where('DS_Name', trim($this->SubCategory))->first();
        if ($debsource) {
            $this->SubCategory = $debsource->DS_Id;
        } else {
            $this->SubCategory = null; // Set to null or handle the case where no matching record is found
        }

        $this->update = true;
    }

    public function UpdateLedger($Id)
    {
        // Upload the image and validate input
        $this->ImageUpload();
        $this->validate();

        // Fetch the debit source record
        $debitsource = DebitSources::where('Id', $this->Particular)->first();
        if (!$debitsource) {
            session()->flash('Error', 'Debit source not found.');
            return redirect()->route('Debit');
        }

        $this->Source = $debitsource->DS_Name;
        $this->Name = $debitsource->Name;

        // Create description
        $Desc = "Spent Rs. " . trim($this->Amount_Paid) . "/- from " . trim($this->Description) . " for " . trim($this->Source) . ", " . trim($this->Name) . " on " . trim($this->Date) . " by " . trim($this->Payment_Mode) . ". Total: " . trim($this->Total_Amount) . ", Paid: " . trim($this->Amount_Paid) . ", Balance: " . trim($this->Balance);

        // Prepare data for update
        $data = [
            'Date' => $this->Date,
            'Category' => $this->Category,
            'Source' => $this->Source,
            'Name' => $this->Name,
            'Unit_Price' => $this->Unit_Price,
            'Quantity' => $this->Quantity,
            'Total_Amount' => $this->Total_Amount,
            'Amount_Paid' => $this->Amount_Paid,
            'Balance' => $this->Balance,
            'Description' => $Desc,
            'Attachment' => $this->New_Attachment,
            'Payment_Mode' => $this->Payment_Mode,
            'updated_at' => Carbon::now()
        ];

        // Update debit ledger and balance ledger based on balance
        if ($this->Balance > 0) {
            DB::table('debit_ledger')->where('Id', $Id)->update($data);

            $data = [
                'Date' => $this->Date,
                'Category' => $this->Category,
                'Sub_Category' => $this->Source,
                'Name' => $this->Name,
                'Total_Amount' => $this->Total_Amount,
                'Amount_Paid' => $this->Amount_Paid,
                'Balance' => $this->Balance,
                'Description' => $Desc,
                'Attachment' => $this->New_Attachment,
                'Payment_Mode' => $this->Payment_Mode,
                'updated_at' => Carbon::now()
            ];
            $bal = $data; // Reuse the same data array for balance ledger
            $bal['Sub_Category'] = $this->Source; // Adjust key for balance ledger
            DB::table('balance_ledger')->where('Id', $Id)->update($bal);

            $message = 'Transaction Details & Balance Updated!';
        } else {
            DB::table('debit_ledger')->where('Id', $Id)->update($data);

            $message = 'Transaction Details Updated!';
        }

        // Redirect with notification
        $notification = [
            'message' => $message,
            'alert-type' => 'info'
        ];
        return redirect()->route('Debit')->with($notification);
    }


    public function Delete($Id)
    {
        // Fetch balance sum for the given ID
        $getbal = DB::table('balance_ledger')->where('Id', $Id)->sum('Balance');

        if ($getbal > 0) {
            // If balance is greater than 0, notify the user to clear the due
            $this->clearButton = true;
            $this->balId = $Id;
            $this->balamount = $getbal;

            $notification = [
                'message' => 'The selected entry has a balance due. Please clear the due of ' . $getbal . ' for ID ' . $Id,
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        } else {
            // Proceed to delete the debit and balance records
            $this->deleteImage($Id);

            // Attempt to delete records
            $debitDeleted = Debit::where('Id', $Id)->delete();
            $balanceDeleted = BalanceLedger::where('Id', $Id)->delete();

            // Determine the notification message based on what was deleted
            if ($debitDeleted && $balanceDeleted) {
                $notification = [
                    'message' => 'Debit and balance ledger entries deleted successfully!',
                    'alert-type' => 'info'
                ];
            } elseif ($debitDeleted) {
                $notification = [
                    'message' => 'Debit transaction deleted successfully!',
                    'alert-type' => 'info'
                ];
            } else {
                $notification = [
                    'message' => 'Unable to delete. Please try again.',
                    'alert-type' => 'error'
                ];
            }

            return redirect()->back()->with($notification);
        }
    }

    public function UpdateBalance($Id)
    {
        // Fetch the balance ledger record
        $balanceRecord = BalanceLedger::where('Id', $Id)->first();
        if (!$balanceRecord) {
            $notification = [
                'message' => 'Balance record not found!',
                'alert-type' => 'danger'
            ];
            return redirect()->route('Debit')->with($notification);
        }

        // Fetch the debit record
        $debitRecord = Debit::where('Id', $Id)->first();
        if (!$debitRecord) {
            $notification = [
                'message' => 'Debit record not found!',
                'alert-type' => 'danger'
            ];
            return redirect()->route('Debit')->with($notification);
        }

        // Prepare data for update
        $desc = $debitRecord->Description . ' Balance Updated @ ' . Carbon::now();
        $updateData = [
            'Amount_Paid' => $balanceRecord->Total_Amount,
            'Balance' => 0,
            'Description' => $desc,
        ];

        // Update both balance and debit records
        $updateBalance = DB::table('balance_ledger')->where('Id', $Id)->update($updateData);
        $updateDebit = DB::table('debit_ledger')->where('Id', $Id)->update($updateData);

        // Check if both updates were successful
        if ($updateBalance && $updateDebit) {
            $notification = [
                'message' => 'Balance cleared, no due!',
                'alert-type' => 'success'
            ];
            return redirect()->route('Debit')->with($notification);
        } else {
            $notification = [
                'message' => 'Unable to clear the balance! Please retry.',
                'alert-type' => 'danger'
            ];
            return redirect()->route('Debit')->with($notification);
        }
    }

    public function LastUpdate()
    {
        // Fetch the most recent debit record
        $latest_app = Debit::latest('created_at')->first();

        // Check if a record exists and update the lastRecTime accordingly
        if ($latest_app) {
            $this->lastRecTime = Carbon::parse($latest_app->created_at)->diffForHumans();
        } else {
            $this->lastRecTime = 'No records found';
        }
    }


    public function render()
    {
        // Update the last update time
        $this->LastUpdate();

        // Determine the query for transactions based on user role and date selection
        if (!is_null($this->Select_Date)) {
            $query = Debit::where('Date', $this->Select_Date);

            if (Auth::user()->role == 'branch admin') {
                $query->where('Branch_Id', $this->Branch_Id);
            }

            $Transactions = $query->filter(trim($this->filterby))->paginate($this->paginate);
        } else {
            $query = Debit::whereDate('created_at', DB::raw('CURDATE()'));

            if (Auth::user()->role == 'branch admin') {
                $query->where('Branch_Id', $this->Branch_Id);
            }

            $Transactions = $query->filter(trim($this->filterby))->paginate($this->paginate);
        }

        // Check for empty results
        if ($Transactions->isEmpty()) {
            session()->flash('Error', 'Sorry!! No Record Available for ' . ($this->Select_Date ?? 'today'));
        }

        // Fetch necessary data for views
        $DebitSource = DebitSource::where('Category', $this->Category)->get();
        $DebitSources = DebitSources::where('DS_Id', $this->SubCategory)->get();
        $PaymentMode = PaymentMode::all();

        // Update calculations if a particular record is selected
        if (!empty($this->Particular)) {
            $debitsources = DebitSources::find($this->Particular);

            if ($debitsources) {
                $this->Unit_Price = $debitsources->Unit_Price;
                $this->Total_Amount = intval($this->Unit_Price) * intval($this->Quantity);
                $this->Balance = intval($this->Total_Amount) - intval($this->Amount_Paid);
            }
        }

        // Calculate total amount paid today
        $today_total = $Transactions->sum('Amount_Paid');
        $this->total = $today_total;

        // Fetch balance collection
        $this->balCollection = BalanceLedger::find($this->balId);

        // Render the view with data
        return view('livewire.admin-module.ledger.debit.debit-ledger', [
            'DebitSource' => $DebitSource,
            'DebitSources' => $DebitSources,
            'PaymentMode' => $PaymentMode,
            'Transactions' => $Transactions,
            'today' => $this->today,
        ]);
    }

}
