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
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class GlobalSearch extends Component
{
    use WithPagination;
    use RightInsightTrait;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['SearchResult'];
    public $search;
    public $Checked = [];
    public $filterby, $created, $updated;
    public $count;
    public $total;
    protected $search_data;
    public $collection, $n = 1;
    public $paginate = 5;

    public $Name;
    public $Registered;
    public $Client_Id;
    public $Mobile_No;
    public $Service_Count;
    public $Pending_App;
    public $Delivered;
    public $Balance;
    public $Revenue;
    public $Registered_Count = 0;
    public $Search_Count = 0;
    public $filtered;
    public $Balance_Collection = [];
    public $Status = NULL, $byStatus, $StatusCount, $FilterChecked;

    public function mount($key)
    {
        $this->search = $key;
    }
    public function SingleDelete($Id, $Client_Id)
    {
        $check_bal = BalanceLedger::Where([['Id', $Id], ['Client_Id', $Client_Id]])->get();
        if (sizeof($check_bal) > 0) {
            foreach ($check_bal as $bal) {
                $balance = $bal['Balance'];
            }
            if ($balance > 0) {
                $this->Balance_Collection = $check_bal;
            }
        } else {
            $check_app = Application::Where([['Id', $Id], ['Client_Id', $Client_Id]])->get();
            if (sizeof($check_app) > 0) {
                foreach ($check_app as $bal) {
                    $balance = $bal['Balance'];
                }
                if ($balance > 0) {
                    $this->Balance_Collection = $check_app;
                    // dd('Balance Found');
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
        if (sizeof($fetch_bal) > 0) {
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
            if (sizeof($fetch_app) > 0) {
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
        dd('we are about to move to recycle bil');
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
        $this->render();
        session()->flash('SuccessMsg', 'Congratulations!!  Client Registered Successfully!, New Client Id is :' . $client_Id);
        return redirect()->route('global_search', $this->search);
    }

    public function ApplicationsbyStatus($key = null)
    {
        $this->resetPage();
        $this->Status = $key;
    }
    public function UpdateStatus($Id, $Status)
    {
        $data = array();
        $data['Status'] = $Status;
        Application::Where('Id', $Id)->update($data);
        $notification = array(
            'message' => 'Status Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('global_search', $this->search)->with($notification);
    }
    public function SearchResults($key)
    {
        $mobile = (int)$this->search;
        $this->Registered = ClientRegister::Where('Mobile_No', $mobile)
            ->orWhere('Name', $this->search)
            ->orWhere('Id', $this->search)
            ->get();

        $this->search_data = Application::where([['Mobile_No', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Name', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Id', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Ack_No', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Client_Id', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->filter(trim($this->filterby))
            ->when($this->Status, function ($query, $status) {
                return $query->where('Status', $status);
            })
            ->paginate($this->paginate);
        $this->Search_Count = count($this->search_data);

        $this->Service_Count = Application::where([['Mobile_No', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Name', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Id', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Ack_No', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Client_Id', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->count();

        $search_data = Application::where([['Mobile_No', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Name', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Id', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Ack_No', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Client_Id', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->get();

        $this->StatusCount = Application::where([['Mobile_No', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Name', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Id', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Ack_No', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->orWhere([['Client_Id', '=', $key], ['Recycle_Bin', '=', $this->no]])
            ->filter(trim($this->filterby))
            ->when($this->Status, function ($query, $status) {
                return $query->where('Status', $status);
            })->count();

        $this->Delivered = 0;
        $Balance = 0;
        $Revenue = 0;
        foreach ($search_data as $data) {
            $status  = $data['Status'];
            if ($status == "Delivered to Client") {
                $this->Delivered += 1;
            }
            $Balance += $data['Balance'];
            $Revenue += $data['Amount_Paid'];
        }
        $this->Balance = $Balance;
        $this->Revenue = $Revenue;
        $this->Pending_App = $this->Service_Count - $this->Delivered;
        return $this->search_data;
    }

    public function render()
    {
        $this->SearchResults($this->search);
        $this->resetPage();
        $temp = collect([]);
        $temp_count = [];
        foreach ($this->search_data as $data) {
            $this->filtered = ClientRegister::Where('Mobile_No', $data['Mobile_No'])->get();
            foreach ($this->filtered as $found) {
                array_push($temp_count, $found['Id']);

                DB::update('update digital_cyber_db set Registered = ?,Client_Id = ? where Mobile_No = ?', ['Yes', $found['Id'], $found['Mobile_No']]);
            }
        }
        $this->filtered = array_unique($temp_count);
        if (sizeof($temp_count) >= 1) {
            foreach ($this->filtered as $data) {
                $details = ClientRegister::where('Id', $data)->get();

                foreach ($details as $data) {
                    $Id = $data['Id'];
                    $this->Name = $data['Name'];
                    $Relative_Name = $data['Relative_Name'];
                    $mobile = $data['Mobile_No'];
                    $address = $data['Address'];
                    $dob = $data['DOB'];
                    $gender = $data['Gender'];
                    $client_type = $data['Client_Type'];
                    $created_at = $data['created_at'];
                    $updated_at = $data['updated_at'];
                    $old_profile_image = $data['Profile_Image'];
                    $temp->push(['Id' => $Id, 'Name' => $this->Name, 'Relative_Name' => $Relative_Name, 'Gender' => $gender, 'Mobile_No' => $mobile, 'Address' => $address, 'Client_Type' => $client_type, 'DOB' => $dob, 'created_at' => $created_at, 'Profile_Image' => $old_profile_image, 'updated_at' => $updated_at]);
                }
            }
            $this->Registered_Count = sizeof($temp);
            $this->Registered = $temp;
        }
        $status_list = Status::all();


        return view('livewire.admin-module.application.global-search', [
            'search_data' => $this->search_data, 'n' => $this->n, 'status_list' => $status_list,
        ]);
    }
}
