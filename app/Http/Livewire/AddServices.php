<?php

namespace App\Http\Livewire;

use App\Models\Application;
use App\Models\Bookmark;
use App\Models\MainServices;
use App\Models\SubServices;
use App\Traits\RightInsightTrait;
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
    public $Thumbnail, $Order_By , $paginate,$pos, $filterby,$Update = 0;
    public $Category_Type, $Main_ServiceId,$Unit_Price ,$Old_Thumbnail;
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

   public function mount()
   {
        $length = mt_rand(2,3);
        $Char = strtoupper(substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, $length));
        $this->Service_Id = 'DC'.mt_rand(1,99).$Char;


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
   public function Save()
   {

        $exist = MainServices::Wherekey($this->Service_Id)->get();
        foreach($exist as $item)
        {
            $application = $item['Application'];
        }
        if(sizeof($exist)>0)
        {
            $this->validate(['Name'=>'required','Description'=>'required','Service_Type'=>'required']);

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
                $filename = 'MS_'.$this->Name.'_'.time().'.'.$extension;
                $url = $this->Thumbnail->storePubliclyAs($path,$filename,'public');
                $this->New_Thumbnail = $url;
            }
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
            $ser = DB::table('service_list')->where('Id','=',$this->Service_Id)->Update($data);
            $app = DB::table('digital_cyber_db')->where('Application','=',$application)->Update($data_app);

            if($ser && $app )
            {
                session()->flash('SuccessMsg', trim($this->Name).' Service Details Updated!');
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
                session()->flash('Error', trim($this->Name).' Service Details Unable to Updated!');
                $this->Category_Type='Main';
                $this->ResetFields();

            }

        }
        else
        {
            $this->validate();
            $save_service = new MainServices();
            $save_service->Id = $this->Service_Id;
            $save_service->Name = trim($this->Name);
            $save_service->Service_Type = trim($this->Service_Type);
            $save_service->Description = trim($this->Description);
            $save_service->Details = trim($this->Details);
            $save_service->Features = trim($this->Features);
            $save_service->Specification = trim($this->Specification);
            $save_service->Order_By = $this->Order_By;
            $save_service->Thumbnail = 'storage/app/'. $this->Thumbnail->storeAs('Thumbnails/'.$this->Name.'/',$this->Name.time());
            $save_service->save();
            session()->flash('SuccessMsg','New  Service "'.$this->Name.'"  Added Successfully!.');
            $this->ResetFields();
        }
   }
    public function EditMainservice($Id)
    {

        if($this->Category_Type=='Main')
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
        elseif($this->Category_Type=='Sub')
        {
            $this->Update = 1;
            $fetch = SubServices::Wherekey($Id)->get();
            foreach($fetch as $service)
            {
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

    public function Delete($Id)
    {
        if($this->Category_Type == 'Main')
        {
            $fetch = MainServices::Wherekey($Id)->get();
            foreach($fetch as $item)
            {
                $name = $item['Name'];
                $this->Old_Thumbnail = $item['Thumbnail'];
            }
            $find = Application::where('Application',$name)->count();
            if($find>0)
            {
                session()->flash('Error','Sorry Unable to Delete '.$name.'Service. '.$find. ' Applications Served' );
            }
            else
            {
                $fetch_ser = SubServices::Where('Service_Id',$Id)->get();
                if(count($fetch_ser)>0)
                {
                    foreach($fetch_ser as $item)
                    {
                        $Thumbnail = $item['Thumbnail'];
                        $name = $item['name'];
                        if(!empty($Thumbnail))
                        {

                            if (Storage::disk('public')->exists($Thumbnail))
                            {
                                unlink(public_path('storage/'.$Thumbnail));
                                $delete_sub = SubServices::Where('Service_Id',$Id)->Delete();
                                if($delete_sub)
                                {
                                    session()->flash('SuccessMsg',$name.' Sub Services & Icon Deleted Successfully!');
                                }
                                else
                                {
                                    session()->flash('Error', 'Unable to Sub Service');
                                }
                            }
                        }
                        elseif($Thumbnail=='Not Available')
                        {
                            $delete_sub = SubServices::Where('Service_Id',$Id)->Delete();
                            if($delete_sub)
                                {
                                    session()->flash('SuccessMsg',$name.' Sub Services Deleted Successfully!');
                                }
                                else
                                {
                                    session()->flash('Error', 'Unable to Sub Service');
                                }
                        }

                    }
                }

                if(!empty($this->Old_Thumbnail))
                {

                    if (Storage::disk('public')->exists($this->Old_Thumbnail))
                    {
                        unlink(public_path('storage/'.$this->Old_Thumbnail));
                        $delete_main = MainServices::Wherekey($Id)->Delete();
                        if($delete_main)
                        {
                            session()->flash('SuccessMsg',$name.' Service &  all Sub Services Deleted Successfully!');
                            $this->ResetFields();
                        }
                        else
                        {
                            session()->flash('Error', 'Unable to Delete Bookmark');
                        }
                    }
                    else
                    {
                        session()->flash('Error', 'File Not Available');
                        $delete_main = MainServices::Wherekey($Id)->Delete();
                    }
                }




            }


        }
        elseif($this->Category_Type == 'Sub')
        {
            $service_id = $this->Service_Id;
            $fetch = SubServices::Wherekey($Id)->get();
            foreach($fetch as $item)
            {
                $name = $item['Name'];
                $this->Old_Thumbnail = $item['Thumbnail'];
            }
            $find = Application::where('Application_Type',$name)->count();
            if($find>0)
            {
                session()->flash('Error','Sorry Unable to Delete '.$name.'Sub Service. '.$find. ' Applications Served' );
            }
            else
            {
                if($this->Old_Thumbnail !='Not Available')
                {
                    if (Storage::disk('public')->exists($this->Old_Thumbnail))
                    {
                        unlink(public_path('storage/'.$this->Old_Thumbnail));
                        $delete_main = SubServices::Wherekey($Id)->Delete();
                        if($delete_main)
                        {
                            session()->flash('SuccessMsg',$name.'  Services Deleted Successfully!');
                            $this->ResetFields();
                            $this->Category_Type='Sub';
                            $this->Service_Id=$service_id;

                        }
                        else
                        {
                            session()->flash('Error', 'Unable to Delete Bookmark');
                        }
                    }
                    else
                    {
                        session()->flash('Error', 'File Not Available');
                    }
                }


            }
        }
        // delete working
    }
    public function render()
    {

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
