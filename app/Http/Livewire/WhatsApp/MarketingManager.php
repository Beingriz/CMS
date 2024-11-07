<?php

namespace App\Http\Livewire\Whatsapp;

use App\Jobs\SendWhatsAppMessageJob;
use App\Models\BulkMessageReport;
use App\Models\ClientRegister;
use App\Models\MainServices;
use App\Models\SubServices;
use App\Models\Templates;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class MarketingManager extends Component
{
    use WithPagination;

    public $selectedTemplateId, $selectedService, $selectedServiceType;
    public $main_service, $sub_service = [],$totalClients;
    public $created, $updated,$checked;

    protected $paginationTheme = 'bootstrap',$clients=[];

    public function mount()
    {
        // Load main services on mount
        $this->loadServices();
        $this->LastUpdate();
    }



    public function loadClients($application, $applicationtype)
    {
        // Fetch the service name based on the selected service ID
        $serviceName = MainServices::where('Id', $application)->value('Name');
        $application = $serviceName;

            // Query to get distinct clients who meet the selected service criteria and join with the branch table
        $query = ClientRegister::select(
            'client_register.Id',
            'client_register.Name',
            'client_register.Mobile_No',
            'digital_cyber_db.Status',       // Select Status from application table
            'digital_cyber_db.Applicant_Image', // Select Profile_Image from application table
            'digital_cyber_db.Branch_Id',     // Select Branch_Id from application table
            'branches.name as Branch_Name'      // Select Branch Name from branch table (alias for easier access)
        )
        ->distinct()
        ->join('digital_cyber_db', 'client_register.Id', '=', 'digital_cyber_db.Client_Id')
        ->join('branches', 'digital_cyber_db.Branch_Id', '=', 'branches.branch_id') // Join with branch table
        ->where('digital_cyber_db.Application', $application)
        ->where('digital_cyber_db.Application_Type', $applicationtype);

        // Get the total unique count
        $this->totalClients = $query->count();

        // Retrieve the list of clients with unique names and phone numbers
        $this->clients = $query->paginate(10);
    }

    public function LastUpdate()
    {
        // Get latest created_at and updated_at from Templates
        $latest = Templates::latest('created_at')->first();
        if ($latest) {
            $this->created = Carbon::parse($latest['created_at'])->diffForHumans();
            $this->updated = Carbon::parse($latest['updated_at'])->diffForHumans();
        }
    }

    public function sendBulkMessages()
    {
        $template = Templates::find($this->selectedTemplateId);

        // Filter the clients to exclude checked ones
        $clientsToSend = collect($this->clients)
            ->filter(function ($client) {
                return !in_array($client->Id, $this->checked);
            });

        $totalRecipients = $clientsToSend->count();

        // Create a new report for tracking
        $report = BulkMessageReport::create([
            'template_id' => $this->selectedTemplateId,
            'service' => $this->selectedService,
            'service_type' => $this->selectedServiceType,
            'total_recipients' => $totalRecipients,
            'successful_sends' => 0,
        ]);

        // Dispatch job for each filtered client with a delay
        foreach ($clientsToSend as $index => $client) {
            SendWhatsAppMessageJob::dispatch($client, $template, $report->id)
                                ->delay(now()->addSeconds($index * 20));
        }

        session()->flash('SuccessMsg', 'Bulk messages are being sent! Check reports for details.');
    }


    public function render()
    {
        $this->LastUpdate();
        $this->loadServices();
        if(!empty($this->selectedService) && !empty($this->selectedServiceType)){
            $this->loadClients($this->selectedService,$this->selectedServiceType);
        }


        return view('livewire.whatsapp.marketing-manager', [
            'templates' => Templates::where('status', 'approved')->paginate(5),
            'main_services' => $this->main_service,
            'reports' => BulkMessageReport::latest()->get(),
            'clients' => $this->clients,
            'sub_service' => $this->sub_service
        ]);
    }

    private function loadServices()
    {
        $this->main_service = MainServices::orderBy('Name')->get();
        if ($this->selectedService) {
            $this->sub_service = SubServices::orderBy('Name')
                ->where('Service_Id', $this->selectedService)
                ->get();
        }
    }
}
