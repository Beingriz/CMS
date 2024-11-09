<?php

namespace App\Http\Livewire\WhatsApp;

use App\Models\Templates;
use Livewire\Component;
use Twilio\Rest\Client;

class TemplateManager extends Component
{
    public $templateId, $template_name, $template_body, $media_url, $status, $whatsapp_category;
    public $isEdit = false;
    public $content_template_sid;
    public $template_language = 'English';
    public $whatsapp_approval_status = 'pending';
    public $content_type = 'text';
    public $last_updated_at;

    // Define validation rules
    protected $rules = [
        'template_name' => 'required|string|max:255',
        'content_template_sid' => 'nullable|string|unique:templates,content_template_sid|max:255',
        'template_language' => 'required',
        'template_body' => 'required|string',
        'media_url' => 'nullable|url',
        'whatsapp_approval_status' => 'required|in:pending,approved,rejected',
        'content_type' => 'required',
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

            $templates = $twilio->content->v1->contentAndApprovals->read();
            // Iterate over the templates returned from Twilio API response
            foreach ($templates as $template) {
                // Prepare the data to store or update
                $typeName = $template->types;
                $typeName = key($typeName);
                $templateData = [
                    'template_sid' => $template->sid, // Twilio's unique SID for the template
                    'template_name' => $template->friendlyName, // Template name
                    'lang' => $template->language === 'en' ? 'English' : $template->language, // Default to 'en' if not specified
                    'category' => strtolower($template->approvalRequests['category'] ?? 'utility'), // Default category to 'utility' if not specified
                    'content_type' =>strtolower($template->approvalRequests['content_type'] ?? 'text'), // Type of the content like 'twilio/text', 'whatsapp/card', etc.
                    'variables' => json_encode($template->variables ?? []), // Store the variables as JSON, if any
                    'body' => $template->types[$typeName]['body'] ?? '', // Template body (message content)
                    'media_url' => !empty($template->types['whatsapp/card']['media'])
                                                ? json_encode($template->types['whatsapp/card']['media'])
                                                : null, // Media URL, if available
                    'status' => strtolower($template->approvalRequests['status'] ?? 'pending'), // Default to 'pending' if not specified
                    'use_count' => $template->use_count ?? 0, // Initialize use_count to 0 if not specified
                    'last_created_at' => $template->dateCreated ? $template->dateCreated->format('Y-m-d H:i:s') : null,
                    'last_updated_at' => $template->dateUpdated ? $template->dateUpdated->format('Y-m-d H:i:s') : null,
                ];

                // Check if the template already exists in the database
                $existingTemplate = Templates::where('template_sid', $template->sid)->first();

                if ($existingTemplate) {
                    // Update the existing template
                    $existingTemplate->update($templateData);
                } else {
                    // Insert the new template if it doesn't exist
                    Templates::create($templateData);
                }
            }
            // session()->flash('SuccessMsg', 'Templates synchronized successfully with Twilio.');
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
        $templates = Templates::where('status', 'approved')->paginate(10);
        return view('livewire.whats-app.template-manager', [
            'templates' => $templates,
        ]);
    }
}
