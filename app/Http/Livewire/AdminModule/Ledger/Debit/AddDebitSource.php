<?php

namespace App\Http\Livewire\AdminModule\Ledger\Debit;

use App\Models\Debit;
use App\Models\DebitSource;
use App\Models\DebitSources;
use App\Traits\RightInsightTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AddDebitSource extends Component
{
    use RightInsightTrait;
    use WithFileUploads;
    use WithPagination;
    public $DS_Id, $Type, $CategoryList, $pos, $Unit_Price, $CategoryType, $Exist = NULL;
    public $Name = "", $Tenure, $Loan_Amount;
    public $CategoryName, $SubCategoryName;
    public $Thumbnail, $iteration;
    public $Image, $OldImage, $Update = 0;
    public $Paginate = 10;
    public $Checked = [];
    public $filterby;
    protected $exist_main_categories = [];
    protected $exist_categories = [];
    public $fName;
    public $edit, $NewImage;
    protected $listeners = ['refreshProducts',
    'editMain' => 'EditMain',
    'editSub' => 'EditSub',
    'deleteMain' => 'DeleteMain',
    'deleteSub' => 'DeleteSub',];

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'Name' => 'required|unique:credit_source',
        'Image' => 'required|image',
    ];
    protected $messages = [
        'Name.required' => 'Please Enter the Category Name',
        'SubCategoryName.required' => 'Please Enter Sub Category Name',
        'Unit_Price.required' => 'Please Set Unit Price',
        'Image.required|' => 'Please Select Thumbnail',
    ];

    public function updated($propertyName)
    {

        $this->validateOnly($propertyName);
    }

    public function mount($EditData, $DeleteData, $editid, $deleteid)
    {

        $time = substr(time(), 6, 8);
        $this->DS_Id = 'DS' . $time;
        if ($this->CategoryList) {
            $this->edit = NULL;
        }
        if (!empty($EditData)) {
            $this->EditMain($EditData);
        }
        if (!empty($DeleteData)) {
            $this->DeleteMain($DeleteData);
        }
        if (!empty($editid)) {
            $this->EditSub($editid);
        }
        if (!empty($deleteid)) {
            $this->DeleteSub($deleteid);
        }
    }
    public function ResetMainFields()
    {
        $this->Type = 'Main Category';
        $time = substr(time(), 6, 8);
        $this->DS_Id = 'DS' . $time;
        $this->Name = Null;
        $this->Image = Null;
        $this->iteration++;
        $this->OldImage = Null;
        $this->Update = 0;
    }
    public function ResetSubFields()
    {
        $this->Type = 'Sub Category';
        $this->CategoryList = Null;
        $this->SubCategoryName = Null;
        $this->Unit_Price = Null;
        $this->Update = 0;
    }
    public function Save() #Function to Save Categories
    {
       // Trim the input fields
        $this->Name = trim($this->Name);
        $this->CategoryType = trim($this->CategoryType);
        $this->CategoryList = trim($this->CategoryList);
        $this->SubCategoryName = trim($this->SubCategoryName);
        $this->Unit_Price = trim($this->Unit_Price);
        $this->Loan_Amount = trim($this->Loan_Amount);
        $this->Tenure = trim($this->Tenure);

        if ($this->Type == 'Main Category') {
            $this->validate([
                'Name' => 'required|unique:credit_source',
                'Image' => 'required|image',
            ]);

            $save_DS = new DebitSource();
            $save_DS->Id = $this->DS_Id;
            $save_DS->Name = $this->Name;
            $save_DS->Category = $this->CategoryType;

            $this->ImageUpload();
            $save_DS->Thumbnail = $this->NewImage;
            $save_DS->save(); // Category Created

            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Debit Source ' . $this->Name . ' Added!.',
                'text' => '',
                'icon' => 'success',
                'rediredect-url' => route('DebitSource'),
                'timer' => 2000,
            ]);

        } elseif ($this->Type == 'Sub Category') {
            $this->validate([
                'CategoryList' => 'required',
                'SubCategoryName' => 'required',
                'Unit_Price' => 'required',
            ]);

            $exists = DebitSource::where('Name', $this->CategoryList)->first();
            if ($exists) {
                $this->DS_Id = $exists->Id;
                $Name = $exists->Name;
            }

            $time = substr(time(), -8); // Changed to -8 to get the last 8 digits
            $dsId = $this->DS_Id . $time;

            $save_DS = new DebitSources();
            $save_DS->Id = $dsId;
            $save_DS->DS_Id = $this->DS_Id;
            $save_DS->DS_Name = $Name;
            $save_DS->Name = $this->SubCategoryName;
            $save_DS->Unit_Price = $this->Unit_Price;

            if ($this->CategoryType == "Loan") {
                $save_DS->Loan_Amount = $this->Loan_Amount;
                $save_DS->Tenure = $this->Tenure;
                $amount = $this->Loan_Amount / $this->Tenure;
                $save_DS->Unit_Price = $amount;
            }

            $save_DS->save(); // Sub Category Created

            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Debit Source ' . $this->SubCategoryName . ' Added!.',
                'text' => '',
                'icon' => 'success',
                'rediredect-url' => route('DebitSource'),
                'timer' => 2000,
            ]);
            $this->ResetSubFields();
            $this->CategoryList = $this->SubCategoryName;
        }
    }

    public function Change($val) # Function to Reset Field when Category Changes
    {
        $this->Update = 0;
        $time = substr(time(), 6, 8);
        $this->DS_Id = 'DS' . $time;
        $this->Name = NULL;
        $this->CategoryName = NULL;
        $this->SubCategoryName = NULL;
        $this->Image = NULL;
        $this->iteration++;
        $this->OldImage = NULL;
        $this->CategoryList = NULL;
        $this->Unit_Price = NULL;
    }
    public function EditMain($id) # Function to Fetch Main Category Fields
    {
        $this->Type = 'Main Category';
        $this->Update = 1;
        $fetch = DebitSource::Where('Id', '=', $id)->get();
        foreach ($fetch as $key) {
            $this->DS_Id = $key['Id'];
            $Name = $key['Name'];
            $OldImage = $key['Thumbnail'];
        }
        $this->Image = NULL;
        $this->DS_Id = $id;
        $this->Name = $Name;
        $this->OldImage = $OldImage;
    }
    public function ImageUpload()
    {
        if (!empty($this->Image)) { // Check if a new image is selected
            if (!empty($this->OldImage) && Storage::disk('public')->exists($this->OldImage)) {
                unlink(storage_path('app/public/' . $this->OldImage));
            }

            $this->validate([
                'Image' => 'required|image',
            ]);

            $extension = $this->Image->getClientOriginalExtension();
            $path = 'Digital Ledger/Debit Source/Thumbnail' . time();
            $filename = 'DS_' . $this->Name . '_' . time() . '.' . $extension;
            $url = $this->Image->storePubliclyAs($path, $filename, 'public');
            $this->NewImage = $url;
        } else { // Check if old image exists
            if (!empty($this->OldImage) && Storage::disk('public')->exists($this->OldImage)) {
                $this->NewImage = $this->OldImage;
            } else {
                $this->validate([
                    'Image' => 'required|image',
                ]);

                $extension = $this->Image->getClientOriginalExtension();
                $path = 'Digital Ledger/Debit Source/Thumbnail' . time();
                $filename = 'DS_' . $this->Name . '_' . time() . '.' . $extension;
                $url = $this->Image->storePubliclyAs($path, $filename, 'public');
                $this->NewImage = $url;
            }
        }
    }

    public function UpdateMain($Id) # Function to Update Main Category Fields in Record
    {
        // Fetch the old name
        $fetch = DebitSource::find($Id);
        if (!$fetch) {
            session()->flash('Error', 'Record not found.');
            return;
        }
        $oldname = $fetch->Name;

        // Handle the image upload
        $this->ImageUpload();

        // Update the main category
        $update_source = DB::update('update debit_source set Name = ?, Thumbnail=? where Id = ?', [$this->Name, $this->NewImage, $Id]);

        // Update sub-categories associated with the main category
        $update_sources = DB::update('update debit_sources set DS_Name = ? where DS_Id = ?', [$this->Name, $Id]);

        // Update ledger entries
        $update_CL = DB::update('update debit_ledger set Category = ? where Category = ?', [$this->Name, $oldname]);

        // Reset fields
        $this->ResetMainFields();

        // Set session flash messages based on updates
        if ($update_source && $update_CL && $update_sources) {
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Debit Source ' . $this->Name . ' Updated!.',
                'text' => '',
                'icon' => 'success',
                'rediredect-url' => route('DebitSource'),
                'timer' => 2000,
            ]);
        } elseif ($update_source) {
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Debit Source ' . $this->Name . ' Updated!.',
                'text' => 'Record Updated Successfully!',
                'icon' => 'success',
                'rediredect-url' => route('DebitSource'),
                'timer' => 2000,
            ]);
        } elseif ($update_CL) {
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Debit Source ' . $this->Name . ' Updated!.',
                'text' => 'Ledger Updated Successfully!',
                'icon' => 'success',
                'rediredect-url' => route('DebitSource'),
                'timer' => 2000,
            ]);
        } else {
            session()->flash('Error', 'Sorry! Unable to Update ' . $this->Name . ' Source in Record.');
            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Unable to Update ' . $this->Name . ' Source in Record.',
                'text' => '',
                'icon' => 'error',
                'rediredect-url' => route('DebitSource'),
                'timer' => 2000,
            ]);
        }
    }



    public function DeleteMain($Id) # Function to Delete Main Category Record
    {
        // Fetch the main category record
        $fetch = DebitSource::find($Id);
        if (!$fetch) {
            session()->flash('Error', 'Record not found.');
            return;
        }

        $Name = $fetch->Name;
        $Image = $fetch->Thumbnail;

        // Check if the category has sub-categories
        $subCategories = DebitSources::where([['DS_Name', '=', $Name], ['DS_Id', '=', $Id]])->count();
        if ($subCategories > 0) {
            $this->dispatchBrowserEvent('swal:error', [
                'title' => $Name . ' This Category Contains ' . $subCategories . ' Sub Categories. Please Delete Sub Categories first.',
                'text' => '',
                'icon' => 'error',
                'rediredect-url' => route('DebitSource'),
                'timer' => 2000,
            ]);
            return;
        }

        // Check if the category is used in any debit records
        $debits = Debit::where('Category', $Name)->count();
        if ($debits > 0) {
            $this->dispatchBrowserEvent('swal:error', [
                'title' => $Name . ' This Source Field is Served, Cannot Delete.',
                'text' => '',
                'icon' => 'error',
                'rediredect-url' => route('DebitSource'),
                'timer' => 2000,
            ]);
            return;
        }

        // Remove the image if it exists
        if (!empty($Image)) {
            $imagePath = str_replace('storage/app/', '', $Image);
            if (Storage::exists($imagePath)) {
                unlink(storage_path('app/' . $imagePath));
            }
        }

        // Delete the main category record
        $delete = DebitSource::destroy($Id);
        if ($delete) {
            $this->dispatchBrowserEvent('swal:success', [
                'title' => $Name . ' Deleted Permanently.',
                'text' => '',
                'icon' => 'success',
                'rediredect-url' => route('DebitSource'),
                'timer' => 2000,
            ]);
        } else {
            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Unable to Delete ' . $Name . ' sorry.',
                'text' => '',
                'icon' => 'error',
                'rediredect-url' => route('DebitSource'),
                'timer' => 2000,
            ]);
        }

        // Reset fields
        $this->Name = null;
        $this->Image = null;
        $this->OldImage = null;
        $this->Update = 0;
    }

    public function EditSub($id) # Function to Fetch Sub Category Fields
    {
        $this->Type = "Sub Category";
        $this->Update = 2;

        // Fetch the sub-category record
        $fetch = DebitSources::find($id);
        if (!$fetch) {
            session()->flash('Error', 'Sub-category not found.');
            return;
        }

        // Assign the fetched values to the class properties
        $this->DS_Id = $fetch->Id;
        $this->CategoryList = $fetch->DS_Name;
        $this->SubCategoryName = $fetch->Name;
        $this->Unit_Price = $fetch->Unit_Price;
        $this->Tenure = $fetch->Tenure;
        $this->Loan_Amount = $fetch->Loan_Amount;
    }

    public function Capitalize()
    {
        if (!is_null($this->Name)) {
            $this->Name = ucwords($this->Name);
        }

        if (!is_null($this->SubCategoryName)) {
            $this->SubCategoryName = ucwords($this->SubCategoryName);
        }
    }

    public function UpdateSub($Id) # Function to Update Sub Category Record
    {
        // Fetch the sub-category record
        $fetch = DebitSources::find($Id);
        if (!$fetch) {
            session()->flash('Error', 'Sub-category not found.');
            return;
        }

        $DS_Name = $fetch->DS_Name;
        $Source = $fetch->Name;

        // Check if the sub-category is used in any debit records
        $check_record = DB::table('debit_ledger')->where('Source', $Source)->get();
        if ($check_record->isNotEmpty()) {
            foreach ($check_record as $key) {
                $category = $key->Category;
                $subcategory = $key->Source;
            }
        }

        // Update the ledger records
        $data = [
            'Category' => $this->CategoryList,
            'Source' => $this->SubCategoryName,
        ];
        $update_CL = DB::table('debit_ledger')->where('Source', $Source)->update($data);

        // Calculate the total revenue
        $revenue = DB::table('debit_ledger')->where('Source', $this->SubCategoryName)->sum('Amount_Paid');

        // Update the sub-category record
        $data = [
            'Name' => $this->SubCategoryName,
            'Unit_Price' => $this->Unit_Price,
            'Total_Paid' => $revenue,
        ];
        $update = DB::table('debit_sources')->where('Id', $Id)->update($data);

        // Handle the result of the updates
        if ($update && $update_CL) {
            session()->flash('SuccessMsg', $this->SubCategoryName . ' Details Updated Successfully.');
        } elseif ($update) {
            session()->flash('SuccessMsg', $this->SubCategoryName . ' Record Updated Successfully.');
        } elseif ($update_CL) {
            session()->flash('SuccessMsg', $this->SubCategoryName . ' Ledger Updated Successfully.');
        } else {
            session()->flash('Error', 'No changes found for ' . $this->SubCategoryName . ' field for update.');
        }

        // Reset fields
        $this->ResetSubFields();
        $this->CategoryList = $DS_Name;
    }

    public function DeleteSub($Id)
    {
        // Fetch the sub-category record
        $fetch = DebitSources::find($Id);
        if (!$fetch) {
            session()->flash('Error', 'Sub-category not found.');
            return;
        }

        $main = trim($fetch->DS_Name);
        $sub = trim($fetch->Name);



        // Check if the sub-category is used in any debit ledger records
        $find_CL = Debit::where([['Source','=',$main],['Name', '=', $sub]])->get();

        if ($find_CL->count() > 0) {
            session()->flash('Error', "$sub for $main is already served " . $find_CL->count() . " times, Unable to Delete.");
            return;
        }

        // Attempt to delete the sub-category record
        try {
            $delete = DebitSources::destroy($Id);
            if ($delete) {
                session()->flash('SuccessMsg', "$sub for $main Deleted Permanently.");
            } else {
                session()->flash('Error', "Unable to delete $sub for $main.");
            }
        } catch (\Exception $e) {
            // Log the exception message for debugging
            Log::error('DeleteSub Exception: ' . $e->getMessage());
            session()->flash('Error', "An error occurred while deleting $sub for $main. Please try again.");
        }
    }



    public function ResetList($val) # Function to Reset Sub Category Fields When Sub Category Value changes.
    {
        $this->SubCategoryName = null;
        $this->Unit_Price = null;
    }


    public function render() # Default Function to View Blade File In Livewire
{
    $this->Capitalize();

    // Fetch main categories
    $Exist_Main_Category = DebitSource::orderBy('Name')->get();

    // Determine which categories to show based on the type
    if ($this->Type === 'Main Category') {
        $this->exist_main_categories = DebitSource::orderBy('Name')->paginate(10);
        $this->exist_categories = null; // Clear sub-categories
    } elseif ($this->Type === 'Sub Category') {
        $this->exist_categories = DebitSources::where('DS_Name', $this->CategoryList)->paginate(10);
        $this->exist_main_categories = null; // Clear main categories
    }

    // Fetch category ID and type if CategoryList is not null
    if (!is_null($this->CategoryList)) {
        $category = DebitSource::where('Name', $this->CategoryList)->first();
        if ($category) {
            $this->CategoryType = $category->Category;
            $id = $category->Id;

            $this->exist_categories = DebitSources::where([
                ['DS_Name', '=', $this->CategoryList],
                ['DS_Id', '=', $id]
            ])->paginate(10);
        }
    }

    // Calculate Unit Price if CategoryType is "Loan"
    if ($this->CategoryType === 'Loan') {
        $this->Unit_Price = $this->Loan_Amount / ($this->Tenure > 0 ? $this->Tenure : 1);
    }

    // Return view with necessary data
    return view('livewire.admin-module.ledger.debit.add-debit-source', [
        'n' => $this->n,
        'exist_main_categories' => $this->exist_main_categories,
        'Categorys' => $Exist_Main_Category,
        'exist_categories' => $this->exist_categories
    ]);
}

}
