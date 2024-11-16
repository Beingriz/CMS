<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Callback_Db;
use App\Models\DocumentFiles;
use App\Models\EnquiryDB;
use App\Models\Status;
use App\Models\SubServices;
use App\Traits\RightInsightTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF; // Import the PDF facade

class ApplicationController extends Controller
{
    use RightInsightTrait;


    public $total_amount;
    public $no='No';
    public function index()
    {

        $this->Dashboard();
        return view('admin-module.application.new_application');
    }

    public function updateApplication()
    {
        return view('admin-module.application.update_application');
    }

    public function Home()
    {

        return view('admin-module.application.app_dashboard',);
    }

    public function genInvoice($id)
    {
        $data = [
            'Client_Id' => $id,
            // Add other necessary data here
        ];
        $pdf = PDF::loadView('admin-module.invoice.print_ack', $data)
        ->setPaper('a5', 'portrait'); // Set paper size to A5

        return $pdf->stream('invoice.pdf');
    }


    //Applicaiton Dashboard Calculation..
    public function Dashboard()
{
    $branchId = Auth::user()->branch_id;
    $role = Auth::user()->role;
    $isBranchAdmin = $role === 'branch admin' || $role === 'operator';

    // Live data for Main Services
    $mainServicesData = $this->getMainServicesData($branchId, $isBranchAdmin);

    // Live data for Status Records
    $statusData = $this->getStatusData();

    return view('admin-module.application.app_dashboard', [
        'total_application' => $this->applications_served,
        'total_amount' => $this->total_amount,
        'Mainservices' => $mainServicesData,
        'applications_served' => $this->applications_served,
        'previous_day_app' => $this->previous_day_app,
        'applications_delivered' => $this->applications_delivered,
        'previous_day_app_delivered' => $this->previous_day_app_delivered,
        'total_revenue' => $this->sum,
        'previous_revenue' => $this->previous_sum,
        'balance_due' => $this->balance_due_sum,
        'previous_bal' => $this->previous_bal_sum,
        'new_clients' => $this->new_clients,
        'previous_day_new_clients' => $this->previous_day_new_clients,
        'bookmarks' => $this->bookmarks,
    ]);
}

private function getMainServicesData($branchId, $isBranchAdmin)
{
    $data = [];
    foreach ($this->MainServices as $key) {
        $query = Application::where('Application', $key['Name']);

        if ($isBranchAdmin) {
            $query->where('Branch_Id', $branchId);
        }

        $application_total_count = $query->count();
        $total_amount = DB::table('digital_cyber_db')
            ->where('Application', $key['Name'])
            ->when($isBranchAdmin, function ($q) use ($branchId) {
                return $q->where('Branch_Id', $branchId);
            })
            ->sum('Amount_Paid');

        $notification = $this->calculateNotifications($key['Name'], $branchId, $isBranchAdmin);

        $data[] = [
            'Id' => $key['Id'],
            'Name' => $key['Name'],
            'Thumbnail' => $key['Thumbnail'],
            'Total_Count' => $application_total_count,
            'Temp_Count' => $notification,
            'Total_Amount' => $total_amount,
        ];
    }
    return $data;
}

private function calculateNotifications($applicationName, $branchId, $isBranchAdmin)
{
    $query = Application::where('Application', $applicationName)
        ->where('Status', 'Received')
        ->where('Recycle_Bin', 'No');

    if ($isBranchAdmin) {
        $query->where('Branch_Id', $branchId);
    }

    $today = now();
    $notifications = $query->get()->filter(function ($item) use ($today) {
        $received_date = new Carbon($item->Received_Date);
        return $received_date->diffInDays($today) >= 2;
    })->count();

    return $notifications;
}

private function getStatusData()
{
    $statusRecords = Status::all();
    $data = [];

    foreach ($statusRecords as $item) {
        $name = $item->Status;

        $amount = DB::table('digital_cyber_db')
            ->where('Status', $name)
            ->sum('Total_Amount');

        $count = DB::table('digital_cyber_db')
            ->where('Status', $name)
            ->count();

        $data[] = [
            'Status' => $name,
            'Total_Amount' => $amount,
            'Total_Count' => $count,
        ];
    }

    return $data;
}

    public function DynamicDashboard($MainServiceId)
    {
        $branch_id = Auth::user()->branch_id;
        $No = 'No';
        $Sub_Services = SubServices::Where('Service_Id', $MainServiceId)->get();
        $role = Auth::user()->role;
        if (count($Sub_Services) > 0) {
            foreach ($Sub_Services as $item) { {
                    $name = $item['Name'];
                    if($role == 'branch admin' || $role == 'operator'){
                        $count = Application::Where([['Branch_Id', $branch_id],['Application_Type', $name], ['Recycle_Bin', $No]])->count();
                        DB::update('update sub_service_list set Total_Count=?  where Name = ?', [$count, $name]);
                    }else {
                        $count = Application::Where([['Application_Type', $name], ['Recycle_Bin', $No]])->count();
                        DB::update('update sub_service_list set Total_Count=?  where Name = ?', [$count, $name]);
                    }
                   }
            }
        }
        $a = 0;
        $b = 1;
        DB::update('update status set Temp_Count=?  where?', [$a, $b]);
        return view('admin-module.application.app_dynamic_dashboard', [
            'MainServiceId' => $MainServiceId,
        ]);
    }

    public function Edit($Id)
    {
        return view('admin-module.application.edit_app', ['application_type' => $this->application_type, 'payment_mode' => $this->payment_mode, 'sl_no' => $this->sl_no, 'n' => $this->n, 'daily_applications' => $this->daily_applications, 'applications_served' => $this->applications_served, 'previous_day_app' => $this->previous_day_app, 'applications_delivered' => $this->applications_delivered, 'previous_day_app_delivered' => $this->previous_day_app_delivered, 'total_revenue' => $this->sum, 'previous_revenue' => $this->previous_sum, 'balance_due' => $this->balance_due_sum, 'previous_bal' => $this->previous_bal_sum, 'Id' => $Id, 'ForceDelete' => $this->ForceDelete]);
    }
    public function deleteApp($Id)
    {
        // Check balance due in digital_cyber_db
        $check_bal_app = DB::table('digital_cyber_db')
            ->where('Id', $Id)
            ->where('Balance', '>', 0)
            ->exists();

        // Check balance due in balance_ledger
        $check_bal = DB::table('balance_ledger')
            ->where('Client_Id', $Id)
            ->where('Balance', '>', 0)
            ->exists();

        // Check balance due in credit_ledger
        $check_bal_credit = DB::table('credit_ledger')
            ->where('Client_Id', $Id)
            ->where('Balance', '>', 0)
            ->exists();


        if ($check_bal_app && $check_bal && $check_bal_credit) {
            session()->flash('Error', 'Balance Due Found for this Application Id: ' . $Id . ' Please Clear Due and try again!');
        } elseif ($check_bal_app && $check_bal) {
            session()->flash('Error', 'Balance Due Found in Balance Ledger for this Application Id: ' . $Id . ' Please Clear Due and try again!');
        } elseif ($check_bal_app && $check_bal_credit) {
            session()->flash('Error', 'Balance Due Found in Credit Ledger for this Application Id: ' . $Id . ' Please Clear Due and try again!');
        } elseif ($check_bal_app) {
            session()->flash('Error', 'Balance Due Found only In Application for this Application Id: ' . $Id . ' Please Clear Due and try again!');
        } else {
            // Update record to recycle bin if no balance due found
            $recyble_app = DB::table('digital_cyber_db')->where('Id', $Id)->update(['Recycle_Bin' => 'Yes']);
            if ($recyble_app) {
                $checkCreditLedger = DB::table('credit_ledger')->where('Id',$Id)->exists();
                if($checkCreditLedger){
                    DB::table('credit_ledger')->where('Id',$Id)->delete();
                }
                return redirect()->route('new.application')->with('SuccessMsg', 'Record for Application Id: ' . $Id . ' Deleted!');
            }
             //check credit ledger to delete same entry

        }
    }

    public function Download_Ack($Id)
    {
        $fetch = Application::wherekey($Id)->get();
        if ($fetch != NULL) {
            foreach ($fetch as $key) {
                $file = $key['Ack_File'];
            }

            if (Storage::disk('public')->exists($file)) {
                return response()->download(public_path('storage/' . $file));
            } else {
                session()->flash('Error', 'Acknowledgment File Not Available!');
                return redirect()->back();
            }
        } else {
            session()->flash('Error', 'Acknowledgment File Not Available!');
            return redirect()->back();
        }
    }
    public function Download_Doc($Id)
    {
        $fetch = Application::wherekey($Id)->get();
        if ($fetch != NULL) {
            foreach ($fetch as $key) {
                $file = $key['Doc_File'];
            }
            if (Storage::disk('public')->exists($file)) {
                return response()->download(public_path('storage/' . $file));
            } else {
                session()->flash('Error', 'Document File Not Available!');
                return redirect()->back();
            }
        } else {
            session()->flash('Error', 'Document File Not Available!');
            return redirect()->back();
        }
    }
    public function Download_Pay($Id)
    {
        $fetch = Application::wherekey($Id)->get();
        foreach ($fetch as $key) {
            $file = $key['Payment_Receipt'];
        }
        if ($file != NULL) {
            if (Storage::disk('public')->exists($file)) {
                return response()->download(public_path('storage/' . $file));
            } else {
                session()->flash('Error', 'Payment File Not Available!');
                return redirect()->back();
            }
        } else {
            session()->flash('Error', 'Payment File Not Available!');
            return redirect()->back();
        }
    }
    public function Download_Files($Doc_Id)
    {

        $fetch = DocumentFiles::wherekey($Doc_Id)->get();
        foreach ($fetch as $key) {
            $file = $key['Document_Path'];
            $Id = $key['App_Id'];
        }
        if (Storage::disk('public')->exists($file)) {
            return response()->download(public_path('storage/' . $file));
        } else {
            session()->flash('Error', 'Document File Not Available!');
            return redirect()->back();
        }
    }

    public function Delete_File($Id)
    {
        $check = DocumentFiles::wherekey($Id)->get();
        foreach ($check as $key) {
            $name = $key['Document_Name'];
            $file = $key['Document_Path'];
        }
        // dd($file);
        if (Storage::disk('public')->exists($file)) {
            // dd('found file');
            unlink('storage/' . $file);
            DocumentFiles::wherekey($Id)->delete();
            session()->flash('SuccessMsg', $name . ' File Deleted Successfully');
            return redirect()->back();
        } else {
            session()->flash('Error', $name . ' File Not Exist');
            return redirect()->back();
        }
    }
    public function MultipleDocDelete(Request $req, $array)
    {
        dd($req);
        $check = DocumentFiles::whereIn($array)->get();
        dd($check);
        foreach ($check as $key) {
            $file = $key['Document_Path'];
        }
    }

    public function Update(Request $request, $Id)
    {

        $rule = ['Name' => 'required', 'Mobile_No' => ['required', 'min:10'], 'Application_Type' => 'required', 'DOB' => 'required', 'Total_Amount' => 'required', 'Amount_Paid' => 'required', 'Balance' => 'required', 'Payment_Mode' => 'required'];
        $validation = Validator::make($request->input(), $rule);
        if ($validation->fails()) {
            return redirect('/update_app/' . $Id)->withInput()->withErrors($validation);
        }
        // Application will save in Digital Cyber DB , Pan Card , and Credit Ledger
        elseif ($request->Application_Type == "New Pan Card" || $request->Application_Type == "Pan Card Correction" || $request->Application_Type == "Reprint Pan Card") {
            $validate = $request->input();
            // Update application in Digital Cyber DB and Pan Card DB
            // Digital Cyber DB
            DB::update('update digital_cyber_db set Application_Type = ?,Name=?,Mobile_No=?,Dob=?,Ack_No=?,Document_No=?,Total_Amount=?,Amount_Paid=?,Balance=?,Payment_Mode=? where Id = ?', [$validate['Application_Type'], $validate['Name'], $validate['Mobile_No'], $validate['DOB'], $validate['Ack_No'], $validate['Document_No'], $validate['Total_Amount'], $validate['Amount_Paid'], $validate['Balance'], $validate['Payment_Mode'], $Id]);
            // Pan Card Db
            DB::update('update pan_card set Application_Type = ?,Name=?,Mobile_No=?,Dob=?,Ack_No=?,Pan_No=?,Total_Amount=?,Amount_Paid=?,Balance=?,Payment_Mode=? where Id = ?', [$validate['Application_Type'], $validate['Name'], $validate['Mobile_No'], $validate['DOB'], $validate['Ack_No'], $validate['Document_No'], $validate['Total_Amount'], $validate['Amount_Paid'], $validate['Balance'], $validate['Payment_Mode'], $Id]);
            // Credit Ledger
            $desc = "Received Rs. " . $validate['Amount_Paid'] . "/- From  " . $validate['Name'] . " for " . $validate['Application_Type'] . ", on " . $this->today . " by  " . $validate['Payment_Mode'];

            DB::update('update credit_ledger set Source = ?,Date=?,Amount=?,Description=?,Payment_Mode=? where Id = ?', [$validate['Application_Type'], $this->today, $validate['Amount_Paid'], $desc, $validate['Payment_Mode'], $Id]);

            return redirect('/edit_app/' . $Id)->with('SuccessUpdate', 'Applicatin Updated Successfully');
        }
        // Application will save only in Digital Cyber and Credit Ledger
        else {
            $validate = $request->input();
            // Update application only in Digital Cyber DB

            // Digital Cyber DB
            DB::update('update digital_cyber_db set Application_Type = ?,Name=?,Mobile_No=?,Dob=?,Ack_No=?,Document_No=?,Total_Amount=?,Amount_Paid=?,Balance=?,Payment_Mode=? where Id = ?', [$validate['Application_Type'], $validate['Name'], $validate['Mobile_No'], $validate['DOB'], $validate['Ack_No'], $validate['Document_No'], $validate['Total_Amount'], $validate['Amount_Paid'], $validate['Balance'], $validate['Payment_Mode'], $Id]);

            // Credit Ledger
            $desc = "Received Rs. " . $validate['Amount_Paid'] . "/- From  " . $validate['Name'] . " for " . $validate['Application_Type'] . ", on " . $this->today . " by  " . $validate['Payment_Mode'];

            DB::update('update credit_ledger set Source = ?,Date=?,Amount=?,Description=?,Payment_Mode=? where Id = ?', [$validate['Application_Type'], $this->today, $validate['Amount_Paid'], $desc, $validate['Payment_Mode'], $Id]);
            return redirect('/edit_app/' . $Id)->with('SuccessUpdate', 'Applicatin Updated Successfully');
        }
    }

    public function List()
    {
        $Id =  "DCA" . date("Y") . date("m") . mt_rand(100, 999);
        $total = 0;
        foreach ($this->daily_app_amount as $key) {
            $key  = get_object_vars($key); {
                $total += $key['Amount_Paid'];
            }
        }

        // Code for insight Data Records are fetched from Right Insight Traits


        // Returns the Values to New Form
        return view('Application\new_app', ['daily_applications' => $this->daily_applications, 'daily_total' => $total, 'application_type' => $this->application_type, 'payment_mode' => $this->payment_mode, 'Id' => $Id, 'sl_no' => $this->sl_no, 'n' => $this->n, 'applications_served' => $this->applications_served, 'previous_day_app' => $this->previous_day_app, 'applications_delivered' => $this->applications_delivered, 'previous_day_app_delivered' => $this->previous_day_app_delivered, 'total_revenue' => $this->sum, 'previous_revenue' => $this->previous_sum, 'balance_due' => $this->balance_due_sum, 'previous_bal' => $this->previous_bal_sum, 'today' => $this->today]);
    }
    public function PreviousDay()
    {
        $Id =  "DCA" . date("Y") . date("m") . mt_rand(100, 999);
        $previous_day_app = DB::table('digital_cyber_db')->where([['Received_Date', '=', $this->previous_day], ['Recycle_Bin', '=', $this->no]])->paginate(5);
        $sl_no = DB::table('digital_cyber_db')->where([['Received_Date', '=', $this->previous_day], ['Recycle_Bin', '=', $this->no]])->count();
        if ($sl_no > 0) {
            $total = 0;
            foreach ($previous_day_app as $key) {
                $key  = get_object_vars($key); {
                    $total += $key['Amount_Paid'];
                }
            }


            return view('Application\new_app', ['daily_applications' => $previous_day_app, 'total' => $total, 'application_type' => $this->application_type, 'payment_mode' => $this->payment_mode, 'Id' => $Id, 'sl_no' => $sl_no, 'n' => $this->n, 'applications_served' => $this->applications_served, 'previous_day_app' => $this->previous_day_app, 'applications_delivered' => $this->applications_delivered, 'previous_day_app_delivered' => $this->previous_day_app_delivered, 'total_revenue' => $this->sum, 'previous_revenue' => $this->previous_sum, 'balance_due' => $this->balance_due_sum, 'previous_bal' => $this->previous_bal_sum, 'today' => $this->today]);
        } else {
            return redirect('app_form')->with('Error', 'No Records Available for Selected Day i.e' . $this->today);
        }
    }
    public function SelectedDateList($date)
    {
        $no = 'No';
        $Id =  "DCA" . date("Y") . date("m") . mt_rand(100, 999);
        $daily_applications = DB::table('digital_cyber_db')->where([['Received_Date', '=', $date], ['Recycle_Bin', '=', $no]])->paginate(5);
        $sl_no = DB::table('digital_cyber_db')->where([['Received_Date', '=', $date], ['Recycle_Bin', '=', $no]])->count();
        if ($sl_no > 0) {
            $total = 0;
            foreach ($daily_applications as $key) {
                $key  = get_object_vars($key); {
                    $total += $key['Amount_Paid'];
                }
            }

            // Code for insight Data Records


            return view('Application\new_app', ['daily_applications' => $daily_applications, 'total' => $total, 'application_type' => $this->application_type, 'payment_mode' => $this->payment_mode, 'Id' => $Id, 'sl_no' => $sl_no, 'n' => $this->n, 'applications_served' => $this->applications_served, 'previous_day_app' => $this->previous_day_app, 'applications_delivered' => $this->applications_delivered, 'previous_day_app_delivered' => $this->previous_day_app_delivered, 'total_revenue' => $this->sum, 'previous_revenue' => $this->previous_sum, 'balance_due' => $this->balance_due_sum, 'previous_bal' => $this->previous_bal_sum, 'today' => $this->today]);
        } else {
            return redirect('app_form')->with('Error', 'No Records Available for Selected Day i.e' . $date);
        }
    }
    public function BalanceList()
    {
        $no = 'No';
        $balance_list = DB::table('digital_cyber_db')->where([['Balance', '>', 0], ['Recycle_Bin', '=', $no]])->paginate(10);
        $sl_no = DB::table('digital_cyber_db')->where([['Balance', '>', 1], ['Recycle_Bin', '=', $no]])->count();
        // Code for insight Data Records


        return view('Application\balance_list', ['balance_list' => $balance_list, 'sl_no' => $sl_no, 'n' => $this->n, 'applications_served' => $this->applications_served, 'previous_day_app' => $this->previous_day_app, 'applications_delivered' => $this->applications_delivered, 'previous_day_app_delivered' => $this->previous_day_app_delivered, 'total_revenue' => $this->sum, 'previous_revenue' => $this->previous_sum, 'balance_due' => $this->balance_due_sum, 'previous_bal' => $this->previous_bal_sum, 'application_type' => $this->application_type, 'info' => $this->info]);
    }
    public function Bookmarks()
    {
        $editId = '';
        $deleteId = '';
        return view('admin-module.Bookmark.bookmarks', ['EditId' => $editId, 'DeleteId' => $deleteId]);
    }
    public function EditBookmark($Id)
    {
        $deleteId = '';
        return view('admin-module.Bookmark.bookmarks', ['EditId' => $Id, 'DeleteId' => $deleteId]);
    }
    public function DeleteBookmark($Id)
    {
        $editId = '';
        return view('admin-module.Bookmark.bookmarks', ['EditId' => $editId, 'DeleteId' => $Id]);
    }
    public function AddStatus()
    {
        $Id = '';
        $id = '';
        $ViewStatus = '';
        return view('admin-module.Status.status', ['EditId' => $Id, 'DeleteId' => $id, 'ViewStatus' => $ViewStatus]);
    }
    public function EditStatus($Id)
    {
        $id = '';
        $status = '';
        return view('admin-module.Status.status', ['EditId' => $Id, 'DeleteId' => $id, 'VeiwStatus' => $status]);
    }


    public function ViewStatus($status)
    {
        $eid = '';
        $did = '';
        return view('admin-module.Status.status', ['EditId' => $eid, 'DeleteId' => $did, 'VeiwStatus' => $status]);
    }


    public function DeleteStatus($Id)
    {
        $id = '';
        $status = '';
        return view('admin-module.Status.status', ['EditId' => $id, 'DeleteId' => $Id, 'VeiwStatus' => $status]);
    }





    public function UpdateEnquiryDashboard($Id)
    {
        $name = 'Enquiry';
        if ($name == 'Enquiry') {
            $Tittle1 = 'Total Enquiries';
            $Tittle2 = 'New Enquiries';
            $Tittle3 = 'Hot';
            $Tittle4 = 'Completed';
        } else {
            $Tittle1 = '';
            $Tittle2 = '';
            $Tittle3 = '';
            $Tittle4 = '';
        }
        $EditId = '';
        $DeleteId = '';
        $totalRequests = EnquiryDB::all()->count();
        $delivered = EnquiryDB::where('Status', 'Completed')->count();
        $pending = EnquiryDB::where('Lead_Status', 'Hot')->count();
        $new =   EnquiryDB::whereDate('created_at', DB::raw('CURDATE()'))->count();
        $percentpending = number_format(($pending * 100) / $totalRequests, 1, '.', '');
        $percentdelivered = number_format(($delivered * 100) / $totalRequests, 1, '.', '');
        return view('admin-module.dashboard.update_enquiry_status', ['Name' => $name, 'Id' => $Id, 'Tittle1' => $Tittle1, 'Tittle2' => $Tittle2, 'Tittle3' => $Tittle3, 'Tittle4' => $Tittle4, 'totalRequests' => $totalRequests, 'delivered' => $delivered, 'pending' => $pending, 'new' => $new, 'percentpending' => $percentpending, 'percentdelivered' => $percentdelivered, 'DeleteId' => $DeleteId, 'EditId' => $EditId]);
    }


    public function EditEnquiryStatus($eidtId)
    {
        $name = 'Enquiry';
        if ($name == 'Enquiry') {
            $Tittle1 = 'Total Enquiries';
            $Tittle2 = 'New Enquiries';
            $Tittle3 = 'Hot';
            $Tittle4 = 'Completed';
        } else {
            $Tittle1 = '';
            $Tittle2 = '';
            $Tittle3 = '';
            $Tittle4 = '';
        }
        $DeleteId = '';
        $Id = '';
        $totalRequests = EnquiryDB::all()->count();
        $delivered = EnquiryDB::where('Status', 'Completed')->count();
        $pending = EnquiryDB::where('Lead_Status', 'Hot')->count();
        $new =   EnquiryDB::whereDate('created_at', DB::raw('CURDATE()'))->count();
        $percentpending = number_format(($pending * 100) / $totalRequests, 1, '.', '');
        $percentdelivered = number_format(($delivered * 100) / $totalRequests, 1, '.', '');
        return view('admin-module.dashboard.update_enquiry_status', ['Name' => $name, 'Id' => $Id, 'Tittle1' => $Tittle1, 'Tittle2' => $Tittle2, 'Tittle3' => $Tittle3, 'Tittle4' => $Tittle4, 'totalRequests' => $totalRequests, 'delivered' => $delivered, 'pending' => $pending, 'new' => $new, 'percentpending' => $percentpending, 'percentdelivered' => $percentdelivered, 'DeleteId' => $DeleteId, 'EditId' => $eidtId]);
    }


    public function DeleteEnquiryStatus($DeleteId)
    {
        $name = 'Enquiry';
        if ($name == 'Enquiry') {
            $Tittle1 = 'Total Enquiries';
            $Tittle2 = 'New Enquiries';
            $Tittle3 = 'Hot';
            $Tittle4 = 'Completed';
        } else {
            $Tittle1 = '';
            $Tittle2 = '';
            $Tittle3 = '';
            $Tittle4 = '';
        }
        $EditId = '';
        $Id = '';
        $totalRequests = EnquiryDB::all()->count();
        $delivered = EnquiryDB::where('Status', 'Completed')->count();
        $pending = EnquiryDB::where('Lead_Status', 'Hot')->count();
        $new =   EnquiryDB::whereDate('created_at', DB::raw('CURDATE()'))->count();
        $percentpending = number_format(($pending * 100) / $totalRequests, 1, '.', '');
        $percentdelivered = number_format(($delivered * 100) / $totalRequests, 1, '.', '');
        return view('admin-module.dashboard.update_enquiry_status', ['Name' => $name, 'Id' => $Id, 'Tittle1' => $Tittle1, 'Tittle2' => $Tittle2, 'Tittle3' => $Tittle3, 'Tittle4' => $Tittle4, 'totalRequests' => $totalRequests, 'delivered' => $delivered, 'pending' => $pending, 'new' => $new, 'percentpending' => $percentpending, 'percentdelivered' => $percentdelivered, 'DeleteId' => $DeleteId, 'EditId' => $EditId]);
    }


    public function waGreat($mobile)
    {
        $message = urlencode("Hello and welcome to *Digital Cyber* We're excited to have you as a new customer. With our wide range of government-related services, from passport assistance to train reservations, we aim to make your life easier. Don't forget to join our community group for the latest updates !
        https://chat.whatsapp.com/DVMSuz7P1BeFzqoqmUJIcw "); // URL-encode the greeting message
        // $whatsappLink = 'https://web.whatsapp.com/send?phone=' . $mobile . '&text=' . $message;

        $whatsappLink = 'whatsapp://send?phone=+91' . $mobile . '&text=' . $message;
        return redirect($whatsappLink);
    }

    public function waCallBack($mobile, $name, $service, $servicetype)
    {
        $message = urlencode("Hello *" . $name . "* 👋🏻😍 ,

        Thank you for requesting a call back on *" . $service . " " . $servicetype . "* I'll be happy to assist you. Please provide me with your preferred date and time for the call, along with any specific details or questions you have. I'll make sure to get back to you as soon as possible.

        Best regards,
        *Digital Cyber* "); // URL-encode the greeting message
        // $whatsappLink = 'https://web.whatsapp.com/send?phone=' . $mobile . '&text=' . $message;

        $whatsappLink = 'whatsapp://send?phone=+91' . $mobile . '&text=' . $message;
        return redirect($whatsappLink);
    }


    public function waApplyNow($mobile, $name, $service, $servicetype)
    {
        $message = urlencode("Hello *" . $name . "* 👋🏻😍 ,

        Thank you for Applying *" . $service . " " . $servicetype . "* Service,
        I'll be happy to assist you.

        Please provide us with your preferred date and time for the call back,

        our Team will make sure to get back to you as soon as possible.

         Best regards,
        *Digital Cyber*
        *+91 8892988334*"); // URL-encode the greeting message
        // $whatsappLink = 'https://web.whatsapp.com/send?phone=' . $mobile . '&text=' . $message;

        $whatsappLink = 'whatsapp://send?phone=+91' . $mobile . '&text=' . $message;
        return redirect($whatsappLink);
    }


    public function waEnquiry($mobile, $name, $service, $time)
    {
        $message = urlencode("Dear *" . $name . "* 👋🏻😍
        ,
        ▶ Thank you for reaching out to us through our website with your Enquiry *" . $time . "* We appreciate your interest and would be more than happy to assist you.

        ▶ Our team is currently reviewing your inquiry and will provide you with a detailed response as soon as possible. We understand the importance of your questions and aim to address them thoroughly and accurately.


        Best regards,
        *Digital Cyber*
        _The power to Empowe_
        *Call : +91 8892988334*
        *Call : +91 8951775912*"); // URL-encode the greeting message
        // $whatsappLink = 'https://web.whatsapp.com/send?phone=' . $mobile . '&text=' . $message;

        $whatsappLink = 'whatsapp://send?phone=+91' . $mobile . '&text=' . $message;
        // dd($whatsappLink);
        return redirect($whatsappLink);
    }


    public function UpdateCallbackStatus($Id, $Client_Id, $name)
    {
        $Tittle1 = 'Total Requests';
        $Tittle2 = 'New ';
        $Tittle3 = 'Pending';
        $Tittle4 = 'Delivered';
        $editId = '';
        $deleteId = '';
        $totalRequests = Callback_Db::all()->count();
        $delivered = Callback_Db::where('Status', 'Completed')->count();
        $pending = Callback_Db::where('Status', '!=', 'Completed')->count();
        $new =   Callback_Db::whereDate('created_at', DB::raw('CURDATE()'))->count();
        $percentpending = number_format(($pending * 100) / $totalRequests, 1, '.', '');
        $percentdelivered = number_format(($delivered * 100) / $totalRequests, 1, '.', '');

        return view('admin.Dashboard.update_callback_status', ['Id' => $Id, 'Client_Id' => $Client_Id, 'Name' => $name, 'Tittle1' => $Tittle1, 'Tittle2' => $Tittle2, 'Tittle3' => $Tittle3, 'Tittle4' => $Tittle4, 'EditId' => $editId, 'DeleteId' => $deleteId, 'totalRequests' => $totalRequests, 'delivered' => $delivered, 'pending' => $pending, 'new' => $new, 'percentpending' => $percentpending, 'percentdelivered' => $percentdelivered]);
    }


    public function EditCBStatus($editId, $Client_Id, $name)
    {
        $Tittle1 = 'Total Requests';
        $Tittle2 = 'New ';
        $Tittle3 = 'Pending';
        $Tittle4 = 'Delivered';
        $totalRequests = Callback_Db::all()->count();
        $delivered = Callback_Db::where('Status', 'Completed')->count();
        $pending = Callback_Db::where('Status', '!=', 'Completed')->count();
        $new =   Callback_Db::whereDate('created_at', DB::raw('CURDATE()'))->count();
        $percentpending = number_format(($pending * 100) / $totalRequests, 1, '.', '');
        $percentdelivered = number_format(($delivered * 100) / $totalRequests, 1, '.', '');
        $Id = '';
        $deleteId = '';
        return view('admin.Dashboard.update_callback_status', ['Id' => $Id, 'Client_Id' => $Client_Id, 'Name' => $name, 'Tittle1' => $Tittle1, 'Tittle2' => $Tittle2, 'Tittle3' => $Tittle3, 'Tittle4' => $Tittle4, 'EditId' => $editId, 'DeleteId' => $deleteId, 'totalRequests' => $totalRequests, 'delivered' => $delivered, 'pending' => $pending, 'new' => $new, 'percentpending' => $percentpending, 'percentdelivered' => $percentdelivered]);
    }


    public function DeleteCBStatus($deleteId, $Client_Id, $name)
    {
        $Tittle1 = 'Total Requests';
        $Tittle2 = 'New ';
        $Tittle3 = 'Pending';
        $Tittle4 = 'Delivered';
        $totalRequests = Callback_Db::all()->count();
        $delivered = Callback_Db::where('Status', 'Completed')->count();
        $pending = Callback_Db::where('Status', '!=', 'Completed')->count();
        $new =   Callback_Db::whereDate('created_at', DB::raw('CURDATE()'))->count();
        $percentpending = number_format(($pending * 100) / $totalRequests, 1, '.', '');
        $percentdelivered = number_format(($delivered * 100) / $totalRequests, 1, '.', '');
        $Id = '';
        $editId = '';
        return view('admin.Dashboard.update_callback_status', ['Id' => $Id, 'Client_Id' => $Client_Id, 'Name' => $name, 'Tittle1' => $Tittle1, 'Tittle2' => $Tittle2, 'Tittle3' => $Tittle3, 'Tittle4' => $Tittle4, 'EditId' => $editId, 'DeleteId' => $deleteId, 'totalRequests' => $totalRequests, 'delivered' => $delivered, 'pending' => $pending, 'new' => $new, 'percentpending' => $percentpending, 'percentdelivered' => $percentdelivered]);
    }


    public function AppStatusList($service)
    {
        $app_list = DB::table('digital_cyber_db')
            ->where([['Status', '=', $service], ['Recycle_Bin', '=', $this->no]])
            ->paginate(15);

        $sl_no = DB::table('digital_cyber_db')
            ->where([['Status', '=', $service], ['Recycle_Bin', '=', $this->no]])
            ->count();

        return view('Application\app_status_list', [
            'app_list' => $app_list,
            'sl_no' => $sl_no,
            'n' => $this->n,
            'applications_served' => $this->applications_served,
            'previous_day_app' => $this->previous_day_app,
            'applications_delivered' => $this->applications_delivered,
            'previous_day_app_delivered' => $this->previous_day_app_delivered,
            'total_revenue' => $this->sum,
            'previous_revenue' => $this->previous_sum,
            'balance_due' => $this->balance_due_sum,
            'previous_bal' => $this->previous_bal_sum,
            'application_type' => $this->application_type,
            'info' => $this->info,
            'service' => $service
        ]);
    }

    public function Selected_Ser_Balance_List($value)
    {
        $selected_ser_balance_list = DB::table('digital_cyber_db')
            ->where([['Balance', '>', 1], ['Recycle_Bin', '=', $this->no], ['Application_Type', '=', $value]])
            ->paginate(10);

        $sl_count = DB::table('digital_cyber_db')
            ->where([['Balance', '>', 1], ['Recycle_Bin', '=', $this->no], ['Application_Type', '=', $value]])
            ->count();

        $count_bal = $selected_ser_balance_list->sum('Balance');

        $info = $sl_count . ' ' . $value . ' Applications Found Due for ₹ ' . $count_bal . '/-  as on ' . date("Y-m-d");

        return view('Application\balance_list', [
            'balance_list' => $selected_ser_balance_list,
            'sl_no' => $sl_count,
            'n' => $this->n,
            'applications_served' => $this->applications_served,
            'previous_day_app' => $this->previous_day_app,
            'applications_delivered' => $this->applications_delivered,
            'previous_day_app_delivered' => $this->previous_day_app_delivered,
            'total_revenue' => $this->sum,
            'previous_revenue' => $this->previous_sum,
            'balance_due' => $this->balance_due_sum,
            'previous_bal' => $this->previous_bal_sum,
            'application_type' => $this->application_type,
            'info' => $info
        ]);
    }

    public function ViewApplication($Client_Id)
    {
        $applicant_data = DB::table('digital_cyber_db')
            ->where([['Client_Id', '=', $Client_Id], ['Recycle_Bin', '=', $this->no]])
            ->get();

        $mobile = $applicant_data->first()->Mobile_No ?? '';

        $get_app = DB::table('digital_cyber_db')
            ->where('Mobile_No', '=', $mobile)
            ->get();

        $count_app = $get_app->count();
        $app_delivered = $get_app->where('Status', 'Delivered')->count();
        $app_pending = $get_app->where('Status', 'Pending')->count();
        $app_deleted = DB::table('digital_cyber_db')
            ->where([['Mobile_No', '=', $mobile], ['Recycle_Bin', '=', 'Yes']])
            ->count();

        $tot = $get_app->sum('Total_Amount');
        $amnt = $get_app->sum('Amount_Paid');
        $bal = $get_app->sum('Balance');

        return view('admin-module.application.open_application', [
            'applicant_data' => $applicant_data,
            'sl_no' => $applicant_data->count(),
            'n' => $this->n,
            'applications_served' => $this->applications_served,
            'previous_day_app' => $this->previous_day_app,
            'applications_delivered' => $this->applications_delivered,
            'previous_day_app_delivered' => $this->previous_day_app_delivered,
            'total_revenue' => $this->sum,
            'previous_revenue' => $this->previous_sum,
            'balance_due' => $this->balance_due_sum,
            'previous_bal' => $this->previous_bal_sum,
            'info' => $this->info,
            'indi_total' => $tot,
            'indi_amount' => $amnt,
            'indi_bal' => $bal,
            'indi_count' => $count_app,
            'indi_data' => $get_app,
            'indi_delivered' => $app_delivered,
            'indi_pending' => $app_pending,
            'indi_deleted' => $app_deleted,
            'Client_Id' => $Client_Id
        ]);
    }

    public function  GlobalSearch($key)
    {
        return view('admin-module.application.search', ['search' => $key]);
    }

    public function EditProfile($id)
    {
        return view('admin-module.application.edit_profile', ['Id' => $id]);
    }

    public function Delete($id)
    {
        DB::table('digital_cyber_db')->where('Id', $id)->update(['Recycle_Bin' => $this->yes]);

        return redirect('app_form')->with('RecycleMsg', 'Apllication Moved to Recycle Bin');
    }

    public function DeletePermanently($id)
    {
        DB::table('digital_cyber_db')->where('Id', $id)->delete();
        DB::table('pan_card')->where('Id', $id)->delete();

        return redirect('view_recycle_bin')->with('RecycleMsg', 'Apllication Deleted Permanently');
    }

    public function Restore($id)
    {
        $value = "No";
        DB::table('digital_cyber_db')->where('Id', $id)->update(['Recycle_Bin' => $value]);
        DB::table('pan_card')->where('Id', $id)->update(['Recycle_Bin' => $value]);

        return redirect('view_recycle_bin');
    }

    public function ViewRecycleBin()
    {

        $No = "Yes";
        $recycle_data = DB::table('digital_cyber_db')->where('Recycle_Bin', '=', $No)->paginate(10);
        $total_recycle_data = DB::table('digital_cyber_db')->where('Recycle_Bin', '=', $No)->get();
        $sl_no = DB::table('digital_cyber_db')->where('Recycle_Bin', '=', $No)->count();
        $total = 0;
        $n = 1;
        foreach ($total_recycle_data as $key) {
            $key  = get_object_vars($key); {
                $total += $key['Amount_Paid'];
            }
        }
        return view('Application\recycle_bin', ['recycle_data' => $recycle_data, 'count' => $sl_no, 'sl_no' => $sl_no, 'n' => $n, 'total' => $total]);
    }
}
