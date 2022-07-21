<?php

namespace App\Http\Livewire;

use App\Models\Bookmark;
use App\Models\MainServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Bookmarks extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme ='Bootstrap';
    public $Name, $Thumbnail,$Bm_Id,$Old_Thumbnail,$Relation,$Update,$n=1,$Hyperlink, $iteration, $ChangeRelation, $New_Thumbnail;


    protected $rules = [
        'Name' =>'required ',
        'Relation' =>'required',
        'Hyperlink' =>'required',
        'Thumbnail' =>'required',
    ];

    protected $messages = [
       'Name.required' => 'Please Enter the Bookmark Name',
       'Service_Type.required' => 'Please Select Bookmark Relation',
       'Description.required' => 'Please Copy or enter Web Address ',
       'Thumbnail.required' =>'Please Select Bookmark Icon',

   ];
   public function updated($propertyName)
   {
       $this->validateOnly($propertyName);
   }
    public function mount()
    {
        $this->Bm_Id = 'BM'.time();
    }
    public function ResetFields()
    {
        $this->Bm_Id = 'BM'.time();
        $this->Name = NULL;
        $this->Thumbnail = NULL;
        $this->iteration ++;
        $this->Hyperlink = NULL;
        $this->Old_Thumbnail = NULL;
        $this->ChangeRelation = NULL;
        $this->Relation = '---Select---';
        $this->Update=0;
    }
    public function Change($val)
    {
        $this->Name = NULL;
        $this->Thumbnail = NULL;
        $this->ChangeRelation = NULL;
        $this->iteration++;
        $this->Hyperlink = NULL;
        $this->Old_Thumbnail = NULL;
        $this->Update = 0;
    }
    public function Save()
    {

        $this->validate();
        $save_bm = new Bookmark();
        $save_bm->BM_ID = $this->Bm_Id;
        $save_bm->Name = $this->Name;
        $save_bm->Relation = $this->Relation;
        $save_bm->Hyperlink = $this->Hyperlink;
        $save_bm->Thumbnail = 'storage/app/'. $this->Thumbnail->storeAs('Thumbnails/Bookmarks/',$this->Name.time().'.jpeg');
        $save_bm->save();
        session()->flash('SuccessMsg',$this->Name.'  is saved In '.$this->Relation.' Category');
        $this->ResetFields();
        $this->Relation = $this->Relation;


    }
    public function Edit($bm_Id)
    {
        $fetch = Bookmark::Where('BM_Id',$bm_Id)->get();
        foreach($fetch as $item)
        {
            $this->Bm_Id = $item['BM_Id'];
            $this->Name = $item['Name'];
            $this->Relation = $item['Relation'];
            $this->Hyperlink = $item['Hyperlink'];
            $this->Old_Thumbnail = $item['Thumbnail'];
        }
        $this->Update = 1;
        $this->ChangeRelation=Null;
        $this->iteration++;
    }
    public function Update()
    {
        if(!is_Null($this->Thumbnail))
        {
            if(!is_Null($this->Old_Thumbnail))
            {
                $Thumbnail = str_replace('storage/app/', '',$this->Old_Thumbnail);
                if(Storage::exists($Thumbnail))
                {
                    unlink(storage_path('app/'.$Thumbnail));
                    $this->New_Thumbnail = 'storage/app/'. $this->Thumbnail->storeAs('Thumbnails/Bookmarks/',$this->Name.time().'.jpeg');
                }
                else
                {
                    $this->New_Thumbnail = 'storage/app/'. $this->Thumbnail->storeAs('Thumbnails/Bookmarks/',$this->Name.time().'.jpeg');
                }
            }
            else
            {
                $this->validate([
                    'Thumbnail'=>'required|image',
                ]);
            }
        }
        else
        {
            if(!is_Null($this->Old_Thumbnail))
            {
                $Thumbnail = str_replace('storage/app/', '',$this->Old_Thumbnail);
                if(Storage::exists($Thumbnail))
                {
                    $this->New_Thumbnail = $this->Old_Thumbnail;
                }
                else
                {
                    session()->flash('Error','File Does not Exist. Please Select New Thumbnail');
                    $this->validate([
                        'Thumbnail'=>'required|image',
                    ]);
                }
            }
            else
            {
                $this->validate([
                    'Thumbnail'=>'required|image',
                ]);
            }

        }
        if($this->ChangeRelation =="")
        {
            $this->Relation = $this->Relation;
        }
        else
        {
            $this->Relation = $this->ChangeRelation;
        }
        $Update = DB::update('update bookmark set Name = ?, Relation = ?, Hyperlink = ?, Thumbnail = ? where BM_Id = ? ', [$this->Name,$this->Relation,$this->Hyperlink,$this->New_Thumbnail,$this->Bm_Id]);
        if($Update)
        {
            session()->flash('SuccessMsg',$this->Name.' Bookmark is Updated for '.$this->Relation);
            $this->ResetFields();
            $this->Thumbnail=Null;
            $this->iteration++;
            $this->Update = 0;
        }


    }
    public function Delete($bm_Id)
    {
        $fetch = Bookmark::Where('BM_Id',$bm_Id)->get();
        if(count($fetch)>0)
        {
            foreach($fetch as $item)
            {
                $this->Old_Thumbnail = $item['Thumbnail'];
                $this->Name = $item['Name'];
            }
        }
        $path = str_replace('storage/app/', '', $this->Old_Thumbnail);
        if (Storage::exists($path))
        {
            unlink(storage_path('app/'.$path));
            $delete = Bookmark::Where('BM_Id',$bm_Id)->delete();
            if($delete)
            {
                session()->flash('SuccessMsg',$this->Name.' is Deleted from '.$this->Relation);
                $this->ResetFields();
            }
            else
            {
                session()->flash('Error', 'Unable to Delete Bookmark');
            }
        }
        else
        {
            $delete = Bookmark::Where('BM_Id',$bm_Id)->delete();
            if($delete)
            {
                session()->flash('SuccessMsg',$this->Name.'  is Deleted from '.$this->Relation);
                $this->ResetFields();
            }
            else
            {
                session()->flash('Error', 'Unable to Delete Bookmark');
            }
        }

    }
    public function render()
    {
        $MainServices = MainServices::all();
        $Existing_Bm = DB::table('bookmark')->where('Relation',$this->Relation)->paginate(10);
        return view('livewire.bookmarks',['MainServices'=>$MainServices,'Existing_Bm'=>$Existing_Bm]);
    }
}
