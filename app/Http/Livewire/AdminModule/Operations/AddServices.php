<?php

namespace App\Http\Livewire\AdminModule\Operations;

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
    protected $paginationTheme = 'bootstrap';
    use WithFileUploads;
    public $Service_Id, $servName,$subServName, $Service_Type, $Services = [],  $Description, $Details, $Specification, $Features, $Service_Fee;
    public $Thumbnail, $SubThumbnail, $Order_By, $paginate, $pos, $filterby, $Update = 0, $lastRecTime;
    public $Category_Type, $Main_ServiceId, $Unit_Price, $Old_Thumbnail, $New_Thumbnail;
    protected $Existing_Sevices = [];

    protected $rules = [
        'servName' => 'required|unique:service_list,Name',
        'subServName' => 'required|unique:sub_service_list,Name',
        'Service_Type' => 'required',
        'Description' => 'required|min:20 |max:300',
        'Thumbnail' => 'required|image|max:1024',
        'SubThumbnail' => 'required|image|max:1024',
        'Unit_Price' => 'required|numeric',
        'Service_Fee' => 'required|numeric',
    ];

    protected $messages = [
        'servName.required' => 'Please Enter the Service Name',
        'subServName.required' => 'Please Enter the Sub Service Name',
        'Service_Type.required' => 'Please Select Service Type',
        'Description.required' => 'Please Write Service Description ',
        'Thumbnail.required' => 'Please Select Thumbnail',

    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($EditData, $DeleteData, $Type)
    {
        $length = mt_rand(2, 3);
        $Char = strtoupper(substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, $length));
        $this->Service_Id = 'DC' . mt_rand(1, 99) . $Char;
        if (!empty($EditData)) {
            $this->Edit($EditData, $Type);
            $this->Category_Type = $Type;
        }
        if (!empty($DeleteData)) {
            $this->Delete($DeleteData, $Type);
            $this->Category_Type = $Type;
        }
    }

    public function ResetFields()
    {

        $this->Update = 0;
        $this->servName = '';
        $this->subServName = '';
        $this->Service_Type = '';
        $this->Description = '';
        $this->Details = '';
        $this->Features = '';
        $this->Specification = '';
        $this->Unit_Price = '';
        $this->Order_By = '';
        $this->Thumbnail = NULL;
        $this->Old_Thumbnail = NULL;
        $length = mt_rand(2, 3);
        $Char = strtoupper(substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, $length));
        $this->Service_Id = 'DC' . mt_rand(1, 99) . $Char;
    }

    public function Save()
    {
        // Find existing service record
        sleep(2); // Simulate a slow server
        $exist = MainServices::find($this->Service_Id);
        $application = $exist ? $exist->Application : null;

        // Check if service exists
        if ($exist) {
            // Process thumbnail and data preparation
            $this->processNewThumbnail();

            // Prepare service and application data
            $data = $this->prepareMainServiceData();
            $data_app = ['Application' => trim($this->servName)];

            // Update service and application records in the database
            $ser = DB::table('service_list')->where('Id', $this->Service_Id)->update($data);
            $app = Application::where('Application', $application)->update($data_app);

            // Flash success or failure message
            $this->flashMessage($ser, $app, 'Service & Applications Updated!');
        } else {
            // Process thumbnail and save new record
            $this->processNewThumbnail();

            // Save new service record
            $save_service = new MainServices($this->prepareMainServiceData());
            $save_service->save();

            // Flash success message for new service
            session()->flash('SuccessMsg', 'New Service "' . $this->servName . '" Added Successfully!');
            $this->ResetFields();
        }
    }

    /**
     * Helper function to prepare data for main service.
     */
    protected function prepareMainServiceData()
    {
        $description = strtolower(trim($this->Description));
        $name = strtolower(trim($this->servName));
        $details = strtolower(trim($this->Details));
        $features = strtolower(trim($this->Features));
        $specification = strtolower(trim($this->Specification));
        return [
            'Id' => $this->Service_Id,
            'Name' => ucwords($name),
            'Service_Type' => trim($this->Service_Type),
            'Description' => ucwords($description),
            'Details' => ucwords($details),
            'Features' => ucwords($features),
            'Specification' => ucwords($specification),
            'Order_By' => trim($this->Order_By),
            'Thumbnail' => $this->New_Thumbnail,
        ];

    }

    /**
     * Helper function to flash success or error message after operation.
     */
    protected function flashMessage($ser, $app, $message)
    {
        if ($ser && $app) {
            session()->flash('SuccessMsg', $message);
        } elseif ($ser) {
            session()->flash('SuccessMsg', 'Service Database Updated!');
        } elseif ($app) {
            session()->flash('SuccessMsg', 'Application Database Updated!');
        } else {
            session()->flash('Error', 'No Changes Found.');
        }
        $this->Category_Type = 'Main';
        $this->ResetFields();
    }

    /**
     * Process thumbnail upload.
     */
    public function processNewThumbnail()
    {
        try {
            // Check if a new thumbnail is uploaded
            if (!empty($this->Thumbnail)) {
                // Delete the old thumbnail if it exists
                if (!empty($this->Old_Thumbnail) && Storage::disk('public')->exists($this->Old_Thumbnail)) {
                    Storage::disk('public')->delete($this->Old_Thumbnail);
                }

                // Store the new thumbnail and queue the process
                $this->New_Thumbnail = $this->storeThumbnail();
            } elseif (!empty($this->Old_Thumbnail) && Storage::disk('public')->exists($this->Old_Thumbnail)) {
                // If no new thumbnail, keep the old one
                $this->New_Thumbnail = $this->Old_Thumbnail;
            } else {
                // If there's no thumbnail, store the new one
                $this->New_Thumbnail = $this->storeThumbnail();
            }
        } catch (\Exception $e) {
            session()->flash('Error', 'Image upload failed: ' . $e->getMessage());
        }
    }

    /**
     * Store the service thumbnail image in storage.
     */
    protected function storeThumbnail()
    {
        $extension = $this->Thumbnail->getClientOriginalExtension();
        $path = 'Services';
        $filename = 'MS_' . $this->servName . '_' . time() . '.' . $extension;

        return $this->Thumbnail->storePubliclyAs($path, $filename, 'public');
    }



    public function Edit($Id, $Type)
    {
        $this->Update = 1;

        if ($Type == 'Main') {
            // Fetch a single main service record
            $service = MainServices::whereKey($Id)->first();

            if ($service) {
                $this->Service_Id = $service->Id;
                $this->servName = $service->Name;
                $this->Description = $service->Description;
                $this->Details = $service->Details;
                $this->Features = $service->Features;
                $this->Specification = $service->Specification;
                $this->Order_By = $service->Order_By;
                $this->Service_Type = $service->Service_Type;
                $this->Old_Thumbnail = $service->Thumbnail;
            }
        } elseif ($Type == 'Sub') {
            // Fetch a single sub service record
            $service = SubServices::whereKey($Id)->first();

            if ($service) {
                $this->Main_ServiceId = $service->Service_Id;
                $this->Service_Id = $service->Id;
                $this->subServName = $service->Name;
                $this->Description = $service->Description;
                $this->Service_Type = $service->Service_Type;
                $this->Unit_Price = $service->Unit_Price;
                $this->Service_Fee = $service->Service_Fee;
                $this->Old_Thumbnail = $service->Thumbnail;
            }
        }
    }

    public function deleteImage($Id, $type)
    {
        // Define a list of placeholder values that shouldn't trigger deletion
        $placeholders = ['not available', 'no-image.png', 'placeholder.jpg'];

        // Determine the model based on type
        $model = $type === 'Main' ? MainServices::class : ($type === 'Sub' ? SubServices::class : null);

        if ($model) {
            $fetch = $model::where('Id', $Id)->first();

            if ($fetch && !empty($fetch->Thumbnail)) {
                $file = $fetch->Thumbnail;

                // Check if $file is not in placeholders and exists in storage
                if (!in_array($file, $placeholders) && Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file); // Delete the file if it’s valid
                }
            }
        }
    }


    public function SaveSubService()
    {
        // Check if the SubService already exists
        $exist = SubServices::where('Id', $this->Service_Id)->get();
        if ($exist->isNotEmpty()) {
            $application_type = $exist->first()->subServName;  // Get the name of the existing sub-service

            // Handle Thumbnail
            if (is_null($this->SubThumbnail) || empty($this->SubThumbnail)) {
                $this->handleExistingThumbnail();
            } else {
                $this->handleNewThumbnail();
            }

            // Prepare data for update
            $data = $this->prepareSubServiceData();
            $app_data = ['Application_Type' => trim($this->subServName)];

            // Update SubService and Application records
            $ser = DB::table('sub_service_list')->where('Id', '=', $this->Service_Id)->update($data);
            $app = DB::table('digital_cyber_db')->where('Application_Type', '=', $application_type)->update($app_data);

            // Handle the outcome of the update
            $this->handleSaveOutcome($ser, $app);
        } else {
            // Validation for new sub-service

            // Handle new thumbnail upload
            $this->handleNewThumbnail();

            // Create new SubService record
            $this->saveNewSubService();

            session()->flash('SuccessMsg', 'New Sub Service "' . $this->subServName . '" Added Successfully!');
            $this->ResetFields();
        }
    }

    // Handle Thumbnail upload for existing sub-service
    protected function handleExistingThumbnail()
    {
        if (Storage::disk('public')->exists($this->Old_Thumbnail)) {
            $this->New_Thumbnail = $this->Old_Thumbnail;
        } elseif ($this->Old_Thumbnail == 'Not Available') {
            $this->validate(['SubThumbnail' => 'required']);
        } else {
            $this->validate(['SubThumbnail' => 'required']);
        }
    }

    // Handle new Thumbnail upload for a new or updated sub-service
    protected function handleNewThumbnail()
    {
        $extension = $this->SubThumbnail->getClientOriginalExtension();
        $path = 'Thumbnails/Services/' . trim($this->subServName);
        $filename = 'SS_' . trim($this->subServName) . '_' . time() . '.' . $extension;
        $url = $this->SubThumbnail->storePubliclyAs($path, $filename, 'public');
        $this->New_Thumbnail = $url;
    }

    // Prepare data array for sub-service
    protected function prepareSubServiceData()
    {
        $description = strtolower(trim($this->Description));
        $name = strtolower(trim($this->subServName));
        return [
            'Name' => ucwords($name),
            'Service_Type' => trim($this->Service_Type),
            'Description' => ucwords($description),
            'Unit_Price' => trim($this->Unit_Price),
            'Service_Fee' => trim($this->Service_Fee),
            'Thumbnail' => $this->New_Thumbnail,
        ];
    }

    // Save new SubService to the database
    protected function saveNewSubService()
    {
        $save_service = new SubServices();
        $save_service->Service_Id = $this->Main_ServiceId;
        $save_service->Id = $this->Service_Id;
        $name = strtolower(trim($this->subServName));
        $save_service->Name = ucwords($name);
        $save_service->Service_Type = $this->Service_Type;
        $description = strtolower(trim($this->Description));
        $save_service->Description = ucwords($description);
        $save_service->Unit_Price = trim($this->Unit_Price);
        $save_service->Service_Fee = trim($this->Service_Fee);
        $save_service->Thumbnail = $this->New_Thumbnail;
        $save_service->save();
    }

    // Handle outcome of saving/updating SubService and Application
    protected function handleSaveOutcome($ser, $app)
    {
        if ($ser && $app) {
            session()->flash('SuccessMsg', trim($this->subServName) . ' Service Details Updated!');
            $this->Category_Type = 'Sub';
            $this->ResetFields();
        } elseif ($ser) {
            session()->flash('SuccessMsg', trim($this->subServName) . ' Service Database Updated!');
            $this->Category_Type = 'Sub';
            $this->ResetFields();
        } elseif ($app) {
            session()->flash('SuccessMsg', trim($this->subServName) . ' Application Database Updated!');
            $this->Category_Type = 'Sub';
            $this->ResetFields();
        } else {
            session()->flash('Error', trim($this->subServName) . ' Service Details Unable to Update!');
            $this->Category_Type = 'Sub';
            $this->ResetFields();
        }
    }

    public function Delete($Id, $type)
    {
        $subSerDelCount = 0;

        // Determine service and get name
        if ($type == 'Main') {
            $fetch = MainServices::whereKey($Id)->first();
            $name = $fetch->Name;
            $this->Old_Thumbnail = $fetch->Thumbnail;

            // Check if applications are linked to this service
            if (Application::where('Application', $name)->count() > 0) {
                return redirect()->back()->with([
                    'message' => 'Sorry, unable to delete ' . $name . ' service. Applications are already served.',
                    'alert-type' => 'error'
                ]);
            }

            // Delete sub-services and then main service
            $this->deleteSubServices($Id);
            $this->deleteMainService($Id, $name);
        } elseif ($type == 'Sub') {
            $fetch = SubServices::whereKey($Id)->get();
            $name = $fetch->first()->Name;
            $this->Old_Thumbnail = $fetch->first()->Thumbnail;

            // Check if applications are linked to this sub-service
            if (Application::where('Application_Type', $name)->count() > 0) {
                return redirect()->back()->with([
                    'message' => 'Sorry, unable to delete ' . $name . ' service. Applications are already served.',
                    'alert-type' => 'error'
                ]);
            }

            // Delete sub-service
            $this->deleteSubService($Id, $name);
        }
    }

    // Delete Sub Service logic
    private function deleteSubServices($serviceId)
    {
        $fetch_ser = SubServices::where('Service_Id', $serviceId)->get();
        foreach ($fetch_ser as $item) {
            $this->deleteThumbnail($item->Thumbnail);
            SubServices::where('Service_Id', $serviceId)->delete();
        }
    }

    // Delete Main Service logic
    private function deleteMainService($id, $name)
    {
        $this->deleteThumbnail($this->Old_Thumbnail);
        MainServices::whereKey($id)->delete();
        return redirect()->route('add_services')->with([
            'message' => $name . ' service and all sub-services deleted successfully!',
            'alert-type' => 'success'
        ]);
    }

    // Delete Sub Service logic
    private function deleteSubService($id, $name)
    {
        $this->deleteThumbnail($this->Old_Thumbnail);
        SubServices::whereKey($id)->delete();
        return redirect()->back()->with([
            'message' => $name . ' service deleted successfully!',
            'alert-type' => 'success'
        ]);
    }

    // Function to delete Thumbnail
    private function deleteThumbnail($thumbnail)
    {
        if ($thumbnail && Storage::disk('public')->exists($thumbnail)) {
            unlink(public_path('storage/' . $thumbnail));
        }
    }

    public function LastUpdate()
    {
        # code...
        if ($this->Category_Type == 'Main') {
            $latest_app = MainServices::latest('created_at')->first();
            $this->lastRecTime =  Carbon::parse($latest_app['created_at'])->diffForHumans();
        } elseif ($this->Category_Type == 'Sub') {
            $latest_app = SubServices::latest('created_at')->first();
            $this->lastRecTime =  Carbon::parse($latest_app['created_at'])->diffForHumans();
        }
    }
    public function render()
    {
        $this->LastUpdate();

        if ($this->Category_Type == 'Main') {

            $this->Existing_Sevices = DB::table('service_list')->paginate(10);
        } elseif ($this->Category_Type == 'Sub') {

            $this->Existing_Sevices = SubServices::Where('Service_Id', $this->Main_ServiceId)->Paginate(10);
        }
        return view('livewire.admin-module.operations.add-services', ['MainServices' => $this->MainServices, 'n' => $this->n, 'Existing_Sevices' => $this->Existing_Sevices]);
    }
}
