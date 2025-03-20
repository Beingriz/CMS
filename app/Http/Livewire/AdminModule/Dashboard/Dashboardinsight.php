<?php

namespace App\Http\Livewire\AdminModule\Dashboard;

use App\Models\Application;
use App\Models\Callback_Db;
use App\Models\CreditLedger;
use App\Models\Debit;
use App\Models\Feedback;
use App\Models\QuickApply;
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
    public $Branch_Id, $Emp_Id, $isBranchAdminOrOperator;

    public function mount()
    {


         // Check if there's a session event and emit it to Livewire
         if (session()->has('emit_livewire_event')) {
            $eventData = session('emit_livewire_event');
            $this->emit($eventData['event'], $eventData);
        }
        $this->Branch_Id = Auth::user()->branch_id;
        $this->Emp_Id = Auth::user()->Emp_Id;
        $this->isBranchAdminOrOperator = in_array(Auth::user()->role, ['branch admin', 'operator']);
    }
    public function showSweetAlert($data)
    {
        $this->dispatchBrowserEvent('swal:success', $data);
    }

    private function queryWithRole($table, $dateColumn = 'created_at')
    {
        $branchId = 'Branch_Id';
        if($table == 'quick_apply'){
            $branchId = 'branch_id';
        }
        $query = DB::table($table)->whereDate($dateColumn, '=', now()->toDateString());
        if ($this->isBranchAdminOrOperator) {
            $query->where($branchId, $this->Branch_Id);
        }
        return $query;
    }

    public function Today()
    {
        $this->Report = true;
        $this->Caption = 'Today Credit';
        $this->totalRevenue = $this->queryWithRole('credit_ledger')->sum('Amount_Paid');
    }

    public function Debit()
    {
        $this->Report = true;
        $this->Caption = 'Today Debit';
        $this->totalRevenue = $this->queryWithRole('debit_ledger')->sum('Amount_Paid');
    }

    public function ServToday()
    {
        $this->ServReport = true;
        $this->ServCaption = "Today";
        $this->officeApp = $this->queryWithRole('digital_cyber_db')->count();
        $this->directApp = $this->queryWithRole('quick_apply')->count();
        $this->callBackApp = $this->queryWithRole('callback')->count();
    }

    public function ServLastWeek()
    {
        $this->ServReport = true;
        $this->ServCaption = "Last Week";

        $startOfWeek = now()->subWeek()->startOfDay();
        $endOfWeek = now()->endOfDay();

        $this->officeApp = $this->queryWithRoleBetweenDates('digital_cyber_db', $startOfWeek, $endOfWeek)->count();
        $this->directApp = $this->queryWithRoleBetweenDates('quick_apply', $startOfWeek, $endOfWeek)->count();
        $this->callBackApp = $this->queryWithRoleBetweenDates('callback', $startOfWeek, $endOfWeek)->count();
    }

    public function ServLastMonth()
    {
        $this->ServReport = true;
        $this->ServCaption = "Last Month";

        $startOfLastMonth = now()->subMonth()->startOfMonth();
        $endOfLastMonth = now()->subMonth()->endOfMonth();

        $this->officeApp = $this->queryWithRoleBetweenDates('digital_cyber_db', $startOfLastMonth, $endOfLastMonth)->count();
        $this->directApp = $this->queryWithRoleBetweenDates('quick_apply', $startOfLastMonth, $endOfLastMonth)->count();
        $this->callBackApp = $this->queryWithRoleBetweenDates('callback', $startOfLastMonth, $endOfLastMonth)->count();
    }

    public function ServThisYear()
    {
        $this->ServReport = true;
        $this->ServCaption = "This Year";

        $startOfYear = now()->startOfYear();
        $endOfYear = now()->endOfYear();

        $this->officeApp = $this->queryWithRoleBetweenDates('digital_cyber_db', $startOfYear, $endOfYear)->count();
        $this->directApp = $this->queryWithRoleBetweenDates('quick_apply', $startOfYear, $endOfYear)->count();
        $this->callBackApp = $this->queryWithRoleBetweenDates('callback', $startOfYear, $endOfYear)->count();
    }

    public function ServLastYear()
    {
        $this->ServReport = true;
        $this->ServCaption = "Last Year";

        $startOfLastYear = now()->subYear()->startOfYear();
        $endOfLastYear = now()->subYear()->endOfYear();

        $this->officeApp = $this->queryWithRoleBetweenDates('digital_cyber_db', $startOfLastYear, $endOfLastYear)->count();
        $this->directApp = $this->queryWithRoleBetweenDates('quick_apply', $startOfLastYear, $endOfLastYear)->count();
        $this->callBackApp = $this->queryWithRoleBetweenDates('callback', $startOfLastYear, $endOfLastYear)->count();
    }

    private function queryWithRoleBetweenDates($table, $startDate, $endDate, $dateColumn = 'created_at')
    {
        $query = DB::table($table)->whereBetween($dateColumn, [$startDate, $endDate]);
        if ($this->isBranchAdminOrOperator) {
            $query->where('Branch_Id', $this->Branch_Id);
        }
        return $query;
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
        $this->totalToday = Application::when($this->isBranchAdminOrOperator, function ($query) {
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

        $this->totalSales = Application::when($this->isBranchAdminOrOperator, function ($query) {
            $query->where('Branch_Id', $this->Branch_Id);
        })
        ->select(DB::raw('SUM(Amount_Paid) as total_amount'))
        ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
        ->value('total_amount');

        $this->totalOrders = Application::when($this->isBranchAdminOrOperator, function ($query) {
            $query->where('Branch_Id', $this->Branch_Id);
        })
        ->select(DB::raw('COUNT(*) as total_orders'))
        ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
        ->value('total_orders');

        $this->newUsers = User::when($this->isBranchAdminOrOperator, function ($query) {
            $query->where('Branch_Id', $this->Branch_Id);
        })
        ->select(DB::raw('COUNT(*) as new_users'))
        ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
        ->value('new_users');

        $this->callBack = Callback_Db::when($this->isBranchAdminOrOperator, function ($query) {
            $query->where('Branch_Id', $this->Branch_Id);
        })
        ->select(DB::raw('COUNT(*) as callback'))
        ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
        ->value('callback');

        if (!$this->Report) {
            $this->totalRevenue = CreditLedger::when($this->isBranchAdminOrOperator, function ($query) {
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

        $this->lastMonthAmount = CreditLedger::when($this->isBranchAdminOrOperator, function ($query) {
            $query->where('Branch_Id', $this->Branch_Id);
        })
        ->select(DB::raw('SUM(Amount_Paid) as total_amount'))
        ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)')
        ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)')
        ->value('total_amount');

        if (!$this->ServReport) {
            $this->officeApp = Application::when($this->isBranchAdminOrOperator, function ($query) {
                $query->where('Branch_Id', $this->Branch_Id);
            })
            ->select(DB::raw('COUNT(*) as officeApp'))
            ->value('officeApp');

            $this->directApp = QuickApply::when($this->isBranchAdminOrOperator, function ($query) {
                $query->where('branch_id', $this->Branch_Id);
            })
            ->select(DB::raw('COUNT(*) as directApp'))
            ->value('directApp');

            $this->callBackApp = Callback_Db::when($this->isBranchAdminOrOperator, function ($query) {
                $query->where('Branch_Id', $this->Branch_Id);
            })
            ->select(DB::raw('COUNT(*) as callbackApp'))
            ->value('callbackApp');
        }

        $applist = Application::when($this->isBranchAdminOrOperator, function ($query) {
            $query->where('Branch_Id', $this->Branch_Id);
        })
        ->whereDate('created_at', today())
        ->where('Recycle_Bin','No')
        ->paginate(10);

        $creditledger = CreditLedger::when($this->isBranchAdminOrOperator, function ($query) {
            $query->where('Branch_Id', $this->Branch_Id);
        })
        ->whereDate('created_at',  today())
        ->paginate(10);

        $DebitLedger = Debit::when($this->isBranchAdminOrOperator, function ($query) {
            $query->where('Branch_Id', $this->Branch_Id);
        })
        ->whereDate('created_at',  today())
        ->paginate(10);

        $callback = Callback_Db::when($this->isBranchAdminOrOperator, function ($query) {
            $query->where('Branch_Id', $this->Branch_Id);
        })
        ->whereDate('created_at',  today())
        ->paginate(10);

        $feedback = Feedback::when($this->isBranchAdminOrOperator, function ($query) {
            $query->where('Branch_Id', $this->Branch_Id);
        })
        ->whereDate('created_at',  today())
        ->paginate(10);

        $lead = QuickApply::when($this->isBranchAdminOrOperator, function ($query) {
            $query->where('branch_id', $this->Branch_Id);
        })
        ->whereDate('created_at',  today())
        ->paginate(10);

        return view('livewire.admin-module.dashboard.dashboard-insight', [
            'Applist' => $applist,
            'CreditLedger' => $creditledger,
            'DebitLedger' => $DebitLedger,
            'callbacks' => $callback,
            'feedbacks' => $feedback,
            'leads' => $lead,
        ]);
    }
}
