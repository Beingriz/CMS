<?php

namespace App\Http\Livewire;

use App\Models\ClientRegister;
use App\Models\User;
use App\Traits\WhatsappTrait;
use Illuminate\Auth\Events\Registered;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;


class UserRegister extends Component
{
    use WhatsappTrait;
    public $name, $email, $username, $mobile_no, $password, $password_confirmation;

    protected $rules = [
        'name' => 'required',
        'mobile_no' => 'required | min:10 | max : 10|unique:client_register|unique:users',
        'username' => 'required | unique:users',
        'email' => 'required | unique:users',
        'password' => ['required', 'confirmed', 'min:8'],
    ];
    protected $message = [
        'name' => 'please enter your name',
        'mobile_no' => 'enter valid mobile no',
        'username' => 'Select unique username',
        'email' => 'enter your email id',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function Register()
    {
        $this->validate();
        $client_Id = 'DC' . date('Y') . strtoupper(Str::random(3)) . rand(000, 9999);
        $user = User::create([
            'Client_Id' => $client_Id,
            'name' => $this->name,
            'username' => $this->username,
            'mobile_no' => $this->mobile_no,
            'email' => $this->email,
            'profile_image' => 'account.png',
            'password' => Hash::make($this->password),
        ]);


        $user_data = new ClientRegister();
        $user_data->Id = $client_Id;
        $user_data->Name = $this->name;
        $user_data->Relative_Name = 'Not Available';
        $user_data->Gender = 'Not Available';
        $user_data->DOB = NULL;
        $user_data->Mobile_No = $this->mobile_no;
        $user_data->Email_Id = $this->email;
        $user_data->Address = "Not Available";
        $user_data->Profile_Image = 'account.png';
        $user_data->Client_Type = "New Client";
        $user_data->save(); // Client Registered
        event(new Registered($user));
        Auth::login($user);
        $notification = array(
            'message' => $this->name . ' Login Successfull',
            'alert-type' => 'info'
        );
        $this->UserRegisterAlert($this->name, $this->mobile_no, $this->username);
        return redirect()->route('user.dashboard')->with($notification);
    }
    public function render()
    {
        return view('livewire.user-register');
    }
}
