<?php

namespace App\Http\Livewire;

use App\Models\Branches;
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
    public $name, $email, $username, $mobile_no, $password, $password_confirmation,$Branch_Id,$Emp_Id,$Branch;

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
            'Client_Id' => trim($client_Id),
            'name' => trim($this->name),
            'branch_id' => $this->Branch,
            'Emp_Id' => 'Direct',
            'username' => trim($this->username),
            'mobile_no' => trim($this->mobile_no),
            'email' => trim($this->email),
            'role' => 'user',
            'status' => 'user',
            'address' => 'Not Available',
            'profile_image' => 'account.png',
            'password' => Hash::make(trim($this->password)),
        ]);


        $user_data = new ClientRegister();
        $user_data->Id = trim($client_Id);
        $user_data->Name = trim($this->name);
        $user_data->Relative_Name = 'Not Available';
        $user_data->Gender = 'Not Available';
        $user_data->DOB = NULL;
        $user_data->Mobile_No = trim($this->mobile_no);
        $user_data->Email_Id = trim($this->email);
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
        $this->userRegisterationAlert(trim($this->mobile_no),trim($this->name),trim($this->username),trim($this->password));
        return redirect()->route('home')->with($notification);
    }
    public function render()
    {
        $Branches = Branches::all();
        return view('livewire.user-register',['Branches'=>$Branches]);
    }
}
