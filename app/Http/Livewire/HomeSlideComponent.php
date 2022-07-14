<?php

namespace App\Http\Livewire;

use App\Models\HomeSlide;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Ramsey\Uuid\Type\Hexadecimal;
use Intervention\Image\Facades\Image;

class HomeSlideComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $title, $slide_image, $video_url, $short_desc,$old_slide_image;

    protected $rules =[
        'title'=>'required',
        'short_desc'=>'required',
        'video_url'=>'required',
        'slide_image'=>'required'
    ];
    protected $messages = [
        'title.required'=>'Please Enter the Banner Tittle',
        'short_desc.required'=>'Please Type Short Description of Banner',
        'video_url.required'=>'Please Enter Video URL',
        'slide_image.required'=>'Banner Image Can not be blank'
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function Fetch($id)
    {
        $data = HomeSlide::find($id);
        $this->title = $data->title;
        $this->short_desc = $data->short_desc;
        $this->video_url = $data->video_url;
        $this->old_slide_image = $data->slide_image;
    }
    public function ResetFields()
    {
        $this->title = NULL;
        $this->short_desc = NULL;
        $this->video_url =NULL;
        $this->old_slide_image = NULL;
        $this->slide_image = NULL;
    }
    public function UpdateSlide($id)
    {
        $image = $this->StoreImage();
        if(!is_Null($image))
        {
            $data = array();
            $data['title'] = $this->title;
            $data['short_desc'] = $this->short_desc;
            $data['video_url'] = $this->video_url;
            $data['slide_image'] =$image;

            $udpate = DB::table('home_slides')->where('id',$id)->update($data);
            $this->ResetFields();
            $notification = array(
                    'message'=>'Banner Slide Updated Successfully!',
                    'alert-type' =>'success'
                    );
            return redirect()->route('home_slide')->with($notification);
        }
        else
        {

            $this->validate(['title'=>'required', 'short_desc'=>'required',
            'video_url'=>'required']);

            $data = array();
            $data['title'] = $this->title;
            $data['short_desc'] = $this->short_desc;
            $data['video_url'] = $this->video_url;
            $udpate = DB::table('home_slides')->where('id',$id)->update($data);
            $this->ResetFields();
            $notification = array(
            'message'=>'Banner Details Updated Successfully!',
            'alert-type' =>'success'
            );
            return redirect()->route('home_slide')->with($notification);
        }
    }

    public function StoreImage()
    {
        if(!$this->slide_image)
        {
            return null;
        }
        else
        {
            $name = date('Ymd').'_'.$this->slide_image->getClientOriginalName();
            $name = 'Uploads/Home_Slide/'. $name;
            $image = Image::make($this->slide_image)->resize(632,825)->encode('jpg');
            Storage::disk('public')->delete($this->old_slide_image);
            Storage::disk('public')->put($name,$image);
            return $name;
        }
    }
    public function getImagePathAttribute()
    {
        return storage::disck('public')->url($this->slide_image);
    }
    public function render()
    {
        $id = Auth::user()->id;
        $profiledata = User::find($id);
        $home_slide = HomeSlide::where('id',1)->get();
        return view('livewire.home-slide-component',compact('profiledata','home_slide'));
    }
}
