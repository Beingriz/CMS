<?php

namespace App\Http\Livewire\AdminModule\Application;

use App\Models\Application;
use App\Models\Bookmark;
use App\Models\Bookmarks;
use App\Models\MainServices;
use App\Models\Status;
use App\Models\SubServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DynamicDashboard extends Component
{
    use WithPagination;

    // Properties
    protected $paginationTheme = 'bootstrap';
    public $servicename;
    public $SubServices;
    public $status;
    public $MainServiceId;
    public $Sub_Serv_Name;
    public $Serv_Name;
    public $status_count;
    protected $StatusDetails = [];
    public $n = 1;
    public $ShowTable = false;
    public $temp_count = 0;
    public $ChangedStaus;
    public $status_name, $paginate = 5, $filterby;
    public $Branch_Id, $Emp_Id;

    // Initialize component with MainServiceId and user details
    public function mount($MainServiceId)
    {
        $this->MainServiceId = $MainServiceId;
        $this->Branch_Id = Auth::user()->branch_id;
        $this->Emp_Id = Auth::user()->Emp_Id;
    }

    // Refresh the page and reset pagination
    public function RefreshPage()
    {
        $this->resetPage();
    }

    // Change service and update statuses
    public function ChangeService($Sub_Serv_Name)
    {
        $this->Serv_Name = MainServices::Where('Id', $this->MainServiceId)->value('Name');
        $this->Sub_Serv_Name = $Sub_Serv_Name;

        // Retrieve and update status counts
        $this->status = DB::table('status')
            ->where('Relation', $this->Serv_Name)
            ->orWhere('Relation', 'General')
            ->orderBy('Orderby', 'asc')
            ->get();

        if ($this->status->isNotEmpty()) {
            $n = 0;
            $No = 'No';

            foreach ($this->status as $item) {
                $status_name = $item->Status;
                DB::update('update status set Temp_Count=? where status=?', [$n, $status_name]);

                // Count applications based on user role and update status
                $role = Auth::user()->role;
                $query = DB::table('digital_cyber_db')
                    ->where('Application', $this->Serv_Name)
                    ->where('Application_Type', $Sub_Serv_Name)
                    ->where('Status', $status_name)
                    ->where('Recycle_Bin', $No);

                if ($role == 'branch admin' || $role == 'operator') {
                    $query->where('Branch_Id', $this->Branch_Id);
                }

                $count = $query->count();
                DB::update('update status set Temp_Count=? where status=?', [$count, $status_name]);
            }
        }

        $this->ShowTable = false;
        $this->temp_count = 1;
        $this->resetPage();
    }

    // Show details for a specific status
    public function ShowDetails($name)
    {
        $this->status_name = $name;
        $this->ShowTable = true;
        $this->resetPage();
    }

    // Update application status
    public function updateStatus(int $id, string $pstatus, string $ustatus, string $subserv): void
    {
        $this->updateApplicationStatus($id, $ustatus);
        $this->flashSuccessMessage($pstatus, $ustatus);
        $this->ShowTable = false;

        $this->updateServiceNotifications();
        $this->changeService($subserv);
        $this->showDetails($pstatus);
        $this->resetPage();
    }

    // Helper function to update application status
    private function updateApplicationStatus(int $id, string $ustatus): void
    {
        $data = [
            'Status' => $ustatus,
            'updated_at' => Carbon::now(),
        ];
        Application::where('Id', $id)->update($data);
    }

    // Helper function to flash success message
    private function flashSuccessMessage(string $pstatus, string $ustatus): void
    {
        session()->flash('SuccessMsg', 'The Status has been Changed From ' . $pstatus . ' to ' . $ustatus . ' Successfully');
    }

    // Update service notifications
    private function updateServiceNotifications(): void
    {
        $mainServices = MainServices::all();
        $today = Carbon::today();

        foreach ($mainServices as $service) {
            $this->updateNotificationCount($service->Name, $today);
        }
    }

    // Helper function to update notification count
    private function updateNotificationCount(string $serviceName, Carbon $today): void
    {
        $notification = 0;
        $no = 'No';

        $query = DB::table('digital_cyber_db')
            ->where('Application', $serviceName)
            ->where('Status', 'Received')
            ->where('Recycle_Bin', $no);

        $role = Auth::user()->role;
        if ($role == 'branch admin' || $role == 'operator') {
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $checkStatus = $query->get();
        DB::update('update service_list set Temp_Count = ? where Name = ?', [$notification, $serviceName]);

        foreach ($checkStatus as $count) {
            $receivedDate = new Carbon($count->Received_Date);
            $diffDays = $receivedDate->diffInDays($today);

            if ($diffDays >= 2) {
                $notification += 1;
                DB::update('update service_list set Temp_Count = ? where Name = ?', [$notification, $serviceName]);
            }
        }
    }

    // Update service type and relevant notifications
    public function UpdateServiceType($Id, $ptype, $utype, $pstatus)
    {
        // Update application type in the database
        $data = [
            'Application_Type' => $utype,
            'updated_at' => Carbon::now(),
        ];
        Application::where('Id', $Id)->update($data);

        session()->flash('SuccessMsg', 'The Service Type has been Changed From ' . $ptype . ' to ' . $utype . ' Successfully');

        $this->updateMainSerivcesNotification();
        $this->updateSubServiceCount($this->MainServiceId);
        $this->ChangeService($ptype);
        $this->ShowDetails($pstatus);
        $this->ShowTable = true;
        $this->resetPage();
    }

    // Update notifications for main services
    public function updateMainSerivcesNotification()
    {
        $mainServices = MainServices::all();
        $today = Carbon::today();

        foreach ($mainServices as $service) {
            $notification = 0;
            $role = Auth::user()->role;
            $query = DB::table('digital_cyber_db')
                ->where('Application', $service->Name)
                ->where('Status', 'Received')
                ->where('Recycle_Bin', 'No');

            if ($role == 'branch admin' || $role == 'operator') {
                $query->where('Branch_Id', $this->Branch_Id);
            }

            $checkStatus = $query->get();
            foreach ($checkStatus as $count) {
                $receivedDate = new Carbon($count->Received_Date);
                $diffDays = $receivedDate->diffInDays($today);

                if ($diffDays >= 2) {
                    $notification += 1;
                    MainServices::where('Name', $service->Name)->update(['Temp_Count' => $notification]);
                }
            }
        }
    }

    // Update counts for sub-services
    public function updateSubServiceCount($MainServiceId)
    {
        $subServices = SubServices::where('Service_Id', $MainServiceId)->get();
        foreach ($subServices as $item) {
            $name = $item->Name;
            $count = Application::where('Branch_Id', $this->Branch_Id)
                ->where('Application_Type', $name)
                ->where('Recycle_Bin', 'No')
                ->count();
            SubServices::where('Name', $name)->update(['Total_Count' => $count]);
        }
    }

    // Render the component view
    public function render()
    {
        $this->Serv_Name = MainServices::where('Id', $this->MainServiceId)->value('Name');
        $this->SubServices = SubServices::where('Service_Id', $this->MainServiceId)->get();

        // Retrieve statuses
        $this->status = DB::table('status')
            ->where('Relation', $this->Serv_Name)
            ->orWhere('Relation', 'General')
            ->orderBy('Orderby', 'asc')
            ->get();

        // Retrieve bookmarks
        $bookmarks = Bookmark::where('Relation', $this->Serv_Name)->orderBy('Name', 'asc')->get();

        // Retrieve status details based on user role
        $role = Auth::user()->role;
        $query = Application::where('Application', $this->Serv_Name)
            ->where('Application_Type', $this->Sub_Serv_Name)
            ->where('Status', trim($this->status_name))
            ->where('Recycle_Bin', 'No')
            ->filter(trim($this->filterby))
            ->orderBy('Received_Date', 'desc');

        if ($role == 'branch admin' || $role == 'operator') {
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $statusDetails = $query->paginate($this->paginate);

        // Return view with data
        return view('livewire.admin-module.application.dynamic-dashboard', compact('statusDetails'), [
            'status' => $this->status,
            'ServName' => $this->Serv_Name,
            'bookmarks' => $bookmarks,
            'SubServices' => $this->SubServices,
            'n' => $this->n,
        ]);
    }
}

