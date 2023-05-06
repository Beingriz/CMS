<?php

namespace App\Http\Controllers;

use App\Models\About_Us;
use App\Models\Application;
use App\Models\Carousel_DB;
use App\Models\HomeSlide;
use App\Models\MainServices;
use App\Models\User;
use App\Models\UserTopBar;
use App\Traits\RightInsightTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class UserController extends Controller
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    use RightInsightTrait;
    public $Company_Name;
    public function HomeIndex(){
        $records = UserTopBar::Where('Selected','Yes')->get();
        foreach($records as $key){
            $this->Company_Name = $key['Company_Name'];
        }
        $carousel = Carousel_DB::all();
        $aboutus = About_Us::where('Selected','Yes')->get();
        $services = MainServices::where('Service_Type','Public')->get();
        $services_count = count($services);
        return view('user.user_home.user_index',compact('records','carousel','aboutus','services'),['CompanyName'=>$this->Company_Name,'services_count'=>$services_count,'service_list'=>$this->services_list]);
    }
    public function UserDashboard(){
        $records = UserTopBar::Where('Selected','Yes')->get();
        foreach($records as $key){
            $this->Company_Name = $key['Company_Name'];
        }
        $carousel = Carousel_DB::all();
        $aboutus = About_Us::where('Selected','Yes')->get();
        $services = MainServices::where('Service_Type','Public')->get();
        $services_count = count($services);
        return view('user.user_auth.user_dashboard',compact('records','carousel','aboutus','services'),['CompanyName'=>$this->Company_Name,'services_count'=>$services_count,'service_list'=>$this->services_list]);
    }
    public function UserHome($Id)
    {
        # code...
        $services = MainServices::where('Service_Type','Public')->get();
        $services_count = count($services);
        return view('user.user_account.user_home',['services_count'=>$services_count,'service_list'=>$this->services_list]);
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
        return view('user.user_home.user-pages.enquiry-form-page',compact('services','records','carousel'));
    }
    public function AboutUS()
    {
        # code...
        $aboutus = About_Us::where('Selected','Yes')->get();
        $records = UserTopBar::Where('Selected','Yes')->get();
        foreach($records as $key){
            $this->Company_Name = $key['Company_Name'];
        }
        return view('user.user_home.user-pages.about-page',compact('aboutus','records'));
    }
    public function Teams()
    {
        # To Display Teams page...
        $records = UserTopBar::Where('Selected','Yes')->get();
        foreach($records as $key){
            $this->Company_Name = $key['Company_Name'];
        }
        return view('user.user_home.user-pages.team-page',compact('records'));
    }
    public function Testimonials()
    {
        # To Display Testimonial page...
        $records = UserTopBar::Where('Selected','Yes')->get();
        foreach($records as $key){
            $this->Company_Name = $key['Company_Name'];
        }
        return view('user.user_home.user-pages.Testimonial-page',compact('records'));
    }
    public function Feature()
    {
        # code...
        return view();
    }
    public function Services()
    {
        # To Display Services
        $records = UserTopBar::Where('Selected','Yes')->get();
        foreach($records as $key){
            $this->Company_Name = $key['Company_Name'];
        }
        $services = MainServices::where('Service_Type','Public')->get();
        return view('user.user_home.user-pages.services-page',compact('services','records'));
    }
    public function ServiceDetails($Id)
    {
        # code...
        $records = UserTopBar::Where('Selected','Yes')->get();
        foreach($records as $key){
            $this->Company_Name = $key['Company_Name'];
        }
        return view('user.user_home.user-pages.services-details-page',compact('records'),['ServiceId'=>$Id]);
    }

    public function ViewProfile(){
        $id = Auth::user()->id;
        $profiledata = User::find($id);
        return view('user.user_account.pages.user_view_profile',compact('profiledata'),['services_count'=>$this->services_count,'service_list'=>$this->services_list]);
    }

    public function MyServiceHistory($mobile_no){
        return view('user.user_account.pages.user_service_history',['mobile_no'=>$mobile_no,'services_count'=>$this->services_count,'service_list'=>$this->services_list]);
    }

    public function ServiceList()
    {
        $services = MainServices::where('Service_Type','Public')->get();
        return view('user.user_account.pages.services_list',compact('services'),['services_count'=>$this->services_count,'service_list'=>$this->services_list]);
    }
    public function ServDetails($Id)
    {
        $services = MainServices::where('Service_Type','Public')->get();
        return view('user.user_account.pages.services-details-page',compact('services'),['services_count'=>$this->services_count,'service_list'=>$this->services_list,'ServiceId'=>$Id]);
    }
    public function About()
    {
        $services = MainServices::where('Service_Type','Public')->get();
        $aboutus = About_Us::where('Selected','Yes')->get();
        return view('user.user_account.pages.about-page',compact('services','aboutus'),['services_count'=>$this->services_count,'service_list'=>$this->services_list]);
    }
}

