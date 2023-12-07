<?php

namespace App\Http\Livewire\AdminModule\HomePage;

use App\Models\DocumentList;
use App\Models\MainServices;
use App\Models\SubServices;
use Livewire\Component;

class ProductDetials extends Component
{
    public $MainServiceId;
    public $SubServiceId;
    public $Name;
    public $Description;
    public $Details;
    public $Features;
    public $Specification;
    public $Thumbnail;
    public $Tota_Count;
    public $Sub_Name;
    public $Sub_Desc;
    public $Sub_Total_Count;
    public $n=1;

    public $Document_List=[];
    public $services=[];
    public function mount($MainServiceId)
    {
        $this->MainServiceId = $MainServiceId;

        $MainServices = MainServices::where('Id', $this->MainServiceId)->get();
        foreach($MainServices as $service)
        {
            $this->Name = $service['Name'];
            $this->Description = $service['Description'];
            $this->Details = $service['Details'];
            $this->Features = $service['Features'];
            $this->Specification = $service['Specification'];
            $this->Thumbnail = $service['Thumbnail'];
            $this->Tota_Count = $service['Tota_Count'];
        }
    }
    public function ShowDetails($subserid)
    {

        $this->SubServiceId = $subserid;
        $MainServices = SubServices::where('Id', $this->SubServiceId)->get();
        foreach($MainServices as $service)
        {
            $this->Sub_Name = $service['Name'];
            $this->Sub_Desc = $service['Description'];
            $this->Sub_Total_Count = $service['Total_Count'];

        }
        $this->Document_List = DocumentList::Where('Sub_Service_Id',$this->SubServiceId)->get();

    }
    public function render()
    {
        $this->services = SubServices::Where('Service_Id',$this->MainServiceId)->get();
        return view('livewire.product-detials');
    }
}
