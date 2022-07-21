<?php

namespace App\Http\Controllers;

use App\Traits\RightInsightTrait;
use Illuminate\Http\Request;

class Admin extends Controller
{
    use RightInsightTrait;
    public function Home()
    {
        return view('Admin.admin_dashboard',[
            'bookmarks'=>$this->bookmarks, 'application_type'=>$this->application_type,'payment_mode'=>$this->payment_mode, 'n'=>$this->n,'applications_served'=>$this->applications_served,'previous_day_app'=>$this->previous_day_app,'applications_delivered'=>$this->applications_delivered,'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,'today'=>$this->today
        ]);
    }
}
