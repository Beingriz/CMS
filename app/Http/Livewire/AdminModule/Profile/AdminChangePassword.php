<?php

namespace App\Http\Livewire\AdminModule\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AdminChangePassword extends Component
{
    public $old_password, $new_password, $confirm_password;

    protected $rules = [
        'old_password' => 'required | Min:8',
        'new_password' => 'required | Min:8',
        'confirm_password' => 'required | Min:8 | same:new_password',
    ];
    protected $messages = [
        'old_password.required' => 'Please Enter Old Password',
        'new_password.required' => 'Please Enter New Password',
        'confirm_password.required' => 'Please Enter Comfirm Password'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function ResetFields()
    {
        $this->old_password = NUll;
        $this->new_password = NUll;
        $this->confirm_password = NUll;
    }

    public function ChangePassword()
    {
        $this->validate();
        $hashedpassword = Auth::user()->password;
        if (Hash::check($this->old_password, $hashedpassword)) {
            $User = User::find(Auth::id());
            $User->password = bcrypt($this->confirm_password);
            $User->save();

            session()->flash('SuccessMsg', 'Password Changed Successfully!');
            $this->ResetFields();
            return redirect()->back();
        } else {
            session()->flash('Error', 'Old Password Doesn' . "'" . ' Match!');
        }
    }

    public function render()
    {
        $id = Auth::user()->id;
        $profiledata = User::find($id);
        return view('livewire.admin-module.profile.admin-change-password', compact('profiledata'));
    }
}
