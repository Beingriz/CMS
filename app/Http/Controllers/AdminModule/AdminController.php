<?php

namespace App\Http\Controllers\AdminModule;

use App\Http\Controllers\Controller;
use App\Http\Livewire\UserTopBar;
use App\Models\About_Us;
use App\Models\ApplyServiceForm;
use App\Models\Callback_Db;
use App\Models\Carousel_DB;
use App\Models\EnquiryDB;
use App\Models\HomeSlide;
use App\Models\MainServices;
use App\Models\User;
use App\Models\UserTopBar as ModelsUserTopBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    public $Company_Name;
    public $Branch_Id, $Emp_Id;


    public function HomeIndex()
    {
        $data = HomeSlide::find(1);
        $records = ModelsUserTopBar::Where('Selected', 'Yes')->get();
        foreach ($records as $key) {
            $this->Company_Name = $key['Company_Name'];
        }
        $carousel = Carousel_DB::all();
        $aboutus = About_Us::where('Selected', 'Yes')->get();
        $services = MainServices::where('Service_Type', 'Public')->get();

        return view('user.user_home.user_index', compact('records', 'carousel', 'aboutus', 'services'), ['CompanyName' => $this->Company_Name]);
    }
    // Admin Dashboard Insight Functions.
    public function AdminDashboard()
    {
        $this->Branch_Id = Auth::user()->branch_id;
        $userRole = Auth::user()->role;

        $totalToday = $this->getTotalToday($this->Branch_Id, $userRole);

        $results = $this->getMonthlyEntries($this->Branch_Id, $userRole);

        $totalSales = $this->getTotalSales($this->Branch_Id, $userRole);

        $totalOrders = $this->getTotalOrders($this->Branch_Id, $userRole);

        $newUsers = $this->getNewUsers($this->Branch_Id, $userRole);

        $totalEnquiries = $this->getTotalEnquiries($this->Branch_Id, $userRole);

        $callBack = $this->getCallBack($this->Branch_Id, $userRole);

        $totalRevenue = $this->getTotalRevenue($this->Branch_Id, $userRole);

        $lastWeekAmount = $this->getLastWeekAmount($this->Branch_Id, $userRole);

        $lastMonthAmount = $this->getLastMonthAmount($this->Branch_Id, $userRole);

        return view('admin-module.index', [
            'totalSales' => $totalSales,
            'totalEnquiries' => $totalEnquiries,
            'totalOrders' => $totalOrders,
            'newUsers' => $newUsers,
            'callBack' => $callBack,
            'totalRevenue' => $totalRevenue,
            'lastWeekAmount' => $lastWeekAmount,
            'lastMonthAmount' => $lastMonthAmount
        ]);
    }

        private function getTotalToday($branchId, $role)
        {
            $query = DB::table('digital_cyber_db')
                ->whereDate('created_at', now()->toDateString());

            if ($role == 'branch admin' || $role == 'operator') {
                $query->where('Branch_Id', $branchId);
            }

            return $query->count();
        }

        private function getMonthlyEntries($branchId, $role)
        {
            $query = "
                SELECT YEAR(created_at) AS year,
                    MONTH(created_at) AS month,
                    COUNT(*) AS total_entries
                FROM digital_cyber_db
                WHERE YEAR(created_at) = YEAR(CURRENT_DATE)
                AND MONTH(created_at) = MONTH(CURRENT_DATE)
            ";

            if ($role == 'branch admin' || $role == 'operator') {
                $query .= " AND Branch_Id = ?";
                $query .= " GROUP BY YEAR(created_at), MONTH(created_at)";
                return DB::select($query, [$branchId]);
            }

            $query .= " GROUP BY YEAR(created_at), MONTH(created_at)";
            return DB::select($query);
        }


        private function getTotalSales($branchId, $role)
        {
            $query = DB::table('digital_cyber_db')
                ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
                ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE)')
                ->select(DB::raw('SUM(Amount_Paid) as total_amount'));

            if ($role == 'branch admin' || $role == 'operator') {
                $query->where('Branch_Id', $branchId);
            }

            return $query->value('total_amount');
        }

        private function getTotalOrders($branchId, $role)
        {
            $query = DB::table('digital_cyber_db')
                ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
                ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE)')
                ->select(DB::raw('COUNT(*) as total_orders'));

            if ($role == 'branch admin' || $role == 'operator') {
                $query->where('Branch_Id', $branchId);
            }

            return $query->value('total_orders');
        }

        private function getNewUsers($branchId, $role)
        {
            $query = DB::table('users')
                ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
                ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE)')
                ->select(DB::raw('COUNT(*) as new_users'));

            if ($role == 'branch admin' || $role == 'operator') {
                $query->where('Branch_Id', $branchId);
            }

            return $query->value('new_users');
        }

        private function getTotalEnquiries($branchId, $role)
        {
            $query = DB::table('enquiry_form')
                ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
                ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE)')
                ->select(DB::raw('COUNT(*) as new_enquiries'));

            if ($role == 'branch admin' || $role == 'operator') {
                $query->where('Branch_Id', $branchId);
            }

            return $query->value('new_enquiries');
        }

        private function getCallBack($branchId, $role)
        {
            $query = DB::table('callback')
                ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
                ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE)')
                ->select(DB::raw('COUNT(*) as callback'));

            if ($role == 'branch admin' || $role == 'operator') {
                $query->where('Branch_Id', $branchId);
            }

            return $query->value('callback');
        }

        private function getTotalRevenue($branchId, $role)
        {
            $query = DB::table('credit_ledger')
                ->select(DB::raw('SUM(Amount_Paid) as total_revenue'));

            if ($role == 'branch admin' || $role == 'operator') {
                $query->where('Branch_Id', $branchId);
            }

            return $query->value('total_revenue');
        }

        private function getLastWeekAmount($branchId, $role)
        {
            $query = DB::table('credit_ledger')
                ->whereBetween('created_at', [
                    DB::raw('DATE_SUB(CURDATE(), INTERVAL (DAYOFWEEK(CURDATE()) + 6) DAY)'),
                    DB::raw('DATE_SUB(CURDATE(), INTERVAL (DAYOFWEEK(CURDATE()) - 1) DAY)')
                ]);

            if ($role == 'branch admin' || $role == 'operator') {
                $query->where('Branch_Id', $branchId);
            }

            return $query->sum('Amount_Paid');
        }

        private function getLastMonthAmount($branchId, $role)
        {
            $query = DB::table('credit_ledger')
                ->whereRaw('YEAR(created_at) = YEAR(CURDATE() - INTERVAL 1 MONTH)')
                ->whereRaw('MONTH(created_at) = MONTH(CURDATE() - INTERVAL 1 MONTH)')
                ->select(DB::raw('SUM(Amount_Paid) as total_amount'));

            if ($role == 'branch admin' || $role == 'operator') {
                $query->where('Branch_Id', $branchId);
            }

            return $query->value('total_amount');
        }

        public function DashboardUpdate($name)
        {
            $branchId = Auth::user()->branch_id;
            $userRole = Auth::user()->role;

            $Tittle1 = '';
            $Tittle2 = '';
            $Tittle3 = '';
            $Tittle4 = '';
            $totalRequests = 0;
            $delivered = 0;
            $pending = 0;
            $new = 0;
            $percentpending = 0;
            $percentdelivered = 0;

            if ($name == 'User') {
                $Tittle1 = 'Total Users';
                $Tittle2 = 'New User';
                $Tittle3 = 'Pending';
                $Tittle4 = 'Converted';

                $totalRequests = $this->getTotalRequests(User::class, $branchId, $userRole);
                $delivered = $this->getDelivered(User::class, $branchId, $userRole, 'Completed');
                $pending = $this->getPending(User::class, $branchId, $userRole, 'Completed');
                $new = $this->getNewRequests(User::class, $branchId, $userRole);

            } elseif ($name == 'Orders') {
                $Tittle1 = 'Total Orders';
                $Tittle2 = 'New Orders';
                $Tittle3 = 'Pending';
                $Tittle4 = 'Delivered';

                $totalRequests = $this->getTotalRequests(ApplyServiceForm::class, $branchId, $userRole);
                $delivered = $this->getDelivered(ApplyServiceForm::class, $branchId, $userRole, 'Delivered to Client');
                $pending = $this->getPending(ApplyServiceForm::class, $branchId, $userRole, 'Delivered to Client');
                $new = $this->getNewRequests(ApplyServiceForm::class, $branchId, $userRole);

            } elseif ($name == 'Callback') {
                $Tittle1 = 'Total Requests';
                $Tittle2 = 'New Requests';
                $Tittle3 = 'Converted';
                $Tittle4 = 'Pending';

                $totalRequests = $this->getTotalRequests(Callback_Db::class, $branchId, $userRole);
                $delivered = $this->getDelivered(Callback_Db::class, $branchId, $userRole, 'Completed');
                $pending = $this->getPending(Callback_Db::class, $branchId, $userRole, 'Completed');
                $new = $this->getNewRequests(Callback_Db::class, $branchId, $userRole);

            } elseif ($name == 'Enquiry') {
                $Tittle1 = 'Total Enquiries';
                $Tittle2 = 'New Enquiries';
                $Tittle3 = 'Hot';
                $Tittle4 = 'Completed';

                $totalRequests = $this->getTotalRequests(EnquiryDB::class, $branchId, $userRole);
                $delivered = $this->getDelivered(EnquiryDB::class, $branchId, $userRole, 'Completed');
                $pending = $this->getPending(EnquiryDB::class, $branchId, $userRole, 'Hot', 'Lead_Status');
                $new = $this->getNewRequests(EnquiryDB::class, $branchId, $userRole);
            }

            if ($totalRequests > 0) {
                $percentpending = number_format(($pending * 100) / $totalRequests, 1, '.', '');
                $percentdelivered = number_format(($delivered * 100) / $totalRequests, 1, '.', '');
            }

            return view('admin-module.dashboard.dashboard_update', [
                'Name' => $name,
                'Tittle1' => $Tittle1,
                'Tittle2' => $Tittle2,
                'Tittle3' => $Tittle3,
                'Tittle4' => $Tittle4,
                'totalRequests' => $totalRequests,
                'delivered' => $delivered,
                'pending' => $pending,
                'new' => $new,
                'percentpending' => $percentpending,
                'percentdelivered' => $percentdelivered
            ]);
        }

        private function getTotalRequests($model, $branchId, $role)
        {
            if ($role == 'branch admin' || $role == 'operator') {
                return $model::where('Branch_Id', $branchId)->count();
            }
            return $model::count();
        }

        private function getDelivered($model, $branchId, $role, $status)
        {
            if ($role == 'branch admin' || $role == 'operator') {
                return $model::where('Branch_Id', $branchId)->where('Status', $status)->count();
            }
            return $model::where('Status', $status)->count();
        }

        private function getPending($model, $branchId, $role, $status, $column = 'Status')
        {
            if ($role == 'branch admin' || $role == 'operator') {
                return $model::where('Branch_Id', $branchId)->where($column, '!=', $status)->count();
            }
            return $model::where($column, '!=', $status)->count();
        }

        private function getNewRequests($model, $branchId, $role)
        {
            if ($role == 'branch admin' || $role == 'operator') {
                return $model::where('Branch_Id', $branchId)->whereDate('created_at', DB::raw('CURDATE()'))->count();
            }
            return $model::whereDate('created_at', DB::raw('CURDATE()'))->count();
        }


// -----------------------------------------------Employee Module Functions ------------------------------------

    public function employeeRegistration(){
        $editid='';
        $updateid='';
        $deleteid='';
        return view('admin-module.employee.employee_register',['EditId'=>$editid,'UpdateId'=>$updateid,'DeleteId'=>$deleteid]);
    }
    public function editEmployee($id){
        $editid=$id;
        $updateid='';
        $deleteid='';
        return view('admin-module.employee.employee_register',['EditId'=>$editid,'UpdateId'=>$updateid,'DeleteId'=>$deleteid]);
    }
    public function employeeUpdate($id){
        $editid='';
        $deleteid='';
        $updateid=$id;
        return view('admin-module.employee.employee_register',['EditId'=>$editid,'UpdateId'=>$updateid,'DeleteId'=>$deleteid]);
    }
    public function deleteEmployee($id){
        $editid='';
        $updateid='';
        $deleteid=$id;
        return view('admin-module.employee.employee_register',['EditId'=>$editid,'UpdateId'=>$updateid,'DeleteId'=>$deleteid]);
    }

// Document advisor

    public function AddDocument(){
        $edit='';
        $delete='';
        return view('admin-module.documents.add_document',['Edit_Id'=>$edit,'Delete_Id'=>$delete]);
    }
    public function editDocumet($id){
        $edit=$id;
        $delete='';
        return view('admin-module.documents.add_document',['Edit_Id'=>$edit,'Delete_Id'=>$delete]);
    }
    public function deleteDocument($id){
        $edit='';
        $delete=$id;
        return view('admin-module.documents.add_document',['Edit_Id'=>$edit,'Delete_Id'=>$delete]);
    }
    public function documentAdvisor(){

        return view('admin-module.documents.document_advisor');
    }
//-------------------------------WhatsAPpp-----------------------------
    public function MarketingDashboard()
    {
        return view('admin-module.marketing.marketing');
    }
    public function WhatsappChat()
    {
        return view('whats-app.whatsapp_chatbot');
    }
    public function Templates()
    {
        $sid="";
        return view('whats-app.whatsapp_template_manage',['sid'=>$sid]);
    }
    public function deleteTemplate($sid)
    {
        return view('whats-app.whatsapp_template_manage',['sid'=>$sid]);
    }
    public function Marketing()
    {
        return view('whats-app.whatsapp_marketing_manager');
    }
    public function BlockList()
    {
        return view('whats-app.whatsapp_blocklisted_contacts');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = array(
            'message' => 'You have been logged out Successfully',
            'alert-type' => 'success'
        );
        return redirect('/')->with($notification);
    } //End Destroy Function

    public function ProfileView()
    {
        $id = Auth::user()->id;
        $profiledata = User::find($id);
        return view('admin-module.profile.profile_view', compact('profiledata'));
    }
    public function ChangePassword()
    {
        return view('admin-module.profile.change_password');
    }
    public function AddServices()
    {
        $EditData = '';
        $DeleteData = '';
        $type = '';
        return view('admin-module.Services.add_service', ['EditData' => $EditData, 'DeleteData' => $DeleteData, 'Type' => $type]);
    }
    public function EditServices($Id, $type)
    {
        $EditData = $Id;
        $DeleteData = '';
        return view('admin-module.Services.add_service', ['EditData' => $EditData, 'DeleteData' => $DeleteData, 'Type' => $type]);
    }
    public function DeleteServices($Id, $type)
    {
        $EditData = '';
        $DeleteData = $Id;
        return view('admin-module.Services.add_service', ['EditData' => $EditData, 'DeleteData' => $DeleteData, 'Type' => $type]);
    }

    // Status Functions
    public function AddStatus()
    {
        $EditId='';
        $ViewStatus='';
        $DeleteId='';
        return view('admin-module.status.status',['EditId' => $EditId, 'ViewStatus' => $ViewStatus, 'DeleteId' => $DeleteId]);
    }
    public function EditStatus ($id)
    {
        $EditId=$id;
        $ViewStatus='';
        $DeleteId='';
        return view('admin-module.status.status',['EditId' => $EditId, 'ViewStatus' => $ViewStatus, 'DeleteId' => $DeleteId]);
    }
    public function DeleteStatus ($id)
    {

        $EditId='';
        $ViewStatus='';
        $DeleteId=$id;
        return view('admin-module.status.status',['EditId' => $EditId, 'ViewStatus' => $ViewStatus, 'DeleteId' => $DeleteId]);
    }

// Branches
    public function BranchRegister(){
        $Id='';
        $deleteId = '';
        return view('admin-module.branch.branch_register', ['EditId' => $Id, 'DeleteId' => $deleteId]);
    }
    public function EditBranch($Id)
    {
        $deleteId = '';
        return view('admin-module.branch.branch_register', ['EditId' => $Id, 'DeleteId' => $deleteId]);
    }
    public function DeleteBranch($Id)
    {
        $editId = '';
        return view('admin-module.branch.branch_register', ['EditId' => $editId, 'DeleteId' => $Id]);
    }

    public function UserTopBar()
    {
        $editId = "";
        return view('user.admin_forms.header_footer_form', ['EditData' => $editId]);
    }
    public function Carousel()
    {
        # code...
        $Id = "";
        return view('user.admin_forms.carousel_form', ['EditData' => $Id]);
    }
    public function AboutUs()
    {
        # code...
        $Id = "";
        return view('user.admin_forms.about_us_form', ['EditData' => $Id, 'SelectId' => $Id]);
    }
    public function ContactUs()
    {
        # code...
        return view('user-module.enquiry-form');
    }
    public function DeleteCarousel($Id)
    {
        $getDetials = Carousel_DB::findorFail($Id);
        $img = $getDetials->Image;

        if (Storage::disk('public')->exists($img)) // Check for existing File
        {
            unlink(storage_path('app/public/' . $img)); // Deleting Existing File
        }
        Carousel_DB::where('Id', $Id)->delete();
        $notification = array(
            'message' => 'Deleted Succssfully',
            'alert-type'  => 'info'
        );
        return redirect()->back()->with($notification);
    }
    public function EditCarousel($Id)
    {
        return view('user.admin_forms.carousel_form', ['EditData' => $Id]);
    } //End Function

    public function EditAboutUs($Id)
    {
        $selectId = "";
        return view('user.admin_forms.about_us_form', ['EditData' => $Id, 'SelectId' => $selectId]);
    } //End Function

    public function SelectAbout($Id)
    {
        $editId = "";
        return view('user.admin_forms.about_us_form', ['EditData' => $editId, 'SelectId' => $Id]);
    } //End Function

    public function DeleteAboutUs($Id)
    {
        $fetch = About_Us::findorFail($Id);
        $image = $fetch['Image'];
        if (Storage::disk('public')->exists($image)) // Check for existing File
        {
            unlink(storage_path('app/public/' . $image)); // Deleting Existing File
        }
        About_Us::Where('Id', '=', $Id)->delete();
        $notification = array(
            'message' => 'Record Deleted!',
            'alert-type' => 'danger'
        );
        return redirect()->route('new.about_us')->with($notification);
    }
    public function EditHeader($Id)
    {
        $editId = "";
        return view('user.admin_forms.header_footer_form', ['EditData' => $editId,]);
    } //End Function

    public function DataMigration()
    {
        return view('admin-module.Data_Migration.data_migration');
    }
}
