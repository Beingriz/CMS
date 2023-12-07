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
    public $CS_Id, $Type ,$CategoryList , $pos ,$Unit_Price, $Exist = NULL;
    public $Name = "";
    public $CategoryName, $SubCategoryName;
    public $Thumbnail , $iteration;
    public $Image , $OldImage, $Update = 0;
    public $Paginate = 10;
    public $Checked = [];
    public $filterby;
    protected $exist_main_categories = [];
    protected $exist_categories=[];
    public $fName;
    public $edit, $NewImage;
    protected $listeners = ['refreshProducts'];

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'Name' => 'required|unique:credit_source',
        'Image'=>'required|image',
    ];
    protected $messages = [
        'Name.required'=>'Please Enter the Category Name',
        'SubCategoryName.required' => 'Please Enter Sub Category Name',
        'Unit_Price.required' => 'Please Set Unit Price',
        'Image.required|'=>'Please Select Thumbnail',
     ];

    public function updated( $propertyName)
    {

        $this->validateOnly($propertyName);
    }

    public function mount($EditData,$DeleteData,$editid,$deleteid)
    {

        $time = substr(time() , 6 ,8 );
        $this->CS_Id = 'CS'.$time;
        if($this->CategoryList)
        {
            $this->edit = NULL;
        }
        if(!empty($EditData)){
            $this->EditMain($EditData);
        }
        if(!empty($DeleteData)){
            $this->DeleteMain($DeleteData);
        }
        if(!empty($editid)){
            $this->EditSub($editid);
        }
        if(!empty($deleteid)){
            $this->DeleteSub($deleteid);
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
            $this->ImageUpload();
            $save_CS->Thumbnail = $this->NewImage;
            $save_CS->save(); //Category Created
            $notification = array(
                'message'=>'Credit Sournce'.$this->Name.' Added!.',
                'alert-type'=>'success'
            );
            return redirect()->route('CreditSource')->with($notification);
            $this->Type == 'Main Category';
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
        $this->Type = 'Main Category';
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
     public function ImageUpload(){

        if(!empty($this->Image)) // Check if new image is selected
        {
            if(!empty($this->OldImage))
            {
                if(Storage::disk('public')->exists($this->OldImage))
                {
                    unlink(storage_path('app/public/'.$this->OldImage));
                    $extension = $this->Image->getClientOriginalExtension();
                    $path = 'Digital Ledger/Credit Source/Thumbnail'.time();
                    $filename = 'BM_'.$this->Name.'_'.time().'.'.$extension;
                    $url = $this->Image->storePubliclyAs($path,$filename,'public');
                    $this->NewImage = $url;
                }
                else
                {
                    $extension = $this->Image->getClientOriginalExtension();
                    $path = 'Digital Ledger/Credit Source/Thumbnail'.time();
                    $filename = 'BM_'.$this->Name.'_'.time().'.'.$extension;
                    $url = $this->Image->storePubliclyAs($path,$filename,'public');
                    $this->NewImage = $url;
                }
            }
            else
            {

                $this->validate([
                    'Image'=>'required|image',
                ]);
                $extension = $this->Image->getClientOriginalExtension();
                $path = 'Digital Ledger/Credit Source/Thumbnail'.time();
                $filename = 'BM_'.$this->Name.'_'.time().'.'.$extension;
                $url = $this->Image->storePubliclyAs($path,$filename,'public');
                $this->NewImage = $url;

            }
        }
        else // check old is exist
        {
            if(!empty($this->OldImage))
            {
                if(Storage::disk('public')->exists($this->OldImage))
                {
                    $this->NewImage = $this->OldImage;
                }
            }
            else
            {
                $this->validate([
                    'Image'=>'required|image',
                ]);
                $extension = $this->Image->getClientOriginalExtension();
                $path = 'Digital Ledger/Credit Source/Thumbnail'.time();
                $filename = 'BM_'.$this->Name.'_'.time().'.'.$extension;
                $url = $this->Image->storePubliclyAs($path,$filename,'public');
                $this->NewImage = $url;

            }
        }
    }
     public function UpdateMain($Id) # Function to Update Main Category Fields in Record
     {
        $fetch = CreditSource::Wherekey($Id)->get();
        foreach($fetch as $key)
        {
            $oldname = $key['Name'];
        }
        $this->ImageUpload();
        $update_source = DB::update('update credit_source set Name = ?, Thumbnail=? where Id = ?', [$this->Name,$this->NewImage,$Id]);
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
        $this->Type = "Sub Category";
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
     public function Capitalize()
    {
        $this->Name = ucwords($this->Name);
        $this->SubCategoryName = ucwords($this->SubCategoryName);
    }
     public function UpdateSub($Id) # Function to Update Sub Category Record
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
        }
        $data = array();
        $data['Category'] = $this->CategoryList;
        $data['Sub_Category'] = $this->SubCategoryName;
        $update_CL = DB::table('credit_ledger')->where('Sub_Category',$Source)->update($data);
        $revenue = DB::table('credit_ledger')->where('Sub_Category',$this->SubCategoryName)->SUM('Total_Amount');
        $data = array();
        $data['Source'] = $this->SubCategoryName;
        $data['Unit_Price'] = $this->Unit_Price;
        $data['Total_Revenue'] = $revenue;
        $update = DB::table('credit_sources')->where('Id',$Id)->update($data);

        $data = array();
        $data['Category'] = $this->CategoryList;
        $data['Sub_Category'] = $this->SubCategoryName;
        $update_CL = DB::table('credit_ledger')->where('Sub_Category',$Source)->update($data);

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
        $this->Capitalize();
        $Exist_Main_Category = CreditSource::orderby('Name')->get();
        if($this->Type == 'Main Category')
        {
            $this->exist_main_categories = CreditSource::orderby('Name')->paginate(10);
        }
        elseif ($this->Type == "Sub Category")
        {
            $this->exist_categories = CreditSources::Where('CS_Name','=',$this->CategoryList)->paginate(10);
        }
        if(!is_null($this->CategoryList))
        {
            $getid = CreditSource::Where('Name',$this->CategoryList)->get();
            foreach($getid as $key)
            {
                $id = $key['Id'];
            }
            $this->exist_categories = CreditSources::Where([['CS_Name','=',$this->CategoryList],['CS_Id','=',$id]])->paginate(10);
        }
        return view('livewire.add-credit-source',[
            'n'=>$this->n,
            'exist_main_categories'=>$this->exist_main_categories,
            'Categorys'=>$Exist_Main_Category,
            'exist_categories'=>$this->exist_categories
        ]);
    }
}
