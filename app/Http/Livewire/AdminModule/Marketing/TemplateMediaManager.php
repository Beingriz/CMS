<?php

namespace App\Http\Livewire\AdminModule\Marketing;

use App\Models\TemplateMediaManager as ModelsTemplateMediaManager;
use App\Models\Templates;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class TemplateMediaManager extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'Bootstrap';
    public $Template,$templates,$temp_name, $Sid, $Temp_Body,$Media, $media_id, $Old_Media, $n = 1, $iteration, $created, $updated,$Update;
    public $disabled;
    protected $Existing_Media;

    protected $rules = [
        'Template' => 'required ',
    ];

    protected $messages = [
        'Template' => 'Please select the Template',

    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function mount($EditId, $DeleteId)
    {
        $this->media_id = 'TMd' . time();
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
        $this->Template = NULL;
        $this->Temp_Body = NULL;
        $this->Sid = NULL;
        $this->temp_name = NULL;
        $this->Media = NULL;
        $this->iteration++;
        $this->Old_Media = NULL;

        $this->Update = 0;
    }
    public function Change($val)
    {

    }
    public function Save()
    {
        $this->validate([
            'Media' => 'required|mimes:jpeg,jpg,png,mp4,pdf', // File types allowed
        ]);
        $extension = $this->Media->getClientOriginalExtension();
        $path = 'Media/Template/' . $this->temp_name;
        $filename = 'TMd_' . $this->temp_name . '_' . time() . '.' . $extension;
        $url = $this->Media->storePubliclyAs($path, $filename, 'public');
        $data = new ModelsTemplateMediaManager();
        $data['id'] = $this->media_id;
        $data['sid'] = $this->Sid;
        $data['template_name'] = $this->temp_name;
        $data['body'] = $this->Temp_Body;
        $data['media_file'] = $url;
        $data->save();
        session()->flash('SuccessMsg', $this->temp_name . ' Media is Added');
        $this->ResetFields();
        $this->iteration++;

    }

    public function Edit($media_id)
    {
        $this->Update = 1;
        $this->disabled = 'disabled';

        $this->media_id = $media_id;
        $fetch = ModelsTemplateMediaManager::where('id', $media_id)->get();
        $this->Template = Templates::where('template_name',$fetch[0]->template_name)->first()->id;
        foreach ($fetch as $item) {
            $this->Sid = $item->sid;
            $this->Temp_Body = $item->body;
            $this->Old_Media = $item->media_file;
        }
    }

    public function Update()
    {

        $this->validate([
            'Media' => 'required|mimes:jpeg,jpg,png,mp4,pdf', // File types allowed
        ]);
        $extension = $this->Media->getClientOriginalExtension();
        $path = 'Media/Template/' . $this->temp_name;
        $filename = 'TMd_' . $this->temp_name . '_' . time() . '.' . $extension;
        $url = $this->Media->storePubliclyAs($path, $filename, 'public');
        $data = ModelsTemplateMediaManager::where('id', $this->media_id)->first();
        $data->media_file = $url;
        $data->save();
        redirect()->route('template.media');
        session()->flash('SuccessMsg', $this->temp_name . ' Media is Updated');
        $this->ResetFields();
        $this->iteration++;
    }
    public function LastUpdate()
    {
        $latest = ModelsTemplateMediaManager::orderBy('updated_at', 'desc')->first();
        if($latest){
            $this->created = Carbon::parse($latest['created_at'])->diffForHumans();
            $this->updated = Carbon::parse($latest['updated_at'])->diffForHumans();
        }

    }
    public function Delete($media_id)
    {
        $fetch = ModelsTemplateMediaManager::where('id', $media_id)->get();
        foreach ($fetch as $item) {
            if (Storage::disk('public')->exists($item->media_file)) {
                Storage::disk('public')->delete($item->media_file);
            }
        }
        $Delete = ModelsTemplateMediaManager::where('id', $media_id)->delete();
        if ($Delete) {
            session()->flash('SuccessMsg', 'Media is Deleted');
            $this->ResetFields();
            $this->iteration++;
            return redirect()->route('template.media');
        }
    }


    public function render()
    {
        $this->LastUpdate();
        $this->templates = Templates::where('status','approved')->get();
        if(!empty($this->Template)){

            $this->Temp_Body = Templates::where('id',$this->Template)->first()->body;
            $this->Sid = Templates::where('id',$this->Template)->first()->template_sid;
            $this->temp_name = Templates::where('id',$this->Template)->first()->template_name;
        }
        $this->Existing_Media = ModelsTemplateMediaManager::where('template_name',$this->temp_name)->paginate(10);
        return view('livewire.admin-module.marketing.template-media-manager',['Existing_Media'=>$this->Existing_Media]);
    }
}
