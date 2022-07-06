<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class AdminPanel extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $ProfileView =1, $ProfileEdit = 0;

    public $profiledata;
    public $name,$email,$dob,$mobile_no,$address,$profile_image,$old_profile_image;

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
    }
    public function UpdateProfile()
    {
        $id = Auth::user()->id;
        $data = array();

        $data['name'] = $this->name;
        $data['email'] = $this->email;
        $data['mobile_no'] = $this->mobile_no;
        $data['dob'] = $this->dob;
        $data['address'] = $this->address;

        if($this->profile_image!=NULL)
        {
            $filename = date('YmdHi').$this->profile_image->getClientOriginalName();
            $data['profile_image'] = '/storage/app/'.$this->profile_image->storeAs('Admin/Profile',$filename);
        }
        DB::table('users')->where('id',$id)->update($data);
        return redirect()->route('admin.profile_view');


    }
    public function render()
    {
        $id = Auth::user()->id;
        $this->profiledata = User::find($id);

        return view('livewire.admin-panel',['profiledata'=>$this->profiledata]);
    }
}
