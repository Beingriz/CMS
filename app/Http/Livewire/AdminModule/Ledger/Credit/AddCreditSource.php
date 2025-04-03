<?php

namespace App\Http\Livewire\AdminModule\Ledger\Credit;

use App\Models\CreditLedger;
use App\Models\CreditSource;
use App\Models\CreditSources;
use App\Traits\RightInsightTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


use function PHPUnit\Framework\isNull;

class AddCreditSource extends Component
{
    use RightInsightTrait;
    use WithFileUploads;
    use WithPagination;
    public $CS_Id, $Type, $CategoryList, $pos, $Unit_Price, $Exist = NULL;
    public $Name = "";
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
    protected $listeners = ['refreshProducts','editMain' => 'EditMain',
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
        $this->CS_Id = 'CS' . $time;
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
        $this->CS_Id = 'CS' . $time;
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
    public function Save() # Function to Save Categories
    {
        if ($this->Type === 'Main Category') {
            // Validate main category
            $this->validate([
                'Name'  => 'required|unique:credit_source',
                'Image' => 'required|image',
            ]);

            // Create new main category
            $save_CS = new CreditSource();
            $save_CS->Id = $this->CS_Id;
            $save_CS->Name = $this->Name;

            // Upload image
            $this->ImageUpload();
            $save_CS->Thumbnail = $this->NewImage;
            $save_CS->save(); // Save Main Category

            // Show success message using SweetAlert
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Main Category Created!',
                'text'  => "Credit Source '{$this->Name}' added successfully!",
                'icon'  => 'success',
                'redirect-url' => route('CreditSource'),
                'redirect-delay' => 2000, // Delay before redirecting
            ]);


        }

        if ($this->Type === 'Sub Category') {
            // Validate subcategory
            $this->validate([
                'CategoryList'   => 'required',
                'SubCategoryName'=> 'required|unique:credit_sources,Source',
                'Unit_Price'     => 'required|numeric|min:0',
            ]);

            // Check if main category exists
            $exists = CreditSource::where('Name', $this->CategoryList)->first();

            if (!$exists) {
                $this->dispatchBrowserEvent('swal:error', [
                    'title' => 'Error',
                    'text'  => "Main Category '{$this->CategoryList}' not found!",
                    'icon'  => 'error',
                ]);
                return;
            }

            // Generate unique ID for subcategory
            $time = substr(time(), 6, 8);
            $csId = $exists->Id . $time;

            // Create new subcategory
            $save_CS = new CreditSources();
            $save_CS->Id = $csId;
            $save_CS->CS_Id = $exists->Id;
            $save_CS->CS_Name = $exists->Name;
            $save_CS->Source = $this->SubCategoryName;
            $save_CS->Unit_Price = $this->Unit_Price;
            $save_CS->Total_Revenue = 0;
            $save_CS->save(); // Save Sub Category

            // Show success message using SweetAlert
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Sub Category Created!',
                'text'  => "Sub Category '{$this->SubCategoryName}' under '{$exists->Name}' created successfully!",
                'icon'  => 'success',
                'redirect-url' => route('CreditSource'),
                'redirect-delay' => 2000, // Delay before redirecting
            ]);

            // Reset fields
            $this->ResetSubFields();
            $this->CategoryList = $this->SubCategoryName;
        }
    }

    public function Change($val) # Function to Reset Field when Category Changes
    {
        $this->Update = 0;
        $time = substr(time(), 6, 8);
        $this->CS_Id = 'CS' . $time;
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
        $fetch = CreditSource::Where('Id', '=', $id)->get();
        foreach ($fetch as $key) {
            $this->CS_Id = $key['Id'];
            $Name = $key['Name'];
            $OldImage = $key['Thumbnail'];
        }
        $this->Image = NULL;
        $this->CS_Id = $id;
        $this->Name = $Name;
        $this->OldImage = $OldImage;
    }
    public function ImageUpload()
    {

        if (!empty($this->Image)) // Check if new image is selected
        {
            if (!empty($this->OldImage)) {
                if (Storage::disk('public')->exists($this->OldImage)) {
                    unlink(storage_path('app/public/' . $this->OldImage));
                    $extension = $this->Image->getClientOriginalExtension();
                    $path = 'Digital Ledger/Credit Source/Thumbnail' . time();
                    $filename = 'BM_' . $this->Name . '_' . time() . '.' . $extension;
                    $url = $this->Image->storePubliclyAs($path, $filename, 'public');
                    $this->NewImage = $url;
                } else {
                    $extension = $this->Image->getClientOriginalExtension();
                    $path = 'Digital Ledger/Credit Source/Thumbnail' . time();
                    $filename = 'BM_' . $this->Name . '_' . time() . '.' . $extension;
                    $url = $this->Image->storePubliclyAs($path, $filename, 'public');
                    $this->NewImage = $url;
                }
            } else {

                $this->validate([
                    'Image' => 'required|image',
                ]);
                $extension = $this->Image->getClientOriginalExtension();
                $path = 'Digital Ledger/Credit Source/Thumbnail' . time();
                $filename = 'BM_' . $this->Name . '_' . time() . '.' . $extension;
                $url = $this->Image->storePubliclyAs($path, $filename, 'public');
                $this->NewImage = $url;
            }
        } else // check old is exist
        {
            if (!empty($this->OldImage)) {
                if (Storage::disk('public')->exists($this->OldImage)) {
                    $this->NewImage = $this->OldImage;
                }
            } else {
                $this->validate([
                    'Image' => 'required|image',
                ]);
                $extension = $this->Image->getClientOriginalExtension();
                $path = 'Digital Ledger/Credit Source/Thumbnail' . time();
                $filename = 'BM_' . $this->Name . '_' . time() . '.' . $extension;
                $url = $this->Image->storePubliclyAs($path, $filename, 'public');
                $this->NewImage = $url;
            }
        }
    }


    public function UpdateMain($Id)
    {
        try {
            DB::beginTransaction(); // Start transaction

            // Fetch old name
            $fetch = CreditSource::find($Id);
            if (!$fetch) {
                session()->flash('Error', 'Record not found!');
                return;
            }
            $oldname = $fetch->Name;

            // Upload Image
            $this->ImageUpload();

            // Update Main Category
            CreditSource::where('Id', $Id)->update([
                'Name' => $this->Name,
                'Thumbnail' => $this->NewImage
            ]);

            // Update Credit Sources Table
            DB::table('credit_sources')->where('CS_Id', $Id)->update([
                'CS_Name' => $this->Name
            ]);

            // Update Credit Ledger
            DB::table('credit_ledger')->where('Category', $oldname)->update([
                'Category' => $this->Name
            ]);

            DB::commit(); // Commit transaction

            $this->ResetMainFields();

            // Show Success Message
            $this->dispatchBrowserEvent('swal:success-non-redirect', [
                'title' => $this->Name . ' Record Updated Successfully!',
                'text' => 'Credit Source Updated Successfully',
                'icon' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction if anything fails
            session()->flash('Error', 'Failed to update record: ' . $e->getMessage());
        }
    }



    public function DeleteMain($Id)
    {
        try {
            // Fetch the main category
            $category = CreditSource::find($Id);

            if (!$category) {
                session()->flash('Error', 'Category not found.');
                return;
            }

            $Name = $category->Name;
            $Image = $category->Thumbnail;

            // Check if there are subcategories or related ledger entries
            if (CreditSources::where('CS_Name', $Name)->exists()) {
                $this->dispatchBrowserEvent('swal:warning-non-redirect', [
                    'title' => 'Subcategories exist',
                    'text' => "$Name has subcategories. Delete them first.",
                    'icon' => 'warning',
                ]);
                return;
            }

            if (CreditLedger::where('Category', $Name)->exists()) {
                $this->dispatchBrowserEvent('swal:warning-non-redirect', [
                    'title' => 'Ledger records exist',
                    'text' => "$Name is used in ledger records. Delete them first.",
                    'icon' => 'warning',
                ]);
                return;
            }

            // Begin transaction
            DB::beginTransaction();

            // Delete image if exists
            if ($Image && Storage::exists($Image)) {
                Storage::delete($Image);
            }

            // Delete category
            $category = CreditSource::where('Id', $Id)->delete();

            // Commit transaction
            DB::commit();

            $this->dispatchBrowserEvent('swal:success-non-redirect', [
                'title' => "$Name deleted successfully!",
                'text' => 'Category deleted successfully',
                'icon' => 'success',
            ]);
            $this->ResetMainFields(); // Reset form fields
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Error',
                'text' => 'Failed to delete category: ' . $e->getMessage(),
                'icon' => 'error',
            ]);
        }
    }
    public function EditSub($id) # Function to Fetch Sub Category Fields
    {
        $this->Type = "Sub Category";
        $this->Update = 2;
        $fetch = CreditSources::Where('Id', '=', $id)->get();
        foreach ($fetch as $key) {
            $this->CS_Id = $key['Id'];
            $this->CategoryList = $key['CS_Name'];
            $this->SubCategoryName = $key['Source'];
            $this->Unit_Price = $key['Unit_Price'];
        }
    }
    public function Capitalize()
    {
        $this->Name = ucwords($this->Name);
        $this->SubCategoryName = ucwords($this->SubCategoryName);
    }
    public function UpdateSub($Id)
    {
        // Fetch the existing subcategory record
        $fetch = CreditSources::whereKey($Id)->first();

        if (!$fetch) {
            session()->flash('Error', 'Sub Category not found!');
            return;
        }

        // Extract values
        $CS_Name = $fetch->CS_Name;
        $Source = $fetch->Source;
        $Unit_Price = $fetch->Unit_Price;

        // Check if the subcategory exists in the credit ledger
        $existsInLedger = DB::table('credit_ledger')->where('Sub_Category', $Source)->exists();

        // Calculate total revenue for the updated subcategory
        $revenue = DB::table('credit_ledger')
            ->where('Sub_Category', $this->SubCategoryName)
            ->sum('Total_Amount');

        // Data to update in `credit_sources`
        $updateData = [
            'Source' => $this->SubCategoryName,
            'Unit_Price' => $this->Unit_Price,
            'Total_Revenue' => $revenue,
        ];

        // Update `credit_sources`
        $updateSource = DB::table('credit_sources')->where('Id', $Id)->update($updateData);

        // Update `credit_ledger` only if the subcategory exists there
        if ($existsInLedger) {
            DB::table('credit_ledger')->where('Sub_Category', $Source)->update([
                'Category' => $this->CategoryList,
                'Sub_Category' => $this->SubCategoryName,
            ]);
        }

        // Set success messages
        if ($updateSource && $existsInLedger) {
            $message = 'Sub Category & Ledger Updated Successfully!';
        } elseif ($updateSource) {
            $message = 'Sub Category Record Updated Successfully!';
        } elseif ($existsInLedger) {
            $message = 'Ledger Updated Successfully!';
        } else {
            session()->flash('Error', 'No changes found for ' . $this->SubCategoryName . '.');
            return;
        }

        // Reset fields after update
        $this->ResetSubFields();
        $this->CategoryList = $CS_Name;

        // Show success message using SweetAlert
        $this->dispatchBrowserEvent('swal:success', [
            'title' => 'Update Successful!',
            'text' => $message,
            'icon' => 'success',
            'redirect-url' => route('CreditSource'),
            'redirect-delay' => 2000, // Delay before redirecting
        ]);
    }


    public function DeleteSub($Id)
    {
        // Fetch the subcategory record
        $fetch = CreditSources::whereKey($Id)->first();

        if (!$fetch) {
            session()->flash('Error', 'Sub Category not found!');
            return;
        }

        // Extract values
        $main = $fetch->CS_Name;
        $sub = $fetch->Source;
        // Check if this subcategory is used in credit_ledger
        $existsInLedger = DB::table('credit_ledger')
            ->where('Category', $main)
            ->where('Sub_Category', $sub)
            ->exists();

        if ($existsInLedger) {
            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Deletion Failed!',
                'text' => "❌ '$sub' under '$main' is already used in the ledger.",
                'icon' => 'error',
            ]);
        }

        // Delete the subcategory
        $delete = CreditSources::whereKey($Id)->delete();

        if ($delete) {
            // Trigger a SweetAlert success notification
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Deletion Successful!',
                'text' => "'$sub' under '$main' deleted permanently.",
                'icon' => 'success',
                'redirect-url' => route('CreditSource'),
                'redirect-delay' => 2000, // Delay before redirecting
            ]);
        } else {
            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Deletion Failed!',
                'text' => "Failed to delete '$sub' under '$main'.",
                'icon' => 'error',

            ]);
        }
    }


    public function ResetList($val) # Function to Reset Sub Category Fields When Sub Category Value changes.
    {
        $this->SubCategoryName = NULL;
        $this->Unit_Price = NULL;
    }

    public function render() # Default Function to View Blade File In Livewire
    {
        $this->Capitalize();
        $Exist_Main_Category = CreditSource::orderby('Name')->get();
        if ($this->Type == 'Main Category') {
            $this->exist_main_categories = CreditSource::orderby('Name')->paginate(10);
        } elseif ($this->Type == "Sub Category") {
            $this->exist_categories = CreditSources::Where('CS_Name', '=', $this->CategoryList)->paginate(10);
        }
        if (!is_null($this->CategoryList)) {
            $getid = CreditSource::Where('Name', $this->CategoryList)->get();
            foreach ($getid as $key) {
                $id = $key['Id'];
            }
            $this->exist_categories = CreditSources::Where([['CS_Name', '=', $this->CategoryList], ['CS_Id', '=', $id]])->paginate(10);
        }
        return view('livewire.admin-module.ledger.credit.add-credit-source', [
            'n' => $this->n,
            'exist_main_categories' => $this->exist_main_categories,
            'Categorys' => $Exist_Main_Category,
            'exist_categories' => $this->exist_categories
        ]);
    }
}
