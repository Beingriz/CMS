<?php

namespace App\Http\Livewire\AdminModule\Employees;

use App\Models\Branches;
use App\Models\EmployeeRegister;
use App\Models\User;
use App\Traits\WhatsappTrait;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EmpRegister extends Component
{
    use WithFileUploads, WithPagination, WhatsappTrait;

    protected $paginationTheme = 'bootstrap';
    public $Id, $Emp_Id, $Branch_Id, $Name, $DOB, $Father_Name, $Mobile_No, $Address, $Gender, $Email_Id, $Experience, $Qualification, $Branch, $Role, $Profile_Img, $Qualification_Doc, $Resume_Doc, $Old_Profile_Img,$username;
    public $paginate = 10;
    public $Select_Date = null;
    public $filterby = "", $iteration;
    public $Checked = [];
    public $FilterChecked = [];
    public $Single;
    public $collection = [];
    public $bal_id = null;
    public $update = 0, $Show_Insight = false;

    protected $rules = [
        'Name' => 'required|string|max:255',
        'DOB' => 'required|date',
        'Father_Name' => 'required|string|max:255',
        'Mobile_No' => 'required|digits:10|unique:employee_register,Mobile_No|unique:users,mobile_no',
        'Address' => 'required|string|max:500',
        'Gender' => 'required|string|in:Male,Female',
        'Email_Id' => 'required|email|max:255|unique:employee_register,Email_Id|unique:users,email',
        'Qualification' => 'required|string',
        'Experience' => 'required|string',
        'Branch' => 'required|exists:branches,branch_id',
        'Role' => 'required|string|in:admin,branch admin,operator',
        'Profile_Img' => 'nullable|max:1024', // allowing jpeg and png images up to 1MB
        'Qualification_Doc' => 'nullable|max:2048', // assuming max file size of 2MB
        'Resume_Doc' => 'nullable|max:2048', // assuming max file size of 2MB
    ];

    protected $messages = [
        'Name.required' => 'Please enter a name.',
        'DOB.required' => 'Please select a date of birth.',
        'Mobile_No.required' => 'Please enter a mobile number.',
        'Mobile_No.digits' => 'The mobile number must be 10 digits.',
        'Mobile_No.unique' => 'This mobile number is already taken.',
        'Father_Name.required' => 'Please enter the father name.',
        'Gender.required' => 'Please select a gender.',
        'Email_Id.required' => 'Please enter a valid email ID.',
        'Email_Id.unique' => 'This email ID is already taken.',
        'Qualification.required' => 'Please enter the highest qualification.',
        'Role.required' => 'Please select an employee role.',
        'Experience.required' => 'Please enter the experience.',
    ];

    public function mount() {
        $this->Id = 'EMP' . time();
        $this->Branch_Id = Auth::user()->branch_id;
        $this->Emp_Id = Auth::user()->Emp_Id;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected function handleFileUpload($fieldName, $oldFilePath)
    {
        if ($this->{$fieldName} instanceof \Illuminate\Http\UploadedFile) {
            $file = $this->{$fieldName};
            $path = 'Digital_Cyber/Employees/' . $this->Name . ' ' . $this->Emp_Id . '/' . trim($this->Role) . '/' . trim($this->Name);
            $filename = $fieldName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $this->{$fieldName . '_Path'} = $file->storePubliclyAs($path, $filename, 'public');

            // Delete old file if exists
            if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }
        } else {
            $this->{$fieldName . '_Path'} = $oldFilePath;
        }
    }

    // Function to Generate Random Username
    public function usernameGenrator($name, $dob)
    {
        // randomly creating username for new client registration,
        // it is the combinamtion of full name without space being first letter capital
        // ending with 2 letter of seconds of current time stamp and 2 letter of applicant date of birth.
        $username = strtolower($name); // to small case/
        $username = ucfirst($username); // first letter capital.
        $currentTimestamp = time(); // Get the current timestamp
        $timeString = date("His", $currentTimestamp); // Format timestamp as HHMMSS
        $sec = substr($timeString, -2); // Get the last two letters
        $dob = substr($dob, -2); // Get the last two letters
        $username = str_replace(' ', '', $username);
        $this->username = $username . $sec . $dob;
    }

    public function Save()
    {
        $this->validate();
        $this->usernameGenrator($this->Name,$this->DOB);

        // Saving Employee
        $empReg = new EmployeeRegister();
        $empReg->Id = trim($this->Id);
        $empReg->Emp_Id = trim($this->Emp_Id);
        $empReg->Branch_Id = trim($this->Branch_Id);
        $empReg->Username = trim($this->username);
        $empReg->Password = Hash::make(trim($this->username));
        $empReg->Name = trim($this->Name);
        $empReg->Father_Name = trim($this->Father_Name);
        $empReg->DOB = trim($this->DOB);
        $empReg->Mobile_No = trim($this->Mobile_No);
        $empReg->Email_Id = trim($this->Email_Id);
        $empReg->Gender = trim($this->Gender);
        $empReg->Address = trim($this->Address);
        $empReg->Role = trim($this->Role);
        $empReg->Branch = trim($this->Branch);
        $empReg->Qualification = trim($this->Qualification);
        $empReg->Experience = trim($this->Experience);
        $empReg->Profile_Img = $this->Profile_Img;
        $empReg->Resume_Doc = $this->Resume_Doc;
        $empReg->Qualification_Doc = $this->Qualification_Doc;
        $empReg->save();

        // Handle file uploads
        $this->handleFileUpload('Profile_Img', $this->Old_Profile_Img);
        $this->handleFileUpload('Qualification_Doc', null);
        $this->handleFileUpload('Resume_Doc', null);

        $empReg->Profile_Img = $this->Profile_Img_Path ?? null;
        $empReg->Qualification_Doc = $this->Qualification_Doc_Path ?? null;
        $empReg->Resume_Doc = $this->Resume_Doc_Path ?? null;

        $empReg->save();
        $user = User::create([
            'Client_Id' => $this->Id,
            'branch_id' => trim($this->Branch),
            'Emp_Id' => trim($this->Emp_Id),
            'name' => trim($this->Name),
            'gender' => trim($this->Gender),
            'address' => trim($this->Address),
            'dob' => trim($this->DOB),
            'status' => trim('Employee'),
            'role' => trim($this->Role),
            'mobile_no' => trim($this->Mobile_No),
            'email' => trim($this->Email_Id),
            'profile_image' => trim($this->Profile_Img),
            'username' => trim($this->username),
            'password' => Hash::make(trim($this->username)),
        ]);
        event(new Registered($user)); // User Registration to Portal with Login Credentials
        //Send Whatsapp Alert.
        $this->EmployeeRegisterAlert($this->Name, $this->Mobile_No, $this->username);


        session()->flash('SuccessMsg', 'Employee successfully registered.');

        // Reset form fields after saving
        $this->reset(['Name', 'DOB', 'Father_Name', 'Mobile_No', 'Address', 'Gender', 'Email_Id', 'Experience', 'Qualification', 'Branch', 'Role', 'Profile_Img', 'Qualification_Doc', 'Resume_Doc', 'Old_Profile_Img']);
        $this->iteration++;
        return redirect()->route('emp.register');
    }

    public function render()
    {
        $Branches = Branches::all();
          // Fetch employee data with branch name
        $employeeData = EmployeeRegister::with('branch') // Assuming you have a branch relationship
        ->filter($this->filterby)
        ->paginate($this->paginate);

        $lastRecTime = Carbon::parse(EmployeeRegister::latest('created_at')->first()->created_at ?? now())->diffForHumans();


        return view('livewire.admin-module.employees.emp-register', [
            'Branches' => $Branches,
            'employeeData' => $employeeData,
            'lastRecTime' => $lastRecTime,
        ]);
    }
}
