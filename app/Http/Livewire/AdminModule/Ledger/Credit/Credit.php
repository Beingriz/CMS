<?php

namespace App\Http\Livewire\AdminModule\Ledger\Credit;

use App\Models\BalanceLedger;
use App\Models\CreditLedger;
use App\Models\CreditSource;
use App\Models\CreditSources;
use App\Traits\RightInsightTrait;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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
    public $Sources, $creditsource = NULL;
    public $SelectedSources = NULL;
    public $Date;
    public $Unit_Price;
    public $Quantity;
    public $Total_Amount = NULL, $Total;
    public $Amount_Paid = 0;
    public $Balance = 0;
    public $Description = 'Walk in Customer';
    public $Payment_Mode = 'Cash';
    public $Attachment, $itteration;
    public $Old_Attachment, $New_Attachment, $lastRecTime, $clearButton = false, $balamount, $balId, $balCollection;

    public $paginate = 10;
    public $Select_Date = NULL;
    public $filterby = "";
    public $Checked = [];
    public $FilterChecked = [];
    public $Single;
    public $collection = [];
    public $bal_id = NULL;
    public $update = 0, $Show_Insight = false;
    public $Branch_Id, $Emp_Id;


    protected $rules = [
        'Sources' => 'required',
        'Date' => 'required',
        'Total_Amount' => 'required',
        'Amount_Paid' => 'required',
        'Description' => 'required',
        'Payment_Mode' => 'required',
    ];
    protected $messages = [
        'Sources.required' => 'Please Select the Credit Source.',
        'Date.required' => 'Date Field Cannot be empty.',
        'Total_Amount.required' => 'Please Enter the Total Amount.',
        'Amount_Paid.required' => 'Please Enter the Amount Received.',
        'Description.required' => 'Please Enter the Proper Description.',
        'Payment_Mode.required' => 'Please SelectPayment Method. ',
    ];

    protected $listeners = [
        'delete' => 'Delete',
        'edit' => 'Edit',
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($EditData, $DeleteData)
    {
        $this->transaction_id = 'CE' . time();
        $this->Date = date("Y-m-d");
        $this->Total = 0;
        $this->Quantity = 1;
        $this->Total_Amount = 0;
        $this->Balance = 0;
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
        if (!empty($this->Attachment)) // Check if new image is selected
        {
            if (!empty($this->Old_Attachment)) {
                if (Storage::disk('public')->exists($this->Old_Attachment)) {
                    unlink(storage_path('app/public/' . $this->Old_Attachment));
                    $extension = $this->Thumbnail->getClientOriginalExtension();
                    $path = 'Digital Ledger/Credit Book/Attachments' . time();
                    $filename = 'BM_' . $this->Name . '_' . time() . '.' . $extension;
                    $url = $this->Thumbnail->storePubliclyAs($path, $filename, 'public');
                    $this->New_Attachment = $url;
                } else {
                    $extension = $this->Thumbnail->getClientOriginalExtension();
                    $path = 'Digital Ledger/Credit Book/Attachments' . time();
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
    public function CreditEntry()
    {
        $this->validate();
        $transId = 'CE' . time();
        $clientId = 'C' . time();
        $this->Balance = intval($this->Total_Amount) - intval($this->Amount_Paid);
        $CategoryName = CreditSource::Wherekey($this->SourceSelected)->first()->Name ?? 'Unknown';

        $this->ImageUpload();

        $Desc = "Received Rs. " . $this->Amount_Paid . "/- From " . $this->Description .
            " for " . $CategoryName . ',' . $this->SelectedSources . " on " . $this->Date .
            " by " . $this->Payment_Mode . ", Total: " . $this->Total_Amount .
            ", Paid: " . $this->Amount_Paid . ", Balance: " . $this->Balance;

        // Save Credit Ledger Entry
        $creditentry = new CreditLedger();
        $creditentry->Id = $transId;
        $creditentry->Client_Id = $clientId;
        $creditentry->Branch_Id = $this->Branch_Id;
        $creditentry->Emp_Id = $this->Emp_Id;
        $creditentry->Date = $this->Date;
        $creditentry->Category = $CategoryName;
        $creditentry->Sub_Category = $this->SelectedSources;
        $creditentry->Unit_Price = $this->Unit_Price;
        $creditentry->Quantity = $this->Quantity;
        $creditentry->Total_Amount = $this->Total_Amount;
        $creditentry->Amount_Paid = $this->Amount_Paid;
        $creditentry->Balance = $this->Balance;
        $creditentry->Description = $Desc;
        $creditentry->Payment_Mode = $this->Payment_Mode;
        $creditentry->Attachment = $this->New_Attachment;
        $creditentry->save();

        // Save Balance Ledger Entry (only if balance exists)
        if ($this->Balance > 0) {
            $save_balance = new BalanceLedger();
            $save_balance->Id = $transId;
            $save_balance->Client_Id = $clientId;
            $save_balance->Branch_Id = $this->Branch_Id;
            $save_balance->Emp_Id = $this->Emp_Id;
            $save_balance->Date = $this->Date;
            $save_balance->Name = $this->Description;
            $save_balance->Mobile_No = $clientId;
            $save_balance->Category = $CategoryName;
            $save_balance->Sub_Category = $this->SelectedSources;
            $save_balance->Total_Amount = $this->Total_Amount;
            $save_balance->Amount_Paid = $this->Amount_Paid;
            $save_balance->Balance = $this->Balance;
            $save_balance->Payment_Mode = $this->Payment_Mode;
            $save_balance->Attachment = $this->New_Attachment;
            $save_balance->Description = $this->Description;
            $save_balance->save();
        }

        // Dispatch a browser event to trigger SweetAlert
        $this->dispatchBrowserEvent('swal:success', [
            'title' => 'Success!',
            'text' => 'Transaction saved successfully.',
            'icon' => 'success',
            'redirect-url' => route('Credit'),
        ]);

    }

    public function Edit($Id)
    {
        $this->update = 1;
        $fetch = CreditLedger::Where('Id', $Id)->get();

        foreach ($fetch as $key) {
            $this->transaction_id = $key['Id'];
            $CategoryName = $key['Category'];
            $this->SelectedSources = $key['Sub_Category'];
            $this->Date = $key['Date'];
            $this->Total_Amount = $key['Total_Amount'];
            $this->Unit_Price = $key['Unit_Price'];
            $this->Quantity = $key['Quantity'];
            $this->Amount_Paid = $key['Amount_Paid'];
            $this->Balance = $key['Balance'];
            $this->Description = $this->Description;
            $this->Payment_Mode = $key['Payment_Mode'];
            $this->Old_Attachment = $key['Attachment'];
        }
        $CategoryName = CreditSource::Where('Name', $CategoryName)->get();
        foreach ($CategoryName as $CS_Id) {
            $this->SourceSelected = $CS_Id['Id'];
        }
    }
    public function ResetFields()
    {
        $this->Total_Amount = 0;
        $this->Quantity = 0;
        $this->Amount_Paid = 0;
        $this->Balance = 0;
        $this->Description = $this->Description;
        $this->Payment_Mode = NULL;
        $this->Old_Attachment = NULL;
        $this->Attachment = NULL;
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
        foreach ($CategoryName as $key) {
            $CategoryName = $key['Name'];
        }
        $Desc = "Received Rs. " . $this->Amount_Paid . "/- From  " . $this->Description . " for " . $CategoryName . ',' . $this->SelectedSources . " , on " . $this->Date . " by  " . $this->Payment_Mode . ", Total: " . $this->Total_Amount . ", Paid: " . $this->Amount_Paid . ", Balance: " . $this->Balance;

        $this->ImageUpload();
        $data = array();
        $data['Date'] = $this->Date;
        $data['Category'] = $CategoryName;
        $data['Sub_Category'] = $this->SelectedSources;
        $data['Unit_Price'] = $this->Unit_Price;
        $data['Quantity'] = $this->Quantity;
        $data['Total_Amount'] = $this->Total_Amount;
        $data['Amount_Paid'] = $this->Amount_Paid;
        $data['Balance'] = $this->Balance;
        $data['Description'] = $Desc;
        $data['Payment_Mode'] = $this->Payment_Mode;
        $data['Attachment'] = $this->New_Attachment;
        $Update = DB::table('credit_ledger')->where('Id', '=', $Id)->Update($data);
        $this->clerBalDue($Id, $this->Amount_Paid);
        if ($Update > 0) {
             // Dispatch a browser event to trigger SweetAlert
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Success!',
                'text' => 'Transaction Updated successfully.',
                'icon' => 'success',
                'redirect-url' => route('Credit'),
            ]);
            $this->ResetFields();
            $this->Attachment = Null;
            $this->itteration++;
            $this->update = 0;
        }
    }
    public function clerBalDue($Id, $amount)
    {
        $getbal =  DB::table('Balance_ledger')->Where('Client_Id', $Id)->SUM('Balance');
        if ($getbal > $amount) {
            $data = array();
            $data['Balance'] = $amount;
            DB::table('Balance_ledger')->Where('Client_Id', $Id)->update($data);
        }
    }
    public function deleteImage($Id)
    {
        $fetch = CreditLedger::Where('Id', $Id)->get();
        foreach ($fetch as $key) {
            $file = $key['Attachment'];
        }
        if (!empty($file)) {
            if (Storage::disk('public')->exists($file)) {
                unlink(storage_path('app/public/' . $file));
            }
        }
    }
    public function Delete($Id)
    {
        // Fetch balance for the entry
        $getbal = DB::table('Balance_ledger')->where('Id', $Id)->value('Balance');

        if ($getbal > 0) {
            // If balance exists, show warning and ask for due clearance
            $this->clearButton = true;
            $this->balId = $Id;
            $this->balamount = $getbal;

            $this->dispatchBrowserEvent('swal:confirm', [
                'title' => 'Outstanding Balance!',
                'text' => "The selected entry has a due balance of Rs. {$getbal}. Please clear the due amount for ID {$Id}.",
                'icon' => 'warning',
                'confirmButtonText' => 'Clear Due',
                'cancelButtonText' => 'Cancel',
            ]);
            return; // Stop execution if balance exists
        }

        // If no balance, proceed with deletion
        $this->deleteImage($Id);

        // Delete from both ledgers
        $creditDeleted = CreditLedger::whereKey($Id)->delete();
        $balanceDeleted = BalanceLedger::whereKey($Id)->delete();

        // Success message handling
        if ($creditDeleted || $balanceDeleted) {
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Success!',
                'text' => 'Entry deleted successfully from ledger.',
                'icon' => 'success',
                'redirect-url' => route('Credit'),
            ]);
        } else {
            // Error handling in case deletion fails
            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Error!',
                'text' => 'Failed to delete the entry. Please try again.',
                'icon' => 'error',
            ]);
        }

    }

    public function MultipleDelete()
    {

        $check_bal = BalanceLedger::WhereIn('Client_Id', $this->Checked)->get();
        if (sizeof($check_bal) > 0) {
            $temp = collect([]);
            foreach ($check_bal as $get_id) {
                $bal = 0;
                $bal_ids = $get_id['Client_Id'];
                $bal_id = $get_id['Id'];
                $desc = $get_id['Description'];
                $tot = $get_id['Total_Amount'];
                $paid = $get_id['Amount_Paid'];
                $bal += $get_id['Balance'];
                if ($bal > 0) {
                    $temp->push(['Id' => $bal_ids, 'Description' => $desc, 'Total_Amount' => $tot, 'Amount_Paid' => $paid, 'Balance' => $bal]);
                    $this->FilterChecked = [];
                    foreach ($temp as $key) {
                        $id = $key['Id'];
                        array_push($this->FilterChecked, $id);
                    }
                }
            }
            $this->collection = $temp;
            $Checked = array_diff($this->Checked, $this->FilterChecked);
            $del_credit = CreditLedger::wherekey($Checked)->delete();
            if ($del_credit) {
                session()->flash('SuccessMsg', count($Checked) . ' Records Deleted Successfully..');
            } else {
                session()->flash('Error', ' Records Unable to Delete..');
            }
        } else {
            $check_bal = CreditLedger::WhereIn('Id', $this->Checked)->get();

            $del_credit = CreditLedger::Wherekey($this->Checked)->delete();
            if ($del_credit) {
                session()->flash('SuccessMsg', count($this->Checked) . ' Records Deleted Successfully..');
            } else {
                session()->flash('Error', count($del_credit) . ' Records Unable to Delete..');
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
        $fetch = CreditLedger::where('Id', $Id)->get();
        foreach ($fetch as $key) {
            $desc = $key['Description'];
        }
        $baldata = array();
        $baldata['Amount_Paid'] = $total;
        $baldata['Balance'] = 0;

        $creditdata = array();
        $creditdata['Amount_Paid'] = $total;
        $creditdata['Balance'] = 0;
        $desc = $desc . ' Balance Updated @' . Carbon::now();
        $creditdata['Balance'] = 0;
        $creditdata['Description'] = $desc;

        $update_bal = DB::table('balance_ledger')->where('Id', $Id)->update($baldata);
        $update_credit = DB::table('credit_ledger')->where('Id', $Id)->update($creditdata);
        if ($update_bal && $update_credit) {
            $notification = array(
                'message' => 'Balance Clered, No Due.!',
                'alert-type' => 'success'
            );
            return redirect()->route('Credit')->with($notification);
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
        $latest_app = CreditLedger::latest('created_at')->first();
        $this->lastRecTime =  Carbon::parse($latest_app['created_at'])->diffForHumans();
    }
    public function RefreshPage(){
        $this->resetpage();
    }
    public function isBranchAdminOrOperator()
    {
        $role = Auth::user()->role;
        return $role === 'branch admin' || $role === 'operator';
    }

    public function render()
    {
        $this->LastUpdate();

        $isBranchAdminOrOperator = $this->isBranchAdminOrOperator();
        $query = CreditLedger::query();

        if ($isBranchAdminOrOperator) {
            $query->where('Branch_Id', $this->Branch_Id);
        }

        if (!is_null($this->Select_Date)) {
            $query->where('Date', $this->Select_Date);
        } else {
            $query->where('Date', $this->today);
        }

        $query->filter(trim($this->filterby));
        $todays_list = $query->paginate($this->paginate);
        if (!is_null($this->SourceSelected)) {
            $this->Sources = CreditSources::orderby('Source')->where('CS_Id', $this->SourceSelected)->get();
        }
        $this->balCollection = BalanceLedger::where('Id', $this->balId)->get();
        $Unit_Price = 0;
        if (!empty($this->SourceSelected)) {
            if (!empty($this->SelectedSources)) {
                $this->Unit_Price = CreditSources::where('Source', '=', $this->SelectedSources)->get();
                foreach ($this->Unit_Price as $unit) {
                    $Unit_Price += $unit['Unit_Price'];
                }
            }
        }
        $this->Unit_Price = $Unit_Price;
        $this->Total_Amount = intval($Unit_Price) * intval($this->Quantity);
        $this->Balance = intval($this->Total_Amount) - intval($this->Amount_Paid);


        // Additional logic for calculations and rendering
        $source = CreditLedger::Where('Sub_Category', $this->SelectedSources)->get();
        $prev_earning = CreditLedger::Where([['Date', '=', $this->previous_day], ['Sub_Category', '=', $this->SelectedSources]])->paginate($this->paginate);
        $total_prev_earnings = 0;
        $source_total = 0;
        $today_total = 0;
        foreach ($todays_list as $key) {
            $today_total += $key['Amount_Paid'];
        }

        foreach ($source as $key) {
            $source_total += $key['Amount_Paid'];
        }

        if ($isBranchAdminOrOperator) {
            $todays_list_total = CreditLedger::where('Date', $this->today)
                                            ->where('Branch_Id', $this->Branch_Id)->get();
        } else {
            $todays_list_total = CreditLedger::where('Date', $this->today)->get();
        }

        foreach ($todays_list_total as $key) {
            $today_total += $key['Amount_Paid'];
        }

        foreach ($prev_earning as $key) {
            $total_prev_earnings += $key['Amount_Paid'];
        }

        $total_revenue = $this->sum;
        $contribution = number_format(($source_total * 100) / $total_revenue, 2);
        $percentage = number_format(($today_total / 1500) * 100);
        $creditsource = CreditSource::orderby('Name')->get();

        return view('livewire.admin-module.ledger.credit.credit', [
            'credit_source' => $creditsource,
            'credit_sources' => $this->Sources,
            'payment_mode' => $this->payment_mode,
            'total_revenue' => $this->sum,
            'previous_revenue' => $this->previous_revenue,
            'applications_served' => $this->applications_served,
            'previous_day_app' => $this->previous_day_app,
            'applications_delivered' => $this->applications_delivered,
            'previous_day_app_delivered' => $this->previous_day_app_delivered,
            'total_revenue' => $this->sum,
            'previous_revenue' => $this->previous_sum,
            'balance_due' => $this->balance_due_sum,
            'previous_bal' => $this->previous_bal_sum,
            'today' => $this->today,
            'total' => $today_total,
            'percentage' => $percentage,
            'creditdata' => $todays_list,
            'n' => $this->n,
            'source_total' => $source_total,
            'contribution' => $contribution,
            'prev_earning' => $total_prev_earnings,
            'Total' => $this->Total_Amount,
            'Total_Amount' => $this->Total_Amount,
            'Unit_Price' => $this->Unit_Price,
        ]);
    }

}
