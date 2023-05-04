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
    public function Registration(){
        $records = UserTopBar::Where('Selected','Yes')->get();
        foreach($records as $key){
            $this->Company_Name = $key['Company_Name'];
        }
        return view('user.user_auth.user_registration',compact('records'));
    }
    public function Dashboard(){
        $records = UserTopBar::Where('Selected','Yes')->get();
        foreach($records as $key){
            $this->Company_Name = $key['Company_Name'];
        }
        $carousel = Carousel_DB::all();
        $aboutus = About_Us::where('Selected','Yes')->get();
        $services = MainServices::where('Service_Type','Public')->get();
        return view('user.user_auth.user_dashboard',compact('records','carousel','aboutus','services'),['CompanyName'=>$this->Company_Name]);

    }
}
