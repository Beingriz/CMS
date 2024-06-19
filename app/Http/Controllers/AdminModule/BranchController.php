<?php

namespace App\Http\Controllers\AdminModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    //
    public function BranchAdminDashboard(){
        return view('branch-admin-module.index');
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
