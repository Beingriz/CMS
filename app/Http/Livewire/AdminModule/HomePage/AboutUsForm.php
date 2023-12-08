<?php

namespace App\Http\Livewire\AdminModule\HomePage;

use App\Models\About_Us;
use App\Models\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AboutUsForm extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $Tittle,$Description,$Image,$Update,$Count,$Sl=1,$Id,$Old_Image,$New_Image,$Selected,$Delivered,$Iteration=0;
    public $Clients;
    protected $rules = [
        'Tittle' => 'Required|max:30',
        'Description'=>'Required |min:10|max:500',
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
    }

    public function mount($EditData,$SelectId)
    {
        # code...
        $this->Id = 'AU'.time();
        $this->Clients = Application::all()->count();
        $this->Delivered = Application::where('Status','=','Delivered to Client')->get()->count();

        //Edit Id from Controller to Make Edit on Livewire
        if(!empty($EditData)){
            $this->Edit($EditData);
        }
        //Select ID From Controller
        if(!empty($SelectId)){
            $this->Select($SelectId);
        }
    }
    public function ResetFields()
    {
        # code...
        $this->Tittle="";
        $this->Description="";
        $this->Image=NULL;
        $this->Iteration++;
        $this->Update = 0;

    }
    public function Save()
    {
        # code...
        $this->validate();
        $save = new About_Us();
        $save->Id = $this->Id;
        $save->Tittle = $this->Tittle;
        $save->Description = $this->Description;
        $save->Total_Clients = $this->Clients;
        $save->Delivered = $this->Delivered;
        if(!empty($this->Image)){
            $extension = $this->Image->getClientOriginalExtension();
            $path = 'About Us/';
            $filename = 'AboutUs '.$this->Tittle.'_'.time().'.'.$extension;
            $url = $this->Image->storePubliclyAs($path,$filename,'public');
            $this->New_Image = $url;
        }
        $save->Image = $this->New_Image;
        $save->save();
        $this->ResetFields();
        $this->Update=0;
        $notification = array(
            'message' => 'New About Us Added Succesfully!',
            'alert-type'=>'success',
        );
        return redirect()->route('new.about_us')->with($notification);
    }
    public function Edit($Id)
    {
        $fetch = About_Us::find($Id);
        $this->Id = $Id;
        $this->Tittle = $fetch['Tittle'];
        $this->Description = $fetch['Description'];
        $this->Old_Image = $fetch['Image'];
        $this->Update=1;

    }
    public function Image()
    {
        # code...
        # if image is selected, check if database has any image, else update the new image
        # if image is not selected, dont update image. remove validation for image selection


        if(!empty($this->Image)) //if new image is selected
        {
            if(!empty($this->Old_Image)) // check if old image is available in db
            {
                if (Storage::disk('public')->exists($this->Old_Image)) // Check for existing File
                {
                    unlink(storage_path('app/public/'.$this->Old_Image)); // Deleting Existing File

                    $extension = $this->Image->getClientOriginalExtension();
                    $path = 'AboutUS/';
                    $filename = 'AboutUS'.$this->Tittle.'_'.time().'.'.$extension;
                    $url = $this->Image->storePubliclyAs($path,$filename,'public');
                    $this->New_Image = $url;
                    $data = array();
                    $data['Image']=$url;
                    DB::table('about_us')->where([['Id','=',$this->Id]])->update($data); // update db wil empty string
                }
                else // if file not avaialbe then upload new selected image
                {
                    $extension = $this->Image->getClientOriginalExtension();
                    $path = 'AboutUS/';
                    $filename = 'AboutUS'.$this->Tittle.'_'.time().'.'.$extension;
                    $url = $this->Image->storePubliclyAs($path,$filename,'public');
                    $this->New_Image = $url;
                }
            }
            else // if old image is not available id db then upload image
            {
                $extension = $this->Image->getClientOriginalExtension();
                $path = 'AboutUS/';
                $filename = 'AboutUS'.$this->Tittle.'_'.time().'.'.$extension;
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
        if(!empty($this->Old_Image)){
            $this->validate([
                'Tittle' => 'Required|max:30',
                'Description'=>'Required |min:10|max:500',
            ]);
        }
        $data = array();
        $data['Tittle'] = $this->Tittle;
        $data['Description'] = $this->Description;
        $data['Total_Clients'] = $this->Clients;
        $data['Delivered'] = $this->Delivered;
        $this->Image();
        $data['Image']= $this->New_Image;
        DB::table('about_us')->where([['Id','=',$this->Id]])->update($data);
        session()->flash('SuccessMsg','About Us Details Updated Successfully!');
        $this->ResetFields();
        $this->Update=0;
    }
    public function Select($Id)
    {
        $data = array();
        $data['Selected'] = 'No';
        DB::table('about_us')->Update($data);
        $data['Selected'] = 'Yes';
        $Update = DB::table('about_us')->where('Id','=',$Id)->Update($data);
    }
    public function Delete($Id)
    {
        $fetch = About_Us::find($Id);
        $image = $fetch['Image'];
        if (Storage::disk('public')->exists($image)) // Check for existing File
        {
            unlink(storage_path('app/public/'.$image)); // Deleting Existing File
        }
        About_Us::Where('Id','=',$Id)->delete();
        session()->flash('SuccessMsg', 'Record Deleted Successfully!');
    }
    public function render()
    {
        $Records = About_Us::all();
        return view('livewire.admin-module.home-page.about-us-form',compact('Records'));
    }

}
