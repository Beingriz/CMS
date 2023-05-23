<?php

namespace App\Http\Livewire;

use App\Models\Application;
use App\Models\Bookmark;
use App\Models\ClientRegister;
use App\Models\MainServices;
use App\Models\Status;
use Carbon\Carbon;
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
    public $Name, $Thumbnail,$Id,$Old_Thumbnail,$Relation,$Update,$n=1, $iteration, $ChangeRelation, $New_Thumbnail,$Order,$created,$updated,$New_Image;


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
    public function mount($Id,$DelId,$ViewStatus)
    {
        $this->Id = 'ST'.time();
        if(!empty($Id)){
            $this->Edit($Id);
        }
        if(!empty($DelId)){
            $this->Delete($DelId);
        }
        if(!empty($ViewStatus)){
            $this->ViewStatus($ViewStatus);
        }

    }
    public function ResetFields()
    {
        $this->Id = 'ST'.time();
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
        $this->list = false;
        $this->Name = NULL;
        $this->Thumbnail = NULL;
        $this->ChangeRelation = NULL;
        $this->iteration++;
        $this->Order = NULL;
        $this->Old_Thumbnail = NULL;
        $this->Update = 0;
    }
    public function Image()
    {
        # code...
        # if image is selected, check if database has any image, else update the new image
        # if image is not selected, dont update image. remove validation for image selection


        if(!empty($this->Thumbnail)) //if new image is selected
        {
            if(!empty($this->Old_Thumbnail)) // check if old image is available in db
            {
                if (Storage::disk('public')->exists($this->Old_Thumbnail)) // Check for existing File
                {
                    unlink(storage_path('app/public/'.$this->Old_Thumbnail)); // Deleting Existing File

                    $extension = $this->Thumbnail->getClientOriginalExtension();
                    $path = 'Status/Thumbnail';
                    $filename = 'St'.$this->Name.'_'.time().'.'.$extension;
                    $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
                    $this->New_Image = $url;
                    $data = array();
                    $data['Thumbnail']=$url;
                    DB::table('status')->where([['Id','=',$this->Id]])->update($data); // update db wil empty string
                }
                else // if file not avaialbe then upload new selected image
                {
                    $extension = $this->Thumbnail->getClientOriginalExtension();
                    $path = 'Status/Thumbnail';
                    $filename = 'St'.$this->Name.'_'.time().'.'.$extension;
                    $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
                    $this->New_Image = $url;
                }
            }
            else // if old image is not available id db then upload image
            {
                $extension = $this->Thumbnail->getClientOriginalExtension();
                $path = 'Status/Thumbnail';
                $filename = 'St'.$this->Name.'_'.time().'.'.$extension;
                $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
                $this->New_Image = $url;
            }
        }
        else // if no image is selected then leave this field as it is with old image.
        {
            $this->New_Image = $this->Old_Thumbnail;
        }
    }
    public function Save()
    {

        $this->validate();
        if(!empty($this->Thumbnail))
        {
            $extension = $this->Thumbnail->getClientOriginalExtension();
            $path = 'Thumbnails/Status/'.$this->Name;
            $filename = 'ST_'.$this->Name.'_'.time().'.'.$extension;
            $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
            $this->Thumbnail = $url;
        }
        else
        {
            $this->Thumbnail = 'Not Available';
        }
        $save_st = new Status();
        $save_st->Id = $this->Id;
        $save_st->Status = $this->Name;
        $save_st->Relation = $this->Relation;
        $save_st->Orderby = $this->Order;
        $save_st->Thumbnail =  $this->Thumbnail;
        $save_st->save();
        session()->flash('SuccessMsg',$this->Name.'  is saved In '.$this->Relation.' Category');
        $relation = $this->Relation;
        $this->ResetFields();
        $this->Relation = $relation;


    }
    public function Edit($Id)
    {
        $fetch = Status::Where('Id',$Id)->get();
        foreach($fetch as $item)
        {
            $this->Id = $item['Id'];
            $this->Name = $item['Status'];
            $this->Relation = $item['Relation'];
            $this->Old_Thumbnail = $item['Thumbnail'];
            $this->Order = $item['Orderby'];
        }
        $this->Update = 1;
        $this->ChangeRelation=Null;
        $this->iteration++;
    }
    public $list=false,$status;
    public function ViewStatus($status){
        $this->list = true;
        $this->status = $status;
    }
    public function UpdateStatus($Id, $Status)
    {
        $data = array();
        $data['Status'] = trim($Status);
        Application::Where('Id',$Id)->update($data);
        $status = Status::all();
        foreach($status as $item){
            $name = $item['Status'];
            $amount = DB::table('digital_cyber_db')->Where('Status',$name)->SUM('Total_Amount');
            $count = DB::table('digital_cyber_db')->where('Status',$name)->count();
            $data = array();
            $data['Total_Amount'] = $amount;
            $data['Total_Count'] = $count;
            DB::table('status')->where('Status',$name)->update($data);
        }
         $notification = array(
            'message' =>'Status Updated Successfully',
            'alert-type' => 'info'
         );
         return redirect()->back()->with($notification);
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
                    $path = 'Thumbnails/Status/'.$this->Name;
                    $filename = 'St_'.$this->Name.'_'.time().'.'.$extension;
                    $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
                    $this->New_Thumbnail = $url;
                }
                else
                {
                    $extension = $this->Thumbnail->getClientOriginalExtension();
                    $path = 'Thumbnails/Status/'.$this->Name;
                    $filename = 'St_'.$this->Name.'_'.time().'.'.$extension;
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
        $data['Status'] = $this->Name;
        $data['Relation'] = $this->Relation;
        $data['Thumbnail'] = $this->New_Thumbnail;
        $Update = DB::table('status')->where('Id','=',$this->Id)->Update($data);
        if($Update)
        {
            session()->flash('SuccessMsg',$this->Name.' Status is Updated for '.$this->Relation);
            $this->ResetFields();
            $this->Thumbnail=Null;
            $this->iteration++;
            $this->Update = 0;
        }
    }
    public function Delete($Id)
    {
        $fetch = Status::Where('Id',$Id)->get();
        foreach($fetch as $item)
        {
            $this->Old_Thumbnail = $item['Thumbnail'];
            $this->Name = $item['Name'];
            $this->Relation = $item['Relation'];
        }
        if($this->Old_Thumbnail == NULL)
        {
            $delete = Status::Where('Id',$Id)->delete();
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
            $delete = Status::Where('Id',$Id)->delete();
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
                $delete = Status::Where('Id',$Id)->delete();
                session()->flash('Error', 'Unable to Delete Icon / Not Available Bookmark');

            }
        }
        else
        {
            $delete = Status::Where('Id',$Id)->delete();
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
    public function LastUpdate()
    {
        $latest = Bookmark::latest('created_at')->first();
        $this->created = Carbon::parse($latest['created_at'])->diffForHumans();
        $this->updated = Carbon::parse($latest['updated_at'])->diffForHumans();
    }
    public function render()
    {
        $this->LastUpdate();
        $status_list = Status::all();
        $MainServices = MainServices::all();
        $Existing_st = DB::table('status')->where('Relation',$this->Relation)->orderBy('Orderby','asc')->paginate(5);
        $records = Application::where('status',$this->status)->paginate(10);
        return view('livewire.status-module',['MainServices'=>$MainServices,'Existing_st'=>$Existing_st,'status_list' =>$status_list,'records'=>$records]);
    }
}
