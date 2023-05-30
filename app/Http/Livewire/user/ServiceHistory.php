<?php

namespace App\Http\Livewire\User;

use App\Models\Application;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceHistory extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $MobileNo,$service_count;
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
        $Services = DB::table('digital_cyber_db')
                    ->join('applynow', 'digital_cyber_db.Mobile_No','=','applynow.Mobile_No')
                    ->where('applynow.Mobile_No','=',$this->MobileNo)
                    ->select('applynow.*','digital_cyber_db.*')
                    ->orderBy('applynow.created_at','desc')->paginate(10);
        // $this->service_count = Application::where('Mobile_No',$this->MobileNo)->count();
        return view('livewire.user.service-history',compact('Services'));
    }
}
