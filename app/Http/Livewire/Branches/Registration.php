<?php

namespace App\Http\Livewire\Branches;

use App\Models\Application;
use App\Models\Branches;
use App\Models\EmployeeRegister;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Registration extends Component
{

    public $Name, $Address, $Update, $Br_Id, $MapLink,$created,$updated;
    public $user_count, $employee_count;
    protected $listeners = ['edit' => 'Edit', 'delete' => 'Delete'];


    public function mount($EditId, $DeleteId)
    {
        $this->Br_Id = 'BR' . time();

    }
    protected $rules = [
        'Name' => 'required ',
        'Address' => 'required',
        'MapLink' => 'required',
    ];

    protected $messages = [
        'Name.required' => 'Please Enter the Branch Name',
        'Address.required' => 'Please Fill Branch Address',
        'MapLink.required' => 'Please enter google Map Link ',

    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function LastUpdate()
    {
        $latest = Branches::latest('created_at')->first();
        if($latest !=NULL){
            $this->created = Carbon::parse($latest['created_at'])->diffForHumans();
            $this->updated = Carbon::parse($latest['updated_at'])->diffForHumans();
        }

    }
    public function ResetFields()
    {
        $this->Br_Id = 'BR'.time();
        $this->Name = NULL;
        $this->Address = NULL;
        $this->MapLink = NULL;
        $this->Update = 0;
    }
    public function Save()
    {
        $this->validate();
        $save_bm = new Branches();
        $save_bm->branch_id = $this->Br_Id;
        $save_bm->name = $this->Name;
        $save_bm->address = $this->Address;
        $save_bm->google_map_link = $this->MapLink;
        $save_bm->save();
        $this->dispatchBrowserEvent('swal:success', [
            'type' => 'success',
            'title' => 'Branch Registered Successfully',
            'text' => 'Branch with name : '.$this->Name . '  is Registered Successfully!',
            'icon' => 'success',
            'redirect-url' => route('branch_register')  // Redirect to Branch Registration Page
        ]);
        $this->ResetFields();
    }

    public function Edit($br_Id)
    {
        $fetch = Branches::Where('branch_id', $br_Id)->get();
        foreach ($fetch as $item) {
            $this->Br_Id = $item['branch_id'];
            $this->Name = $item['name'];
            $this->Address = $item['address'];
            $this->MapLink = $item['google_map_link'];
        }
        $this->Update = 1;
    }

    public function updateBranch($id){
        $this->validate();
        $update = Branches::Where('branch_id', $id)->update([
            'name' => $this->Name,
            'address' => $this->Address,
            'google_map_link' => $this->MapLink,
        ]);
        if ($update) {
            $this->dispatchBrowserEvent('swal:success-non-redirect', [
                'type' => 'success',
                'title' => 'Branch Updated Successfully',
                'text' => 'Branch with name : '.$this->Name . '  is Updated Successfully!',
                'icon' => 'success',
            ]);
            $this->ResetFields();
        } else {
            $this->dispatchBrowserEvent('swal:success-non-redirect', [
                'type' => 'error',
                'title' => 'Branch Update Failed',
                'text' => 'Unable to Update Branch, Please try again later!',
                'icon' => 'error',
            ]);
        }
    }
    public function Delete($br_Id)
    {
        $branch = Branches::where('branch_id', $br_Id)->first(); // Fetch single record

        if (!$branch) {
            session()->flash('error', 'Branch not found!');
            return redirect()->back();
        }

         // Check if branch is associated with Applications or Employees
    $isUsedInApplications = Application::where('Branch_Id', $br_Id)->exists();
    $isUsedInEmployees = EmployeeRegister::where('Branch_Id', $br_Id)->exists();

    if ($isUsedInApplications || $isUsedInEmployees) {
        $this->dispatchBrowserEvent('swal:success-non-redirect', [
            'title' => 'Cannot Delete Branch!',
            'text' => "Branch '{$branch->name}' at '{$branch->address}' is associated with applications or employees.",
            'icon' => 'warning'
        ]);
        return;
    }
        // Delete branch
        if ($branch->delete()) {
            // Dispatch SweetAlert
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Deleted Successfully!',
                'text' => "Branch '{$branch->name}' at '{$branch->address}' has been deleted.",
                'icon' => 'success',
                'redirect-url' => route('branch_register') // Redirect to branch list after deletion
            ]);
        } else {
            $this->dispatchBrowserEvent('swal:success-non-redirect', [
                'title' => 'Failed to Delete!',
                'text' => "Branch '{$branch->name}' at '{$branch->address}' could not be deleted.",
                'icon' => 'error'
            ]);
        }
    }

    public function autoCapitalize()
    {
        $this->Name = ucwords($this->Name);
        $this->Address = ucwords($this->Address);
    }
    public function render()
    {
        $this->autoCapitalize();
        $this->LastUpdate();
        $Existing_Branches = DB::table('branches')->paginate(5);

        return view('livewire.branches.registration',['Existing_branches'=>$Existing_Branches]);
    }
}
