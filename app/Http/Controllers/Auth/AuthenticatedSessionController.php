<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Traits\WhatsappTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    use WhatsappTrait;
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        $url ='';
        if($request->user()->role === 'user' ){
            $url = '/';
        }elseif($request->user()->role === 'admin'){
            $url = '/admin/dashboard';
        }elseif($request->user()->role === 'branch admin'){
            $url = '/admin/dashboard';
        }elseif($request->user()->role === 'operator'){
            $url = '/admin/dashboard';
        }
        $name = $request->user()->name;

        $notification = array(
            'message'=>$name.' Welcome back',
            'alert-type' =>'success'
        );

        return redirect()->intended($url)->with($notification);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
