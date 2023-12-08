<?php

namespace App\Http\Livewire\AdminModule\Application;

use Livewire\Component;
use App\Models\Application;
use App\Models\ClientRegister;
use Livewire\WithPagination;
use App\Traits\RightInsightTrait;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class ClientSearch extends Component
{
    use RightInsightTrait;
    use WithPagination;
    use WithFileUploads;
    public $Mobile_No = NULL;
    public $name, $Email_ID, $Client_Type;
    public $dob, $Email_Id, $DOB;
    public $address;
    public $search;
    public $n = 1, $Profile_Image, $Old_Profile_Image, $iteration, $Form_View = 0, $Reg_Rev = 0, $UnReg_Rev = 0;
    protected $paginationTheme = 'bootstrap';
    protected $rules = [
        'Mobile_No' => 'required |Min:10 |Max:10',
        'name' => 'required',
        'dob' => 'required',
        'address' => 'required',
        'Email_ID' => 'required |email',
        'Client_Type' => 'required',
        'Profile_Image' => 'required | image|mimes:jpeg,png,jpg|max:1024',
    ];
    protected $messages = [
        'name.required' => 'Client Name Cannot be Empty',
        'dob.required' => 'Please Select Date of Birth',
        'Email_ID.required' => 'Enter Valid Email Id',
        'address.required' => 'Enter Correct Address',
        'Mobile_No.required' => 'Mobile No is Mandatory',
        'Client_Type.required' => 'Select Client Type',
        'Profile_Image.required' => 'Profile must be in JPEG format & within 1 MB',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function Capitalize()
    {
        $this->name = ucwords($this->name);
        $this->address = ucwords($this->address);
    }
    public function submit()
    {
        $this->validate();

        $exist = ClientRegister::where('Mobile_No', $this->Mobile_No)->get();
        foreach ($exist as $key) {
            $id = $key['Id'];
            $name = $key['Name'];
        }
        if (sizeof($exist) > 0) {
            session()->flash('SuccessMsg', 'Client Already Registered with Client ID' . $id);
        } else {
            $Id = 'DC' . time();
            $user_data = new ClientRegister;
            $user_data->Id = $Id;
            $user_data->Name = $this->name;
            $user_data->Mobile_No = $this->Mobile_No;
            $user_data->Email_Id = $this->Email_ID;
            $user_data->DOB = $this->dob;
            $user_data->Address = $this->address;
            $user_data->Profile_Image = 'storage/app/' . $this->Profile_Image->storeAs('Client_DB/' . $this->name . ' ' . $Id . '/' . 'Profile Image', $this->name . $this->Mobile_No . time() . '.jpeg');
            $user_data->Client_Type = $this->Client_Type;
            $user_data->Registered_On = date("Y-m-d");
            $user_data->save();
            session()->flash('SuccessMsg', 'Registration for ' . $this->name . ' is Successfull!! Client ID: ' . $Id . ' for Mobile No: ' . $this->Mobile_No . '.');
            return redirect('../client_registration');
        }
    }
    public function Register($Client_Id)
    {
        $user_data = Application::Where('Client_Id', $Client_Id)->get();
        foreach ($user_data as $data) {
            $name = $data['Name'];
            $mobile = $data['Mobile_No'];
            $dob = $data['DOB'];
        }
        $user_data = ClientRegister::Where('Mobile_No', $mobile)->get();
        if (sizeof($user_data) > 0) {
            session()->flash('SuccessMsg', "User Already Exist Kindly Register with other Mobile Number ");
        } else {
            $user_data = new ClientRegister;
            $user_data->Id = $Client_Id;
            $user_data->Name = $name;
            $user_data->Mobile_No = $mobile;
            $user_data->Email_Id = $name . $mobile . "@gmail.com";
            $user_data->DOB = $dob;
            $user_data->Address = "Not Available";
            $user_data->Profile_Image = "Not Available";
            $user_data->Client_Type = "Old Client";
            $user_data->Registered_On = date('Y-m-d');
            $user_data->save();

            session()->flash('SuccessMsg', 'Registration of ' . $name . ' is Successfull!! Client ID: ' . $Client_Id . ' for Mobile No: ' . $mobile . '.');
        }
    }
    public function EditClientDetails($Client_Id)
    {
        $this->Form_View = 1;
        $Client_Details = ClientRegister::where('Id', $Client_Id)->get();
        foreach ($Client_Details as $data) {
            $this->name = $data['Name'];
            $this->dob = $data['DOB'];
            $this->address = $data['Address'];
            $this->Email_Id = $data->Email_Id;
            $this->Client_Type = $data['Client_Type'];
        }
    }
    public function ResetFields()
    {
        $this->name = NULL;
        $this->Profile_Image = NULL;
        $this->iteration++;
        $this->address = NULL;
        $this->Email_ID = NULL;
        $this->DOB = NULL;
        $this->Client_Type = '---Client Type---';
        $this->Form_View = 0;
    }
    public function UpdateClientDetails($Client_Id)
    {

        $user = ClientRegister::where('Id', $Client_Id)->get();
        foreach ($user as $data) {
            $Profile_Image = $data['Profile_Image'];
        }
        if ($Profile_Image == "" || $Profile_Image == "Not Available") {
            $Profile_Image = 'storage/app/' . $this->Profile_Image->storeAs('Client_DB/' . $this->name . ' ' . $Client_Id . '/' . 'Profile Image', $this->name . $this->Mobile_No . time() . '.jpeg');
        } elseif ($this->Profile_Image != "") {
            $Profile_Image = 'storage/app/' . $this->Profile_Image->storeAs('Client_DB/' . $this->name . ' ' . $Client_Id . '/' . 'Profile Image', $this->name . $this->Mobile_No . time() . '.jpeg');
        } else {
            $Profile_Image = $data['Profile_Image'];
        }
        $update = DB::update('update client_register set Name = ?,DOB=?,Email_Id=?,Address=?,Client_Type=?,Profile_Image=? where Id = ?', [$this->name, $this->dob, $this->Email_ID, $this->address, $this->Client_Type, $Profile_Image, $Client_Id]);
        if ($update) {
            session()->flash('SuccessMsg', 'Update of ' . $this->name . ' is Successfull!! Client ID: ' . $Client_Id . ' for Mobile No: ' . $this->Mobile_No . '.');
        }
        $this->Form_View = 0;
        foreach ($user as $data) {
            $this->Mobile_No = $data['Mobile_No'];
        }
        $this->ResetFields();
    }
    public function render()
    {
        $this->Capitalize();
        $user = ClientRegister::where('Mobile_No', $this->Mobile_No)->get();
        $apps = Application::where('Mobile_No', $this->Mobile_No)->Paginate(10);
        $app = Application::where('Mobile_No', $this->Mobile_No)->get();
        $this->Reg_Rev = 0.0;
        $Reg_count  = Application::where('Registered', 'Yes')->get();
        foreach ($Reg_count as $key) { {
                $this->Reg_Rev += $key['Amount_Paid'];
            }
        }
        $this->UnReg_Rev = 0.0;
        $UnReg_count  = Application::where('Registered', 'No')->get();
        foreach ($UnReg_count as $key) { {
                $this->UnReg_Rev += $key['Amount_Paid'];
            }
        }
        if (sizeof($user) >= 1) {
            foreach ($user as $key) {
                $id = $key['Id'];
                $name = $key['Name'];
            }
        } elseif (sizeof($app) > 0) {
            foreach ($app as $key) {
                $mobile = $key['Mobile_No'];
                $id = $key['Id'];
                $name = $key['Name'];
            }

            $exist = ClientRegister::Where('Mobile_No', $mobile)->get();
            if (sizeof($exist) > 0) {
                session()->flash('SuccessMsg', 'Client Already Registered with Client Id :  ' . $id . ' & Name : ' . $name);
            }
        }
        return view('livewire.client-search', [
            'SearchResults' => $apps, 'SearchResult' => $app, 'applications_served' => $this->applications_served, 'RegisteredClient' => $user, 'Form_View' => $this->Form_View, 'Reg_Rev' => $this->Reg_Rev, 'UnReg_Rev' => $this->UnReg_Rev
        ]);
    }
}
