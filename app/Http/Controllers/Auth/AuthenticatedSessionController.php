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

        // Define Admin Roles
        $adminRoles = ['admin', 'branch admin', 'operator'];

        // Determine Redirect URL
        $url = in_array($request->user()->role, $adminRoles) ? '/admin/dashboard' : '/';

        // Get User Name for SweetAlert
        $name = $request->user()->name;

        // Set SweetAlert Notification
        session()->flash('swal', [
            'title' => 'Welcome Back!',
            'text' => "Hello, $name! You have successfully logged in.",
            'icon' => 'success',
            'timer' => 1000 // Redirect delay for smooth transition
        ]);

        return redirect()->intended($url);
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
