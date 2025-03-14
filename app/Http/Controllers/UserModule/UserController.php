<?php

namespace App\Http\Controllers\UserModule;

use App\Http\Controllers\Controller;
use App\Models\About_Us;
use App\Models\Application;
use App\Models\ApplyServiceForm;
use App\Models\Callback_Db;
use App\Models\Carousel_DB;
use App\Models\Feedback;
use App\Models\HomeSlide;
use App\Models\MainServices;
use App\Models\QuickApply;
use App\Models\User;
use App\Models\UserTopBar;
use App\Traits\RightInsightTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class UserController extends Controller
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    use RightInsightTrait;
    public $Company_Name;
    public function HomeIndex()
    {
        $records = UserTopBar::Where('Selected', 'Yes')->get();
        foreach ($records as $key) {
            $this->Company_Name = $key['Company_Name'];
        }
        $carousel = Carousel_DB::all();
        $aboutus = About_Us::where('Selected', 'Yes')->get();
        $services = MainServices::where('Service_Type', 'Public')->get();
        $services_count = count($services);
        return view('user.user_home.user_index', compact('records', 'carousel', 'aboutus', 'services'), ['CompanyName' => $this->Company_Name, 'services_count' => $services_count, 'service_list' => $this->services_list]);
    }
    public function UserDashboard()
    {
        $records = UserTopBar::Where('Selected', 'Yes')->get();
        foreach ($records as $key) {
            $this->Company_Name = $key['Company_Name'];
        }
        $carousel = Carousel_DB::all();
        $aboutus = About_Us::where('Selected', 'Yes')->get();
        $services = MainServices::where('Service_Type', 'Public')->get();
        $services_count = count($services);
        return view('user.user_auth.user_dashboard', compact('records', 'carousel', 'aboutus', 'services'), ['CompanyName' => $this->Company_Name, 'services_count' => $services_count, 'service_list' => $this->services_list]);
    }
    public function UserHome($Id)
    {
        # code...
        $services = MainServices::where('Service_Type', 'Public')->get();
        $services_count = count($services);
        $registered_on = User::where('id', $Id)->latest('created_at')->first();
        $reg_time =  Carbon::parse($registered_on['created_at'])->diffForHumans();
        $applied = DB::table('digital_cyber_db')
            ->join('users', 'digital_cyber_db.Client_Id', '=', 'users.Client_Id')
            ->where('users.Client_Id', '=', Auth::user()->Client_Id)
            ->select('digital_cyber_db.*')
            ->orderBy('digital_cyber_db.created_at', 'desc')->count();
        // $applied = Application::where('Mobile_No', Auth::user()->mobile_no)->count();
        $records = DB::table('digital_cyber_db')
            ->join('users', 'digital_cyber_db.Client_Id', '=', 'users.Client_Id')
            ->where('users.Client_Id', '=', Auth::user()->Client_Id)
            ->select('digital_cyber_db.*')
            ->orderBy('digital_cyber_db.created_at', 'desc')->get();

        $delivered = Application::where('Mobile_No', Auth::user()->mobile_no)
            ->where('Status', 'Delivered to Client')->count();
        // if ($applied <= 0) {
        //     $applied = 1;
        // }
        $perc = ($delivered * 100) / ($applied == 0 ? 1 : $applied);
        $perc = number_format($perc, 2);
        $bal = 0;
        $paid = 0;
        foreach ($records as $key) {
                 if (is_array($key)) {
                      $paid += $key['Amount_Paid'];
                      $bal += $key['Balance'];
                } elseif (is_object($key)) {
                      $paid += $key->Amount_Paid;
                      $bal += $key->Balance;
                 }
              }
        return view('user.user_account.user_home', compact('services'), ['services_count' => $services_count, 'service_list' => $this->services_list, 'reg_on' => $reg_time, 'Applied' => $applied, 'Delivered' => $delivered, 'perc' => $perc, 'bal' => $bal, 'paid' => $paid]);
    }
    public function Home()
    {
        $data = HomeSlide::find(1);
        $records = UserTopBar::Where('Selected', 'Yes')->get();
        foreach ($records as $key) {
            $this->Company_Name = $key['Company_Name'];
        }
        $carousel = Carousel_DB::all();
        $aboutus = About_Us::where('Selected', 'Yes')->get();
        $services = MainServices::where('Service_Type', 'Public')->get();
        return view('user.user_home.user_index', compact('records', 'carousel', 'aboutus', 'services'), ['CompanyName' => $this->Company_Name]);
    }
    public function ContactUs()
    {
        # Function to call Contact us page from Menu
        $records = UserTopBar::Where('Selected', 'Yes')->get();
        foreach ($records as $key) {
            $this->Company_Name = $key['Company_Name'];
        }
        $services = MainServices::where('Service_Type', 'Public')->get();
        $carousel = Carousel_DB::all();
        return view('user.user_home.user-pages.enquiry-form-page', compact('services', 'records', 'carousel'));
    }
    public function AboutUS()
    {
        # code...
        $aboutus = About_Us::where('Selected', 'Yes')->get();
        $records = UserTopBar::Where('Selected', 'Yes')->get();
        foreach ($records as $key) {
            $this->Company_Name = $key['Company_Name'];
        }
        return view('user.user_home.user-pages.about-page', compact('aboutus', 'records'));
    }
    public function Teams()
    {
        # To Display Teams page...
        $records = UserTopBar::Where('Selected', 'Yes')->get();
        foreach ($records as $key) {
            $this->Company_Name = $key['Company_Name'];
        }
        return view('user.user_home.user-pages.team-page', compact('records'));
    }
    public function Testimonials()
    {
        # To Display Testimonial page...
        $records = UserTopBar::Where('Selected', 'Yes')->get();
        foreach ($records as $key) {
            $this->Company_Name = $key['Company_Name'];
        }
        return view('user.user_home.user-pages.Testimonial-page', compact('records'));
    }
    public function Feature()
    {
        # code...
        return view();
    }
    public function Services()
    {
        # To Display Services
        $records = UserTopBar::Where('Selected', 'Yes')->get();
        foreach ($records as $key) {
            $this->Company_Name = $key['Company_Name'];
        }
        $services = MainServices::where('Service_Type', 'Public')->get();
        return view('user.user_home.user-pages.services-page', compact('services', 'records'));
    }
    public function ServiceDetails($Id)
    {
        # code...
        $records = UserTopBar::Where('Selected', 'Yes')->get();
        foreach ($records as $key) {
            $this->Company_Name = $key['Company_Name'];
        }
        return view('user.user_home.user-pages.services-details-page', compact('records'), ['ServiceId' => $Id]);
    }

    public function ViewProfile()
    {
        $id = Auth::user()->id;
        $profiledata = User::find($id);
        return view('user.user_account.pages.user_view_profile', compact('profiledata'), ['services_count' => $this->services_count, 'service_list' => $this->services_list]);
    }

    public function MyServiceHistory($id)
    {
        return view('user.user_account.pages.user_service_history', ['id' => $id, 'services_count' => $this->services_count, 'service_list' => $this->services_list]);
    }
    public function MyOrderHistory($client_id)
    {
        $deleteId ='';
        return view('user.user_account.pages.user_order_history', ['deleteId'=>$deleteId,'client_id' => $client_id, 'services_count' => $this->services_count, 'service_list' => $this->services_list]);
    }
    public function deleteUserOrder($client_id)
    {
        $deleteId = $client_id;
        return view('user.user_account.pages.user_order_history', ['deleteId'=>$deleteId,'client_id' => $client_id, 'services_count' => $this->services_count, 'service_list' => $this->services_list]);
    }

    public function ServiceList()
    {
        $services = MainServices::where('Service_Type', 'Public')->get();
        return view('user.user_account.pages.services_list', compact('services'), ['services_count' => $this->services_count, 'service_list' => $this->services_list]);
    }
    public function ServDetails($Id)
    {
        $services = MainServices::where('Service_Type', 'Public')->get();
        return view('user.user_account.pages.services-details-page', compact('services'), ['services_count' => $this->services_count, 'service_list' => $this->services_list, 'ServiceId' => $Id]);
    }
    public function About()
    {
        $services = MainServices::where('Service_Type', 'Public')->get();
        $aboutus = About_Us::where('Selected', 'Yes')->get();
        return view('user.user_account.pages.about-page', compact('services', 'aboutus'), ['services_count' => $this->services_count, 'service_list' => $this->services_list]);
    }
    public function ApplyNow($Id, $price)
    {
        $services = MainServices::where('Service_Type', 'Public')->get();
        $aboutus = About_Us::where('Selected', 'Yes')->get();
        return view('user.user_account.pages.apply_now_form', compact('services', 'aboutus'), ['services_count' => $this->services_count, 'service_list' => $this->services_list, 'Id' => $Id, 'Price' => $price]);
    }
    public function ApplyNowCarousel($Id, $price)
    {
        $services = MainServices::where('Service_Type', 'Public')->get();
        $aboutus = About_Us::where('Selected', 'Yes')->get();
        return view('user.user_account.pages.apply_now_form', compact('services', 'aboutus'), ['services_count' => $this->services_count, 'service_list' => $this->services_list, 'Id' => $Id, 'Price' => $price]);
    }

    public function Acknowledgment($Id)
    {
        $services = MainServices::where('Service_Type', 'Public')->get();
        $aboutus = About_Us::where('Selected', 'Yes')->get();
        $date = Carbon::now();
        return view('user.user_account.pages.ackmowledgment', compact('services', 'aboutus'), ['services_count' => $this->services_count, 'service_list' => $this->services_list, 'App_Id' => $Id, 'date' => $date]);
    }
    public function Callback($Id, $service, $servicetype)
    {
        $user = User::findorFail($Id);
        $time = Carbon::now();
        $save = new Callback_Db();
        $save['Id'] = 'CB' . $time->format('m-d-Y-H:i:s');
        $save['Client_Id'] = $user->Client_Id;
        $save['Name'] = $user->name;
        $save['Mobile_No'] = $user->mobile_no;
        $save['Username'] = $user->username;
        $save['Service'] = $service;
        $save['Service_Type'] = $servicetype;
        $save['Profile_Image'] = $user->profile_image;
        $save->save();
        $notification = array(
            'message' => $user->name . ' your Callback Request for : ' . $service . ' -> ' . $servicetype . ' is Sent! Thank you!.',
            'alaert-type' => 'info',
        );
        return redirect()->route('user.home', $user->id)->with($notification);
    }
    public function Feedback($Id)
    {
        return view('user.user_account.pages.feedback_form', ['Id' => $Id], ['services_count' => $this->services_count, 'service_list' => $this->services_list]);
    }
    public function Follow()
    {
        return view('user.user_account.pages.follow_us', ['services_count' => $this->services_count, 'service_list' => $this->services_list]);
    }
    public function Track($id)
    {
        $records = QuickApply::where('id', $id)->get();
        $applied_on = QuickApply::where('id', $id)->latest('created_at')->first();
        $time =  Carbon::parse($applied_on['created_at'])->diffForHumans();

        return view('user.user_account.pages.track_application', ['time' => $time, 'records' => $records, 'Id' => $id, 'services_count' => $this->services_count, 'service_list' => $this->services_list]);
    }

    public function viewApplication($Id)
    {
        $records = Application::where('Id', $Id)->get();
        $applied_on = Application::where('id', $Id)->latest('created_at')->first();
        $time =  Carbon::parse($applied_on['created_at'])->diffForHumans();

        return view('user.user_account.pages.track_application', ['time' => $time, 'records' => $records, 'Id' => $Id, 'services_count' => $this->services_count, 'service_list' => $this->services_list]);
    }
    public function viewDocument($Id)
    {
        $record = QuickApply::where('id', $Id)->get();
        $file = '';
        foreach ($record as $item) {
            if (!empty($item->Consent)) {
                $file = $item->File;
            }
        }

        return view('user.user_account.pages.user_view_document', compact('record'), ['File' => $file, 'services_count' => $this->services_count, 'service_list' => $this->services_list]);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = array(
            'message' => 'You have been logged out Successfully',
            'alert-type' => 'success'
        );
        return redirect('/')->with($notification);
    } //End Destroy Function
}
