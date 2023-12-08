<?php

namespace App\Http\Controllers;

use App\Models\Bookmarks;
use App\Models\Status;
use App\Traits\RightInsightTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Home extends Controller
{
    use RightInsightTrait;



    public function HomeDashboard()
    {
        $status  = count($this->status);
        if ($status > 0) {

            foreach ($this->status as $key) {

                $status_count = DB::table('digital_cyber_db')->where('Status', '=', $key['Status'])->count();
                DB::update('update status set Total_Count=? where Sl_No=?', [$status_count, $key['Sl_No']]);
                $status_amount = DB::table('digital_cyber_db')->where('Status', '=', $key['Status'])->count();
                $total_amount = 0;
                if ($status_amount > 0) {
                    $add_amount = DB::table('digital_cyber_db')->where('Status', '=', $key['Status'])->get();
                    foreach ($add_amount as $total) {
                        $total  = get_object_vars($total); {
                            $total_amount += $total['Amount_Paid'];
                        }
                    }
                }
                DB::update('update status set Total_Amount=? where Sl_No=?', [$total_amount, $key['Sl_No']]);
            }
        }

        // Code for insight Data Records are fetched from RightInsight Trait
        return view('Application\home-dashboard', ['total_applicaiton' => $this->applications_served, 'total_amount' => $total_amount, 'services' => $this->application_type, 'applications_served' => $this->applications_served, 'previous_day_app' => $this->previous_day_app, 'applications_delivered' => $this->applications_delivered, 'previous_day_app_delivered' => $this->previous_day_app_delivered, 'total_revenue' => $this->sum, 'previous_revenue' => $this->previous_sum, 'balance_due' => $this->balance_due_sum, 'previous_bal' => $this->previous_bal_sum, 'new_clients' => $this->new_clients, 'previous_day_new_clients' => $this->previous_day_new_clients, 'status' => $this->status, 'bookmarks' => $this->bookmarks]);
    }
}
