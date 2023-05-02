<?php

namespace App\Http\Livewire;

use App\Models\Application;
use App\Models\DocumentList;
use App\Models\MainServices;
use App\Models\SubServices;
use App\Models\UserTopBar;
use Livewire\Component;

class ServiceDetails extends Component
{
    public $Id,$SubServices,$Company_Name,$ServiceName,$display=false,$getId,$show=false;
    public function mount($Id)
    {
        # code...
        $this->Id = $Id;
    }
    public $serviceName,$delivered;
    public function GetDetails($Id){
        $this->display=true;
        $this->getId = $Id;
        $this->show = false;
        $subservices = SubServices::where('Id',$Id)->get();
        foreach($subservices as $key){
            $this->serviceName = $key['Name'];
        }

        $this->delivered = Application::where('Application_Type',$this->serviceName)->where('Status','Delivered to Client')->get()->count();
    }
    public $documents,$sl=1;
    public function Documents($Id){
        $this->show = true;
        $this->documents = DocumentList::where('Sub_Service_Id',$Id)->get();
    }
    public function render()
    {
        $records = UserTopBar::Where('Selected','Yes')->get();
        foreach($records as $key){
            $this->Company_Name = $key['Company_Name'];
        }
        $serviceName = MainServices::where('Id',$this->Id)->get();
        foreach($serviceName as $key){
            $this->ServiceName = $key['Name'];
        }
        $subservices = SubServices::where('Service_Id',$this->Id)->get();
        $this->SubServices = SubServices::Where('Id',$this->getId)->get();
        return view('livewire.service-details',compact('subservices','records'),['ServiceName',$this->ServiceName]);
    }
}
