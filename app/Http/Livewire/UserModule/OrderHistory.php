<?php

namespace App\Http\Livewire\UserModule;

use App\Models\QuickApply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class OrderHistory extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $Id, $service_count, $available;
    public function mount($id)
    {
        $this->Id = $id;
    }
    public function render()
    {
        // $Services = DB::table('quick_apply')
        //         ->join('users', 'quick_apply.client_id', '=', 'users.Client_Id') // Fixed typo
        //         ->where('users.Client_Id', Auth::user()->Client_Id) // Filter by authenticated user
        //         ->where('quick_apply.status', 'Received') // Added status filter
        //         ->select('quick_apply.*')
        //         ->orderBy('quick_apply.created_at', 'desc')
        //         ->paginate(10);
        $Services = QuickApply::where('client_id', Auth::user()->Client_Id)->paginate(10);
        $this->service_count =  $Services->total();
        return view('livewire.user-module.order-history', compact('Services'));
    }
}
