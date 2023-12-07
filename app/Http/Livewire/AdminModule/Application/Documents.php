<?php

namespace App\Http\Livewire;

use App\Models\DocumentList;
use App\Models\MainServices;
use App\Models\SubServices;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Documents extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $Doc_Id;
    public $MainServices;
    public $MainserviceId;
    public $SubService ;
    public $exist_categories ;
    public $value ;
    public $n=1 ;
    public $i=1 ;
    public $Document_Name;
    public $Document_Names=[];
    public $Existing_Documents=[];
    public $Documents=[];
    public $Subservices =[];
    public $NewTextBox = [];

    protected $rules = [
        'MainserviceId' =>'required',
        'SubService' =>'required',
        'Document_Name' =>'required',
    ];

    protected $messages = [
       'MainserviceId.required' => 'Please Select the Main Service Name',
       'Document_Name.required' => 'Please Enter the Required Docuemt Name',
       'SubService.required' => 'Please Select Sub Service Name',

   ];
   public function updated($propertyName)
   {
       $this->validateOnly($propertyName);
   }
    public function mount()
    {
        $this->Doc_Id = 'DOC'.time();

    }
    public function AddNewText($i)
    {
        {
            $i = $i + 1;
            $this->i = $i;
            array_push($this->NewTextBox ,$i);
        }
    }
    public function ResetFields()
    {
        $this->Doc_Id = 'DOC'.time();
        $this->Document_Name = '';
        $this->Document_Names = [];
        $this->NewTextBox = [];
    }
    public function Remove($value)
    {
        if (($key = array_search($value, $this->NewTextBox)) !== false)
        {
            unset($this->NewTextBox[$key]);
            array_pop($this->Document_Names);
        }
    }

    public function SaveDocument()
    {
        $this->validate();
        $exist = DocumentList::wherekey($this->Doc_Id)->get();
        if(sizeof($exist)>0)
        {
            DB::update('update document_list set Service_Id = ?, Sub_Service_Id = ?, Name = ? where Id = ?', [$this->MainserviceId,$this->SubService,$this->Document_Name,$this->Doc_Id]);
            session()->flash('SuccessMsg', 'Document Name: '.$this->Document_Name.' Updated Successfully!');
            $this->ResetFields();
        }
        elseif(count($this->Document_Names)>0)
        {
            $save_doc = new DocumentList();
            $save_doc->Id = $this->Doc_Id;
            $save_doc->Service_Id = $this->MainserviceId;
            $save_doc->Sub_Service_Id = $this->SubService;
            $save_doc->Name = $this->Document_Name;
            $save_doc->save();
            foreach($this->Document_Names as $item => $value)
            {
                $save_doc = new DocumentList();
                $save_doc->Id = 'DOC'.mt_rand(0, 9999);
                $save_doc->Service_Id = $this->MainserviceId;
                $save_doc->Sub_Service_Id = $this->SubService;
                $save_doc->Name = $value;
                $save_doc->save();
            }
            $this->ResetFields();
            session()->flash('SuccessMsg', 'All Entered Documents Saved Successfully');
        }
        else
        {
            $save_doc = new DocumentList();
            $save_doc->Id = $this->Doc_Id;
            $save_doc->Service_Id = $this->MainserviceId;
            $save_doc->Sub_Service_Id = $this->SubService;
            $save_doc->Name = $this->Document_Name;
            $save_doc->save();
            session()->flash('SuccessMsg', $this->Document_Name.' as Document Saved');
            $this->ResetFields();
        }

    }
    public function Edit($Id)
    {
        $fetch = DocumentList::Wherekey($Id)->get();
        foreach($fetch as $key)
        {
            $name = $key['Name'];
        }
        $this->Document_Name = $name;
        $this->Doc_Id = $Id;
    }
    public function render()
    {
        $this->MainServices = MainServices::all();
        $this->Subservices = SubServices::where('Service_Id',$this->MainserviceId)->get();
        $this->Existing_Documents = DocumentList::Where([['Service_Id',$this->MainserviceId],['Sub_Service_Id',$this->SubService]])->orderby('Name','asc')->get();
        return view('livewire.documents',['MainServices'=>$this->MainServices,'Subservices'=>$this->Subservices]);
    }
}
