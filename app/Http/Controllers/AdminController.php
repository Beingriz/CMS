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
use Illuminate\Support\Facades\DB;
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
        $totalToday = DB::table('digital_cyber_db')
                        ->select(DB::raw('COUNT(*) as total_today'))
                        ->whereRaw('DATE(created_at) = CURDATE()')
                        ->value('total_today');

        $results = DB::select("SELECT YEAR(created_at) AS year, MONTH(created_at) AS month, COUNT(*) AS total_entries
                        FROM digital_cyber_db
                        WHERE (YEAR(created_at) = YEAR(CURRENT_DATE) AND MONTH(created_at) = MONTH(CURRENT_DATE))
                        GROUP BY  YEAR(created_at), MONTH(created_at)
                        ORDER BY  YEAR(created_at), MONTH(created_at) ");

        $totalSales =  DB::table('digital_cyber_db')
                                ->select(DB::raw('SUM(Amount_Paid) as total_amount'))
                                ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
                                ->value('total_amount');
        $totlaOrders = DB::table('digital_cyber_db')
                            ->select(DB::raw('COUNT(*) as total_orders'))
                            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
                            ->value('total_orders');
        $newUsers = DB::table('users')
                            ->select(DB::raw('COUNT(*) as new_users'))
                            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
                            ->value('new_users');
        $callBack = DB::table('callback')
                            ->select(DB::raw('COUNT(*) as callback'))
                            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
                            ->value('callback');
        $totalRevenue =  DB::table('credit_ledger')
                            ->select(DB::raw('SUM(Amount_Paid) as total_revenue'))
                            ->value('total_revenue');
        $lastWeekAmount = DB::select("SELECT SUM(Amount_Paid) AS lastWeekamount FROM credit_ledger
                            WHERE created_at >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) + 6 DAY
                                AND created_at < CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) - 1 DAY");
        $lastMonthAmount = DB::table('credit_ledger')
                            ->select(DB::raw('SUM(Amount_Paid) as total_amount'))
                            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)')
                            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)')
                            ->value('total_amount');


        return view('admin.index',['totalSales'=> $totalSales,'totalOrders'=>$totlaOrders,'newUsers'=>$newUsers,'callBack'=>$callBack,'totalRevenue'=>$totalRevenue,'lastWeekAmount'=>$lastWeekAmount[0]->lastWeekamount,'lastMonthAmount'=>$lastMonthAmount]);

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
        $editId="";
        return view('user.admin_forms.header_footer_form',['EditData'=>$editId]);
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
        $Id = "";
        return view('user.admin_forms.about_us_form',['EditData'=>$Id,'SelectId'=>$Id]);
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

    public function EditAboutUs($Id){
        $selectId="";
        return view('user.admin_forms.about_us_form',['EditData'=>$Id,'SelectId'=>$selectId]);
    }//End Function

    public function SelectAbout($Id){
        $editId="";
        return view('user.admin_forms.about_us_form',['EditData'=>$editId,'SelectId'=>$Id]);
    }//End Function

    public function DeleteAboutUs($Id)
    {
        $fetch = About_Us::findorFail($Id);
        $image = $fetch['Image'];
        if (Storage::disk('public')->exists($image)) // Check for existing File
        {
            unlink(storage_path('app/public/'.$image)); // Deleting Existing File
        }
        About_Us::Where('Id','=',$Id)->delete();
        $notification = array(
            'message'=>'Record Deleted!',
            'alert-type' =>'danger'
        );
        return redirect()->route('new.about_us')->with($notification);
    }
    public function EditHeader($Id){
        $editId="";
        return view('user.admin_forms.header_footer_form',['EditData'=>$editId,]);
    }//End Function
}
