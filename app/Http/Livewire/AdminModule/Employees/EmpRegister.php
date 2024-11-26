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
use Illuminate\Support\Str;
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

    public function mount($EditId, $DeleteId, $UpdateId) {
        $this->Id = 'EMP' . time();
        $this->Branch_Id = Auth::user()->branch_id;
        $this->Emp_Id = Auth::user()->Emp_Id;
        if(!empty($EditId)) {
            $this->Edit($EditId);
        }
        if(!empty($DeleteId)) {
            $this->deleteEmployee($DeleteId);
        }
        // if(!empty($UpdateId)) {
        //     $this->Update($UpdateId);
        // }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected function handleFileUpload($fieldName, $oldFilePath)
    {
        try {
            if ($this->{$fieldName} instanceof \Illuminate\Http\UploadedFile) {
                $file = $this->{$fieldName};
                $path = 'Digital_Cyber/Employees/' . $this->Name . ' ' . $this->Emp_Id . '/' . trim($this->Role) . '/' . trim($this->Name);
                $filename = $fieldName . '_' . time() . '.' . $file->getClientOriginalExtension();
                $this->{$fieldName} = $file->storePubliclyAs($path, $filename, 'public');


                // Delete old file if exists
                if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);

                }
            } else {
                $this->{$fieldName} = $oldFilePath;
            }
        } catch (\Exception $e) {
            session()->flash('error', 'File upload failed. Please try again.');
        }

    }

    private function capitalize()
    {
        $this->Name = ucwords(strtolower(trim($this->Name)));
        $this->Father_Name = ucwords(strtolower(trim($this->Father_Name)));
        $this->Address = ucwords(strtolower(trim($this->Address)));
        $this->Email_Id = strtolower(trim($this->Email_Id));
    }

    // Function to generate a random unique username
    private function generateUsername($name, $dob)
    {
        $username = ucfirst(Str::slug($name));
        $uniqueIdentifier = substr(time(), -4) . substr($dob ?? '0000', -2);
        $generatedUsername = $username . $uniqueIdentifier;

        // Ensure uniqueness by appending a random number if needed
        while (User::where('username', $generatedUsername)->exists()) {
            $generatedUsername = $username . rand(10, 99);
        }

        return $generatedUsername;
    }

    public function Save()
    {
        $this->validate();
        $this->username = $this->generateUsername(trim($this->Name),$this->DOB);

        // Saving Employee

        // Handle file uploads
        $this->handleFileUpload('Profile_Img', $this->Profile_Img);
        $this->handleFileUpload('Qualification_Doc', null);
        $this->handleFileUpload('Resume_Doc',null);

        $empReg = new EmployeeRegister();
        $empReg->Id = trim($this->Id);
        $empReg->Emp_Id = trim($this->Emp_Id);
        $empReg->Branch_Id = trim($this->Branch_Id);
        $empReg->Username = trim($this->username);
        $empReg->Password = Hash::make(trim($this->username));
        $empReg->Name = ucwords(strtolower(trim($this->Name)));
        $empReg->Father_Name = ucwords(strtolower(trim($this->Father_Name)));
        $empReg->DOB = trim($this->DOB);
        $empReg->Mobile_No = trim($this->Mobile_No);
        $empReg->Email_Id = trim($this->Email_Id);
        $empReg->Gender = trim($this->Gender);
        $empReg->Address = ucwords(strtolower(trim($this->Address)));
        $empReg->Role = trim($this->Role);
        $empReg->Branch = trim($this->Branch);
        $empReg->Qualification = trim($this->Qualification);
        $empReg->Experience = trim($this->Experience);
        $empReg->Profile_Img = $this->Profile_Img;
        $empReg->Resume_Doc = $this->Resume_Doc;
        $empReg->Qualification_Doc = $this->Qualification_Doc;
        $empReg->save();

        // Saving User
        $user = User::create([
            'Client_Id' => $this->Id,
            'branch_id' => trim($this->Branch),
            'Emp_Id' => trim($this->Emp_Id),
            'name' => trim($this->Name),
            'gender' => trim($this->Gender),
            'address' => trim($this->Address),
            'dob' => trim($this->DOB),
            'Status' => 'Employee',
            'role' => trim($this->Role),
            'mobile_no' => trim($this->Mobile_No),
            'email' => trim($this->Email_Id),
            'profile_image' => trim($this->Profile_Img),
            'username' => trim($this->username),
            'password' => Hash::make(trim($this->username)),
        ]);
        // event(new Registered($user)); // User Registration to Portal with Login Credentials
        //Send Whatsapp Alert.
        // $this->EmployeeRegisterAlert($this->Name, $this->Mobile_No, $this->username);


        session()->flash('SuccessMsg', 'Employee successfully registered.');

        // Reset form fields after saving
        $this->reset(['Name', 'DOB', 'Father_Name', 'Mobile_No', 'Address', 'Gender', 'Email_Id', 'Experience', 'Qualification', 'Branch', 'Role', 'Profile_Img', 'Qualification_Doc', 'Resume_Doc', 'Old_Profile_Img']);
        $this->iteration++;
        return redirect()->route('emp.register');
    }
    public function Edit($Edit_Id)
    {
        // Fetch employee details based on the given ID
        $employee = EmployeeRegister::where('Id', $Edit_Id)->first();
        if (!$employee) {
            session()->flash('ErrorMsg', 'Employee not found.');
            return;
        }

        // Populate form fields with the employee's details
        $this->Id = $employee->Id;
        $this->Name = $employee->Name;
        $this->Father_Name = $employee->Father_Name;
        $this->DOB = $employee->DOB;
        $this->Mobile_No = $employee->Mobile_No;
        $this->Email_Id = $employee->Email_Id;
        $this->Gender = $employee->Gender;
        $this->Address = $employee->Address;
        $this->Role = $employee->Role;
        $this->Branch = $employee->Branch;
        $this->Qualification = $employee->Qualification;
        $this->Experience = $employee->Experience;
        $this->Old_Profile_Img = $employee->Profile_Img;
        // Indicate that the form is in update mode
        $this->update = 1;
    }
    public function Update($UpdateId)
    {
        // Fetch the employee record
        $employee = EmployeeRegister::where('Id',$UpdateId)->first();

        if (!$employee) {
            session()->flash('ErrorMsg', 'Employee not found.');
            return;
        }

        // Handle file uploads
        if ($this->Profile_Img instanceof \Illuminate\Http\UploadedFile) {
            $this->Old_Profile_Img = $employee->Profile_Img;
            $this->handleFileUpload('Profile_Img', $this->Old_Profile_Img);
        }if ($this->Qualification_Doc instanceof \Illuminate\Http\UploadedFile) {
            $this->Qualification_Doc = $employee->Qualification_Doc;
            $this->handleFileUpload('Qualification_Doc', $employee->Qualification_Doc);
        }if ($this->Resume_Doc instanceof \Illuminate\Http\UploadedFile) {
            $this->Resume_Doc = $employee->Resume_Doc;
            $this->handleFileUpload('Resume_Doc', $employee->Resume_Doc);
        }
        $employee->update([
            'Name' => ucwords(strtolower(trim($this->Name))),
            'Father_Name' => ucwords(strtolower(trim($this->Father_Name))),
            'DOB' => trim($this->DOB),
            'Mobile_No' => trim($this->Mobile_No),
            'Email_Id' => trim($this->Email_Id),
            'Gender' => trim($this->Gender),
            'Address' => ucwords(strtolower(trim($this->Address))),
            'Role' => trim($this->Role),
            'Branch' => trim($this->Branch),
            'Qualification' => trim($this->Qualification),
            'Experience' => trim($this->Experience),
            'Profile_Img' => $this->Profile_Img,
            'Resume_Doc' => $this->Resume_Doc,
            'Qualification_Doc' => $this->Qualification_Doc,
        ]);


        // Update associated user record
        $user = User::where('Client_Id', $this->Id)->first();
        if ($user) {
            $user->update([
                'name' => trim($this->Name),
                'gender' => trim($this->Gender),
                'address' => trim($this->Address),
                'dob' => trim($this->DOB),
                'role' => trim($this->Role),
                'mobile_no' => trim($this->Mobile_No),
                'email' => trim($this->Email_Id),
                'profile_image' => $this->Profile_Img,
            ]);
        }

        // Provide success feedback
        session()->flash('SuccessMsg', 'Employee successfully updated.');

        // Reset form fields
        $this->update = 0; // Reset update mode
        return redirect()->route('emp.register');
    }



    public function deleteEmployee($empId)
    {
        try {
            // Fetch the employee record
            $employee = EmployeeRegister::where('Id', $empId)->first();

            if (!$employee) {
                session()->flash('Error', 'Employee not found.');
                return;
            }

            // Delete associated files if they exist
            $this->deleteFile($employee->Profile_Img);
            $this->deleteFile($employee->Qualification_Doc);
            $this->deleteFile($employee->Resume_Doc);

            // Delete the employee record
            $employee->delete();

            // Delete associated user record
            $user = User::where('Id', $empId)->first();
            if ($user) {
                $user->delete();
            }

            // Provide success feedback
            session()->flash('SuccessMsg', 'Employee successfully deleted.');

        } catch (\Exception $e) {
            // Handle errors
            session()->flash('Error', 'An error occurred while deleting the employee: ' . $e->getMessage());
        }
    }
    private function deleteFile($filePath)
    {
        if ($filePath && file_exists(storage_path('app/' . $filePath))) {
            unlink(storage_path('app/' . $filePath));
        }
    }



    public function render()
    {
        $this->capitalize();
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
