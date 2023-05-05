<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;

class UserRegister extends Component
{
    public $name,$email,$username,$mobile_no,$password,$password_confirmation;
    protected $rules = [
        'name' =>'required',
        'mobile_no'=>'required | min:10 | max : 10 | unique:users',
        'username'=>'required | unique:users',
        'email'=>'required | unique:users',
        'password'=>['required' ,'confirmed','min:8'],
    ];
    protected $message = [
        'name' =>'please enter your name',
        'mobile_no'=>'enter your name',
        'username'=>'Select unique username',
        'email'=>'enter your email id',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function Register(){
        $this->validate();
        $user = User::create([
            'name' => $this->name,
            'username' => $this->username,
            'mobile_no' => $this->mobile_no,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
        $notification = array(
            'message'=>$this->name.' Login Successfull',
            'alert-type' =>'info'
        );
        return redirect('/user/dashboard')->with($notification);
    }
    public function render()
    {
        return view('livewire.user-register');
    }
}
