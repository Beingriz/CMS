<?php

namespace App\Http\Livewire;

use App\Models\Application;
use App\Models\Bookmark;
use App\Models\MainServices;
use App\Models\SubServices;
use App\Traits\RightInsightTrait;
use Carbon\Carbon;
use COM;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AddServices extends Component
{
    use RightInsightTrait;
    use WithPagination;
    protected $paginationTheme='bootstrap';
    use WithFileUploads;
    public $Service_Id,$Name , $Service_Type,$Services=[],  $Description , $Details, $Specification , $Features,$Service_Fee;
    public $Thumbnail, $Order_By , $paginate,$pos, $filterby,$Update = 0,$lastRecTime;
    public $Category_Type, $Main_ServiceId,$Unit_Price ,$Old_Thumbnail,$New_Thumbnail;
    protected $Existing_Sevices=[];

    protected $rules = [
        'Name' =>'required ',
        'Service_Type' =>'required',
        'Description' =>'required|min:50 |max:400',
        'Thumbnail' =>'image|max:1024',
    ];

    protected $messages = [
       'Name.required' => 'Please Enter the Service Name',
       'Service_Type.required' => 'Please Select Service Type',
       'Description.required' => 'Please Write Service Description ',
       'Thumbnail.required' =>'Please Select Thumbnail',

   ];
   public function updated($propertyName)
   {
       $this->validateOnly($propertyName);
   }

   public function mount($EditData,$DeleteData,$Type)
   {
        $length = mt_rand(2,3);
        $Char = strtoupper(substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, $length));
        $this->Service_Id = 'DC'.mt_rand(1,99).$Char;
        if(!empty($EditData)){
            $this->Edit($EditData,$Type);
            $this->Category_Type = $Type;
        }
        if(!empty($DeleteData)){
            $this->Delete($DeleteData,$Type);
            $this->Category_Type = $Type;
        }

   }

   public function ResetFields()
   {

        $this->Update = 0;
        $this->Name = '';
        $this->Service_Type = '';
        $this->Description = '';
        $this->Details = '';
        $this->Features = '';
        $this->Specification = '';
        $this->Unit_Price = '';
        $this->Order_By = '';
        $this->Thumbnail = NULL;
        $this->Old_Thumbnail = NULL;
        $length = mt_rand(2,3);
        $Char = strtoupper(substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, $length));
        $this->Service_Id = 'DC'.mt_rand(1,99).$Char;
   }
   public function ImageUpload(){

    if(!empty($this->Thumbnail)) // Check if new image is selected
    {
        if(!empty($this->Old_Thumbnail))
        {
            if(Storage::disk('public')->exists($this->Old_Thumbnail))
            {
                unlink(storage_path('app/public/'.$this->Old_Thumbnail));
                $extension = $this->Thumbnail->getClientOriginalExtension();
                $path = 'Services/Thumbnail'.time();
                $filename = 'MS_'.$this->Name.'_'.time().'.'.$extension;
                $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
                $this->New_Thumbnail = $url;
            }
            else
            {
                $extension = $this->Thumbnail->getClientOriginalExtension();
                $path = 'Services/Thumbnail'.time();
                $filename = 'MS_'.$this->Name.'_'.time().'.'.$extension;
                $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
                $this->New_Thumbnail = $url;
            }
        }
        else
        {
            $this->validate([
                'Thumbnail'=>'required|image',
            ]);
            $extension = $this->Thumbnail->getClientOriginalExtension();
            $path = 'Services/Thumbnail'.time();
            $filename = 'MS_'.$this->Name.'_'.time().'.'.$extension;
            $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
            $this->New_Thumbnail = $url;
        }
    }
    else // check old is exist
    {
        if(!empty($this->Old_Thumbnail))
        {
            if(Storage::disk('public')->exists($this->Old_Thumbnail))
            {
                $this->New_Thumbnail = $this->Old_Thumbnail;
            }
        }
        else
        {
            $this->validate([
                'Thumbnail'=>'required|image',
            ]);
            $extension = $this->Thumbnail->getClientOriginalExtension();
            $path = 'Services/Thumbnail'.time();
            $filename = 'MS_'.$this->Name.'_'.time().'.'.$extension;
            $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
            $this->New_Thumbnail = $url;
        }
    }
    }
    public function deleteImage($Id, $type){
        if($type == 'Main'){
            $fetch = MainServices::Where('Id',$Id)->first();
            $file = $fetch->Thumbnail;
            if(!empty($file)){
                if(Storage::disk('public')->exists($file))
                {
                    unlink(storage_path('app/public/'.$file));
                }
            }
        }elseif($type == 'Sub'){
            $fetch = SubServices::Where('Id',$Id)->first();
            $file = $fetch->Thumbnail;
            if(!empty($file)){
                if(Storage::disk('public')->exists($file))
                {
                    unlink(storage_path('app/public/'.$file));
                }
            }
        }
    }
   public function Save()
   {
        $exist = MainServices::Wherekey($this->Service_Id)->get();
        foreach($exist as $item)
        {
            $application = $item['Application'];
        }
        if(sizeof($exist)>0) // if Exist then Update
        {
            $this->validate(['Name'=>'required','Description'=>'required|min:50 |max:400','Service_Type'=>'required']);

            $this->ImageUpload();
            $data = array();
            $data['Name'] = trim($this->Name);
            $data['Service_Type'] = trim($this->Service_Type);
            $data['Description'] = trim($this->Description);
            $data['Details'] = trim($this->Details);
            $data['Features'] = trim($this->Features);
            $data['Specification'] = trim($this->Specification);
            $data['Order_By'] = trim($this->Order_By);
            $data['Thumbnail'] = $this->New_Thumbnail;
            $data_app = array();
            $data_app['Application'] = trim($this->Name);
            $app = Application::where('Application',$application)->Update($data_app);
            $ser = DB::table('service_list')->where('Id',$this->Service_Id)->Update($data);


            if($ser && $app )
            {
                session()->flash('SuccessMsg', trim($this->Name).' Service & Applictions Updated!');
                $this->Category_Type='Main';
                $this->ResetFields();
            }
            elseif($ser)
            {
                session()->flash('SuccessMsg', trim($this->Name).' Service Database Updated!');
                $this->Category_Type='Main';
                $this->ResetFields();
            }
            elseif($app)
            {
                session()->flash('SuccessMsg', trim($this->Name).' Application Database Updated!');
                $this->Category_Type='Main';
                $this->ResetFields();
            }
            else
            {
                session()->flash('Error', trim($this->Name).' No Changes Found. ');
                $this->Category_Type='Main';
                $this->ResetFields();

            }
        }
        else // Create New
        {
            $this->validate(['Name'=>'required |unique:service_list,Name']);
            if(!empty($this->Thumbnail)){
                $extension = $this->Thumbnail->getClientOriginalExtension();
                $path = 'Services/Thumbnail'.time();
                $filename = 'MS_'.$this->Name.'_'.time().'.'.$extension;
                $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
                $this->New_Thumbnail = $url;
            }else{
                $this->validate([
                    'Thumbnail'=>'required|image',
                ]);
            }
            $save_service = new MainServices();
            $save_service->Id = $this->Service_Id;
            $save_service->Name = trim($this->Name);
            $save_service->Service_Type = trim($this->Service_Type);
            $save_service->Description = trim($this->Description);
            $save_service->Details = trim($this->Details);
            $save_service->Features = trim($this->Features);
            $save_service->Specification = trim($this->Specification);
            $save_service->Order_By = $this->Order_By;
            $save_service->Thumbnail = $this->New_Thumbnail;
            $save_service->save();
            session()->flash('SuccessMsg','New  Service "'.$this->Name.'"  Added Successfully!.');
            $this->ResetFields();
        }
   }
    public function Edit($Id,$Type)
    {
        if($Type == 'Main')
        {
            $this->Update = 1;
            $fetch = MainServices::Wherekey($Id)->get();
            foreach($fetch as $service)
            {
                 $this->Service_Id = $service['Id'];
                 $this->Name = $service['Name'];
                 $this->Description = $service['Description'];
                 $this->Details = $service['Details'];
                 $this->Features = $service['Features'];
                 $this->Specification = $service['Specification'];
                 $this->Order_By = $service['Order_By'];
                 $this->Service_Type = $service['Service_Type'];
                 $this->Old_Thumbnail = $service['Thumbnail'];
            }
        }
        elseif($Type == 'Sub')
        {
            $this->Update = 1;
            $fetch = SubServices::Wherekey($Id)->get();
            foreach($fetch as $service)
            {
                // $serName = MainServices::where('Id',$service['Service_Id'])->first();
                $this->Main_ServiceId = $service['Service_Id'];
                 $this->Service_Id = $service['Id'];
                 $this->Name = $service['Name'];
                 $this->Description = $service['Description'];
                 $this->Service_Type = $service['Service_Type'];
                 $this->Unit_Price = $service['Unit_Price'];
                 $this->Service_Fee = $service['Service_Fee'];
                 $this->Old_Thumbnail = $service['Thumbnail'];
            }
        }
    }

    public function SaveSubService()
    {

        $this->validate([
            'Name'=>'required',
            'Unit_Price'=>'required |numeric','Service_Fee'=>'required |numeric']);
        $exist = SubServices::Wherekey($this->Service_Id)->get();
        foreach($exist as $item)
        {
            $application_type  = $item['Name'];
        }
        if(sizeof($exist)>0)
        {
            if($this->Thumbnail == NULL OR empty($this->Thumbnail))
            {
                if(storage::disk('public')->exists($this->Old_Thumbnail))
                {
                    $this->New_Thumbnail = $this->Old_Thumbnail;
                }
                elseif($this->Old_Thumbnail == 'Not Available')
                {
                    $this->validate(['Thumbnail'=>'required']);
                }
                else
                {
                    $this->validate(['Thumbnail'=>'required']);
                }

            }
            else
            {

                $extension = $this->Thumbnail->getClientOriginalExtension();
                $path = 'Thumbnails/Services/'.$this->Name;
                $filename = 'SS_'.$this->Name.'_'.time().'.'.$extension;
                $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
                $this->New_Thumbnail = $url;
            }

            $data = array();
            $data['Name'] = trim($this->Name);
            $data['Service_Type'] = trim($this->Service_Type);
            $data['Description'] = trim($this->Description);
            $data['Unit_Price'] =trim($this->Unit_Price);
            $data['Service_Fee'] =trim($this->Service_Fee);
            $data['Thumbnail'] = $this->New_Thumbnail;
            $app_data = array();
            $app_data['Application_Type'] = trim($this->Name);
            $ser = DB::table('sub_service_list')->where('Id','=',$this->Service_Id)->Update($data);
            $app = DB::table('digital_cyber_db')->where('Application_Type','=',$application_type)->Update($app_data);
            if($ser && $app )
            {
                session()->flash('SuccessMsg', trim($this->Name).' Service Details Updated!');
                $this->Category_Type='Sub';
                $this->ResetFields();
            }
            elseif($ser)
            {
                session()->flash('SuccessMsg', trim($this->Name).' Service Database Updated!');
                $this->Category_Type='Sub';
                $this->ResetFields();
            }
            elseif($app)
            {
                session()->flash('SuccessMsg', trim($this->Name).' Application Database Updated!');
                $this->Category_Type='Sub';
                $this->ResetFields();
            }
            else
            {
                session()->flash('Error', trim($this->Name).' Service Details Unable to Updated!');
                $this->Category_Type='Sub';
                $this->ResetFields();

            }

        }
        else
        {
            $this->validate([
                'Name'=>'required|unique:sub_service_list',
                'Unit_Price'=>'required |numeric','Service_Fee'=>'required |numeric',
                 'Thumbnail'=>'required'   ]);

            $extension = $this->Thumbnail->getClientOriginalExtension();
            $path = 'Thumbnails/Services/'.$this->Name;
            $filename = 'SS_'.$this->Name.'_'.time().'.'.$extension;
            $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
            $this->Thumbnail = $url;

            $save_service = new SubServices();
            $save_service->Service_Id = $this->Main_ServiceId;
            $save_service->Id = $this->Service_Id;
            $save_service->Name = trim($this->Name);
            $save_service->Service_Type = $this->Service_Type;
            $save_service->Description = trim($this->Description);
            $save_service->Unit_Price = trim($this->Unit_Price);
            $save_service->Service_Fee = trim($this->Service_Fee);
            $save_service->Thumbnail = $this->Thumbnail;
            $save_service->save();
            session()->flash('SuccessMsg','New  Sub Service  "'.$this->Name.'"  Added Successfully!.');
            $this->ResetFields();
        }
    }

    public function Delete($Id,$type)
    {
        $subSerDelCount = 0;
        if($type == 'Main')
        {
            $fetch = MainServices::Wherekey($Id)->first();
            $name = $fetch->Name;
            $this->Old_Thumbnail = $fetch->Thumbnail;
            $find = Application::where('Application',$name)->count();
            if($find>0) // Application is Served. Cannot Delete this Service. Use Edit Function to Modify.
            {
                $notification = array(
                    'message'=>'Sorry Unable to Delete '.$name.'Service. '.$find. ' Applications Served',
                    'alert-type'=>'error'
                );
                return redirect()->back()->with($notification);
            }
            else // No Application is Servered for this Service so Delete All its Sub Services & Delete Main Service
            {
                // Deleting Sub services
                $fetch_ser = SubServices::Where('Service_Id',$Id)->get();
                if(count($fetch_ser)>0)
                {
                    foreach($fetch_ser as $item)
                    {
                        $Thumbnail = $item['Thumbnail'];
                        $name = $item['name'];
                        if(!empty($Thumbnail)){
                            if (Storage::disk('public')->exists($Thumbnail)){
                                unlink(public_path('storage/'.$Thumbnail));
                                $delete_sub = SubServices::Where('Service_Id',$Id)->Delete();
                                if($delete_sub){
                                    $subSerDelCount++;
                                }
                            }else{
                                $delete_sub = SubServices::Where('Service_Id',$Id)->Delete();
                                if($delete_sub)
                                {
                                    $subSerDelCount++;
                                }
                            }
                        }elseif($Thumbnail=='Not Available' ||$Thumbnail==NULL ){
                            $delete_sub = SubServices::Where('Service_Id',$Id)->Delete();
                            if($delete_sub){
                                session()->flash('SuccessMsg', );
                                $notification = array(
                                    'message'=> $subSerDelCount.' Sub Services of '.$name. ' Deleted Successfully!',
                                    'alert-type'=>'success'
                                );
                                return redirect()->back()->with($notification);
                            }else{
                                $notification = array(
                                    'message'=>'Unable to Sub Service',
                                    'alert-type'=>'error'
                                );
                                return redirect()->back()->with($notification);
                            }
                        }
                    }
                }

                // Deleting Main Service
                if(!empty($this->Old_Thumbnail)){
                    if (Storage::disk('public')->exists($this->Old_Thumbnail)){
                        unlink(public_path('storage/'.$this->Old_Thumbnail));
                        $delete_main = MainServices::Wherekey($Id)->Delete();
                        if($delete_main){
                            $notification = array(
                                'message'=> $name.' Service &  all Sub Services Deleted Successfully!',
                                'alert-type'=>'success'
                            );
                            return redirect()->route('add_services')->with($notification);

                        }else{
                            $notification = array(
                                'message'=>'Unable to Sub Service',
                                'alert-type'=>'error'
                            );
                            return redirect()->back()->with($notification);
                        }
                    }else{
                        $delete_main = MainServices::Wherekey($Id)->Delete();
                        if($delete_main){
                            $notification = array(
                                'message'=> $name.' Service &  all Sub Services Deleted Successfully!',
                                'alert-type'=>'success'
                            );
                            return redirect()->route('add_services')->with($notification);
                        }
                    }
                }
            }
        }
        elseif($type == 'Sub')
        {
            $service_id = $this->Service_Id;
            $fetch = SubServices::Wherekey($Id)->get();
            foreach($fetch as $item)
            {
                $name = $item['Name'];
                $this->Old_Thumbnail = $item['Thumbnail'];
            }
            $find = Application::where('Application_Type',$name)->count();
            if($find>0){
                $notification = array(
                    'message'=>'Sorry Unable to Delete '.$name.'Service. '.$find. ' Applications Served',
                    'alert-type'=>'error'
                );
                return redirect()->back()->with($notification);
            }else{
                if($this->Old_Thumbnail !='Not Available' || $this->Old_Thumbnail != NULL){
                    if (Storage::disk('public')->exists($this->Old_Thumbnail)){
                        unlink(public_path('storage/'.$this->Old_Thumbnail));
                        $delete_sub = SubServices::Wherekey($Id)->Delete();
                        if($delete_sub){
                            session()->flash('SuccessMsg',$name.'  Services Deleted Successfully!');
                            $notification = array(
                                'message'=>$name.'  Services Deleted Successfully!',
                                'alert-type'=>'success'
                            );
                            return redirect()->back()->with($notification);
                            $this->ResetFields();
                            $this->Category_Type='Sub';
                            $this->Service_Id=$service_id;
                        }else{
                            $notification = array(
                                'message'=>'Unable to Sub Service',
                                'alert-type'=>'error'
                            );
                            return redirect()->back()->with($notification);
                        }
                    }else{
                        $delete_sub = SubServices::Wherekey($Id)->Delete();
                        if($delete_sub){
                            $notification = array(
                                'message'=>$name.'  Services Deleted Successfully!',
                                'alert-type'=>'success'
                            );
                            return redirect()->back()->with($notification);
                            $this->ResetFields();
                            $this->Category_Type='Sub';
                            $this->Service_Id=$service_id;
                        }
                    }
                }
            }
        }
    }
    public function LastUpdate()
    {
        # code...
        if($this->Category_Type == 'Main'){
            $latest_app = MainServices::latest('created_at')->first();
            $this->lastRecTime =  Carbon::parse($latest_app['created_at'])->diffForHumans();

        }elseif($this->Category_Type == 'Sub'){
            $latest_app = SubServices::latest('created_at')->first();
            $this->lastRecTime =  Carbon::parse($latest_app['created_at'])->diffForHumans();

        }

    }
    public function render()
    {
        $this->LastUpdate();

        if($this->Category_Type == 'Main')
        {

            $this->Existing_Sevices = DB::table('service_list')->paginate(10);

        }
        elseif($this->Category_Type == 'Sub')
        {

            $this->Existing_Sevices = SubServices::Where('Service_Id',$this->Main_ServiceId)->Paginate(10);
        }
        return view('livewire.add-services',['MainServices'=>$this->MainServices,'n'=>$this->n,'Existing_Sevices'=>$this->Existing_Sevices]);
    }
}
