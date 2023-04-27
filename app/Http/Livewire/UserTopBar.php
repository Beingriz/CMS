<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\UserTopBar as ModelsUserTopBar;
use Livewire\Component;



class UserTopBar extends Component
{
    public $Id,$Company_Name,$Address,$Phone_No,$Facebook,$Instagram,$LinkedIn,$Twitter,$Time_From,$Time_To,$Update;
    protected $rules = [
        'Company_Name' => 'Required',
        'Address' => 'Required',
        'Phone_No' => 'Required',
        'Time_From' => 'Required',
        'Time_To' => 'Required',
    ];

    Protected $messages = [
        'Company_Name'=> 'Company Name Cannot be Blank',
        'Address'=> 'Please Enter Company Address',
        'Phone_No'=> 'Phone Number shuld not be empty',
        'Time_From'=> 'Companys From Timming shuld not be blank ',
        'Time_To'=> 'Companys To Timming shuld not be blank ',
    ];
    public function mount()
    {
        $this->Id = 'UTB'.time();
    }
    public function ResetFields()
    {

        $this->Company_Name="";
        $this->Address="";
        $this->Phone_No="";
        $this->Time_From="";
        $this->Time_To="";
        $this->Facebook="";
        $this->Instagram="";
        $this->LinkedIn="";
        $this->Twitter ="";
        $this->Update=0;
    }
    public function Save()
    {
        $this->validate();
        $save = new ModelsUserTopBar();
        $save->Id = $this->Id;
        $save->Company_Name = $this->Company_Name;
        $save->Address = $this->Address;
        $save->Phone_No = $this->Phone_No;
        $save->Time_From = $this->Time_From;
        $save->Time_To = $this->Time_To;
        $save->Facebook = $this->Facebook;
        $save->Instagram = $this->Instagram;
        $save->LinkedIn = $this->LinkedIn;
        $save->Twitter = $this->Twitter;
        $save->save();
        session()->flash('SuccessMsg','Details Updated Successfully');
        $this->ResetFields();
    }
    public function Edit($Id)
    {
        $fetch = ModelsUserTopBar::find($Id);
        $this->Company_Name= $fetch['Company_Name'];
        $this->Address=$fetch['Address'];
        $this->Phone_No=$fetch['Phone_No'];
        $this->Time_From=$fetch['Time_From'];
        $this->Time_To=$fetch['Time_To'];
        $this->Facebook=$fetch['Facebook'];
        $this->Instagram=$fetch['Instagram'];
        $this->LinkedIn=$fetch['LinkedIn'];
        $this->Twitter =$fetch['Twitter'];
        $this->Update=1;
    }
    public function render()
    {
        $Records = ModelsUserTopBar ::all();
        return view('livewire.user-top-bar', compact('Records'));
    }
}
