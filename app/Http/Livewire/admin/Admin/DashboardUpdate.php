<?php

namespace App\Http\Livewire\Admin\Admin;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardUpdate extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $Records,$Key,$User = false,$Orders = false,$Callback = false,$created;
    public function mount($Key){
       $this->Key = $Key;
    }
    public function UpdateAdmin($Id){
        $data = array();
        $data['role']= 'admin';
        $data['updated_at']= Carbon::now();
        DB::table('users')->where('id',$Id)->update($data);
        $notification = array(
            'message'=>'User changed from USER to ADMIN',
            'alert-type'=>'info'
        );
        return redirect()->back()->with($notification);
    }
    public function UpdateUser($Id){
        $data = array();
        $data['role']= 'user';
        $data['updated_at']= Carbon::now();
        DB::table('users')->where('id',$Id)->update($data);
        $notification = array(
            'message'=>'User changed from Admin to USER',
            'alert-type'=>'info'
        );
        return redirect()->back()->with($notification);
    }
    public function render()
    {
        $table = 'digtial_cyber_db';
        if($this->Key == 'User'){
            $table = 'users';
            $this->User = true;
            $this->Orders = false;
            $this->Callback = false;
            $records = DB::table($table)->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')->paginate(10);


        }elseif($this->Key == 'Orders'){
            $table = 'applynow';
            $this->User = false;
            $this->Orders = true;
            $this->Callback = false;
        }elseif($this->Key == 'Callback'){
            $table = 'callback';
            $this->User = false;
            $this->Orders = false;
            $this->Callback = true;
        }
        $records = DB::table($table)->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')->paginate(10);
        $this->created =  Carbon::parse($records['created_at'])->diffForHumans();
        return view('livewire.admin.admin.dashboard-update',compact('records'));
    }
}
