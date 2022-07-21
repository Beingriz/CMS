<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('Authentication.Login.login');
    }
    public function Signup()
    {
        return view('Authentication.Signup.singup');
    }
}
