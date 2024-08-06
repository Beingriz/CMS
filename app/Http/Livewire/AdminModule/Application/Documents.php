<?php

namespace App\Http\Livewire\AdminModule\Application;

use App\Models\DocumentList;
use App\Models\MainServices;
use App\Models\SubServices;
use Illuminate\Support\Facades\DB;
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
    public $n = 1;
    public $i = 1;
    public $Document_Name;
    public $Document_Names = [];
    public $Existing_Documents = [];
    public $Documents = [];
    public $Subservices = [];
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
    public function mount()
    {
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
        $this->Doc_Id = 'DOC' . time();
        $this->Document_Name = '';
        $this->Document_Names = [];
        $this->NewTextBox = [];
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
        $save_doc->Name = $name;
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
        $fetch = DocumentList::whereKey($Id)->get();
        if ($fetch->isNotEmpty()) {
            $this->Document_Name = $fetch->first()->Name;
            $this->Doc_Id = $Id;
        }
    }

    // Render the component view
    public function render()
    {
        $this->MainServices = MainServices::all();
        $this->Subservices = SubServices::where('Service_Id', $this->MainserviceId)->get();
        $this->Existing_Documents = DocumentList::where([
            ['Service_Id', $this->MainserviceId],
            ['Sub_Service_Id', $this->SubService]
        ])->orderBy('Name', 'asc')->get();

        return view('livewire.admin-module.application.documents', [
            'MainServices' => $this->MainServices,
            'Subservices' => $this->Subservices
        ]);
    }
}

