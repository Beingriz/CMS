<?php

namespace App\Http\Livewire\Whatsapp;

use App\Jobs\SendWhatsAppMessageJob;
use App\Models\BulkMessageReport;
use App\Models\ClientRegister;
use App\Models\MainServices;
use App\Models\SubServices;
use App\Models\Templates;
use Livewire\Component;
use Twilio\Rest\Client;

class MarketingManager extends Component
{
    public $selectedTemplateId, $selectedService, $selectedServiceType;
    public $main_service,$sub_service;
    public $clients = [];

    public function mount()
    {
        $this->loadClients();
    }

    public function updated($property)
    {
        if (in_array($property, ['selectedService', 'selectedServiceType'])) {
            $this->loadClients();
        }
    }

    public function loadClients()
    {
         // Fetch service name based on selected service
        $service = MainServices::where('Id', $this->selectedService)->value('Name');
        $this->selectedService = $service;


        $this->clients = ClientRegister::with('applications') // Eager load applications
            ->whereHas('applications', function ($query) { // Filter applications based on conditions
                if ($this->selectedService) {
                    $query->where('Application', $this->selectedService); // Filter by application
                }
                if ($this->selectedServiceType) {
                    $query->where('Application_Type', $this->selectedServiceType); // Filter by application type
                }
            })
            ->get(); // Retrieve the clients
    }

    public function sendBulkMessages()
    {
        $template = Templates::find($this->selectedTemplateId);
        $clients = ClientRegister::whereHas('applications', function($query) {
            $query->where('Application', $this->selectedService)
                  ->where('Application_Type', $this->selectedServiceType);
        })->get();

        $totalRecipients = count($clients);

        $report = BulkMessageReport::create([
            'template_id' => $this->selectedTemplateId,
            'service' => $this->selectedService,
            'service_type' => $this->selectedServiceType,
            'total_recipients' => $totalRecipients,
            'successful_sends' => 0,
        ]);

        foreach ($clients as $index => $client) {
            SendWhatsAppMessageJob::dispatch($client, $template, $report->id)->delay(now()->addSeconds($index * 20));
        }

        session()->flash('SuccessMsg', 'Bulk messages are being sent! Check reports for details.');
    }
    public function ResetFields(){
        $this->resetInput();
    }

    public function render()
    {
        $this->loadServices();

        return view('livewire.whatsapp.marketing-manager', [
            'templates' => Templates::where('status', 'approved')->paginate(10),
            'reports' => BulkMessageReport::latest()->get(),
        ]);
    }

    private function loadServices()
    {
        $this->main_service = MainServices::orderby('Name')->get();
        if (!empty($this->MainSelected)) {
            $this->sub_service = SubServices::orderby('Name')
                ->where('Service_Id', $this->MainSelected)
                ->get();
        }
    }
}
