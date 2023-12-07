<?php

namespace App\Http\Livewire;

use App\Models\MainServices;
use App\Models\Service;
use App\Models\SubServices;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Update extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $Sources,$MainServices,$SubServices=[],$MainServiceId,$paginate,$n=1,$Source,$SubService;

    protected $rules = [
        'Source' =>'required',
        'MainServiceId' =>'required',
        'SubService' =>'required',
    ];
    protected $messages = [
        'Source.required' =>'Please Select Service .',
        'MainServiceId.required' =>'Please Select Main Service.',
        'SubService.required' =>'Please Select Sub Service',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function Update()
    {
        $this->validate();
        $get = MainServices::Wherekey($this->MainServiceId)->get();
        foreach($get as $key)
        {
            $Applicaiton = $key['Name'];
        }
        $update = DB::update('update digital_cyber_db set Application = ?, Application_Type = ? where Application  = ?', [$Applicaiton,$this->SubService,$this->Source]);
        if($update)
        {
            session()->flash('SuccessMsg','Records Updated Successfully');
        }
        else
        {
            session()->flash('Error','Unable to Update Records');

        }
    }
    public function render()
    {
        $this->Sources = Service::all();
        $this->MainServices = MainServices::all();
        $this->SubServices = SubServices::Where('Service_Id',$this->MainServiceId)->get();

        return view('livewire.update',[
            'MainServices'=>$this->MainServices, 'SubServices'=>$this->SubServices
        ]);
    }
}
