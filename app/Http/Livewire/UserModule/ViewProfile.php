<?php

namespace App\Http\Livewire\UserModule;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ViewProfile extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $ProfileView = 1, $ProfileEdit = 0;

    public $profiledata;
    public $name, $email, $dob, $mobile_no, $address, $username, $profile_image, $old_profile_image, $gender;


    protected $rules = [
        'name' => 'required',
        'dob' => 'required',
        'address' => 'required',
        'username' => 'required | unique:users',
    ];
    protected $messages = [
        'name.required' => 'Please Enter Admin Name',
        'dob.required' => 'Please Select Date of Birth',
        'address.required' => 'Update Address',
        'username.required' => 'Enter Unique Username',

    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function EditProfile()
    {
        $this->ProfileEdit = 1;
        $this->ProfileView = 0;
        $id = Auth::user()->id;
        $this->profiledata = User::where('id', $id)->get();
        foreach ($this->profiledata as $key) {
            $this->name = $key['name'];
            $this->email = $key['email'];
            $this->mobile_no = $key['mobile_no'];
            $this->dob = $key['dob'];
            $this->gender = $key['gender'];
            $this->address = $key['address'];
            $this->old_profile_image = $key['profile_image'];
        }
    }
    public function Back()
    {
        $this->ProfileView = 1;
        $this->ProfileEdit = 0;
        $this->name = NUll;
        $this->email = NUll;
        $this->mobile_no = NUll;
        $this->gender = "";
        $this->dob = NUll;
        $this->address = NUll;
    }
    public function UpdateProfile()
    {
        $this->validate([
            'name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'address' => 'required'
        ]);

        $id = Auth::user()->id;
        $cid = Auth::user()->Client_Id;
        $data = array();

        $data['name'] = $this->name;
        $data['email'] = $this->email;
        $data['dob'] = $this->dob;
        $data['gender'] = $this->gender;
        $data['address'] = $this->address;
        $data['updated_at'] = Carbon::now();
        if (!is_NUll($this->profile_image)) // if New Profile Images is Selected-- Uploading file
        {
            if (!is_NULL($this->old_profile_image)) {
                if (Storage::disk('public')->exists($this->old_profile_image)) // Check for existing File
                {
                    unlink(storage_path('app/public/' . $this->old_profile_image)); // Deleting Existing File
                }
            }
            $filename = date('Ymd') . '_' . $this->profile_image->getClientOriginalName();
            $data['profile_image'] = $this->profile_image->storePubliclyAs('Users/' . $this->name . ' ' . $cid . '/Profile/', $filename, 'public');
        } // New Profile Image Uploaded Successfully

        $update_profile = DB::table('users')->where('id', $id)->update($data);

        $data = array();
        $data['Name'] = $this->name;
        $data['Email_Id'] = $this->email;
        $data['DOB'] = $this->dob;
        $data['Gender'] = $this->gender;
        $data['Address'] = $this->address;
        $data['updated_at'] = Carbon::now();
        $data['Profile_Image'] = Auth::user()->profile_image;;
        $data['updated_at'] = Carbon::now();
        $update_client = DB::table('client_register')->where('Id', Auth::user()->Client_Id)->update($data);
        if ($update_profile > 0 || $update_client > 0) {
            $notification = array(
                'message' => 'Profile Updated',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'No Changes have been done!',
                'alert-type' => 'info'
            );
        }
        return redirect()->route('view.profile')->with($notification);
    }
    public function Capitalize()
    {
        $this->name = ucwords($this->name);
        $this->email = ucwords($this->email);
        $this->address = ucwords($this->address);
    }
    public function render()
    {
        $this->Capitalize();
        $id = Auth::user()->id;
        $this->profiledata = User::find($id);

        return view('livewire.user-module.view-profile', ['profiledata' => $this->profiledata]);
    }
}
