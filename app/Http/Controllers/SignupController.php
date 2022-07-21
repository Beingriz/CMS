<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Signup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    //
    public function index()
    {
        return view('Authentication.Signup.singup');
    }

    public function Save(Request $request)
    {
        $id = 'DCP'.date("Y").mt_rand(100,999);
        $validate = $request->input();
        $validate_rule = ['First_Name'=>'required','Last_Name'=>'required', 'Email'=>['required','email','unique:users'], 'Password'=>'required | min:6'];
        $validation = Validator::make($request->input(), $validate_rule);
        if($validation->fails())
        {
            return redirect('signup')->withInput()->withErrors($validation);

        }
        else
        {
            $name = $request->First_Name .' '. $request->Last_Name;

            $id = "DC".date("Y").$request->First_Name.mt_rand(100, 999);
            $save = new Signup();
            $save->name = $name;
            $save->email = $request->Email;
            $save->password = Hash::make($request->Passoword);
            $save->save();

            if(Auth::guard('users')->attempt($this->only('email','password')))
            {
                return redirect('admin_home')->with('SuccessMsg', "User Created Successfuly!! Login Id ::  ". $id);
            }

        }
    }
}
