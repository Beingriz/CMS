<?php

namespace App\Http\Controllers\AdminModule;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    //Dashboard
    public function BranchAdminDashboard(){
        return view('branch-admin-module.index');
    }

    //Profile View
    public function ProfileView()
    {
        $id = Auth::user()->id;
        $profiledata = User::find($id);
        return view('branch-admin-module.profile.profile_view', compact('profiledata'));
    }

    //Change Password
    public function ChangePassword()
    {
        return view('branch-admin-module.profile.change_password');
    }

    //Logout
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
