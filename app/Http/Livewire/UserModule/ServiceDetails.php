<?php

namespace App\Http\Livewire\UserModule;

use App\Models\Application;
use App\Models\DocumentList;
use App\Models\MainServices;
use App\Models\SubServices;
use App\Models\UserTopBar;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceDetails extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $Id, $SubServices, $Company_Name, $ServiceName, $display = false, $getId, $show = false;
    public function mount($Id)
    {
        # code...
        $this->Id = $Id;
    }
    public $serviceName, $delivered, $Image, $docList;
    public function GetDetails($Id)
    {
        $this->display = true;
        $this->getId = $Id;
        $this->showDoc = false;
        $subservices = SubServices::where('Id', $Id)->get();
        foreach ($subservices as $key) {
            $this->serviceName = $key['Name'];
        }

        $this->delivered = Application::where('Application_Type', $this->serviceName)->where('Status', 'Delivered to Client')->get()->count();
    }
    public $sl = 1, $showDoc = false, $docId = 'DCA001';
    public function GetDocuments($Id)
    {
        $this->showDoc = true;
        $this->docId = $Id;
        $this->display = false;
    }
    public function GetImage()
    {
        $serviceName = MainServices::where('Id', $this->Id)->get();
        foreach ($serviceName as $key) {
            $this->Image = $key['Thumbnail'];
            if (Storage::disk('public')->exists($this->Image)) // Check for existing File
            {
                $this->Image = $key['Thumbnail'];
            } else {

                $this->Image = "Not Available";
            }
        }
    }

    public function render()
    {
        $this->GetImage();
        $records = UserTopBar::Where('Selected', 'Yes')->get();
        foreach ($records as $key) {
            $this->Company_Name = $key['Company_Name'];
        }
        $serviceName = MainServices::where('Id', $this->Id)->get();
        foreach ($serviceName as $key) {
            $this->ServiceName = $key['Name'];
        }
        $subservices = SubServices::where('Service_Id', $this->Id)->get();
        $documents = DocumentList::where('Sub_Service_Id', $this->docId)->paginate(10);
        $this->SubServices = SubServices::Where('Id', $this->getId)->get();
        return view('livewire.admin-module.operations.service-details', compact('subservices', 'records', 'documents'), ['ServiceName', $this->ServiceName]);
    }
}
