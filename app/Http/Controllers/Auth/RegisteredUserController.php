<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ClientRegister;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dob' => ['required'],
            'mobile_no' => ['required', 'max:10','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'mobile_no' => $request->mobile_no,
            'dob' => $request->dob,
            'email' => $request->email,
            'Status' => trim('user'),
            'password' => Hash::make($request->password),
        ]);
        $client = new ClientRegister();
            $client->fill([
                'Id' => 'DC'.time(),
                'Name' => trim($request->name),
                'Relative_Name' => trim('Not Available'),
                'Gender' => trim('Not Available'),
                'DOB' => trim($request->dob),
                'Mobile_No' => trim($request->mobile_no),
                'Email_Id' => trim($request->email),
                'Address' => 'Not Available',
                'Profile_Image' => 'account.png',
                'Client_Type' => 'New Client',
            ]);
            $client->save();

        event(new Registered($user));

        Auth::login($user);
        $this->userRegisterationAlert(trim($request->mobile_no),trim($request->name),trim($request->username),trim($request->password));
        return redirect(RouteServiceProvider::HOME);
    }
}
