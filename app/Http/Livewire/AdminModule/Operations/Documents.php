<?php

namespace App\Http\Livewire\AdminModule\Operations;

use App\Models\DocumentList;
use App\Models\MainServices;
use App\Models\SubServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Block\Document;
use Livewire\Component;
use Livewire\WithPagination;

class Documents extends Component
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
    public $n = 1,$update=false,$readonly="",$lastRecTime;
    public $i = 1;
    public $Document_Name;
    public $Document_Names = [];
    protected $Existing_Documents = [];
    public $Documents = [];
    public $Subservices = NULL;
    public $NewTextBox = [];

    // Validation rules
    protected $rules = [
        'MainserviceId' => 'required',
        'SubService' => 'required',
        'Document_Name' => 'required',
    ];

    // Custom validation messages
    protected $messages = [
        'MainserviceId.required' => 'Please select the main service name.',
        'SubService.required' => 'Please select sub service name.',
        'Document_Name.required' => 'Please enter the required document name.',
    ];

    // Real-time validation
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // Component mount lifecycle hook
    public function mount($Edit_Id,$Delete_Id)
    {
        $this->id();
        if($Edit_Id != ''){
            $this->Edit($Edit_Id);
        }elseif($Delete_Id!=''){
            $this->Delete($Delete_Id);
        }
    }

    public function id(){
        $this->Doc_Id = 'DOC' . time();
    }

    // Add a new text box for additional documents
    public function AddNewText($i)
    {
        $i++;
        $this->i = $i;
        array_push($this->NewTextBox, $i);
    }

    // Reset form fields
    public function ResetFields()
    {
        $this->id();
        $this->Document_Name = '';
        $this->Document_Names = [];
        $this->NewTextBox = [];
        $this->update=false;
        $this->readonly="";
    }

    // Remove a text box
    public function Remove($value)
    {
        if (($key = array_search($value, $this->NewTextBox)) !== false) {
            unset($this->NewTextBox[$key]);
            array_pop($this->Document_Names);
        }
    }

    // Save document to the database
    public function SaveDocument()
    {
        $this->validate();

        // Check if the document already exists
        $exist = DocumentList::whereKey($this->Doc_Id)->get();
        if (sizeof($exist) > 0) {
            // Update existing document
            DB::update(
                'update document_list set Service_Id = ?, Sub_Service_Id = ?, Name = ? where Id = ?',
                [$this->MainserviceId, $this->SubService, $this->Document_Name, $this->Doc_Id]
            );
            session()->flash('SuccessMsg', 'Document Name: ' . $this->Document_Name . ' updated successfully!');
        } elseif (count($this->Document_Names) > 0) {
            // Save multiple new documents
            $this->saveNewDocuments();
            session()->flash('SuccessMsg', 'All entered documents saved successfully');
        } else {
            // Save single new document
            $this->saveSingleDocument($this->Doc_Id, $this->Document_Name);
            session()->flash('SuccessMsg', $this->Document_Name . ' as document saved');
        }
        $this->ResetFields();
    }

    // Helper function to save a single document
    private function saveSingleDocument($id, $name)
    {

        $save_doc = new DocumentList();
        $save_doc->Id = $id;
        $save_doc->Service_Id = $this->MainserviceId;
        $save_doc->Sub_Service_Id = $this->SubService;
        $name = strtolower(trim($name));
        $save_doc->Name = ucwords($name);
        $save_doc->save();
    }

    // Helper function to save multiple documents
    private function saveNewDocuments()
    {
        $this->saveSingleDocument($this->Doc_Id, $this->Document_Name);
        foreach ($this->Document_Names as $value) {
            $this->saveSingleDocument('DOC' . mt_rand(0, 9999), $value);
        }
    }

    // Edit an existing document
    public function Edit($Id)
    {
        $this->update=true;
        $this->readonly='disabled';
        $fetch = DocumentList::whereKey($Id)->get();
        if ($fetch->isNotEmpty()) {
            $this->Document_Name = $fetch->first()->Name;
            $this->MainserviceId = $fetch->first()->Service_Id;
            $this->SubService = $fetch->first()->Sub_Service_Id;
            $this->Doc_Id = $Id;
        }
    }

    public function Update()
    {

        // Find the document by its ID
        $document = DocumentList::find($this->Doc_Id);

        if ($document) {
            $data = array();
            $data['Name'] = $this->Document_Name;
            DB::table('document_list')->where('Id', '=', $this->Doc_Id)->Update($data);
            session()->flash('SuccessMsg', 'Document updated successfully.');
            $this->ResetFields();
        } else {
            // Handle the case where the document does not exist
            session()->flash('error', 'Document not found.');
        }
    }
    // Delete an existing document
    public function Delete($id)
    {
        $document = DocumentList::find($id);
        if ($document) {
            // Store service IDs before deletion
            $this->MainserviceId = $document->Service_Id;
            $this->SubService = $document->Sub_Service_Id;

            // Delete the document
            DocumentList::where('Id', $id)->delete();
            // Flash success message and redirect to 'add.document' route
            session()->flash('SuccessMsg', 'Document Deleted successfully.');
            return redirect()->back();
        } else {
            // Flash error message if document is not found
            session()->flash('Error', 'Document not found.');
            return redirect()->back();
        }
    }

    public function capitalize(){
        $this->Document_Name = strtolower(trim($this->Document_Name));
        $this->Document_Name = ucwords($this->Document_Name);

    }

    public function LastUpdate($service_id, $sub_service_id)
    {
        // Retrieve the latest record based on service and sub-service IDs
        $latest_app = DocumentList::where('service_id', $service_id)
                        ->where('sub_service_id', $sub_service_id)
                        ->latest('created_at')
                        ->first();

        // Check if a record was found
        if ($latest_app) {
            // Parse and format the date to 'diffForHumans'
            $this->lastRecTime = Carbon::parse($latest_app->created_at)->diffForHumans();
        } else {
            // Handle the case where no record was found
            $this->lastRecTime = 'No record found';
        }
    }
    // Render the component view
    public function render()
    {
        $this->capitalize();
        if($this->MainserviceId != null && $this->SubService != null){
            $this->LastUpdate($this->MainserviceId, $this->SubService);
        }
        $this->MainServices = MainServices::all();
        $this->Subservices = SubServices::where('Service_Id', $this->MainserviceId)->get();
        $this->Existing_Documents = DocumentList::with('subservices')->where([
            ['Service_Id', $this->MainserviceId],
            ['Sub_Service_Id', $this->SubService]
        ])->orderBy('Name', 'asc')->paginate(10);

        return view('livewire.admin-module.operations.documents', [
            'MainServices' => $this->MainServices,
            'Subservices' => $this->Subservices,
            'Existing_Documents' => $this->Existing_Documents
        ]);
    }
}

