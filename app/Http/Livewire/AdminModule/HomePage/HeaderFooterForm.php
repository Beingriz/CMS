<?php

namespace App\Http\Livewire\AdminModule\HomePage;

use App\Models\UserTopBar;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HeaderFooterForm extends Component
{
    public $Id,$Company_Name,$Address,$Phone_No,$Facebook,$Instagram,$LinkedIn,$Twitter,$Time_From,$Time_To,$Update,$Youtube;
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
        $this->Youtube ="";
        $this->Update=0;
    }
    public function Save()
    {
        $this->validate();
        $save = new UserTopBar();
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
        $fetch = UserTopBar::find($Id);
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
        $this->Id = $fetch['Id'];
    }
    public function Select($Id)
    {
        $data = array();
        $data['Selected'] = 'No';
        DB::table('user_top_bar')->Update($data);
        $data['Selected'] = 'Yes';
        $Update = DB::table('user_top_bar')->where('Id','=',$Id)->Update($data);
        if($Update)
        {
            session()->flash('SuccessMsg','Details Updated Successfully');
            $this->ResetFields();
            $this->Update=0;
        }
    }
    public function Update()
    {
        $data = array();
        $data['Company_Name'] =  $this->Company_Name;
        $data['Address'] =  $this->Address;
        $data['Phone_No'] =  $this->Phone_No;
        $data['Time_From'] =  $this->Time_From;
        $data['Time_To'] =  $this->Time_To;
        $data['Facebook'] =  $this->Facebook;
        $data['Instagram'] =  $this->Instagram;
        $data['LinkedIn'] =  $this->LinkedIn;
        $data['Twitter'] =  $this->Twitter;
        $data['Youtube'] =  $this->Youtube;
        $Update = DB::table('user_top_bar')->where('Id','=',$this->Id)->Update($data);
        if($Update)
        {
            session()->flash('SuccessMsg','Details Changed');
        }

    }

    public function render()
    {
        $Records = UserTopBar ::all();
        return view('livewire.admin-module.home-page.header-footer-form', compact('Records'));
    }

}
