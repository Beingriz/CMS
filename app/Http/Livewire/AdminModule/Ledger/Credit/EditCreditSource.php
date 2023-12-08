<?php

namespace App\Http\Livewire\AdminModule\Ledger\Credit;

use App\Models\CreditSource;
use App\Models\CreditSources;
use App\Traits\RightInsightTrait;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EditCreditSource extends Component
{
    use RightInsightTrait;
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $CS_Id, $Type, $CategoryList, $pos, $Exist = NULL;
    public $CS_Name, $Source, $Unit_Price;
    public $Name = "";
    public $CategoryName, $SubCategoryName;
    public $Thumbnail;
    public $Paginate = 10;
    public $Checked = [];
    public $filterby;
    public $exist_categories;
    public $id;
    public $user;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function Edit($id)
    {
        $fetch = CreditSources::where('CS_Id', '=', $id)->get();
        foreach ($fetch as $key) {
            $this->CS_Id = $key['CS_Id'];
            $this->CS_Name = $key['CS_Name'];
            $this->Source = $key['Source'];
            $this->Unit_Price = $key['Unit_Price'];
        }
    }

    public function render()
    {
        $creditsource = CreditSources::paginate($this->Paginate);
        if (!is_null($this->CategoryList)) {

            $this->exist_categories = CreditSources::Where('CS_Name', '=', $this->CategoryList)->get();
        }
        $fetch = CreditSources::where('CS_Id', '=', $this->id)->get();
        foreach ($fetch as $key) {
            $CS_Id = $key['CS_Id'];
            $CS_Name = $key['CS_Name'];
            $Source = $key['Source'];
            $Unit_Price = $key['Unit_Price'];
        }
        $Source_Names = CreditSource::orderby('Name')->get();
        return view('livewire.edit-credit-source', [
            'creditsource' => $creditsource, 'n' => $this->n, 'exist_categories' => $this->exist_categories,
            'Categorys' => $Source_Names, 'CS_Id' => $this->CS_Id,
            'CS_Name' => $this->CS_Name, 'Source' => $this->Source, 'Unit_Price' => $this->Unit_Price,

        ]);
    }
}
