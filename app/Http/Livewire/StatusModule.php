<?php

namespace App\Http\Livewire;

use App\Models\Application;
use App\Models\Bookmark;
use App\Models\MainServices;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class StatusModule extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme ='Bootstrap';
    public $Name, $Thumbnail,$ST_Id,$Old_Thumbnail,$Relation,$Update,$n=1, $iteration, $ChangeRelation, $New_Thumbnail,$Order;


    protected $rules = [
        'Name' =>'required ',
        'Relation' =>'required',
        'Thumbnail' =>'required',
    ];

    protected $messages = [
       'Name.required' => 'Please Enter the Status Name',
       'Relation.required' => 'Please Select Status Relation',
       'Thumbnail.required' =>'Please Select Status Icon',

   ];
   public function updated($propertyName)
   {
       $this->validateOnly($propertyName);
   }
    public function mount()
    {
        $this->ST_Id = 'ST'.time();
    }
    public function ResetFields()
    {
        $this->ST_Id = 'ST'.time();
        $this->Name = NULL;
        $this->Thumbnail = NULL;
        $this->iteration ++;
        $this->Old_Thumbnail = NULL;
        $this->ChangeRelation = NULL;
        $this->Relation = '---Select---';
        $this->Order = NULL;
        $this->Update=0;
    }
    public function Change($val)
    {
        $this->Name = NULL;
        $this->Thumbnail = NULL;
        $this->ChangeRelation = NULL;
        $this->iteration++;
        $this->Order = NULL;
        $this->Old_Thumbnail = NULL;
        $this->Update = 0;
    }
    public function Save()
    {

        $this->validate();
        $save_bm = new Status();
        $save_bm->ST_Id = $this->ST_Id;
        $save_bm->Status = $this->Name;
        $save_bm->Relation = $this->Relation;
        $save_bm->Orderby = $this->Order;
        $save_bm->Thumbnail = 'storage/app/'. $this->Thumbnail->storeAs('Thumbnails/Status/',$this->Name.time().'.jpeg');
        $save_bm->save();
        session()->flash('SuccessMsg',$this->Name.'  is saved In '.$this->Relation.' Category');
        $this->ResetFields();
        $this->Relation = $this->Relation;


    }
    public function Edit($ST_Id)
    {
        $fetch = Status::Where('ST_Id',$ST_Id)->get();
        foreach($fetch as $item)
        {
            $this->ST_Id = $item['ST_Id'];
            $this->Name = $item['Status'];
            $this->Relation = $item['Relation'];
            $this->Old_Thumbnail = $item['Thumbnail'];
            $this->Order = $item['Orderby'];
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
                    $this->New_Thumbnail = 'storage/app/'. $this->Thumbnail->storeAs('Thumbnails/Status/',$this->Name.time().'.jpeg');
                }
                else
                {
                    $this->New_Thumbnail = 'storage/app/'. $this->Thumbnail->storeAs('Thumbnails/Status/',$this->Name.time().'.jpeg');
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
        $fetch = Status::where('ST_Id',$this->ST_Id)->get();
        foreach($fetch as $key)
        {
            $status = $key['Status'];
        }
        $check = Application::Where('Status',$status)->get();
        if(count($check)>0)
        {
            $Update_App = DB::update('update digital_cyber_db set Status = ? where Status = ?', [$this->Name,$status]);

        }
        $Update = DB::update('update status set Status = ?, Relation = ?, Orderby = ?, Thumbnail = ? where ST_Id = ? ', [$this->Name,$this->Relation,$this->Order,$this->New_Thumbnail,$this->ST_Id]);

        if($Update)
        {
            session()->flash('SuccessMsg',$this->Name.' Status is Updated in '.$this->Relation.' Category');
            $this->ResetFields();
            $this->Thumbnail=Null;
            $this->iteration++;
            $this->Update = 0;
        }
    }
    public function Delete($ST_Id)
    {
        $fetch = Status::Where('ST_Id',$ST_Id)->get();
        if(count($fetch)>0)
        {
            foreach($fetch as $item)
            {
                $this->Old_Thumbnail = $item['Thumbnail'];
                $this->Name = $item['Status'];
            }
        }
        $path = str_replace('storage/app/', '', $this->Old_Thumbnail);
        if (Storage::exists($path))
        {
            unlink(storage_path('app/'.$path));
            $delete = Status::Where('ST_Id',$ST_Id)->delete();
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
            $delete = Status::Where('ST_Id',$ST_Id)->delete();
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
        $Existing_st = DB::table('status')->where('Relation',$this->Relation)->paginate(10);
        return view('livewire.status-module',['MainServices'=>$MainServices,'Existing_st'=>$Existing_st]);
    }
}
