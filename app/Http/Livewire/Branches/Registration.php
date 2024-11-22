<?php

namespace App\Http\Livewire\Branches;

use App\Models\Branches;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Registration extends Component
{

    public $Name, $Address, $Update, $Br_Id, $MapLink,$created,$updated;
    public $user_count, $employee_count;

    public function mount($EditId, $DeleteId)
    {
        $this->Br_Id = 'BR' . time();
        if (!empty($EditId)) {
            $this->Edit($EditId);
        }
        if (!empty($DeleteId)) {
            $this->Delete($DeleteId);
        }
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
        session()->flash('SuccessMsg', 'Congratulations!, New Branch with name : '.$this->Name . '  is Created Successfully!');
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
    public function Delete($br_Id)
    {
        $fetch = Branches::Where('branch_id', $br_Id)->get();
        foreach ($fetch as $item) {
            $this->user_count = $item['user_count'];
            $this->employee_count = $item['employee_count'];
            $this->Name = $item['name'];
            $this->Address = $item['address'];
        }
        if ($this->employee_count > 0 ||  $this->user_count >0) {
            session()->flash('Error', 'Sorry!, you cannot Delete this Branch, Kindly use Edit option. Thank you!');
        } else {
            $delete = Branches::Where('branch_id', $br_Id)->delete();
            if ($delete) {
                $notification = array(
                    'message' => 'Branch is Deleted successfully!',
                    'alert-type' => 'info'
                );
                session()->flash('Success', $this->Name . 'of '.$this->Address.'Branch is Deleted from');
                return redirect()->back()->with($notification);


            } else {
                session()->flash('Error', 'Unable to Delete Branch, Please try again later!');
            }
        }
    }

    public function render()
    {
        $this->LastUpdate();
        $Existing_Branches = DB::table('branches')->paginate(5);

        return view('livewire.branches.registration',['Existing_branches'=>$Existing_Branches]);
    }
}
