<?php

namespace App\Http\Livewire;

use App\Models\Application;
use App\Models\ClientRegister;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditClientProfile extends Component
{

    public $old_Applicant_Image,$Profile_Image,$total,$balance,$app_pending,$count_app,$Name,$app_deleted,$Mobile_No,$app_delivered,$Gender,$Relative_Name, $Don, $Address, $Client_Type,$Client_Id,$Email;
    public $profiledata, $old_profile_image,$New_Profile_Image;

    use WithFileUploads;
    protected $rules = [
        'Name' =>'required',
        'Relative_Name' =>'required',
        'Gender' =>'required',
        'Dob' =>'required',
        'Mobile_No' =>'required | Min:10',
        'Email' =>'required| email',
        'Address' =>'required',

    ];
    protected $messages = [
       'Name.required' => 'Applicant Name Cannot be Empty',
       'Relative_Name.required' => 'Enter Relative Name',
       'Gender.required' => 'Please Select Gender',
       'Dob.required' => 'Please Select Date of Birth',
       'Mobile_No.required' => 'Mobile Number Cannot Be Empty',
       'Address.required' => 'Enter Total Amount',
       'Email.required' => 'Please Enter Email Id',

   ];

   public function updated($propertyName)
   {
       $this->validateOnly($propertyName);
   }
    public function mount($Id)
    {
        $this->Client_Id = $Id;
        $this->Email = 'Not Available';
        $fetch = ClientRegister::where('Id',$Id)->get();
        foreach($fetch as $key)
        {
            $this->Name = $key['Name'];
            $this->Email = $key['Email_Id'];
            $this->Relative_Name = $key['Relative_Name'];
            $this->Gender = $key['Gender'];
            $this->Mobile_No = $key['Mobile_No'];
            $this->Dob = $key['DOB'];
            $this->Address = $key['Address'];
            $this->Client_Type = $key['Client_Type'];
            $this->old_profile_image = $key['Profile_Image'];
        }
    }
    public function Capitalize()
    {
        $this->Name = strtolower($this->Name);
        $this->Name = ucwords($this->Name);
        $this->Relative_Name = ucwords($this->Relative_Name);
        $this->Email = strtolower($this->Email);
        $this->Email = str_replace(' ', '', $this->Email);
        $this->Address = ucwords($this->Address);
    }
    public function UpdateProfile($Id)
    {
        $this->validate();
        if(!empty($this->Profile_Image))
        {
            if($this->old_profile_image != 'Not Available' )
            {
                if (Storage::disk('public')->exists($this->old_profile_image)) // Check for existing File
                {
                    unlink(storage_path('app/public/'.$this->old_profile_image)); // Deleting Existing File
                    $url='Not Available';
                    $data = array();

                    $data['Profile_Image']=$url;
                    DB::table('client_register')->where([['Id','=',$Id]])->update($data);
                }
                else
                {
                    $this->New_Profile_Image = 'Not Available';
                }
            }
            else
            {
                $extension = $this->Profile_Image->getClientOriginalExtension();
                $path = 'Client_DB/'.$this->Name.'_'.$Id.'/'.$this->Name.'/Photo';
                $filename = 'Profile'.$this->Name.'_'.time().'.'.$extension;
                $url = $this->Profile_Image->storePubliclyAs($path,$filename,'public');
                $this->New_Profile_Image = $url;
            }
        }
        else
        {
            $this->New_Profile_Image = $this->old_profile_image;
        }
        $data = array();
        $data['Name'] = trim($this->Name);
        $data['Relative_Name'] =trim($this->Relative_Name);
        $data['Gender'] = trim($this->Gender);
        $data['Mobile_No'] = trim($this->Mobile_No);
        $data['Address'] = trim($this->Address);
        $data['Profile_Image'] = $this->New_Profile_Image;
        $data['Email_Id'] = trim($this->Email);
        $data['DOB'] = trim($this->Dob);
        ClientRegister::Where([['Id','=',$Id]])->update($data);
        $notification = array(
            'message'=>'Profile Updated Sucessfully',
            'info-type' => 'success'
        );
        return redirect()->route('edit_profile',$Id)->with($notification);
    }
    public function ResetFields($Id)
    {
        $this->mount($Id);
        $this->Profile_Image = NULL;
    }
    public function render()
    {
        $this->Capitalize();
        return view('livewire.edit-client-profile');
    }
}
