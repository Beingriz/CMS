<?php

namespace App\Http\Livewire\UserModule;

use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceHistory extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $Id, $service_count, $available;
    public function mount($id)
    {
        $this->Id = $id;
    }
    public function View($id)
    {
        # code...
    }
    public function render()
    {
        $Services = DB::table('digital_cyber_db')
            ->join('users', 'digital_cyber_db.Client_Id', '=', 'users.Client_Id')
            ->where('users.Client_Id', '=', Auth::user()->Client_Id)
            ->select('digital_cyber_db.*')
            ->orderBy('digital_cyber_db.created_at', 'desc')->paginate(10);
        $this->service_count =  $Services->total();
        return view('livewire.user.service-history', compact('Services'));
    }
}
