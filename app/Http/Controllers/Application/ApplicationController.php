<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplyServiceForm;
use App\Models\Callback_Db;
use App\Models\DocumentFiles;
use App\Models\EnquiryDB;
use App\Models\MainServices;
use App\Models\Status;
use App\Models\SubServices;
use App\Models\User;
use App\Traits\RightInsightTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    use RightInsightTrait;

    public function index()
    {
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

    public function UpdateService()
    {

        return view('DigitalLedger\CreditLedger\update',);
    }

    public function Temp()
    {
        return view('Application\new_template');
    }


    public function Dashboard()
    {
        if ($this->applications_served > 0) {
            foreach ($this->MainServices as $key) {
                $application_total_count = Application::where('Application', $key['Name'])->count();
                $total_amount = DB::table('digital_cyber_db')->where('Application', $key['Name'])->SUM('Amount_Paid');
                $notification = 0;
                $data = array();
                $data['Total_Count'] = $application_total_count;
                $data['Temp_Count'] =  $notification;
                $data['Total_Amount'] =  $total_amount;
                // dd($data);
                MainServices::where('Id', '=', $key['Id'])->Update($data);

                // $application_amount = Application::where('Application','=', $key['Name'])->count();

                $No = 'No';
                $app = $key['Name'];
                $chechk_status = Application::where([['Application', $key['Name']], ['Status', 'Received'], ['Recycle_Bin', $No]])->get();


                foreach ($chechk_status as $count) {
                    // $count = get_object_vars($count);
                    $received_date = $count['Received_Date'];
                    $start_time = new Carbon($received_date);
                    $finish_time = new Carbon($this->today);
                    $diff_days = $start_time->diffInDays($finish_time);
                    if (($diff_days) >= 2) {
                        $notification += 1;
                        DB::update('update service_list set Temp_Count = ? where Name = ?', [$notification, $app]);
                    }
                }
            }
        } else {
            foreach ($this->MainServices as $key) {
                $total_amount = 0;
                $notification = 0;
                $data = array();
                $data['Total_Count'] = 0;
                $data['Temp_Count'] =  $notification;
                $data['Total_Amount'] =  0;
                MainServices::where('Id', $key['Id'])->Update($data);
                $application_amount = Application::where('Application', '=', $key['Name'])->count();
            }
        }
        // Code for insight Data Records are fetched from RightInsight Trait
        $status = Status::all();
        foreach ($status as $item) {
            $name = $item['Status'];
            $amount = DB::table('digital_cyber_db')->Where('Status', $name)->SUM('Total_Amount');
            $count = DB::table('digital_cyber_db')->where('Status', $name)->count();
            $data = array();
            $data['Total_Amount'] = $amount;
            $data['Total_Count'] = $count;
            DB::table('status')->where('Status', $name)->update($data);
        }
        return view('admin-module.application.app_dashboard', ['total_applicaiton' => $this->applications_served, 'total_amount' => $total_amount, 'Mainservices' => $this->MainServices, 'applications_served' => $this->applications_served, 'previous_day_app' => $this->previous_day_app, 'applications_delivered' => $this->applications_delivered, 'previous_day_app_delivered' => $this->previous_day_app_delivered, 'total_revenue' => $this->sum, 'previous_revenue' => $this->previous_sum, 'balance_due' => $this->balance_due_sum, 'previous_bal' => $this->previous_bal_sum, 'new_clients' => $this->new_clients, 'previous_day_new_clients' => $this->previous_day_new_clients, 'bookmarks' => $this->bookmarks,]);
    }


    public function DynamicDashboard($MainServiceId)
    {
        $No = 'No';
        $Sub_Services = SubServices::Where('Service_Id', $MainServiceId)->get();
        if (count($Sub_Services) > 0) {
            foreach ($Sub_Services as $item) { {
                    $name = $item['Name'];
                    $count = Application::Where([['Application_Type', $name], ['Recycle_Bin', $No]])->count();
                    DB::update('update sub_service_list set Total_Count=?  where Name = ?', [$count, $name]);
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
    public function MovetoRecycleBin($Id)
    {

        $check_bal_app = DB::table('digital_cyber_db')->where('Id', '=', $Id)
            ->where(function ($query) {
                $query->where('Balance', '>', 0);
            })->get();

        if (count($check_bal_app) > 0) {
            session()->flash('Error', 'Sorry! Balance due for : ' . $Id . ' Please Clear Due and try again!');
            return redirect()->back();
        } else {
            
            $data = array();
            $data['Recycle_Bin'] = 'Yes';
            $data['updated_at'] = Carbon::now();
            Application::where('Id', $Id)->Update($data);
            session()->flash('SuccessMsg', 'Record for Application Id: ' . $Id . ' Moved to recyble bin!');
            return redirect()->back();
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
        $status = '';
        return view('admin-module.Status.status', ['EditId' => $Id, 'DeleteId' => $id, 'VeiwStatus' => $status]);
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


    public function DashboardUpdate($name)
    {
        if ($name == 'User') {
            $Tittle1 = 'Total Users';
            $Tittle2 = 'New User';
            $Tittle3 = 'Pedning';
            $Tittle4 = 'Converted';
            $totalRequests = User::all()->count();
            $delivered = User::where('Status', 'Completed')->count();
            $pending = User::where('Status', '!=', 'Completed')->count();
            $new =   User::whereDate('created_at', DB::raw('CURDATE()'))->count();
            $percentpending = number_format(($pending * 100) / $totalRequests, 1, '.', '');
            $percentdelivered = number_format(($delivered * 100) / $totalRequests, 1, '.', '');
        } elseif ($name == 'Orders') {
            $Tittle1 = 'Total Orders';
            $Tittle2 = 'New Orders';
            $Tittle3 = 'Pending';
            $Tittle4 = 'Delivered';
            $totalRequests = ApplyServiceForm::all()->count();
            $delivered = ApplyServiceForm::where('Status', 'Delivered to Client')->count();
            $pending = ApplyServiceForm::where('Status', '!=', 'Delivered to Client')->count();
            $new =   ApplyServiceForm::whereDate('created_at', DB::raw('CURDATE()'))->count();
            $percentpending = number_format(($pending * 100) / $totalRequests, 1, '.', '');
            $percentdelivered = number_format(($delivered * 100) / $totalRequests, 1, '.', '');
        } elseif ($name == 'Callback') {
            $Tittle1 = 'Total Requests';
            $Tittle2 = 'New Requests';
            $Tittle3 = 'Converted';
            $Tittle4 = 'Pending';
            $totalRequests = Callback_Db::all()->count();
            $delivered = Callback_Db::where('Status', 'Completed')->count();
            $pending = Callback_Db::where('Status', '!=', 'Completed')->count();
            $new =   Callback_Db::whereDate('created_at', DB::raw('CURDATE()'))->count();
            $percentpending = number_format(($pending * 100) / $totalRequests, 1, '.', '');
            $percentdelivered = number_format(($delivered * 100) / $totalRequests, 1, '.', '');
        } elseif ($name == 'Enquiry') {
            $Tittle1 = 'Total Enquiries';
            $Tittle2 = 'New Enquiries';
            $Tittle3 = 'Hot';
            $Tittle4 = 'Completed';
            $totalRequests = EnquiryDB::all()->count();
            $delivered = EnquiryDB::where('Status', 'Completed')->count();
            $pending = EnquiryDB::where('Lead_Status', 'Hot')->count();
            $new =   EnquiryDB::whereDate('created_at', DB::raw('CURDATE()'))->count();
            $percentpending = number_format(($pending * 100) / $totalRequests, 1, '.', '');
            $percentdelivered = number_format(($delivered * 100) / $totalRequests, 1, '.', '');
        } else {
            $Tittle1 = '';
            $Tittle2 = '';
            $Tittle3 = '';
            $Tittle4 = '';
        }
        return view('admin-module.dashboard.dashboard_update', ['Name' => $name, 'Tittle1' => $Tittle1, 'Tittle2' => $Tittle2, 'Tittle3' => $Tittle3, 'Tittle4' => $Tittle4, 'totalRequests' => $totalRequests, 'delivered' => $delivered, 'pending' => $pending, 'new' => $new, 'percentpending' => $percentpending, 'percentdelivered' => $percentdelivered]);
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
        return view('admin.Dashboard.update_enquiry_status', ['Name' => $name, 'Id' => $Id, 'Tittle1' => $Tittle1, 'Tittle2' => $Tittle2, 'Tittle3' => $Tittle3, 'Tittle4' => $Tittle4, 'totalRequests' => $totalRequests, 'delivered' => $delivered, 'pending' => $pending, 'new' => $new, 'percentpending' => $percentpending, 'percentdelivered' => $percentdelivered, 'DeleteId' => $DeleteId, 'EditId' => $EditId]);
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
        return view('admin.Dashboard.update_enquiry_status', ['Name' => $name, 'Id' => $Id, 'Tittle1' => $Tittle1, 'Tittle2' => $Tittle2, 'Tittle3' => $Tittle3, 'Tittle4' => $Tittle4, 'totalRequests' => $totalRequests, 'delivered' => $delivered, 'pending' => $pending, 'new' => $new, 'percentpending' => $percentpending, 'percentdelivered' => $percentdelivered, 'DeleteId' => $DeleteId, 'EditId' => $eidtId]);
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
        return view('admin.Dashboard.update_enquiry_status', ['Name' => $name, 'Id' => $Id, 'Tittle1' => $Tittle1, 'Tittle2' => $Tittle2, 'Tittle3' => $Tittle3, 'Tittle4' => $Tittle4, 'totalRequests' => $totalRequests, 'delivered' => $delivered, 'pending' => $pending, 'new' => $new, 'percentpending' => $percentpending, 'percentdelivered' => $percentdelivered, 'DeleteId' => $DeleteId, 'EditId' => $EditId]);
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

        $app_list = DB::table('digital_cyber_db')->where([['Status', '=', $service], ['Recycle_Bin', '=', $this->no]])->Paginate(15);
        $sl_no = DB::table('digital_cyber_db')->where([['Status', '=', $service], ['Recycle_Bin', '=', $this->no]])->count();

        // Code for insight Data Records


        return view('Application\app_status_list', ['app_list' => $app_list, 'sl_no' => $sl_no, 'n' => $this->n, 'applications_served' => $this->applications_served, 'previous_day_app' => $this->previous_day_app, 'applications_delivered' => $this->applications_delivered, 'previous_day_app_delivered' => $this->previous_day_app_delivered, 'total_revenue' => $this->sum, 'previous_revenue' => $this->previous_sum, 'balance_due' => $this->balance_due_sum, 'previous_bal' => $this->previous_bal_sum, 'application_type' => $this->application_type, 'info' => $this->info, 'service' => $service]);
    }

    public function Selected_Ser_Balance_List($value)
    {

        $selected_ser_balance_list = DB::table('digital_cyber_db')->where([['Balance', '>', 1], ['Recycle_Bin', '=', $this->no], ['Application_Type', '=', $value]])->paginate(10);
        $sl_count = DB::table('digital_cyber_db')->where([['Balance', '>', 1], ['Recycle_Bin', '=', $this->no], ['Application_Type', '=', $value]])->count();
        $count_bal = 0;
        foreach ($selected_ser_balance_list as $key) {
            $key = get_object_vars($key); {
                $count_bal += $key['Balance'];
            }
        }


        $info = $sl_count . ' ' . $value . ' Applications Found Due for ₹ ' . $count_bal . '/-  as on ' . date("Y-m-d");

        // Code for insight Data Records

        return view('Application\balance_list', ['balance_list' =>
        $selected_ser_balance_list, 'sl_no' => $sl_count, 'n' => $this->n, 'applications_served' => $this->applications_served, 'previous_day_app' => $this->previous_day_app, 'applications_delivered' => $this->applications_delivered, 'previous_day_app_delivered' => $this->previous_day_app_delivered, 'total_revenue' => $this->sum, 'previous_revenue' => $this->previous_sum, 'balance_due' => $this->balance_due_sum, 'previous_bal' => $this->previous_bal_sum, 'application_type' => $this->application_type, 'info' => $info]);
    }


    public function ViewApplication($Client_Id)
    {
        $yes = 'Yes';
        $sl_no = DB::table('digital_cyber_db')->where([['Client_Id', '=', $Client_Id], ['Recycle_Bin', '=', $this->no]])->count();
        $applicant_data = DB::table('digital_cyber_db')->where([['Client_Id', '=', $Client_Id], ['Recycle_Bin', '=', $this->no]])->get();
        $mobile = '';
        foreach ($applicant_data as $field) {
            $field = get_object_vars($field); {
                $mobile = $field['Mobile_No'];
            }
        }
        $get_app = DB::table('digital_cyber_db')->where('Mobile_No', '=', $mobile)->get();
        $count_app = DB::table('digital_cyber_db')->where('Mobile_No', '=', $mobile)->count();
        $app_delivered =  DB::table('digital_cyber_db')->where([['Mobile_No', '=', $mobile], ['Recycle_Bin', '=', $this->no], ['Status', '=', 'Delivered']])->count();
        $app_pending =  DB::table('digital_cyber_db')->where([['Mobile_No', '=', $mobile], ['Recycle_Bin', '=', $this->no], ['Status', '=', 'Pending']])->count();
        $app_deleted =  DB::table('digital_cyber_db')->where([['Mobile_No', '=', $mobile], ['Recycle_Bin', '=', $yes]])->count();
        $tot = 0;
        $amnt = 0;
        $bal = 0;
        foreach ($get_app as $amt) {
            $amt = get_object_vars($amt); {
                $tot +=  $amt['Total_Amount'];
                $amnt += $amt['Amount_Paid'];
                $bal +=  $amt['Balance'];
            }
        }


        return view('admin-module.application.open_application', ['applicant_data' => $applicant_data, 'sl_no' => $sl_no, 'n' => $this->n, 'applications_served' => $this->applications_served, 'previous_day_app' => $this->previous_day_app, 'applications_delivered' => $this->applications_delivered, 'previous_day_app_delivered' => $this->previous_day_app_delivered, 'total_revenue' => $this->sum, 'previous_revenue' => $this->previous_sum, 'balance_due' => $this->balance_due_sum, 'previous_bal' => $this->previous_bal_sum, 'info' => $this->info, 'indi_total' => $tot, 'indi_amount' => $amnt, 'indi_bal' => $bal, 'indi_count' => $count_app, 'indi_data' => $get_app, 'indi_delivered' => $app_delivered, 'indi_pending' => $app_pending, 'indi_deleted' => $app_deleted, 'Client_Id' => $Client_Id]);
    }


    public function Update_Application($Id)
    {

        $sl_no = DB::table('digital_cyber_db')->where([['Id', '=', $Id], ['Recycle_Bin', '=', $this->no]])->count();
        $applicant_data = DB::table('digital_cyber_db')->where([['Id', '=', $Id], ['Recycle_Bin', '=', $this->no]])->get();

        // Code for Individual Customer Data Insight
        foreach ($applicant_data as $field) {
            $field = get_object_vars($field); {
                $mobile = $field['Mobile_No'];
            }
        }
        $get_app = DB::table('digital_cyber_db')->where('Mobile_No', '=', $mobile)->get();
        $count_app = DB::table('digital_cyber_db')->where('Mobile_No', '=', $mobile)->count();
        $app_delivered =  DB::table('digital_cyber_db')->where([['Mobile_No', '=', $mobile], ['Recycle_Bin', '=', $this->no], ['Status', '=', 'Delivered']])->count();
        $app_pending =  DB::table('digital_cyber_db')->where([['Mobile_No', '=', $mobile], ['Recycle_Bin', '=', $this->no], ['Status', '=', 'Pending']])->count();
        $app_deleted =  DB::table('digital_cyber_db')->where([['Mobile_No', '=', $mobile], ['Recycle_Bin', '=', $this->yes]])->count();
        $tot = 0;
        $amnt = 0;
        $bal = 0;
        foreach ($get_app as $amt) {
            $amt = get_object_vars($amt); {
                $tot +=  $amt['Total_Amount'];
                $amnt += $amt['Amount_Paid'];
                $bal +=  $amt['Balance'];
            }
        }
        // End of Data Insight Code

        // Code for insight Data Records
        $applications_served = DB::table('digital_cyber_db')->count();
        $previous_day = date('Y-m-d', strtotime($this->today . ' - 1 days'));
        $previous_day_app = DB::table('digital_cyber_db')->where([['Received_Date', '=', $previous_day], ['Recycle_Bin', '=', $this->no]])->count();
        $status = 'Delivered';
        $applications_delivered = DB::table('digital_cyber_db')->where([[
            'Status', '=',
            $status
        ], ['Recycle_Bin', '=', $this->no]])->count();
        $previous_day_app_delivered = DB::table('digital_cyber_db')->where([[
            'Status', '=',
            $status
        ], ['Recycle_Bin', '=', $this->no], ['Delivered_Date', '=', $previous_day]])->count();

        $total_revenue = DB::table('digital_cyber_db')->where([['Recycle_Bin', '=', $this->no]])->get();
        $sum = 0.00;
        foreach ($total_revenue as $key) {
            $key  = get_object_vars($key); {
                $sum += $key['Amount_Paid'];
            }
        }

        $previous_revenue = DB::table('digital_cyber_db')->where([['Received_Date', '=', $previous_day], ['Recycle_Bin', '=', $this->no]])->get();

        $previous_sum = 0.00;
        foreach ($previous_revenue as $key) {
            $key  = get_object_vars($key); {
                $previous_sum += $key['Amount_Paid'];
            }
        }


        //  End of Data Insight Code

        return view('Application\update_open_app', ['applicant_data' => $applicant_data, 'sl_no' => $sl_no, 'n' => $this->n, 'applications_served' => $applications_served, 'previous_day_app' => $previous_day_app, 'applications_delivered' => $applications_delivered, 'previous_day_app_delivered' => $previous_day_app_delivered, 'total_revenue' => $sum, 'previous_revenue' => $previous_sum, 'balance_due' => $this->balance_due_sum, 'previous_bal' => $this->previous_bal_sum, 'info' => $this->info, 'indi_total' => $tot, 'indi_amount' => $amnt, 'indi_bal' => $bal, 'indi_count' => $count_app, 'indi_data' => $get_app, 'indi_delivered' => $app_delivered, 'indi_pending' => $app_pending, 'application_type' => $this->application_type, 'payment_mode' => $this->payment_mode, 'id' => $Id, 'status_list' => $this->status_list, 'indi_deleted' => $app_deleted]);
    }

    // public function GlobalSearch($key)
    // {
    //     $search = $key;
    //     $search_data = DB::table('digital_cyber_db')
    //                 ->where([['Mobile_No', '=', $search],['Recycle_Bin','=',$this->no]])
    //                 ->orWhere('Name', '=', $search)
    //                 ->orWhere('Ack_No', '=', $search)
    //                 ->get();

    //     $fetched_data_count = DB::table('digital_cyber_db')
    //                         ->where([['Mobile_No', '=', $search],['Recycle_Bin','=',$this->no]])
    //                         ->orWhere('Name', '=', $search)
    //                         ->orWhere('Ack_No', '=', $search)
    //                 ->count();
    //     $total=0;
    //     foreach ($search_data as $key)
    //     {
    //          $key  = get_object_vars($key);
    //         {
    //             $total += $key['Amount_Paid'];
    //         }
    //     }
    //     // code for Isnight Data


    //     return view('Application.searc',['search_data'=>$search_data, 'count'=>$fetched_data_count, 'sl_no'=>$fetched_data_count, 'n'=>$this->n, 'search'=>$search,'total'=>$total,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered,'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum]);

    // }
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
