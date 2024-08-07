<?php

namespace App\Http\Livewire\AdminModule\Operations;

use App\Models\DocumentList;
use App\Models\MainServices;
use App\Models\SubServices;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentAdvisor extends Component
{
    use WithPagination;

    // Pagination theme
    protected $paginationTheme = 'bootstrap';

    // Component properties
    public $Doc_Id;
    public $MainServices;
    public $MainserviceId;
    public $SubService;
    public $exist_categories;
    public $value;
    public $n = 1,$update=false,$readonly="";
    public $i = 1;
    public $UnitPrice,$ServiceFee,$Margin;
    public $Document_Names = [];
    protected $Existing_Documents = [];
    public $Documents = [];
    public $Subservices = NULL;
    public $NewTextBox = [];
     // Render the component view
     public function render()
     {
         $this->MainServices = MainServices::all();
         $this->Subservices = SubServices::where('Service_Id', $this->MainserviceId)->get();
         $this->Existing_Documents = DocumentList::with('subservices')->where([
             ['Service_Id', $this->MainserviceId],
             ['Sub_Service_Id', $this->SubService]
         ])->orderBy('Name', 'asc')->paginate(10);
         if ($this->SubService) {
            $findPrice = SubServices::find($this->SubService);
            if ($findPrice) {
                $this->UnitPrice = $findPrice->Unit_Price;
                $this->ServiceFee = $findPrice->Service_Fee;
                $this->Margin = intval($this->UnitPrice) - intval($this->ServiceFee);
            } else {
                // Handle the case where the subservice is not found
                // For example, you could set $this->Price to a default value or throw an exception
                $this->UnitPrice = NULL;
                $this->ServiceFee = NULL; // or set a default price
            }
        }


         return view('livewire.admin-module.operations.document-advisor', [
             'MainServices' => $this->MainServices,
             'Subservices' => $this->Subservices,
             'Existing_Documents' => $this->Existing_Documents
         ]);
     }
}
