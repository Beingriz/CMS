<?php

namespace App\Http\Controllers;

use App\Models\MainServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Products;
use App\Traits\RightInsightTrait;

class ProductController extends Controller
{
    use RightInsightTrait;
    public function Home()
    {
        $this->MainServices = MainServices::where('Service_Type','Public')->orderby('Order_By','asc')->get();
        return view('dashboard',['services'=>$this->MainServices]);
    }
    public function ProductDetails($MainServiceId)
    {

        return view('Application.product_details',[
            'MainServiceId'=>$MainServiceId,
        ]);
    }
    public function AddDocument()
    {
        return view('Admin.Document_List.add_document',[
            'applications_served'=>$this->applications_served,
            'previous_day_app'=>$this->previous_day_app,
            'applications_delivered'=>$this->applications_delivered,
            'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,
        ]);
    }

    public function Index()
    {
        return view('admin.Services.add_service',[
            'applications_served'=>$this->applications_served,
            'previous_day_app'=>$this->previous_day_app,
            'applications_delivered'=>$this->applications_delivered,
            'previous_day_app_delivered'=>$this->previous_day_app_delivered, 'total_revenue'=>$this->sum,'previous_revenue'=>$this->previous_sum,'balance_due'=>$this->balance_due_sum,'previous_bal'=>$this->previous_bal_sum,
        ]);
    }


}
