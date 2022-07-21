<?php

namespace App\Http\Livewire;


use Livewire\Component;

class Services extends Component
{
    public $main_service;
    public $sub_service = [];
    public $MainSelected;
    public $SubSelected;
    public function render()
        {
            $this->main_service = Service_List::orderby('Name')->get();
            if(!empty($this->MainSelected))
            {
                $this->sub_service = Sub_Services::orderby('Name')->Where('Service_Id', $this->MainSelected)->get();
            }
            return view('livewire.services',[
                'main_service'=>$this->main_service,
                'sub_service'=>$this->sub_service,

            ]);
        }
}

