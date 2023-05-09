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
use Illuminate\Support\Facades\Storage;

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
        return view('user.user_home.user_index',compact('records','carousel','aboutus','services'),['CompanyName'=>$this->Company_Name]);
    }
    public function AdminDashboard(){
        return view('admin.index');

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
        return redirect('/')->with($notification);
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
        return view('user.admin_forms.header_footer_form');
    }
    public function Carousel()
    {
        # code...
        $Id ="";
        return view('user.admin_forms.carousel_form',['EditData'=>$Id]);
    }
    public function AboutUs()
    {
        # code...
        return view('user.admin_forms.about_us_form');
    }
    public function ContactUs()
    {
        # code...
        return view('user.user_dashboard.enquiry-form');
    }
    public function DeleteCarousel($Id)
    {
        $getDetials = Carousel_DB::findorFail($Id);
        $img = $getDetials->Image;

        if (Storage::disk('public')->exists($img)) // Check for existing File
        {
            unlink(storage_path('app/public/'.$img)); // Deleting Existing File
        }
        Carousel_DB::where('Id',$Id)->delete();
        $notification = array(
            'message' =>'Deleted Succssfully',
            'alert-type'  => 'info'
        );
        return redirect()->back()->with($notification);
    }
    public function EditCarousel($Id){
        return view('user.admin_forms.carousel_form',['EditData'=>$Id]);
    }//End Function
}
