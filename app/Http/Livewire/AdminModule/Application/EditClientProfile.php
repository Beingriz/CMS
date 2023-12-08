<?php

namespace App\Http\Livewire\AdminModule\Application;

use App\Models\Application;
use App\Models\ClientRegister;
use App\Traits\RightInsightTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EditClientProfile extends Component
{

    public $old_Applicant_Image, $Profile_Image, $Total_Rev, $Balance, $Paid, $app_pending, $Total_App, $Name, $App_Delivered, $Mobile_No, $Pedning_App, $Gender, $Relative_Name, $Dob, $Address, $Client_Type, $Client_Id, $Email;
    public $profiledata, $old_profile_image, $New_Profile_Image, $Rest_App;
    public $status = NULL, $lastMobRecTime;

    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    // use RightInsightTrait;
    protected $rules = [
        'Name' => 'required',
        'Relative_Name' => 'required',
        'Gender' => 'required',
        'Dob' => 'required',
        'Mobile_No' => 'required | Min:10 | Max:10',
        'Email' => 'required| email',
        'Address' => 'required',

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
        $fetch = ClientRegister::where('Id', $Id)->get();

        foreach ($fetch as $key) {
            $this->Name = $key['Name'];
            $this->Email = $key['Email_Id'];
            $this->Relative_Name = $key['Relative_Name'];
            $this->Gender = $key['Gender'];
            $this->Mobile_No = $key['Mobile_No'];
            $this->Dob = $key['DOB'];
            $this->Address = $key['Address'];
            $this->Client_Type = $key['Client_Type'];
            $this->old_profile_image = $key['Profile_Image'];
            $this->status = 'All';
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
    public function Insight($mobile)
    {
        $fetch = Application::where('Mobile_No', $mobile)->get();
        $rev_total = 0;
        $paid = 0;
        $bal = 0;
        $pending = 0;
        $count = 0;
        $delivered = 0;
        foreach ($fetch as $key) {
            $count++;
            $rev_total += $key['Total_Amount'];
            $paid += $key['Amount_Paid'];
            $bal += $key['Balance'];
            if ($key['Status'] == 'Received') {
                $pending++;
            }
            if ($key['Status'] == 'Delivered to Client') {
                $delivered++;
            }
        }
        $this->Total_Rev = $rev_total;
        $this->Balance = $bal;
        $this->Paid = $rev_total;
        $this->Pedning_App = $pending;
        $this->App_Delivered = $delivered;
        $this->Total_App = $count;
        $this->Rest_App = $count - ($pending + $delivered);
    }
    public function Show($key)
    {
        $this->resetPage();
        $this->status = $key;
        $latest_mob_app = Application::where('Mobile_No', $this->Mobile_No)->latest('created_at')->first();
        if (!is_Null($latest_mob_app)) {
            $this->lastMobRecTime =  Carbon::parse($latest_mob_app['created_at'])->diffForHumans();
        }
    }
    public function UpdateProfile($Id)
    {

        if (!is_Null($this->Profile_Image)) // Check if new image is selected
        {
            if (!is_Null($this->old_profile_image)) {
                if (Storage::disk('public')->exists($this->old_profile_image)) {
                    unlink(storage_path('app/public/' . $this->old_profile_image));
                    $extension = $this->Profile_Image->getClientOriginalExtension();
                    $path = 'Client_DB/' . $this->Name . '_' . $Id . '/' . $this->Name . '/Photo';
                    $filename = 'Profile' . $this->Name . '_' . time() . '.' . $extension;
                    $url = $this->Profile_Image->storePubliclyAs($path, $filename, 'public');
                    $this->New_Profile_Image = $url;
                } else {
                    $extension = $this->Profile_Image->getClientOriginalExtension();
                    $path = 'Client_DB/' . $this->Name . '_' . $Id . '/' . $this->Name . '/Photo';
                    $filename = 'Profile' . $this->Name . '_' . time() . '.' . $extension;
                    $url = $this->Profile_Image->storePubliclyAs($path, $filename, 'public');
                    $this->New_Profile_Image = $url;
                }
            } else {
                $this->validate([
                    'Profile_Image' => 'required|image',
                ]);
            }
        } else // check old is exist
        {
            if (!is_Null($this->old_profile_image)) {
                if (Storage::disk('public')->exists($this->old_profile_image)) {
                    $this->New_Profile_Image = $this->old_profile_image;
                } else {
                    session()->flash('Error', 'File Does not Exist. Please Select New Profile Image');
                    $this->validate([
                        'Profile_Image' => 'required|image',
                    ]);
                }
            } else {
                $this->validate([
                    'Profile_Image' => 'required|image',
                ]);
            }
        }

        $this->validate();
        $data = array();
        $data['Name'] = trim($this->Name);
        $data['Relative_Name'] = trim($this->Relative_Name);
        $data['Gender'] = trim($this->Gender);
        $data['Mobile_No'] = trim($this->Mobile_No);
        $data['Address'] = trim($this->Address);
        $data['Profile_Image'] = $this->New_Profile_Image;
        $data['Email_Id'] = trim($this->Email);
        $data['DOB'] = trim($this->Dob);
        $data['updated_at'] = Carbon::now();
        ClientRegister::Where([['Id', '=', $Id]])->update($data);
        $notification = array(
            'message' => 'Profile Updated Sucessfully',
            'info-type' => 'success'
        );
        return redirect()->route('edit_profile', $Id)->with($notification);
    }
    public function ResetFields($Id)
    {
        $this->mount($Id);
        $this->Profile_Image = NULL;
    }
    public function render()
    {

        if ($this->status == 'All') {
            $Services = Application::where('Mobile_No', $this->Mobile_No)->paginate(10);
        } else {
            $Services = Application::where([['Mobile_No', '=', $this->Mobile_No], ['Status', '=', $this->status]])->paginate(10);
        }

        $this->Capitalize();
        $this->Insight($this->Mobile_No);

        return view('livewire.admin-module.application.edit-client-profile', compact('Services'));
    }
}
