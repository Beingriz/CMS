<?php

namespace App\Http\Controllers;

use App\Http\Livewire\UserTopBar;
use App\Models\About_Us;
use App\Models\Carousel_DB;
use App\Models\HomeSlide;
use App\Models\MainServices;
use App\Models\User;
use App\Models\UserTopBar as ModelsUserTopBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{

    public $Company_Name;
    public function HomeIndex()
    {
        $data = HomeSlide::find(1);
        $records = ModelsUserTopBar::Where('Selected','Yes')->get();
        foreach($records as $key){
            $this->Company_Name = $key['Company_Name'];
        }
        $carousel = Carousel_DB::all();
        $aboutus = About_Us::where('Selected','Yes')->get();
        $services = MainServices::where('Service_Type','Public')->get();
        return view('user.index',compact('records','carousel','aboutus','services'),['CompanyName'=>$this->Company_Name]);
    }
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = array(
            'message'=>'You have been logged out Successfully',
            'alert-type' =>'success'
        );
        return redirect('/login')->with($notification);
    } //End Destroy Function

    public function ProfileView()
    {
        $id = Auth::user()->id;
        $profiledata = User::find($id);
        return view('admin.profile.profile_view',compact('profiledata'));
    }
    public function ChangePassword()
    {
        return view('admin.profile.change_password');
    }
    public function AddServices()
    {
        return view('admin.Services.add_service');
    }
    public function UserTopBar()
    {
        return view('user.user_dashboard.topbar');
    }
    public function Carousel()
    {
        # code...
        return view('user.user_dashboard.carousel');
    }
    public function AboutUs()
    {
        # code...
        return view('user.user_dashboard.about_us');
    }
}
