<?php

namespace App\Http\Livewire\User;

use App\Models\Application;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceHistory extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $MobileNo;
    public function mount($id)
    {
        $this->MobileNo = $id;
    }
    public function View($id)
    {
        # code...
    }
    public function render()
    {
        $Services = Application::where('Mobile_No',$this->MobileNo)->paginate(10);
        return view('livewire.user.service-history',compact('Services'));
    }
}
