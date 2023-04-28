<?php

namespace App\Http\Livewire;

use App\Models\Carousel_DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Carousel extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $Tittle,$Description,$Button1_Name,$Button1_Link,$Button2_Link,$Image,$Update,$Count,$Sl=1,$Id,$Old_Image,$New_Image;

    protected $rules = [
        'Tittle' => 'Required|min:10|max:30',
        'Description'=>'Required |min:10|max:50',
        'Button1_Name'=>'Required|min:5|max:10',
        'Button1_Link'=>'Required',
        'Button2_Link'=>'Required',
        'Image'=> 'required|file|mimes:jpeg,png|max:2048',
    ];
    protected $messages = [
        'Tittle' => 'Please Enter Catchy Tittle',
        'Description'=>'Description should be less than 50 characters',
        'Button1_Name'=>'Buttone Name Cannot be blank',
        'Button1_Link'=>'Buttone Link Cannot be blank',
        'Button2_Link'=>'Buttone Link Cannot be blank',
        'Image'=>'Image  Cannot be empty',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        # code...
        $this->Id = 'SB'.time();
        $this->Count = Carousel_DB::all()->count();
    }
    public function ResetFields()
    {
        # code...
        $this->Tittle="";
        $this->Description="";
        $this->Button1_Name="";
        $this->Button1_Link="";
        $this->Button2_Link="";
        $this->Image=NULL;
        $this->Update = 0;

    }
    public function Save()
    {
        # code...
        $this->validate();
        $save = new Carousel_DB();
        $save->Id = $this->Id;
        $save->Tittle = $this->Tittle;
        $save->Description = $this->Description;
        $save->Button1_Name = $this->Button1_Name;
        $save->Button1_Link = $this->Button1_Link;
        $save->Button2_Link = $this->Button2_Link;
        if(!empty($this->Image)){
            $extension = $this->Image->getClientOriginalExtension();
            $path = 'Carousel/';
            $filename = 'Carousel'.$this->Tittle.'_'.time().'.'.$extension;
            $url = $this->Image->storePubliclyAs($path,$filename,'public');
            $this->New_Image = $url;
        }
        $save->Image = $this->New_Image;
        $save->save();
        session()->flash('SuccessMsg', 'New Carousel Added Successfully!');
        $this->ResetFields();
        $this->Update=0;
    }
    public function Edit($Id)
    {
        $fetch = Carousel_DB::find($Id);
        $this->Id = $Id;
        $this->Tittle = $fetch['Tittle'];
        $this->Description = $fetch['Description'];
        $this->Button1_Name = $fetch['Button1_Name'];
        $this->Button1_Link = $fetch['Button1_Link'];
        $this->Button2_Link = $fetch['Button2_Link'];
        $this->Old_Image = $fetch['Image'];
        $this->Update=1;

    }
    public function Image()
    {
        # code...
        if(!empty($this->Image))
        {
            if($this->Old_Image != 'Not Available' )
            {
                if (Storage::disk('public')->exists($this->Old_Image)) // Check for existing File
                {
                    unlink(storage_path('app/public/'.$this->Old_Image)); // Deleting Existing File
                    $url='Not Available';
                    $data = array();

                    $data['Image']=$url;
                    DB::table('carousel')->where([['Id','=',$this->Id]])->update($data);
                }
                else
                {
                    $this->New_Image = 'Not Available';
                }
            }
            else
            {
                $extension = $this->Image->getClientOriginalExtension();
                $path = 'Carousel/';
                $filename = 'Carousel'.time().'.'.$extension;
                $url = $this->Image->storePubliclyAs($path,$filename,'public');
                $this->New_Image = $url;
            }
        }
        else
        {
            $this->New_Image = $this->Old_Image;
        }
    }
    public function Update()
    {
        if(!empty($this->Old_Image)){
            $this->validate([
                'Tittle' => 'Required|min:10|max:30',
                'Description'=>'Required |min:10|max:50',
                'Button1_Name'=>'Required|min:5|max:10',
                'Button1_Link'=>'Required',
                'Button2_Link'=>'Required',
            ]);
        }
        $data = array();
        $data['Tittle'] = $this->Tittle;
        $data['Description'] = $this->Description;
        $data['Button1_Name'] = $this->Button1_Name;
        $data['Button2_Link'] = $this->Button2_Link;
        $data['Button1_Link'] = $this->Button1_Link;
        $this->Image();
        $data['Image']= $this->New_Image;
        DB::table('carousel')->where([['Id','=',$this->Id]])->update($data);
        session()->flash('SuccessMsg','Carousel Details Updated Successfully!');
        $this->ResetFields();
        $this->Update=0;
    }

    public function render()
    {
        $Records = Carousel_DB::all();
        return view('livewire.carousel',compact('Records'));
    }
}
