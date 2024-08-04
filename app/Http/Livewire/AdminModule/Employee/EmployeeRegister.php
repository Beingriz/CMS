<?php

namespace App\Http\Livewire\AdminModule\Employee;

use App\Models\Branches;
use App\Models\EmployeeRegister as EmpRegister;
use App\Traits\RightInsightTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EmployeeRegister extends Component
{
    use RightInsightTrait;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    public $Id,$Emp_Id,$Branch_Id,$Name,$DOB,$Father_Name,$Mobile_No,$Address,$Gender, $Email_Id,$Experience,$Qualification,$Branch, $Role,$Profile_Img,$Qualification_Doc,$Resume_Doc,$Old_Profile_Img;


    public $paginate = 10;
    public $Select_Date = NULL;
    public $filterby = "",$itteration;
    public $Checked = [];
    public $FilterChecked = [];
    public $Single;
    public $collection = [];
    public $bal_id = NULL;
    public $update = 0, $Show_Insight = false;



    protected $rules = [
        'Name' => 'required',
        'DOB' => 'required',
        'Father_Name' => 'required',
        'Mobile_No' => 'required|digits:10|unique:employee_register,Mobile_No',
        'Address' => 'required',
        'Gender' => 'required',
        'Email_Id' => 'required',
        'Qualification' => 'required',
        'Experience' => 'required',
        'Branch' => 'required',
        'Role' => 'required',
        // 'Profile_Img' => 'required',
    ];
    protected $messages = [
        'Name.required' => 'Please enter a name.',
        'DOB.required' => 'Please select a date of birth.',
        'Mobile_N-.required' => 'Please select a date of birth.',
        'Father_Name.required' => 'Please enter the father name.',
        'Gender.required' => 'Please select a gender.',
        'Email_Id.required' => 'Please enter a valid email ID.',
        'Qualification.required' => 'Please enter the highest qualification.',
        'Role.required' => 'Please select an employee role.',
        'Experience.required' => 'Please enter the highest experience.',
        // 'Profile_Img.required' => 'Please select a profile image.',
    ];
    public function mount() {
        $this->Id = 'EMP'.time();
        $this->Branch_Id = Auth::user()->branch_id;
        $this->Emp_Id = Auth::user()->Emp_Id;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function Save(){
        $this->validate();
        //Saving Employee
        $empReg = new EmpRegister();
        $empReg->Id = $this->Id;
        $empReg->Emp_Id = $this->Emp_Id;
        $empReg->Branch_Id = $this->Branch_Id;
        $empReg->Name = $this->Name;
        $empReg->Father_Name = $this->Father_Name;
        $empReg->DOB = $this->DOB;
        $empReg->Mobile_No = $this->Mobile_No;
        $empReg->Email_Id = $this->Email_Id;
        $empReg->Gender = $this->Gender;
        $empReg->Address = $this->Address;
        $empReg->Role = $this->Role;
        $empReg->Branch = $this->Branch;
        $empReg->Qualification = $this->Qualification;
        $empReg->Experience = $this->Experience;
        $empReg->Profile_Img = $this->Profile_Img;
        $empReg->Resume_Doc = $this->Resume_Doc;
        $empReg->Qualification_Doc = $this->Qualification_Doc;
        $empReg->save();

        session()->flash('SuccessMsg', 'Employee successfully registered.');



    }









    public function render()
    {
        $Branches = Branches::all();
        return view('livewire.admin-module.employee.employee-register',compact('Branches'));
    }
}
