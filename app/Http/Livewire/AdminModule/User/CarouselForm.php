<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\Carousel_DB;
use App\Models\MainServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CarouselForm extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $Tittle,$Description,$Button1_Name,$Button1_Link,$Button2_Link,$Image,$Update,$Count,$Sl=1,$Id,$Old_Image,$New_Image,$Services,$Service_Id,$Clearr;

    protected $rules = [
        'Tittle' => 'Required',
        'Description'=>'Required |min:10|max:110',
        'Image'=> 'required|file|mimes:jpeg,png|max:2048',
    ];
    protected $messages = [
        'Tittle' => 'Please Enter Catchy Tittle',
        'Description'=>'Description should be less than 50 characters',
        'Image'=>'Image  Cannot be empty',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    } //End Function

    public function mount($EditData)
    {
        # code...
        $this->Id = 'SB'.time();
        $this->Count = Carousel_DB::all()->count();
        if(!empty($EditData)){
            $this->Edit($EditData);
        }

    }//End Function


    public function ResetFields()
    {
        # code...
        $this->Id = 'SB'.time();
        $this->Tittle="";
        $this->Description="";
        $this->Image=null;
        $this->Update = 0;
        $this->Clearr++;
    }//End Function

    public function Save()
    {
        # code...
        $this->validate();
        $save = new Carousel_DB();
        $save->Id = $this->Id;
        $save->Tittle = $this->Tittle;
        $save->Description = $this->Description;
        $save->Service_Id = $this->Service_Id;
        if(!empty($this->Image)){
            $extension = $this->Image->getClientOriginalExtension();
            $path = 'Carousel/';
            $filename = 'Carousel'.$this->Tittle.'_'.time().'.'.$extension;
            $url = $this->Image->storePubliclyAs($path,$filename,'public');
            $this->New_Image = $url;
        }
        $save->Image = $this->New_Image;
        $save->save();
        $this->ResetFields();
        $this->Update=0;
        $notification = array(
            'message'=>'Carousel Added Succesfully!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
    }//End Function

    public function Edit($Id)
    {
        $fetch = Carousel_DB::find($Id);
        $this->Id = $Id;
        $this->Tittle = $fetch['Tittle'];
        $this->Service_Id = $fetch['Service_Id'];
        $this->Description = $fetch['Description'];
        $this->Old_Image = $fetch['Image'];
        $this->Update=1;
    }//End Function


    public function Image()
    {
        # if image is selected, check if database has any image, else update the new image
        # if image is not selected, dont update image. remove validation for image selection
        if(!empty($this->Image)) //if new image is selected
        {
            if(!empty($this->Old_Image)) // check if old image is available in db
            {
                if (Storage::disk('public')->exists($this->Old_Image)) // Check for existing File
                {
                    unlink(storage_path('app/public/'.$this->Old_Image)); // Deleting Existing File
                    $url="";
                    $data = array();
                    $data['Image']=$url;
                    DB::table('carousel')->where([['Id','=',$this->Id]])->update($data); // update db wil empty string
                }
                else // if file not avaialbe then upload new selected image
                {
                    $extension = $this->Image->getClientOriginalExtension();
                    $path = 'Carousel/';
                    $filename = 'Carousel'.$this->Tittle.'_'.time().'.'.$extension;
                    $url = $this->Image->storePubliclyAs($path,$filename,'public');
                    $this->New_Image = $url;
                }
            }
            else // if old image is not available id db then upload image
            {
                $extension = $this->Image->getClientOriginalExtension();
                $path = 'Carousel/';
                $filename = 'Carousel'.$this->Tittle.'_'.time().'.'.$extension;
                $url = $this->Image->storePubliclyAs($path,$filename,'public');
                $this->New_Image = $url;
            }
        }
        else // if no image is selected then leave this field as it is with old image.
        {
            $this->New_Image = $this->Old_Image;
        }
    }
    public function Update()
    {
        $this->validate([
            'Tittle' => 'Required',
        'Description'=>'Required |min:10|max:110',
        ]);
        $data = array();
        $data['Tittle'] = $this->Tittle;
        $data['Description'] = $this->Description;
        $data['Service_Id'] = $this->Service_Id;
        $this->Image();
        $data['Image']= $this->New_Image;
        DB::table('carousel')->where([['Id','=',$this->Id]])->update($data);
        $this->ResetFields();
        $this->Update=0;
        $notification = array(
            'message'=>'Data Updated Successfully!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
    }


    public function render()
    {

        if(!empty($this->Tittle)){
            $getId= MainServices::where('Name',$this->Tittle)->get();
            foreach($getId as $key){
                $this->Service_Id = $key['Id'];
            }
        }
        $Records = Carousel_DB::all();
        $this->Services = MainServices::where('Service_Type','Public')->get();
        return view('livewire.admin.user.carousel-form',compact('Records'));
    }

}
