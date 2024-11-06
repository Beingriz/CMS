<?php

namespace App\Http\Livewire\WhatsApp;

use App\Models\Templates;
use Carbon\Carbon;
use Livewire\Component;
use SebastianBergmann\Template\Template;

class TemplateManager extends Component
{
    public $templateId, $template_name, $template_body, $media_url, $status,$created,$updated;
    public $isEdit = false;

    protected $rules = [
        'template_name' => 'required',
        'template_body' => 'required',
        'media_url' => 'nullable|url',
        'status' => 'required|in:pending,approved'
    ];

    public function render()
    {

        return view('livewire.whats-app.template-manager', [
            'templates' => Templates::paginate(10)
        ]);
    }
    public function ResetFields(){
        $this->resetInput();
    }

    public function createTemplate()
    {
        $validatedData = $this->validate();

        // $this->templateId ='Temp'. time().rand(000,999);
        $template = new Templates();
        // $template->id = $this->templateId;
        $template->template_name = $this->template_name;
        $template->template_body = $this->template_body;
        $template->media_url = $this->media_url ?? null; // set to null if not provided
        $template->status = $this->status ?? 'pending';
        $template->save();
        $this->resetInput();

    }
    public function LastUpdate()
    {
        $latest = Templates::latest('created_at')->first();
        if($latest !=NULL){
            $this->created = Carbon::parse($latest['created_at'])->diffForHumans();
            $this->updated = Carbon::parse($latest['updated_at'])->diffForHumans();
        }

    }

    public function editTemplate($id)
    {
        $template = Templates::findOrFail($id);
        $this->templateId = $id;
        $this->template_name = $template->template_name;
        $this->template_body = $template->template_body;
        $this->media_url = $template->media_url;
        $this->status = $template->status;
        $this->isEdit = true;
    }

    public function updateTemplate()
    {
        $this->validate();
        Templates::find($this->templateId)->update($this->validate());
        $this->resetInput();
    }

    public function deleteTemplate($id)
    {
        Templates::find($id)->delete();
    }

    private function resetInput()
    {
        $this->reset(['templateId', 'template_name', 'template_body', 'media_url', 'status', 'isEdit']);
    }
}
