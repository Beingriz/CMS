<?php

namespace App\Http\Livewire\AdminModule\Dashboard;

use App\Models\Application;
use App\Models\ApplyServiceForm;
use App\Models\Callback_Db;
use App\Models\CreditLedger;
use App\Models\Debit;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardInsight extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $totalToday, $results, $totalSales, $totalOrders, $newUsers, $callBack, $totalRevenue, $lastWeekAmount, $lastMonthAmount;
    public $Report = false, $Caption = "Turnover";
    public $officeApp, $directApp, $callBackApp;
    public $ServReport = false, $ServCaption = "Service Insight ";
    public $officeAppRec, $creditRec, $debitRec, $applynowRec, $callbackRec;
    public $Branch_Id,$Emp_Id;

    public function mount(){
        $this->Branch_Id = Auth::user()->branch_id;
        $this->Emp_Id = Auth::user()->Emp_Id;
    }

    public function Today()
    {
        $this->Report = true;
        $this->Caption = 'Today Credit';
        if(Auth::user()->role == 'branch admin'){
            $this->totalRevenue = DB::table('credit_ledger')
                ->where('Branch_Id', $this->Branch_Id)
                ->whereDate('created_at', '=', now()->toDateString()) // Using Laravel's date method
                ->sum('Amount_Paid'); // Use sum() to calculate total directly
        }else{
            $this->totalRevenue = DB::table('credit_ledger')
                ->whereDate('created_at', '=', now()->toDateString()) // Using Laravel's date method
                ->sum('Amount_Paid'); // Use sum() to calculate total directly
        }

    }
    public function Debit()
    {
        $this->Report = true;
        $this->Caption = 'Today Debit';
        if(Auth::user()->role == 'branch admin'){
            $this->totalRevenue = DB::table('debit_ledger')
                ->where('Branch_Id', $this->Branch_Id)
                ->whereDate('created_at', '=', now()->toDateString()) // Using Laravel's date method for clarity
                ->sum('Amount_Paid'); // Directly sum the Amount_Paid column
        }else{
            $this->totalRevenue = DB::table('debit_ledger')
            ->whereDate('created_at', '=', now()->toDateString()) // Using Laravel's date method for clarity
            ->sum('Amount_Paid'); // Directly sum the Amount_Paid column
        }
    }

    public function ServToday()
    {
        $this->ServReport = true;
        $this->ServCaption = "Today";
        if(Auth::user()->role == 'branch admin'){
            $this->officeApp = DB::table('digital_cyber_db')
            ->where('Branch_Id', $this->Branch_Id)
            ->whereDate('created_at', '=', now()->toDateString()) // Using Laravel's date method
            ->count(); // Simplified; no need for DB::raw with count()

            // Count direct applications for today, filtered by branch
            $this->directApp = DB::table('applynow')
            ->where('Branch_Id', $this->Branch_Id)
            ->whereDate('created_at', '=', now()->toDateString())
            ->count(); // Simplified; no need for DB::raw with count()

            // Count callbacks for today, filtered by branch
            $this->callBackApp = DB::table('callback')
            ->where('Branch_Id', $this->Branch_Id)
            ->whereDate('created_at', '=', now()->toDateString())
            ->count(); // Simplified; no need for DB::raw with count()
        }else{
            $this->officeApp = DB::table('digital_cyber_db')
            ->whereDate('created_at', '=', now()->toDateString()) // Using Laravel's date method
            ->count(); // Simplified; no need for DB::raw with count()

            // Count direct applications for today, filtered by branch
            $this->directApp = DB::table('applynow')
            ->whereDate('created_at', '=', now()->toDateString())
            ->count(); // Simplified; no need for DB::raw with count()

            // Count callbacks for today, filtered by branch
            $this->callBackApp = DB::table('callback')
            ->whereDate('created_at', '=', now()->toDateString())
            ->count(); // Simplified; no need for DB::raw with count()
        }
    }
    public function ServLastWeek()
    {
        $this->ServReport = true;
        $this->ServCaption = "Last Week";
       // Determine if the user is a branch admin
        $isBranchAdmin = Auth::user()->role === 'branch admin';

        // Base query for office applications
        $query = DB::table('digital_cyber_db')
            ->where('created_at', '>=', now()->subWeek()->startOfDay())
            ->where('created_at', '<=', now()->endOfDay());

        if ($isBranchAdmin) {
            // If the user is a branch admin, add the branch filter
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $this->officeApp = $query->count(); // Execute the query and get the count

        // Base query for direct applications
        $query = DB::table('applynow')
            ->where('created_at', '>=', now()->subWeek()->startOfDay())
            ->where('created_at', '<=', now()->endOfDay());

        if ($isBranchAdmin) {
            // If the user is a branch admin, add the branch filter
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $this->directApp = $query->count(); // Execute the query and get the count

        // Base query for callbacks
        $query = DB::table('callback')
            ->where('created_at', '>=', now()->subWeek()->startOfDay())
            ->where('created_at', '<=', now()->endOfDay());

        if ($isBranchAdmin) {
            // If the user is a branch admin, add the branch filter
            $query->where('Branch_Id', $this->Branch_Id);
        }
        $this->callBackApp = $query->count(); // Execute the query and get the count

    }
    public function ServLastMonth()
    {
        $this->ServReport = true;
        $this->ServCaption = "Last Month";
       // Determine if the user is a branch admin
        $isBranchAdmin = Auth::user()->role === 'branch admin';

        // Base date filter for the previous month
        $startOfLastMonth = now()->subMonth()->startOfMonth()->toDateString();
        $endOfLastMonth = now()->subMonth()->endOfMonth()->toDateString();

        // Base query for office applications
        $query = DB::table('digital_cyber_db')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);

        if ($isBranchAdmin) {
            // If the user is a branch admin, add the branch filter
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $this->officeApp = $query->count(); // Execute the query and get the count

        // Base query for direct applications
        $query = DB::table('applynow')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);

        if ($isBranchAdmin) {
            // If the user is a branch admin, add the branch filter
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $this->directApp = $query->count(); // Execute the query and get the count

        // Base query for callbacks
        $query = DB::table('callback')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);

        if ($isBranchAdmin) {
            // If the user is a branch admin, add the branch filter
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $this->callBackApp = $query->count(); // Execute the query and get the count

    }
    public function ServThisYear()
    {
        $this->ServReport = true;
        $this->ServCaption = "This Year";
       // Determine if the user is a branch admin
        $isBranchAdmin = Auth::user()->role === 'branch admin';

        // Define the start and end dates for the current year
        $startOfYear = now()->startOfYear()->toDateString();
        $endOfYear = now()->endOfYear()->toDateString();

        // Base query for office applications
        $query = DB::table('digital_cyber_db')
            ->whereBetween('created_at', [$startOfYear, $endOfYear]);

        if ($isBranchAdmin) {
            // If the user is a branch admin, add the branch filter
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $this->officeApp = $query->count(); // Execute the query and get the count

        // Base query for direct applications
        $query = DB::table('applynow')
            ->whereBetween('created_at', [$startOfYear, $endOfYear]);

        if ($isBranchAdmin) {
            // If the user is a branch admin, add the branch filter
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $this->directApp = $query->count(); // Execute the query and get the count

        // Base query for callbacks
        $query = DB::table('callback')
            ->whereBetween('created_at', [$startOfYear, $endOfYear]);

        if ($isBranchAdmin) {
            // If the user is a branch admin, add the branch filter
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $this->callBackApp = $query->count(); // Execute the query and get the count

    }
    public function ServLastYear()
    {
        $this->ServReport = true;
        $this->ServCaption = "Last Year";
        // Determine if the user is a branch admin
        $isBranchAdmin = Auth::user()->role === 'branch admin';

        // Define the start and end dates for the previous year
        $startOfLastYear = now()->subYear()->startOfYear()->toDateString();
        $endOfLastYear = now()->subYear()->endOfYear()->toDateString();

        // Base query for office applications
        $query = DB::table('digital_cyber_db')
            ->whereBetween('created_at', [$startOfLastYear, $endOfLastYear]);

        if ($isBranchAdmin) {
            // If the user is a branch admin, add the branch filter
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $this->officeApp = $query->count(); // Execute the query and get the count

        // Base query for direct applications
        $query = DB::table('applynow')
            ->whereBetween('created_at', [$startOfLastYear, $endOfLastYear]);

        if ($isBranchAdmin) {
            // If the user is a branch admin, add the branch filter
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $this->directApp = $query->count(); // Execute the query and get the count

        // Base query for callbacks
        $query = DB::table('callback')
            ->whereBetween('created_at', [$startOfLastYear, $endOfLastYear]);

        if ($isBranchAdmin) {
            // If the user is a branch admin, add the branch filter
            $query->where('Branch_Id', $this->Branch_Id);
        }

        $this->callBackApp = $query->count(); // Execute the query and get the count

    }
    public $creditReport = false, $appReport = true, $debitReport = false, $leadReport = false, $callBackReport = false, $feedbackReport = false;

    public function CreditLedger()
    {
        //Credit Ledger
        $this->creditReport = true;
        $this->appReport = false;
        $this->callBackReport = false;
        $this->leadReport = false;
        $this->feedbackReport = false;
        $this->debitReport = false;
    } // End Function
    public function DebitLedger()
    {
        //Debit Ledger
        $this->debitReport = true;
        $this->creditReport = false;
        $this->appReport = false;
        $this->callBackReport = false;
        $this->leadReport = false;
        $this->feedbackReport = false;
    } // End Function

    public function Leads()
    {
        //Leads
        $this->debitReport = false;
        $this->creditReport = false;
        $this->appReport = false;
        $this->callBackReport = false;
        $this->leadReport = true;
        $this->feedbackReport = false;
    } // End Function

    public function CallBack()
    {
        //CallBack
        $this->debitReport = false;
        $this->creditReport = false;
        $this->appReport = false;
        $this->callBackReport = true;
        $this->leadReport = false;
        $this->feedbackReport = false;
    } // End Function

    public function FeedBack()
    {
        //FeedBack
        $this->debitReport = false;
        $this->creditReport = false;
        $this->appReport = false;
        $this->callBackReport = false;
        $this->leadReport = false;
        $this->feedbackReport = true;
    } // End Function


    public function render()
    {
        $isBranchAdmin = Auth::user()->role === 'branch admin';

        // Conditional queries
        $this->totalToday = Application::when($isBranchAdmin, function ($query) {
                $query->where('Branch_Id', $this->Branch_Id);
            })
            ->whereRaw('DATE(created_at) = CURDATE()')
            ->count();

        $this->results = DB::select(
            "SELECT YEAR(created_at) AS year, MONTH(created_at) AS month, COUNT(*) AS total_entries
            FROM digital_cyber_db
            WHERE (YEAR(created_at) = YEAR(CURRENT_DATE) AND MONTH(created_at) = MONTH(CURRENT_DATE))
            GROUP BY YEAR(created_at), MONTH(created_at)
            ORDER BY YEAR(created_at), MONTH(created_at)"
        );

        $this->totalSales = Application::when($isBranchAdmin, function ($query) {
                $query->where('Branch_Id', $this->Branch_Id);
            })
            ->select(DB::raw('SUM(Amount_Paid) as total_amount'))
            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
            ->value('total_amount');

        $this->totalOrders = Application::when($isBranchAdmin, function ($query) {
                $query->where('Branch_Id', $this->Branch_Id);
            })
            ->select(DB::raw('COUNT(*) as total_orders'))
            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
            ->value('total_orders');

        $this->newUsers = User::when($isBranchAdmin, function ($query) {
                $query->where('Branch_Id', $this->Branch_Id);
            })
            ->select(DB::raw('COUNT(*) as new_users'))
            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
            ->value('new_users');

        $this->callBack = Callback_Db::when($isBranchAdmin, function ($query) {
                $query->where('Branch_Id', $this->Branch_Id);
            })
            ->select(DB::raw('COUNT(*) as callback'))
            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
            ->value('callback');

        if (!$this->Report) {
            $this->totalRevenue = CreditLedger::when($isBranchAdmin, function ($query) {
                    $query->where('Branch_Id', $this->Branch_Id);
                })
                ->select(DB::raw('SUM(Amount_Paid) as total_revenue'))
                ->value('total_revenue');
        }

        $this->lastWeekAmount = DB::select(
            "SELECT SUM(Amount_Paid) AS lastWeekamount
            FROM credit_ledger
            WHERE created_at >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) + 6 DAY
            AND created_at < CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) - 1 DAY"
        );

        $this->lastMonthAmount = CreditLedger::when($isBranchAdmin, function ($query) {
                $query->where('Branch_Id', $this->Branch_Id);
            })
            ->select(DB::raw('SUM(Amount_Paid) as total_amount'))
            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)')
            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)')
            ->value('total_amount');

        if (!$this->ServReport) {
            $this->officeApp = Application::when($isBranchAdmin, function ($query) {
                    $query->where('Branch_Id', $this->Branch_Id);
                })
                ->select(DB::raw('COUNT(*) as officeApp'))
                ->value('officeApp');

            $this->directApp = ApplyServiceForm::when($isBranchAdmin, function ($query) {
                    $query->where('Branch_Id', $this->Branch_Id);
                })
                ->select(DB::raw('COUNT(*) as directApp'))
                ->value('directApp');

            $this->callBackApp = Callback_Db::when($isBranchAdmin, function ($query) {
                    $query->where('Branch_Id', $this->Branch_Id);
                })
                ->select(DB::raw('COUNT(*) as callbackApp'))
                ->value('callbackApp');
        }

        $applist = Application::when($isBranchAdmin, function ($query) {
                $query->where('Branch_Id', $this->Branch_Id);
            })
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->paginate(10);

        $creditledger = CreditLedger::when($isBranchAdmin, function ($query) {
                $query->where('Branch_Id', $this->Branch_Id);
            })
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->paginate(10);

        $DebitLedger = Debit::when($isBranchAdmin, function ($query) {
                $query->where('Branch_Id', $this->Branch_Id);
            })
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->paginate(10);

        $callback = Callback_Db::when($isBranchAdmin, function ($query) {
                $query->where('Branch_Id', $this->Branch_Id);
            })
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->paginate(10);

        $feedback = Feedback::when($isBranchAdmin, function ($query) {
                $query->where('Branch_Id', $this->Branch_Id);
            })
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->paginate(10);

        $lead = ApplyServiceForm::when($isBranchAdmin, function ($query) {
                $query->where('Branch_Id', $this->Branch_Id);
            })
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->paginate(10);


        return view('livewire.admin-module.dashboard.dashboard-insight', ['Applist' => $applist, 'CreditLedger' => $creditledger, 'DebitLedger' => $DebitLedger, 'callbacks' => $callback, 'feedbacks' => $feedback, 'leads' => $lead]);
    }
}
