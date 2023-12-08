<?php

namespace App\Http\Livewire\AdminModule\Operations;

use App\Models\Bookmark;
use App\Models\MainServices;
use Carbon\Carbon;
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
    public $Name, $Thumbnail,$Bm_Id,$Old_Thumbnail,$Relation,$Update,$n=1,$Hyperlink, $iteration, $ChangeRelation, $New_Thumbnail, $created,$updated;


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
    public function mount($EditId,$DeleteId)
    {
        $this->Bm_Id = 'BM'.time();
        if(!empty($EditId)){
            $this->Edit($EditId);
        }
        if(!empty($DeleteId)){
            $this->Delete($DeleteId);
        }
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
        if(!empty($this->Thumbnail))
        {
            $extension = $this->Thumbnail->getClientOriginalExtension();
            $path = 'Thumbnails/Bookmarks/'.$this->Name;
            $filename = 'BM_'.$this->Name.'_'.time().'.'.$extension;
            $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
            $this->Thumbnail = $url;
        }
        else
        {
            $this->Thumbnail = 'Not Available';
        }

        $save_bm = new Bookmark();
        $save_bm->BM_ID = $this->Bm_Id;
        $save_bm->Name = $this->Name;
        $save_bm->Relation = $this->Relation;
        $save_bm->Hyperlink = $this->Hyperlink;
        $save_bm->Thumbnail = $this->Thumbnail;
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
        if(!is_Null($this->Thumbnail)) // Check if new image is selected
        {
            if(!is_Null($this->Old_Thumbnail))
            {
                if(Storage::disk('public')->exists($this->Old_Thumbnail))
                {
                    unlink(storage_path('app/public/'.$this->Old_Thumbnail));
                    $extension = $this->Thumbnail->getClientOriginalExtension();
                    $path = 'Thumbnails/Bookmarks/'.$this->Name;
                    $filename = 'BM_'.$this->Name.'_'.time().'.'.$extension;
                    $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
                    $this->New_Thumbnail = $url;
                }
                else
                {
                    $extension = $this->Thumbnail->getClientOriginalExtension();
                    $path = 'Thumbnails/Bookmarks/'.$this->Name;
                    $filename = 'BM_'.$this->Name.'_'.time().'.'.$extension;
                    $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
                    $this->New_Thumbnail = $url;
                }
            }
            else
            {
                $this->validate([
                    'Thumbnail'=>'required|image',
                ]);
            }
        }
        else // check old is exist
        {
            if(!is_Null($this->Old_Thumbnail))
            {
                if(Storage::disk('public')->exists($this->Old_Thumbnail))
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
        if(!empty($this->ChangeRelation))
        {
            $this->Relation = $this->ChangeRelation;
        }
        $data = array();
        $data['Name'] = $this->Name;
        $data['Relation'] = $this->Relation;
        $data['Hyperlink'] = $this->Hyperlink;
        $data['Thumbnail'] = $this->New_Thumbnail;
        $Update = DB::table('bookmark')->where('BM_Id','=',$this->Bm_Id)->Update($data);
        if($Update)
        {
            session()->flash('SuccessMsg',$this->Name.' Bookmark is Updated for '.$this->Relation);
            $this->ResetFields();
            $this->Thumbnail=Null;
            $this->iteration++;
            $this->Update = 0;
        }
    }
    public function LastUpdate()
    {
        $latest = Bookmark::latest('created_at')->first();
        $this->created = Carbon::parse($latest['created_at'])->diffForHumans();
        $this->updated = Carbon::parse($latest['updated_at'])->diffForHumans();
    }
    public function Delete($bm_Id)
    {
        $fetch = Bookmark::Where('BM_Id',$bm_Id)->get();
        foreach($fetch as $item)
        {
            $this->Old_Thumbnail = $item['Thumbnail'];
            $this->Name = $item['Name'];
            $this->Relation = $item['Relation'];
        }
        if($this->Old_Thumbnail == NULL)
        {
            $delete = Bookmark::Where('BM_Id',$bm_Id)->delete();
            if($delete)
            {
                session()->flash('SuccessMsg',$this->Name.'  is Deleted From'. $this->Relation);
                $this->Relation =$this->Relation;
            }
            else
            {
                session()->flash('Error', 'Unable to Delete Bookmark');
                $this->Relation = $this->Relation;
            }
        }
        elseif(Storage::disk('public')->exists($this->Old_Thumbnail))
        {
            unlink(storage_path('app/public/'.$this->Old_Thumbnail));
            $delete = Bookmark::Where('BM_Id',$bm_Id)->delete();
            if($delete)
            {
                // session()->flash('SuccessMsg',$this->Name.' is Deleted from '.$this->Relation);
                $this->Relation = $this->Relation;
                $notification = array(
                    'message'=> $this->Name.' is Deleted from '.$this->Relation,
                    'alert-type'=>'info'
                );
                return redirect()->back()->with($notification);
            }
            else
            {
                $delete = Bookmark::Where('BM_Id',$bm_Id)->delete();
                session()->flash('Error', 'Unable to Delete Icon / Not Available Bookmark');

            }
        }
        else
        {
            $delete = Bookmark::Where('BM_Id',$bm_Id)->delete();
            if($delete)
            {

                $this->Relation = $this->Relation;
                $notification = array(
                    'message'=> $this->Name.' is Deleted from '.$this->Relation,
                    'alert-type'=>'info'
                );
                return redirect()->back()->with($notification);
            }
            else
            {
                $this->Relation = $this->Relation;
                session()->flash('Error', 'Unable to Delete Bookmark');

            }
        }

    }
    public function render()
    {
        $this->LastUpdate();
        $MainServices = MainServices::all();
        $Existing_Bm = DB::table('bookmark')->where('Relation',$this->Relation)->paginate(5);
        return view('livewire.admin-module.operations.bookmarks',['MainServices'=>$MainServices,'Existing_Bm'=>$Existing_Bm]);
    }
}
