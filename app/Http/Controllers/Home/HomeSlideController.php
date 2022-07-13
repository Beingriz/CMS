<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeSlideController extends Controller
{
    //
    public function Index()
    {
        return view('admin.home.home_slide_update');
    }
    
}
