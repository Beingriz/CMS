<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class AdminPanel extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $ProfileView =1, $ProfileEdit = 0;

    public $profiledata;
    public $name,$email,$dob,$mobile_no,$address,$username,$profile_image,$old_profile_image;


    protected $rules = [
        'name' =>'required',
        'dob' =>'required',
        'mobile_no' =>'required | Min:10',
        'address' =>'required',
        'username' =>'required | unique:users',
    ];
    protected $messages = [
       'name.required' => 'Please Enter Admin Name',
       'dob.required' => 'Please Select Date of Birth',
       'mobile_no.required' => 'Mobile Number Can'."'".'t Be Empty',
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
        $this->profiledata = User::where('id',$id)->get();
        foreach($this->profiledata as $key)
        {
            $this->name = $key['name'];
            $this->email = $key['email'];
            $this->mobile_no = $key['mobile_no'];
            $this->dob = $key['dob'];
            $this->address = $key['address'];
            $this->old_profile_image = $key['profile_image'];
        }
    }
    public function Back()
    {
        $this->ProfileView=1;
        $this->ProfileEdit=0;
        $this->name= NUll;
        $this->email= NUll;
        $this->mobile_no= NUll;
        $this->dob= NUll;
        $this->address= NUll;

    }
    public function UpdateProfile()
    {
        $this->validate([
            'name'=>'required',
            'mobile_no'=>'required',
            'dob'=>'required',
            'address'=>'required']);

        $id = Auth::user()->id;
        $data = array();

        $data['name'] = $this->name;
        $data['email'] = $this->email;
        $data['mobile_no'] = $this->mobile_no;
        $data['dob'] = $this->dob;
        $data['address'] = $this->address;
        if(!is_NUll($this->profile_image)) // if New Profile Images is Selected-- Uploading file
        {
            if (Storage::disk('public')->exists($this->old_profile_image)) // Check for existing File
                {

                    unlink(storage_path('app/public/'.$this->old_profile_image)); // Deleting Existing File

                }
            $filename = date('Ymd').'_'.$this->profile_image->getClientOriginalName();

            $data['profile_image'] = $this->profile_image->storePubliclyAs('Uploads/Admin/Profile/'.$this->name,$filename,'public');
        } // New Profile Image Uploaded Successfully

        $update = DB::table('users')->where('id',$id)->update($data);
        if($update > 0 )
        {
            $notification = array(
                'message'=>'Admin Profile Updated',
                'alert-type' =>'success'
            );
        }
        else
        {
            $notification = array(
                'message'=>'No Changes have been done!',
                'alert-type' =>'info'
            );
        }

        return redirect()->route('admin.profile_view')->with($notification);
    }
    public function render()
    {
        $id = Auth::user()->id;
        $this->profiledata = User::find($id);

        return view('livewire.admin-panel',['profiledata'=>$this->profiledata]);
    }
}
