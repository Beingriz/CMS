<?php

namespace App\Http\Livewire\Admin\Admin;

use App\Models\Application;
use App\Models\ApplyServiceForm;
use App\Models\Callback_Db;
use App\Models\CreditLedger;
use App\Models\Debit;
use App\Models\Feedback;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboardinsight extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $totalToday,$results,$totalSales,$totlaOrders,$newUsers,$callBack,$totalRevenue,$lastWeekAmount,$lastMonthAmount;
    public $Report = false,$Caption = "Turnover";
    public $officeApp,$directApp,$callBackApp;
    public $ServReport = false,$ServCaption = "Service Insight ";
    public $officeAppRec,$creditRec,$debitRec,$applynowRec,$callbackRec;
    public function Today(){
        $this->Report = true;
        $this->Caption = 'Today Credit';
        $this->totalRevenue =  DB::table('credit_ledger')
        ->select(DB::raw('SUM(Amount_Paid) as total_revenue'))
        ->whereRaw('DATE(created_at) = CURDATE()')
        ->value('total_revenue');
    }
    public function Debit(){
        $this->Report = true;
        $this->Caption = 'Today Debit';
        $this->totalRevenue =  DB::table('debit_ledger')
        ->select(DB::raw('SUM(Amount_Paid) as total_revenue'))
        ->whereRaw('DATE(created_at) = CURDATE()')
        ->value('total_revenue');
    }
    public function ServToday(){
        $this->ServReport = true;
        $this->ServCaption = "Today";
        $this->officeApp = DB::table('digital_cyber_db')
                                ->select(DB::raw('COUNT(*) as officeApp'))
                                ->whereRaw('DATE(created_at) = CURDATE()')
                                ->value('officeApp');

        $this->directApp = DB::table('applynow')
                                ->select(DB::raw('COUNT(*) as directApp'))
                                ->whereRaw('DATE(created_at) = CURDATE()')
                                ->value('directApp');
        $this->callBackApp = DB::table('callback')
                                ->select(DB::raw('COUNT(*) as callbackApp'))
                                ->whereRaw('DATE(created_at) = CURDATE()')
                                ->value('callbackApp');
    }
    public function ServLastWeek(){
        $this->ServReport = true;
        $this->ServCaption = "Last Week";
        $this->officeApp =  DB::table('digital_cyber_db')
                            ->where('created_at', '>=', DB::raw('CURDATE() - INTERVAL 1 WEEK'))
                            ->count();

        $this->directApp = DB::table('applynow')
                            ->where('created_at', '>=', DB::raw('CURDATE() - INTERVAL 1 WEEK'))
                            ->count();
        $this->callBackApp = DB::table('callback')
                                ->select(DB::raw('COUNT(*) as callbackApp'))
                                ->where('created_at', '>=', DB::raw('CURDATE() - INTERVAL 1 WEEK'))
                                ->count();
    }
    public function ServLastMonth(){
        $this->ServReport = true;
        $this->ServCaption = "Last Month";
        $this->officeApp =  DB::table('digital_cyber_db')
                            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)')
                            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)')
                            ->count();

        $this->directApp = DB::table('applynow')
                            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)')
                            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)')
                            ->count();
        $this->callBackApp = DB::table('callback')
                            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)')
                            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)')
                            ->count();
    }
    public function ServThisYear(){
        $this->ServReport = true;
        $this->ServCaption = "This Year";
        $this->officeApp =  DB::table('digital_cyber_db')
                            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE)')
                            ->count();

        $this->directApp = DB::table('applynow')
                            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE)')
                            ->count();
        $this->callBackApp = DB::table('callback')
                            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE)')
                            ->count();
    }
    public function ServLastYear(){
        $this->ServReport = true;
        $this->ServCaption = "Last Year";
        $this->officeApp =  DB::table('digital_cyber_db')
                            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 YEAR)')
                            ->count();

        $this->directApp = DB::table('applynow')
                            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 YEAR)')
                            ->count();
        $this->callBackApp = DB::table('callback')
                            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 YEAR)')
                            ->count();
    }
    public $creditReport = false,$appReport = true,$debitReport = false,$leadReport = false,$callBackReport = false,$feedbackReport = false;

    public function CreditLedger(){
        //Credit Ledger
        $this->creditReport = true;
        $this->appReport = false;
        $this->callBackReport = false;
        $this->leadReport = false;
        $this->feedbackReport = false;
        $this->debitReport = false;


    } // End Function
    public function DebitLedger(){
        //Debit Ledger
        $this->debitReport = true;
        $this->creditReport = false;
        $this->appReport = false;
        $this->callBackReport = false;
        $this->leadReport = false;
        $this->feedbackReport = false;

    }// End Function

    public function Leads(){
        //Leads
        $this->debitReport = false;
        $this->creditReport = false;
        $this->appReport = false;
        $this->callBackReport = false;
        $this->leadReport = true;
        $this->feedbackReport = false;


    }// End Function

    public function CallBack(){
        //CallBack
        $this->debitReport = false;
        $this->creditReport = false;
        $this->appReport = false;
        $this->callBackReport = true;
        $this->leadReport = false;
        $this->feedbackReport = false;
    }// End Function

    public function FeedBack(){
        //FeedBack
        $this->debitReport = false;
        $this->creditReport = false;
        $this->appReport = false;
        $this->callBackReport = false;
        $this->leadReport = false;
        $this->feedbackReport = true;
    }// End Function


   public function render()
    {
        $this->totalToday = DB::table('digital_cyber_db')
                        ->select(DB::raw('COUNT(*) as total_today'))
                        ->whereRaw('DATE(created_at) = CURDATE()')
                        ->value('total_today');

        $this->results = DB::select("SELECT YEAR(created_at) AS year, MONTH(created_at) AS month, COUNT(*) AS total_entries
                        FROM digital_cyber_db
                        WHERE (YEAR(created_at) = YEAR(CURRENT_DATE) AND MONTH(created_at) = MONTH(CURRENT_DATE))
                        GROUP BY  YEAR(created_at), MONTH(created_at)
                        ORDER BY  YEAR(created_at), MONTH(created_at) ");

        $this->totalSales =  DB::table('digital_cyber_db')
                                ->select(DB::raw('SUM(Amount_Paid) as total_amount'))
                                ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
                                ->value('total_amount');
        $this->totlaOrders = DB::table('digital_cyber_db')
                            ->select(DB::raw('COUNT(*) as total_orders'))
                            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
                            ->value('total_orders');
        $this->newUsers = DB::table('users')
                            ->select(DB::raw('COUNT(*) as new_users'))
                            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
                            ->value('new_users');
        $this->callBack = DB::table('callback')
                            ->select(DB::raw('COUNT(*) as callback'))
                            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
                            ->value('callback');
        if(!$this->Report){

        $this->totalRevenue =  DB::table('credit_ledger')
                            ->select(DB::raw('SUM(Amount_Paid) as total_revenue'))
                            ->value('total_revenue');
        }
        $this->lastWeekAmount = DB::select("SELECT SUM(Amount_Paid) AS lastWeekamount FROM credit_ledger
                            WHERE created_at >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) + 6 DAY
                                AND created_at < CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) - 1 DAY");
        $this->lastMonthAmount = DB::table('credit_ledger')
                            ->select(DB::raw('SUM(Amount_Paid) as total_amount'))
                            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)')
                            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)')
                            ->value('total_amount');

        if(!$this->ServReport){
        $this->officeApp = DB::table('digital_cyber_db')
                            ->select(DB::raw('COUNT(*) as officeApp'))
                            ->value('officeApp');
        $this->directApp = DB::table('applynow')
                            ->select(DB::raw('COUNT(*) as directApp'))
                            ->value('directApp');
        $this->callBackApp = DB::table('callback')
                            ->select(DB::raw('COUNT(*) as callbackApp'))
                            ->value('callbackApp');
        }
        $applist = Application::whereDate('created_at',DB::raw('CURDATE()'))->paginate(10);
        $creditledger = CreditLedger::whereDate('created_at',DB::raw('CURDATE()'))->paginate(10);
        $DebitLedger = Debit::whereDate('created_at',DB::raw('CURDATE()'))->paginate(10);
        $callback = Callback_Db::whereDate('created_at',DB::raw('CURDATE()'))->paginate(10);
        $feedback = Feedback::whereDate('created_at',DB::raw('CURDATE()'))->paginate(10);
        $lead = ApplyServiceForm::whereDate('created_at',DB::raw('CURDATE()'))->paginate(10);

        return view('livewire.admin.admin.dashboardinsight',['Applist'=>$applist,'CreditLedger'=>$creditledger,'DebitLedger'=>$DebitLedger,'callbacks'=>$callback,'feedbacks'=>$feedback,'leads'=>$lead]);
    }
}
