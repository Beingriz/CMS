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

    // Component properties
    public $Mobile_No = NULL;
    public $name, $Email_ID, $Client_Type;
    public $dob, $Email_Id, $DOB;
    public $address;
    public $search;
    public $n = 1, $Profile_Image, $Old_Profile_Image, $iteration, $Form_View = 0, $Reg_Rev = 0, $UnReg_Rev = 0;

    // Pagination theme
    protected $paginationTheme = 'bootstrap';

    // Validation rules
    protected $rules = [
        'Mobile_No' => 'required|digits:10',
        'name' => 'required',
        'dob' => 'required|date',
        'address' => 'required',
        'Email_ID' => 'required|email',
        'Client_Type' => 'required',
        'Profile_Image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
    ];

    // Custom validation messages
    protected $messages = [
        'name.required' => 'Client Name cannot be empty.',
        'dob.required' => 'Please select a date of birth.',
        'Email_ID.required' => 'Enter a valid email address.',
        'address.required' => 'Enter a correct address.',
        'Mobile_No.required' => 'Mobile number is mandatory.',
        'Client_Type.required' => 'Select client type.',
        'Profile_Image.required' => 'Profile image must be in JPEG format and within 1 MB.',
    ];

    // Real-time validation
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // Capitalize name and address
    public function Capitalize()
    {
        $this->name = ucwords($this->name);
        $this->address = ucwords($this->address);
    }

    // Submit client registration form
    public function submit()
    {
        $this->validate();

        // Check if the client is already registered
        $exist = ClientRegister::where('Mobile_No', $this->Mobile_No)->get();
        if ($exist->isNotEmpty()) {
            session()->flash('SuccessMsg', 'Client already registered with Client ID: ' . $exist->first()->Id);
        } else {
            // Register new client
            $Id = 'DC' . time();
            $profileImagePath = 'storage/app/' . $this->Profile_Image->storeAs('Client_DB/' . $this->name . ' ' . $Id . '/' . 'Profile Image', $this->name . $this->Mobile_No . time() . '.jpeg');
            $this->registerNewClient($Id, $profileImagePath);
        }
    }

    // Register a new client
    private function registerNewClient($Id, $profileImagePath)
    {
        $user_data = new ClientRegister;
        $user_data->Id = $Id;
        $user_data->Name = $this->name;
        $user_data->Mobile_No = $this->Mobile_No;
        $user_data->Email_Id = $this->Email_ID;
        $user_data->DOB = $this->dob;
        $user_data->Address = $this->address;
        $user_data->Profile_Image = $profileImagePath;
        $user_data->Client_Type = $this->Client_Type;
        $user_data->Registered_On = date("Y-m-d");
        $user_data->save();

        session()->flash('SuccessMsg', 'Registration for ' . $this->name . ' is successful! Client ID: ' . $Id . ' for Mobile No: ' . $this->Mobile_No . '.');
        return redirect('../client_registration');
    }

    // Register a client from the application
    public function Register($Client_Id)
    {
        $user_data = Application::where('Client_Id', $Client_Id)->first();
        if ($user_data) {
            $this->registerExistingClient($user_data);
        }
    }

    // Register existing client from application data
    private function registerExistingClient($user_data)
    {
        $clientExist = ClientRegister::where('Mobile_No', $user_data->Mobile_No)->exists();
        if ($clientExist) {
            session()->flash('SuccessMsg', "User already exists. Please register with another mobile number.");
        } else {
            $newClient = new ClientRegister;
            $newClient->Id = $user_data->Client_Id;
            $newClient->Name = $user_data->Name;
            $newClient->Mobile_No = $user_data->Mobile_No;
            $newClient->Email_Id = $user_data->Name . $user_data->Mobile_No . "@gmail.com";
            $newClient->DOB = $user_data->DOB;
            $newClient->Address = "Not Available";
            $newClient->Profile_Image = "Not Available";
            $newClient->Client_Type = "Old Client";
            $newClient->Registered_On = date('Y-m-d');
            $newClient->save();

            session()->flash('SuccessMsg', 'Registration of ' . $user_data->Name . ' is successful! Client ID: ' . $user_data->Client_Id . ' for Mobile No: ' . $user_data->Mobile_No . '.');
        }
    }

    // Edit client details
    public function EditClientDetails($Client_Id)
    {
        $this->Form_View = 1;
        $Client_Details = ClientRegister::where('Id', $Client_Id)->first();
        if ($Client_Details) {
            $this->name = $Client_Details->Name;
            $this->dob = $Client_Details->DOB;
            $this->address = $Client_Details->Address;
            $this->Email_Id = $Client_Details->Email_Id;
            $this->Client_Type = $Client_Details->Client_Type;
        }
    }

    // Reset form fields
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

    // Update client details
    public function UpdateClientDetails($Client_Id)
    {
        $user = ClientRegister::where('Id', $Client_Id)->first();
        if ($user) {
            $Profile_Image = $this->Profile_Image ? 'storage/app/' . $this->Profile_Image->storeAs('Client_DB/' . $this->name . ' ' . $Client_Id . '/' . 'Profile Image', $this->name . $this->Mobile_No . time() . '.jpeg') : $user->Profile_Image;
            $user->update([
                'Name' => $this->name,
                'DOB' => $this->dob,
                'Email_Id' => $this->Email_ID,
                'Address' => $this->address,
                'Client_Type' => $this->Client_Type,
                'Profile_Image' => $Profile_Image,
            ]);

            session()->flash('SuccessMsg', 'Update of ' . $this->name . ' is successful! Client ID: ' . $Client_Id . ' for Mobile No: ' . $this->Mobile_No . '.');
        }
        $this->Form_View = 0;
        $this->ResetFields();
    }

    // Render the component view
    public function render()
    {
        $this->Capitalize();
        $user = ClientRegister::where('Mobile_No', $this->Mobile_No)->get();
        $apps = Application::where('Mobile_No', $this->Mobile_No)->paginate(10);

        // Calculate registered and unregistered revenue
        $this->calculateRevenue();

        // Handle existing client scenario
        $this->handleExistingClient($user);

        return view('livewire.admin-module.application.client-search', [
            'SearchResults' => $apps,
            'RegisteredClient' => $user,
            'Form_View' => $this->Form_View,
            'Reg_Rev' => $this->Reg_Rev,
            'UnReg_Rev' => $this->UnReg_Rev
        ]);
    }

    // Calculate registered and unregistered revenue
    private function calculateRevenue()
    {
        $this->Reg_Rev = Application::where('Registered', 'Yes')->sum('Amount_Paid');
        $this->UnReg_Rev = Application::where('Registered', 'No')->sum('Amount_Paid');
    }

    // Handle existing client scenario
    private function handleExistingClient($user)
    {
        if ($user->isNotEmpty()) {
            session()->flash('SuccessMsg', 'Client already registered with Client ID: ' . $user->first()->Id . ' & Name: ' . $user->first()->Name);
        } elseif (Application::where('Mobile_No', $this->Mobile_No)->exists()) {
            $app = Application::where('Mobile_No', $this->Mobile_No)->first();
            session()->flash('SuccessMsg', 'Client already registered with Client ID: ' . $app->Id . ' & Name: ' . $app->Name);
        }
    }
}

