<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserViewProfile extends Component
{

    public $name,$mobile_no,$email,$dob,$address,$profile_image,$username,$Id;
    public function mount($Id){

        $this->Id = $Id;

    }
    public function render()
    {
        $fetch = User::where('id',Auth::user()->id)->get();
        foreach($fetch as $key){
            $this->name = $key['name'];
            $this->mobile_no = $key['mobile_no'];
            $this->email = $key['email'];
            $this->address = $key['address'];
            $this->dob = $key['dob'];
            $this->profile_image = $key['profile_image'];
        }
        return view('livewire.user-view-profile');
    }
}
