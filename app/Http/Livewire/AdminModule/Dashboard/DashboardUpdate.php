<?php

namespace App\Http\Livewire\AdminModule\Dashboard;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardUpdate extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Public properties to hold various states and data
    public $Records, $Key, $key, $User = false, $Orders = false, $Callback = false, $created, $Enquiry = false;

    // Mount method to initialize component with the provided key
    public function mount($Key)
    {
        $this->Key = $Key;
    }

    // Method to update user role to admin
    public function UpdateAdmin($Id)
    {
        $data = [
            'role' => 'admin',
            'updated_at' => Carbon::now(),
        ];

        DB::table('users')->where('id', $Id)->update($data);

        $notification = [
            'message' => 'User changed from USER to ADMIN',
            'alert-type' => 'info',
        ];

        return redirect()->back()->with($notification);
    }

    // Method to update user role to user
    public function UpdateUser($Id)
    {
        $data = [
            'role' => 'user',
            'updated_at' => Carbon::now(),
        ];

        DB::table('users')->where('id', $Id)->update($data);

        $notification = [
            'message' => 'User changed from Admin to USER',
            'alert-type' => 'info',
        ];

        return redirect()->back()->with($notification);
    }

    // Render method to fetch and prepare data for rendering the view
    public function render()
    {
        // Determine the table and state based on the Key
        switch ($this->Key) {
            case 'User':
                $table = 'users';
                $this->setState(true, false, false, false);
                break;
            case 'Orders':
                $table = 'applynow';
                $this->setState(false, true, false, false);
                $this->key = 'Delivered to Client';
                break;
            case 'Callback':
                $table = 'callback';
                $this->setState(false, false, true, false);
                $this->key = 'Completed';
                break;
            case 'Enquiry':
                $table = 'enquiry_form';
                $this->setState(false, false, false, true);
                $this->key = 'Completed';
                break;
            default:
                $table = 'digtial_cyber_db';
                break;
        }

        // Fetch records with pagination and filters based on role
        $records = DB::table($table)
            ->when($this->isBranchAdminOrOperator(), function ($query) {
                $query->where('Branch_Id', Auth::user()->branch_id);
            })
            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
            ->where('Status', '!=', $this->key)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Format the created_at date for each record
        $this->created = $records->map(function ($record) {
            return Carbon::parse($record->created_at)->diffForHumans();
        });

        // Return the view with the fetched data
        return view('livewire.admin-module.dashboard.dashboard-update', compact('records'));
    }

    // Helper method to set the state for User, Orders, Callback, and Enquiry
    private function setState($user, $orders, $callback, $enquiry)
    {
        $this->User = $user;
        $this->Orders = $orders;
        $this->Callback = $callback;
        $this->Enquiry = $enquiry;
    }

    // Helper method to check if the user is a branch admin or operator
    private function isBranchAdminOrOperator()
    {
        return in_array(Auth::user()->role, ['branch admin', 'operator']);
    }
}

