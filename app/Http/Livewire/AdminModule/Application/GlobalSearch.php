<?php

namespace App\Http\Livewire\AdminModule\Application;

use App\Models\Application;
use App\Models\BalanceLedger;
use App\Models\ClientRegister;
use App\Models\CreditLedger;
use App\Models\Status;
use App\Models\User;
use App\Traits\RightInsightTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class GlobalSearch extends Component
{
    use WithPagination, RightInsightTrait;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['SearchResult'];

    public $search;
    public $Checked = [];
    public $filterby, $created, $updated;
    public $count;
    public $total;
    public $collection, $n = 1;
    public $paginate = 5;
    public $Name, $Registered, $Client_Id, $Mobile_No, $Service_Count, $Pending_App, $Delivered, $Balance, $Revenue;
    public $Registered_Count = 0;
    public $Search_Count = 0;
    public $filtered;
    public $Balance_Collection = [];
    public $Status = NULL, $byStatus, $StatusCount, $FilterChecked;
    public $Branch_Id, $Emp_Id;
    protected $search_data=[];

    public function mount($key)
    {
        $this->search = $key;
        $this->Branch_Id = Auth::user()->branch_id;
        $this->Emp_Id = Auth::user()->Emp_id;
    }

    public function SingleDelete($Id, $Client_Id)
    {
        $check_bal = BalanceLedger::Where([['Id', $Id], ['Client_Id', $Client_Id]])->get();
        if ($check_bal->isNotEmpty()) {
            foreach ($check_bal as $bal) {
                $balance = $bal['Balance'];
            }
            if ($balance > 0) {
                $this->Balance_Collection = $check_bal;
            }
        } else {
            $check_app = Application::Where([['Id', $Id], ['Client_Id', $Client_Id]])->get();
            if ($check_app->isNotEmpty()) {
                foreach ($check_app as $bal) {
                    $balance = $bal['Balance'];
                }
                if ($balance > 0) {
                    $this->Balance_Collection = $check_app;
                } else {
                    $Yes = 'Yes';
                    DB::update('update digital_cyber_db set Recycle_Bin = ? where Id = ? && Client_Id = ?', [$Yes, $Id, $Client_Id]);
                    session()->flash('SuccessMsg', 'Selected Application ID: ' . $Client_Id . ' Moved to Recycle Bin Successfully,');
                }
            }
        }
    }

    public function ClearBalanceDue($Id, $Client_Id)
    {
        $fetch_bal = BalanceLedger::Where([['Id', $Id], ['Client_Id', $Client_Id]])->get();
        if ($fetch_bal->isNotEmpty()) {
            foreach ($fetch_bal as $bal) {
                $total = $bal['Total_Amount'];
                $paid = $bal['amount_Paid'];
                $balance = $bal['Balance'];
            }
            if ($balance > 0) {
                $paid = $total;
                $ubalance = $total - $paid;
                DB::update('update balance_ledger set Total_Amount = ?, Amount_Paid = ?,Balance = ? where ID = ? && Client_Id=?', [$total, $paid, $ubalance, $Id, $Client_Id]);
                DB::update('update digital_cyber_db set Total_Amount = ?, Amount_Paid = ?,Balance = ? where ID = ? && Client_Id=?', [$total, $paid, $ubalance, $Id, $Client_Id]);
                $update_bal = BalanceLedger::Where([['Id', $Id], ['Client_Id', $Client_Id]])->get();
                $this->Balance_Collection =  $update_bal;
                session()->flash('SuccessMsg', 'Balance Due of ' . $balance . ' for ID: ' . $Client_Id . ' is Updated and Cleared Successfully, Updated Balance is ' . $ubalance);
            }
        } else {
            $fetch_app = Application::Where([['Id', $Id], ['Client_Id', $Client_Id]])->get();
            if ($fetch_app->isNotEmpty()) {
                foreach ($fetch_app as $bal) {
                    $total = $bal['Total_Amount'];
                    $paid = $bal['amount_Paid'];
                    $balance = $bal['Balance'];
                }
                if ($balance > 0) {
                    $paid = $total;
                    $ubalance = $total - $paid;
                    DB::update('update digital_cyber_db set Total_Amount = ?, Amount_Paid = ?,Balance = ? where ID = ? && Client_Id=?', [$total, $paid, $ubalance, $Id, $Client_Id]);
                    $update_bal = Application::Where([['Id', $Id], ['Client_Id', $Client_Id]])->get();
                    $this->Balance_Collection =  $update_bal;
                    session()->flash('SuccessMsg', 'Balance Due of &#x20B9; ' . $balance . ' for ID: ' . $Client_Id . ' is Updated and Cleared Successfully, Updated Balance is &#x20B9; ' . $ubalance);
                }
            } else {
                dd('Sorry No Application Found');
            }
        }
    }

    public function MoveRecycle($Id, $Client_Id)
    {
        dd('we are about to move to recycle bin');
    }

    public function MultipleDelete()
    {
        $check_bal = BalanceLedger::WhereIn('Client_Id', $this->Checked)->get();
        if ($check_bal->isNotEmpty()) {
            $temp = collect([]);
            foreach ($check_bal as $get_id) {
                $bal = $get_id['Balance'];
                if ($bal > 0) {
                    $temp->push([
                        'Id' => $get_id['Client_Id'],
                        'Description' => $get_id['Description'],
                        'Total_Amount' => $get_id['Total_Amount'],
                        'Amount_Paid' => $get_id['Amount_Paid'],
                        'Balance' => $bal
                    ]);
                }
            }
            $this->FilterChecked = $temp->pluck('Id')->toArray();
            $this->collection = $temp;
            $Checked = array_diff($this->Checked, $this->FilterChecked);
            $del_credit = CreditLedger::whereKey($Checked)->delete();
            if ($del_credit) {
                session()->flash('SuccessMsg', count($Checked) . ' Records Deleted Successfully..');
            } else {
                session()->flash('Error', 'Records Unable to Delete..');
            }
        } else {
            $del_credit = CreditLedger::whereKey($this->Checked)->delete();
            if ($del_credit) {
                session()->flash('SuccessMsg', count($this->Checked) . ' Records Deleted Successfully..');
            } else {
                session()->flash('Error', count($this->Checked) . ' Records Unable to Delete..');
            }
        }
    }

    public function Register($Id)
    {
        $fetch = Application::Where('Id', $Id)->get();
        $client_Id = 'DC' . time();
        foreach ($fetch as $data) {
            $name = $data['Name'];
            $mobile = $data['Mobile_No'];
            $dob = $data['DOB'];
            $relative_name = $data['Relative_Name'];
            $gender = $data['Gender'];
        }
        // Client Registration
        $user_data = new ClientRegister;
        $user_data->Id = $client_Id;
        $user_data->Name = $name;
        $user_data->Relative_Name = $relative_name;
        $user_data->Gender = $gender;
        $user_data->DOB = $dob;
        $user_data->Mobile_No = $mobile;
        $user_data->Email_Id = $name . '@gmail.com';
        $user_data->Address = "Chikkabasthi";
        $user_data->Profile_Image = "Not Available";
        $user_data->Client_Type = "Old Client";
        $user_data->save(); // Client Registered

        session()->flash('SuccessMsg', 'Congratulations!! Client Registered Successfully!, New Client Id is :' . $client_Id);
        return redirect()->route('global_search', $this->search);
    }

    public function ApplicationsbyStatus($key = null)
    {
        $this->resetPage();
        $this->Status = $key;
    }

    public function UpdateStatus($Id, $Status)
    {
        Application::Where('Id', $Id)->update(['Status' => $Status]);
        $notification = [
            'message' => 'Status Updated Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('global_search', $this->search)->with($notification);
    }

    public function SearchResults($key)
    {
        $mobile = (int)$this->search;
        $role = Auth::user()->role;

        $query = function ($query) use ($key, $mobile) {
            $query->where([['Mobile_No', '=', $mobile]])
                  ->orWhere([['Name', '=', $this->search]])
                  ->orWhere([['Id', '=', $this->search]]);
        };

        if ($role == 'branch admin' || $role == 'operator') {
            $this->Registered = ClientRegister::where($query)->where('Branch_Id', '=', $this->Branch_Id)->get();
            $this->search_data = Application::where($query)->where('Recycle_Bin', '=', $this->no)->where('Branch_Id', '=', $this->Branch_Id)
                ->filter(trim($this->filterby))
                ->when($this->Status, function ($query, $status) {
                    return $query->where('Status', '=', $status);
                })
                ->latest()
                ->paginate($this->paginate);
        } else {
            $this->Registered = ClientRegister::where($query)->get();
            $this->search_data = Application::where($query)->where('Recycle_Bin', '=', $this->no)
                ->filter(trim($this->filterby))
                ->when($this->Status, function ($query, $status) {
                    return $query->where('Status', '=', $status);
                })
                ->latest()
                ->paginate($this->paginate);
        }

        $this->Registered_Count = count($this->Registered);
        $this->Search_Count = count($this->search_data);
    }

    public function render()
    {
        if ($this->search != '') {
            $this->SearchResults($this->search);
        } else {
            $role = Auth::user()->role;
            if ($role == 'branch admin' || $role == 'operator') {
                $this->Registered = ClientRegister::where('Branch_Id', '=', $this->Branch_Id)->paginate($this->paginate);
                $this->search_data = Application::where('Recycle_Bin', '=', $this->no)->where('Branch_Id', '=', $this->Branch_Id)
                    ->filter(trim($this->filterby))
                    ->when($this->Status, function ($query, $status) {
                        return $query->where('Status', '=', $status);
                    })
                    ->latest()
                    ->paginate($this->paginate);
            } else {
                $this->Registered = ClientRegister::paginate($this->paginate);
                $this->search_data = Application::where('Recycle_Bin', '=', $this->no)
                    ->filter(trim($this->filterby))
                    ->when($this->Status, function ($query, $status) {
                        return $query->where('Status', '=', $status);
                    })
                    ->latest()
                    ->paginate($this->paginate);
            }

            $this->Registered_Count = count($this->Registered);
            $this->Search_Count = count($this->search_data);
        }

        $this->Search_Count = count($this->search_data);
        $status_list = Status::all();

        return view('livewire.admin-module.application.global-search', [
            'search_data' => $this->search_data,
            'total_count' => $this->total,
            'Search_Count' => $this->Search_Count,
            'Registered' => $this->Registered,
            'Registered_Count' => $this->Registered_Count,
            'Balance' => $this->Balance_Collection,
            'status_list' => $status_list
        ]);
    }
}


