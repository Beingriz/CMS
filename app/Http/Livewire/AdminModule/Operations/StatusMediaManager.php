<?php

namespace App\Http\Livewire\AdminModule\Operations;

use App\Models\MainServices;
use App\Models\Status;
use App\Models\StatusMedia;
use App\Models\SubServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class StatusMediaManager extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'Bootstrap';
    public $Service,$Services, $Media, $media_id, $Old_Media, $Service_Type,$Service_Types, $Status, $n = 1, $iteration, $created, $updated,$Update;
    public $sub_service = [],$ServiceName;
    public $status = [], $disabled;
    protected $Existing_Media;

    protected $rules = [
        'Service' => 'required ',
        'Service_Type' => 'required',
        'Status' => 'required',
    ];

    protected $messages = [
        'Service.required' => 'Please Enter the Service Name',
        'Service_Type.required' => 'Please Select Service Type',
        'Status.required' => 'Please Select Status',
        'Media.required' => 'Please Select Media',
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function mount($EditId, $DeleteId)
    {
        $this->media_id = 'MD' . time();
        if (!empty($EditId)) {
            $this->Edit($EditId);
        }
        if (!empty($DeleteId)) {
            $this->Delete($DeleteId);
        }

    }
    public function ResetFields()
    {
        $this->media_id = 'MD' . time();
        $this->Service = NULL;
        $this->Media = NULL;
        $this->iteration++;
        $this->Status = NULL;
        $this->Old_Media = NULL;
        $this->Service_Type = NULL;
        $this->Update = 0;
    }
    public function Change($val)
    {

    }
    public function Save()
    {
        $this->validate([
            'Media' => 'required|mimes:jpeg,jpg,png|max:1024',
        ]);
        $extension = $this->Media->getClientOriginalExtension();
        $path = 'Media/Status/' . $this->Service;
        $filename = 'MD_' . $this->ServiceName . '_' . time() . '.' . $extension;
        $url = $this->Media->storePubliclyAs($path, $filename, 'public');
        $data = new StatusMedia();
        $data['id'] = $this->media_id;
        $data['service'] = $this->ServiceName;
        $data['service_Type'] = $this->Service_Type;
        $data['status'] = $this->Status;
        $data['media'] = $url;
        $data->save();
        session()->flash('SuccessMsg', $this->ServiceName . ' Media is Added for ' . $this->Service_Type);
        $this->ResetFields();
        $this->iteration++;

    }

    public function Edit($media_id)
    {
        $this->Update = 1;
        $this->disabled = 'disabled';
        $fetch = StatusMedia::where('id', $media_id)->get();
        foreach ($fetch as $item) {
            $serviceId = MainServices::where('Name', $item->service)->first()->Id;

            $this->media_id = $item->id;
            $this->Service =  $serviceId;
            $this->Service_Type = $item->service_type;
            $this->Status = $item->status;
            $this->Old_Media = $item->media;
        }
    }

    public function Update()
    {

        if (!empty($this->Media)) {
            $extension = $this->Media->getClientOriginalExtension();
            $path = 'Status Media/' . $this->Service;
            $filename = 'MD_' . $this->Service . '_' . time() . '.' . $extension;
            $url = $this->Media->storePubliclyAs($path, $filename, 'public');
            $this->Media = $url;
        } else {
            $this->Media = $this->Old_Media;
        }
        $data = array();
        $data['service'] = $this->ServiceName;
        $data['service_Type'] = $this->Service_Type;
        $data['status'] = $this->Status;
        $data['media'] = $this->Media;
        $Update = DB::table('status_media')->where('id', $this->media_id)->update($data);
        if ($Update) {
            return redirect()->route('status.media');
            session()->flash('SuccessMsg', $this->Service . ' Media is Updated for ' . $this->Service_Type);
            $this->ResetFields();
            $this->iteration++;
        }
    }
    public function LastUpdate()
    {
        $latest = StatusMedia::latest('created_at')->first();
        if($latest){
            $this->created = Carbon::parse($latest['created_at'])->diffForHumans();
            $this->updated = Carbon::parse($latest['updated_at'])->diffForHumans();
        }

    }
    public function Delete($media_id)
    {
        $fetch = StatusMedia::where('id', $media_id)->get();
        foreach ($fetch as $item) {
            if (Storage::disk('public')->exists($item->media)) {
                Storage::disk('public')->delete($item->media);
            }
        }

        $Delete = StatusMedia::where('id', $media_id)->delete();
        if ($Delete) {
            session()->flash('SuccessMsg', 'Media is Deleted');
            $this->ResetFields();
            $this->iteration++;
        }
    }
    private function loadServices()
    {
        $this->Services = MainServices::orderby('Name')->get();
        if (!empty($this->Service)) {
            $this->sub_service = SubServices::orderby('Name')
                ->where('Service_Id', $this->Service)
                ->get();
        }
    }
    private function loadStatusList()
    {
        $this->status = Status::where('Relation', $this->ServiceName)
            ->orWhere('Relation', 'General')
            ->orderBy('Orderby', 'asc')
            ->get();
    }
    public function render()
    {
        $this->LastUpdate();
        if (!empty($this->Service) && !empty($this->Service_Type) && !empty($this->Status)) {
            $this->ServiceName = MainServices::where('id', $this->Service)->first()->Name;
            $this->Existing_Media = StatusMedia::where('service', $this->ServiceName)
                ->where('service_type', $this->Service_Type)
                ->where('status', $this->Status)
                ->paginate(10);
        }else{
            $this->Existing_Media = StatusMedia::paginate(10);
        }

        $this->loadServices();
        if(!empty($this->Service)){
            $this->ServiceName = MainServices::where('id',$this->Service)->first()->Name;
            $this->loadStatusList();
        }
        return view('livewire.admin-module.operations.status-media-manager',['Existing_Media' => $this->Existing_Media]);
    }
}
