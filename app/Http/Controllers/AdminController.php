<?php

namespace App\Http\Controllers;

use App\Models\HomeSlide;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{

    public function HomeIndex()
    {
        $data = HomeSlide::find(1);
        return view('user.index',compact('data'));
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
}
