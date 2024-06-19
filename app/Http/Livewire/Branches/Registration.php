<?php

namespace App\Http\Livewire\Branches;

use App\Models\Branches;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Registration extends Component
{

    public $Name, $Address, $Update, $Br_Id, $MapLink,$created,$updated;

    public function mount()
    {
        $this->Br_Id = 'Br' . time();
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
        $this->created = Carbon::parse($latest['created_at'])->diffForHumans();
        $this->updated = Carbon::parse($latest['updated_at'])->diffForHumans();
    }
    public function ResetFields()
    {
        $this->Br_Id = 'BM' . time();
        $this->Name = NULL;
        $this->Address = NULL;
        $this->MapLink;
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
        session()->flash('SuccessMsg', $this->Name . '  is Created Successfully');
        $this->ResetFields();
    }


    public function render()
    {
        $this->LastUpdate();
        $Existing_Branches = DB::table('branches')->paginate(5);

        return view('livewire.branches.registration',['Existing_branches'=>$Existing_Branches]);
    }
}
