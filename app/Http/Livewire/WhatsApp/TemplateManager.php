<?php

namespace App\Http\Livewire\WhatsApp;

use App\Models\Templates;
use Livewire\Component;
use Twilio\Rest\Client;

class TemplateManager extends Component
{
    public $templateId, $template_name, $template_body, $media_url, $status, $whatsapp_category;
    public $isEdit = false, $templates;
    public $content_template_sid;
    public $template_language = 'English';
    public $whatsapp_approval_status = 'pending';
    public $content_type = 'text';
    public $last_updated_at;

    // Define validation rules
    protected $rules = [
        'template_name' => 'required|string|max:255',
        'content_template_sid' => 'nullable|string|unique:templates,content_template_sid|max:255',
        'template_language' => 'required|in:English,Hindi,Spanish',
        'template_body' => 'required|string',
        'media_url' => 'nullable|url',
        'whatsapp_approval_status' => 'required|in:pending,approved,rejected',
        'content_type' => 'required|in:text,image,video,whatsapp_card',
        'whatsapp_category' => 'required|in:utility,marketing,transactional',
        'status' => 'required|in:pending,approved',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->fetchAndSyncApprovedTemplates();
    }

    /**
     * Fetch and sync approved templates from Twilio and update the local database.
     */
    public function fetchAndSyncApprovedTemplates() {
        // Initialize Twilio client with credentials
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        try {
            // Fetch approved templates from Twilio's content service
            $templates = $twilio->content->v1->contentAndApprovals->read();

            // Loop through each template and map Twilio's data to your database fields
            foreach ($templates as $template) {
                // Access 'types' which is an array
                if (isset($template->types['whatsapp/card'])) {
                    $whatsappCard = $template->types['whatsapp/card'];

                    // Ensure body is a string, not an array
                    $templateBody = is_array($whatsappCard['body']) ? implode(' ', $whatsappCard['body']) : $whatsappCard['body'];

                    // Match Twilio fields with your database schema
                    $templateData = [
                        'template_name' => $template->friendlyName ?? 'No Name', // Twilio template name
                        'content_template_sid' => $template->sid, // Twilio template SID (unique identifier)
                        'template_language' => $template->language ?? 'English', // Twilio template language
                        'template_body' => $templateBody, // Content body of the template (converted to string if needed)
                        'media_url' => $whatsappCard['media'] ?? null, // Media URL if provided (null if not)
                    ];

                    // Check if the template already exists by its unique content_template_sid
                    $existingTemplate = Templates::where('content_template_sid', $template->sid)->first();
                    if (!is_null($existingTemplate)) {
                        // Update the existing template
                        $existingTemplate->update($templateData);
                    } else {
                        // Insert a new template
                        $temp = new Templates();
                        $temp->template_name = $templateData['template_name'];
                        $temp->content_template_sid = $templateData['content_template_sid'];
                        $temp->template_language = $templateData['template_language'];
                        $temp->template_body = $templateData['template_body'];
                        $temp->media_url = $templateData['media_url'];
                        $temp->save();
                    }
                }
            }

            session()->flash('SuccessMsg', 'Templates synchronized successfully with Twilio.');
        } catch (\Exception $e) {
            // Handle exceptions or API errors
            session()->flash('Error', 'Error fetching templates: ' . $e->getMessage());
        }
    }


    /**
     * Create a new template.
     */
    public function createTemplate()
    {
        $this->validate();

        try {
            Templates::create([
                'template_name' => $this->template_name,
                'content_template_sid' => $this->content_template_sid,
                'template_body' => $this->template_body,
                'media_url' => $this->media_url,
                'whatsapp_category' => $this->whatsapp_category,
                'whatsapp_approval_status' => $this->status,
                'last_updated_at' => now(),
            ]);

            $this->resetFields();
            session()->flash('SuccessMsg', 'Template has been successfully created!');
        } catch (\Exception $e) {
            session()->flash('Error', 'Error creating template. Please try again.');
        }
    }

    /**
     * Reset the form fields.
     */
    public function resetFields()
    {
        $this->reset([
            'template_name',
            'template_body',
            'media_url',
            'whatsapp_category',
            'status'
        ]);
    }

    /**
     * Edit an existing template.
     */
    public function editTemplate($templateId)
    {
        $this->isEdit = true;
        $template = Templates::find($templateId);
        $this->templateId = $template->id;
        $this->template_name = $template->template_name;
        $this->template_body = $template->template_body;
        $this->media_url = $template->media_url;
        $this->whatsapp_category = $template->whatsapp_category;
        $this->status = $template->status;
    }

    /**
     * Delete a template.
     */
    public function deleteTemplate($templateId)
    {
        $template = Templates::find($templateId);
        if ($template) {
            $template->delete();
            session()->flash('SuccessUpdate', 'Template has been deleted successfully!');
        }
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        return view('livewire.whats-app.template-manager', [
            'templates' => Templates::paginate(10)
        ]);
    }
}
