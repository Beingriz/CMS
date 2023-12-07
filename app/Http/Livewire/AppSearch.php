<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ClientRegister;
use App\Models\Application;

class AppSearch extends Component
{
    public $Mobile_No = NULL;
    public $user_type = NULL;

    public function render()
    {
        $Mobile_No = NULL;
        $Mobile_No = ClientRegister::Where('Mobile_No',$this->Mobile_No)->get();
        if(sizeof($Mobile_No)==1)
        {
            $Mobile_No = Application::Where('Mobile_No',$this->Mobile_No)->get();
            $count = count($Mobile_No);
            $this->user_type = "Registered User!! Availed ".$count." Services";
        }
        else
        {
            $Mobile_No = Application::Where('Mobile_No',$this->Mobile_No)->get();
            if(sizeof($Mobile_No)>0)
            {
                $count = count($Mobile_No);
                $this->user_type = "Unregistered User!! Availed ".$count."Services ";
            }
            else
            {
                $this->user_type = "New Client";
            }
        }
        return view('livewire.app-search',['user_type'=>$this->user_type]);
    }
}
