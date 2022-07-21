<?php

namespace App\Http\Livewire;

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
    public $CS_Id, $Type ,$CategoryList , $pos ,$Unit_Price, $Exist = NULL;
    public $Name = "";
    public $CategoryName, $SubCategoryName;
    public $Thumbnail , $iteration;
    public $Image , $OldImage, $Update = 0;
    public $Paginate = 10;
    public $Checked = [];
    public $filterby;
    protected $exist_main_categories = [];
    public $exist_categories;
    public $fName;
    public $edit;
    protected $listeners = ['refreshProducts'];

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'Name' => 'required|unique:credit_source',
        'Thumbnail'=>'required|image',
    ];
    protected $messages = [
        'Name.required'=>'Please Enter the Category Name',
        'SubCategoryName.required' => 'Please Enter Sub Category Name',
        'Unit_Price.required' => 'Please Set Unit Price',
        'Thumbnail.required|'=>'Please Select Thumbnail',
     ];

    public function updated( $propertyName)
    {

        $this->validateOnly($propertyName);
    }

    public function mount()
    {

        $time = substr(time() , 6 ,8 );

        $this->CS_Id = 'CS'.$time;
        if($this->CategoryList)
        {
            $this->edit = NULL;
        }
    }
    public function ResetMainFields()
    {
        $this->Type = 'Main Category';
        $time = substr(time() , 6 ,8 );
        $this->CS_Id = 'CS'.$time;
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
    public function Save() #Funciton to Save Categories
    {
        if($this->Type == 'Main Category')
        {
            $this->validate([
                'Name' => 'required|unique:credit_source',
                'Image'=>'required|image',
            ]);
            $save_CS = new CreditSource();
            $save_CS->Id = $this->CS_Id;
            $save_CS->Name = $this->Name;
            $save_CS->Thumbnail = '/storage/app/'.$this->Image->storeAs('Digital Ledger/Credit Department/Thumbnail',$this->Name.'.jpg');
            $save_CS->save(); //Category Created
            session()->flash('SuccessMsg', 'New Source '.$this->Name.', '.$this->CS_Id. ' Created Successfully!!');
            // redirect('../add_credit_source');
            $this->ResetMainFields();

        }
        elseif($this->Type == 'Sub Category')
        {
            $this->validate([
                'CategoryList' => 'required',
                'SubCategoryName' => 'required',
                'Unit_Price' => 'required',
            ]);

            if(!is_null($this->CategoryList))
            {
                $exists  = CreditSource::Where('Name','=',$this->CategoryList)->get();
                foreach($exists as $key)
                {
                    $Id = $key['Id'];
                    $Name = $key['Name'];
                }
                $this->CS_Id = $Id;
            }
            $time = substr(time(),6,8);
            $csId = $this->CS_Id.$time;
            $save_CS = new CreditSources();
            $save_CS->Id = $csId;
            $save_CS->CS_Id = $this->CS_Id;
            $save_CS->CS_Name = $Name;
            $save_CS->Source = $this->SubCategoryName;
            $save_CS->Unit_Price = $this->Unit_Price;
            $save_CS->Total_Revenue = 0;
            $save_CS->save(); //Sub Category  Created
            session()->flash('SuccessMsg', 'Sub Category Name: '.$this->SubCategoryName.' & ID: '.$Id. ', for '.$Name .' Created Successfully!!');
            $this->ResetSubFields();
            $this->CategoryList = $this->SubCategoryName;;
        }

    }
    public function Change($val) # Function to Reset Field when Category Changes
    {
        $this->Update = 0;
        $time = substr(time() , 6 ,8 );
        $this->CS_Id = 'CS'.$time;
        $this->Name = NULL;
        $this->CategoryName = NULL;
        $this->SubCategoryName = NULL;
        $this->Image = NULL;
        $this->iteration ++;
        $this->OldImage = NULL;
        $this->CategoryList = NULL;
        $this->Unit_Price = NULL;
    }
     public function EditMain($id) # Function to Fetch Main Category Fields
     {
        $this->Update = 1;
        $fetch = CreditSource::Where('Id','=',$id)->get();
        foreach($fetch as $key)
        {
            $this->CS_Id = $key['Id'];
            $Name = $key['Name'];
            $OldImage = $key['Thumbnail'];
        }
        $this->Image = NULL;
        $this->CS_Id = $id;
        $this->Name = $Name;
        $this->OldImage = $OldImage;
     }

     public function UpdateMain($Id) # Function to Update Main Category Fields in Record
     {
        $fetch = CreditSource::Wherekey($Id)->get();
        foreach($fetch as $key)
        {
            $oldimage = $key['Thumbnail'];
            $oldname = $key['Name'];
        }
        if(!is_Null($this->Image))
        {
            $oldimage = str_replace('storage/app/', '' ,$oldimage);
            if (Storage::exists($oldimage))
            {
                unlink(storage_path('app/'.$oldimage));
                $NewImage = 'storage/app/'. $this->Image->storeAs('Digital Ledger/Credit Department/Thumbnail',$this->Name.'_'.time().'.jpg');
            }
            else
            {
                $NewImage = 'storage/app/'.$this->Image->storeAs('Digital Ledger/Credit Department/Thumbnail',$this->Name.'_'.time().'.jpg');
            }
        }
        elseif(!is_Null($oldimage))
        {
            $NewImage = $oldimage;
        }
        $update_source = DB::update('update credit_source set Name = ?, Thumbnail=? where Id = ?', [$this->Name,$NewImage,$Id]);
        $update_sources = DB::update('update credit_sources set CS_Name = ?  where CS_Id = ?', [$this->Name,$Id]);
        $update_CL = DB::update('update credit_ledger set Category = ? where Category = ?', [$this->Name,$oldname]);
        $this->ResetMainFields();
        if($update_source && $update_CL && $update_sources)
        {
            session()->flash('SuccessMsg', $this->Name.' Details Updated Successfully!');
        }
        elseif($update_source)
        {
            session()->flash('SuccessMsg', $this->Name.' Record Updated Successfully!');
        }
        elseif($update_CL)
        {
            session()->flash('SuccessMsg', $this->Name.' Ledger Updated Successfully!');
        }
        else
        {
            session()->flash('Error', 'Sorry!. Unable to Update '.$this->Name .' Source in Record');
        }
     }
     public function DeleteMain($Id) # Function to Delete Main Category Record
     {
        $fetch = CreditSource::Wherekey($Id)->get();
        foreach($fetch as $key)
        {
            $Id = $key['Id'];
            $Name = $key['Name'];
            $Image = $key['Thumbnail'];
        }
        $find = CreditLedger::Where('Category',$Name)->get();
        $findsub = CreditSources::Where([['CS_Name','=',$Name],['CS_Id','=',$Id]])->get();

        if(count($findsub)>0)
        {
            $val = count($findsub);
        session()->flash('Error', $Name.' This Category Contains '.$val. ' Sub Categories. Please Delete Sub Categories first.');
        }
        elseif(count($find)>0)
        {
            session()->flash('Error', $Name.' This Source Field is Served, Cannot Delete ');
        }
        else
        {
            $Image = str_replace('storage/app/', '' ,$Image);
            if(Storage::exists($Image))
            {
                unlink(storage_path('app/'.$Image));
                $delete = CreditSource::Wherekey($Id)->delete();
                if($delete)
                {
                    session()->flash('SuccessMsg', $Name.' Deleted Permanently.. ');
                    $this->Name = NUll;
                    $this->Image = NUll;
                    $this->OldImage = NUll;
                    $this->Update = 0;
                }
                else
                {
                    session()->flash('Error', 'Unable to Delete'.$Name.'sorry..');
                }
            }
            else
            {
                $delete = CreditSource::Wherekey($Id)->delete();
                if($delete)
                {
                    session()->flash('SuccessMsg', $Name.' Deleted Permanently.. No Thumbnail File Found!');
                    $this->Name = NUll;
                    $this->Image = NUll;
                    $this->OldImage = NUll;
                    $this->Update = 0;
                }
                else
                {
                    session()->flash('Error', 'Unable to Delete'.$Name.'sorry..');
                }
            }
        }
    }
     public function EditSub($id) # Function to Fetch Sub Category Fields
     {
         $this->Update = 2;
         $fetch = CreditSources::Where('Id','=',$id)->get();
         foreach($fetch as $key)
         {
            $this->CS_Id = $key['Id'];
            $this->CategoryList = $key['CS_Name'];
            $this->SubCategoryName = $key['Source'];
            $this->Unit_Price = $key['Unit_Price'];
         }
     }
     public function UpdateSub($Id) # Function to Update Main Category Record
     {
        $fetch = CreditSources::Wherekey($Id)->get();
        foreach($fetch as $key)
        {
            $CS_Name = $key['CS_Name'];
            $Source = $key['Source'];
            $Unit_Price = $key['Unit_Price'];
        }
        $check_record = DB::table('credit_ledger')->where([['Sub_Category','=',$Source],])->get();
        $count = count($check_record);
        if(count($check_record))
        {
            foreach($check_record as $key)
            {
                $key = get_object_vars($key);
                $category = $key['Category'];
                $subcategory = $key['Sub_Category'];
            }
            if($category == "" && $subcategory == $Source)
            {
                $update_CL = DB::update('update credit_ledger set Category = ?, Sub_Category=? where Sub_Category =?', [$this->CategoryList,$this->SubCategoryName,$Source]);
                if($update_CL)
                {
                    session()->flash('SuccessMsg',$this->CategoryList.' Has been Updated in'. $count.' Records for '.$category .'values');
                }
                else
                {
                    session()->flash('Error',$this->CategoryList.' Unable to Updated in'. $count.' Records for '.$category .'values');
                }
            }
        }
        $update = DB::update('update credit_sources set Source = ?, Unit_Price=? where Id = ?', [$this->SubCategoryName,$this->Unit_Price,$Id]);
        $update_CL = DB::update('update credit_ledger set Category = ?, Sub_Category=? where Sub_Category =?', [$this->CategoryList,$this->SubCategoryName,$Source]);

        if($update && $update_CL)
        {
            session()->flash('SuccessMsg',$this->SubCategoryName.' Details Updated Successfully..');
            $this->ResetSubFields();
            $this->CategoryList = $CS_Name;
        }
        elseif($update)
        {
            session()->flash('SuccessMsg',$this->SubCategoryName.' Record Updated Successfully ..');
            $this->ResetSubFields();
            $this->CategoryList = $CS_Name;

        }
        elseif($update_CL)
        {
            session()->flash('SuccessMsg',$this->SubCategoryName.' Ledger Updated Successfully..');
            $this->ResetSubFields();
            $this->CategoryList = $CS_Name;
        }
        else
        {
            session()->flash('Error',' No Changes Foud for in '.$this->SubCategoryName. ' Field for Update ..');
        }

    }

    public function DeleteSub($Id)
    {
        $fetch = CreditSources::Wherekey($Id)->get();
        foreach($fetch as $key)
        {
            $main = $key['CS_Name'];
            $sub = $key['Source'];
        }
        $find_CL = DB::table('credit_ledger')->where([['Category', '=', $main],['Sub_Category', '=', $sub],])->get();
        if(count($find_CL)>0)
        {
            session()->flash('Error', $sub.' for '.$main.' is already served  '.count($find_CL).' times,  Unable to Delete');
        }
        else
        {
            $delete = CreditSources::wherekey($Id)->delete();
            if($delete)
            {
                session()->flash('SuccessMsg', $sub.' for '.$main. ' Deleted Permanently.. ');
            }
            else
            {
                session()->flash('Error', $sub.' for '.$main.'was unable to Delete!');
            }
        }
    }

    public function ResetList($val) # Function to Reset Sub Category Fields When Sub Category Value changes.
    {
        $this->SubCategoryName = NULL;
        $this->Unit_Price = NULL;
    }

    public function render() # Default Function to View Blade File In Livewire
    {
        $Exist_Main_Category = CreditSource::orderby('Name')->get();
        if($this->Type == 'Main Category')
        {
            $this->exist_main_categories = CreditSource::orderby('Name')->paginate(10);
        }
        elseif ($this->Type == "Sub Category")
        {
            $this->exist_categories = CreditSources::Where('CS_Name','=',$this->CategoryList)->get();
        }
        if(!is_null($this->CategoryList))
        {
            $getid = CreditSource::Where('Name',$this->CategoryList)->get();
            foreach($getid as $key)
            {
                $id = $key['Id'];
            }
            $this->exist_categories = CreditSources::Where([['CS_Name','=',$this->CategoryList],['CS_Id','=',$id]])->get();
        }
        return view('livewire.add-credit-source',[
            'n'=>$this->n,
            'exist_main_categories'=>$this->exist_main_categories,
            'Categorys'=>$Exist_Main_Category,
            'exist_categories'=>$this->exist_categories
        ]);
    }
}
