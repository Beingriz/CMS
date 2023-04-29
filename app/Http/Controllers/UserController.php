<?php

namespace App\Http\Controllers;

use App\Models\About_Us;
use App\Models\Carousel_DB;
use App\Models\HomeSlide;
use App\Models\MainServices;
use App\Models\UserTopBar;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public $Company_Name;
    public function HomeIndex(){
        $records = UserTopBar::Where('Selected','Yes')->get();
        foreach($records as $key){
            $this->Company_Name = $key['Company_Name'];
        }
        $carousel = Carousel_DB::all();
        $aboutus = About_Us::where('Selected','Yes')->get();
        $services = MainServices::where('Service_Type','Public')->get();
        return view('user.user_home.user_index',compact('records','carousel','aboutus','services'),['CompanyName'=>$this->Company_Name]);
    }
    public function Home()
    {
        $data = HomeSlide::find(1);
        $records = UserTopBar::Where('Selected','Yes')->get();
        foreach($records as $key){
            $this->Company_Name = $key['Company_Name'];
        }
        $carousel = Carousel_DB::all();
        $aboutus = About_Us::where('Selected','Yes')->get();
        $services = MainServices::where('Service_Type','Public')->get();
        return view('user.user_home.user_index',compact('records','carousel','aboutus','services'),['CompanyName'=>$this->Company_Name]);
    }
    public function ContactUs()
    {
        # Function to call Contact us page from Menu
        $records = UserTopBar::Where('Selected','Yes')->get();
        foreach($records as $key){
            $this->Company_Name = $key['Company_Name'];
        }
        $services = MainServices::where('Service_Type','Public')->get();
        $carousel = Carousel_DB::all();

        return view('user.user_home.enquiry-form',compact('services','records','carousel'));
    }
}
