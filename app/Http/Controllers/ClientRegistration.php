<?php

namespace App\Http\Controllers;

use App\Traits\RightInsightTrait;
use Illuminate\Support\Facades\Validator;
use App\Models\Application;
use App\Models\ClientRegister;

use Illuminate\Http\Request;

class ClientRegistration extends Controller
{
    use RightInsightTrait;

    public function Home()
    {
        return view('Admin.Clients.registration', [
            'applications_served' => $this->applications_served,
            'previous_day_app' => $this->previous_day_app,
            'applications_delivered' => $this->applications_delivered,
            'previous_day_app_delivered' => $this->previous_day_app_delivered,
            'total_revenue' => $this->sum,
            'previous_revenue' => $this->previous_sum,
            'balance_due' => $this->balance_due_sum,
            'previous_bal' => $this->previous_bal_sum,
        ]);
    }
    public function Register($Id)
    {
    }

    // public function RegisterUser(Request $request)
    // {
    //     $user_data=$request->input();
    //     $rule = ['Name'=>'required','Mobile_No'=>['required'],'DOB'=>'required','Address'=>'required'];
    //     $validation = Validator::make($user_data,$rule);
    //     if($validation->fails())
    //     {
    //         return redirect('client_registeration')->withInput()->withErrors($validation);
    //     }
    //     else
    //     {
    //         return "Data can save Now ";
    //     }
    // }
}
