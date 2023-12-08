<?php

namespace App\Http\Livewire\AdminModule\Application;

use App\Models\Application;
use App\Models\ClientRegister;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class UpdateApplication extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $Mobile_No, $C_Mon, $C_Name, $Old_Profile_Image, $Records_Show = 'Disable';
    public $lastMobRecTime, $paginate = 5, $filterby,$C_Mob;
    public $created, $updated, $AckFileDownload = 'Disable', $DocFileDownload = 'Disable', $PayFileDownload = 'Disable';


    protected $rules = [
        'Mobile_No' => 'required | Min:10 | Max:10 '
    ];
    protected $messages = [
        'Mobile_No.required' => 'Mobile Number Cannot Be Empty'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function Registered($Mobile_No)
    {
        $fetch = ClientRegister::where('Mobile_No', '=', $Mobile_No)->get();
        foreach ($fetch as $key) {
            $this->C_Name = $key['Name'];
            $this->C_Mob = $key['Mobile_No'];
            $this->Old_Profile_Image = $key['Profile_Image'];
        }
    }
    public function Search($Mobile_No)
    {
        $this->validate(['Mobile_No' => 'required']);
        $applied = Application::Where('Mobile_No', $Mobile_No)->get();
        if (count($applied) > 0) {
            $this->Records_Show = 'Enable';
            $latest_mob_app = Application::where('Mobile_No', $Mobile_No)->latest('created_at')->first();
            $this->lastMobRecTime =  Carbon::parse($latest_mob_app['created_at'])->diffForHumans();
        }
    }

    public function render()
    {
        $this->Registered($this->Mobile_No);
        $AppliedServices = Application::where('Mobile_No', $this->Mobile_No)->filter($this->filterby)->Paginate($this->paginate);
        $status = Status::all();
        return view('livewire.admin-module.application.update-application', ['AppliedServices' => $AppliedServices, 'status' => $status]);
    }
}
