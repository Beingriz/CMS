<?php

namespace App\Http\Livewire;

use App\Models\Application;
use App\Models\ClientRegister;
use Livewire\Component;

class EditClientProfile extends Component
{

    public $old_Applicant_Image,$Profile_Image,$total,$balance,$app_pending,$count_app,$Name,$app_deleted,$Mobile_No,$app_delivered,$Gender,$Relative_Name, $Don, $Address, $Client_Type,$Client_Id,$Email;
    public $profiledata, $old_profile_image;

    public function mount($Id)
    {
        $this->Client_Id = $Id;
        $this->Email = 'Not Available';
        $fetch = ClientRegister::where('Id',$Id)->get();
        foreach($fetch as $key)
        {
            $this->Name = $key['Name'];
            $this->Email = $key['Email'];
            $this->Relative_Name = $key['Relative_Name'];
            $this->Gender = $key['Gender'];
            $this->Mobile_No = $key['Mobile_No'];
            $this->Dob = $key['DOB'];
            $this->Address = $key['Address'];
            $this->Client_Type = $key['Client_Type'];
            $this->old_profile_image = $key['Profile_Image'];
        }
    }
    public function render()
    {
        return view('livewire.edit-client-profile');
    }
}
