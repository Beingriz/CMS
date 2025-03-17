<?php

namespace App\Http\Livewire\AdminModule\Operations;

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
    protected $paginationTheme = 'Bootstrap';
    public $Name, $Thumbnail, $Id, $Old_Thumbnail, $Relation, $Update, $n = 1, $iteration, $ChangeRelation, $New_Thumbnail, $Order, $created, $updated, $New_Image;

    protected $listeners = ['edit'=>'Edit','delete'=>'Delete','change'=>'Change','view'=>'ViewStatus','update'=>'UpdateStatus'];
    protected $rules = [
        'Name' => 'required ',
        'Relation' => 'required',
        'Thumbnail' => 'required',
    ];

    protected $messages = [
        'Name.required' => 'Please Enter the Status Name',
        'Relation.required' => 'Please Select Status Relation',
        'Thumbnail.required' => 'Please Select Status Icon',

    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function mount($Id, $DelId, $ViewStatus)
    {
        $this->Id = 'ST' . time();
        $this->Relation = '---Select---';
        $this->iteration = 0;
        $this->Update = 0;

    }
    public function ResetFields()
    {
        $this->Id = 'ST' . time();
        $this->Name = NULL;
        $this->Thumbnail = NULL;
        $this->iteration++;
        $this->Old_Thumbnail = NULL;
        $this->ChangeRelation = NULL;
        $this->Relation = '---Select---';
        $this->Order = NULL;
        $this->Update = 0;
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


        if (!empty($this->Thumbnail)) //if new image is selected
        {
            if (!empty($this->Old_Thumbnail)) // check if old image is available in db
            {
                if (Storage::disk('public')->exists($this->Old_Thumbnail)) // Check for existing File
                {
                    unlink(storage_path('app/public/' . $this->Old_Thumbnail)); // Deleting Existing File

                    $extension = $this->Thumbnail->getClientOriginalExtension();
                    $path = 'Status/Thumbnail';
                    $filename = 'St' . $this->Name . '_' . time() . '.' . $extension;
                    $url = $this->Thumbnail->storePubliclyAs($path, $filename, 'public');
                    $this->New_Image = $url;
                    $data = array();
                    $data['Thumbnail'] = $url;
                    DB::table('status')->where([['Id', '=', $this->Id]])->update($data); // update db wil empty string
                } else // if file not avaialbe then upload new selected image
                {
                    $extension = $this->Thumbnail->getClientOriginalExtension();
                    $path = 'Status/Thumbnail';
                    $filename = 'St' . $this->Name . '_' . time() . '.' . $extension;
                    $url = $this->Thumbnail->storePubliclyAs($path, $filename, 'public');
                    $this->New_Image = $url;
                }
            } else // if old image is not available id db then upload image
            {
                $extension = $this->Thumbnail->getClientOriginalExtension();
                $path = 'Status/Thumbnail';
                $filename = 'St' . $this->Name . '_' . time() . '.' . $extension;
                $url = $this->Thumbnail->storePubliclyAs($path, $filename, 'public');
                $this->New_Image = $url;
            }
        } else // if no image is selected then leave this field as it is with old image.
        {
            $this->New_Image = $this->Old_Thumbnail;
        }
    }
    public function Save()
    {

        $this->validate();
        if (!empty($this->Thumbnail)) {
            $extension = $this->Thumbnail->getClientOriginalExtension();
            $path = 'Thumbnails/Status/' . $this->Name;
            $filename = 'ST_' . $this->Name . '_' . time() . '.' . $extension;
            $url = $this->Thumbnail->storePubliclyAs($path, $filename, 'public');
            $this->Thumbnail = $url;
        } else {
            $this->Thumbnail = 'Not Available';
        }
        $save_st = new Status();
        $save_st->Id = $this->Id;
        $save_st->Status = $this->Name;
        $save_st->Relation = $this->Relation;
        $save_st->Orderby = $this->Order;
        $save_st->Thumbnail =  $this->Thumbnail;
        $save_st->save();
        $this->dispatchBrowserEvent('swal:success-non-redirect', [
            'title' => 'Updated Successfully!',
            'text' => "New status {$this->Name} has been created successfully!",
            'icon' => 'success',
        ]);
        $relation = $this->Relation;
        $this->ResetFields();
        $this->Relation = $relation;
    }

    public function Edit($Id)
    {

        $fetch = Status::Where('Id', $Id)->get();
        foreach ($fetch as $item) {
            $this->Id = $item['Id'];
            $this->Name = $item['Status'];
            $this->Relation = $item['Relation'];
            $this->Old_Thumbnail = $item['Thumbnail'];
            $this->Order = $item['Orderby'];
        }
        $this->Update = 1;
        $this->ChangeRelation = Null;
        $this->iteration++;
    }

    public $list = false, $status;

    public function ViewStatus($status)
    {
        $this->list = true;
        $this->status = $status;
    }
    public function UpdateStatus($Id, $Status)
    {
        $oldStatus = Application::where('Id', $Id)->value('Status');
        // Trim and update status
        Application::where('Id', $Id)->update(['Status' => trim($Status)]);

        // Fetch all unique status names from the status table
        $statuses = Status::pluck('Status');

        // Loop through and update the total amount & count
        foreach ($statuses as $name) {
            $amount = DB::table('digital_cyber_db')->where('Status', $name)->sum('Total_Amount');
            $count = DB::table('digital_cyber_db')->where('Status', $name)->count();

            DB::table('status')->where('Status', $name)->update([
                'Total_Amount' => $amount,
                'Total_Count' => $count
            ]);
        }
        $this->ViewStatus($oldStatus);
        // Flash SweetAlert notification to session
        $this->dispatchBrowserEvent('swal:success-non-redirect', [
            'title' => 'Updated!',
            'text' => 'Status from '.$oldStatus.' to '.$Status.' has been updated successfully.',
            'icon' => 'success',
        ]);

        return redirect()->back();
    }


    public function Update()
    {
        $relation = $this->Relation;

        // Handle Thumbnail Upload
        if (!is_null($this->Thumbnail)) {
            $this->validate([
                'Thumbnail' => 'required|image',
            ]);

            $extension = $this->Thumbnail->getClientOriginalExtension();
            $path = 'Thumbnails/Status/' . $this->Name;
            $filename = 'St_' . $this->Name . '_' . time() . '.' . $extension;
            $this->New_Thumbnail = $this->Thumbnail->storePubliclyAs($path, $filename, 'public');

            // Delete old file if exists
            if (!is_null($this->Old_Thumbnail) && Storage::disk('public')->exists($this->Old_Thumbnail)) {
                Storage::disk('public')->delete($this->Old_Thumbnail);
            }
        } else {
            // Use existing thumbnail if available
            if (!is_null($this->Old_Thumbnail) && Storage::disk('public')->exists($this->Old_Thumbnail)) {
                $this->New_Thumbnail = $this->Old_Thumbnail;
            } else {
                session()->flash('Error', 'File does not exist. Please select a new thumbnail.');
                return;
            }
        }

        // Fetch Old Status Name
        $oldStatus = Status::where('Id', $this->Id)->value('Status');

        // Update Applications linked with this status
        $updatedApps = Application::where('Status', $oldStatus)->update(['Status' => $this->Name]);

        // Update Status Record
        $updateData = [
            'Status' => $this->Name,
            'Relation' => !empty($this->ChangeRelation) ? $this->ChangeRelation : $this->Relation,
            'Thumbnail' => $this->New_Thumbnail,
        ];
        $update = DB::table('status')->where('Id', $this->Id)->update($updateData);

        if ($update) {
            // Dispatch SweetAlert event
            $this->dispatchBrowserEvent('swal:success-non-redirect', [
                'title' => 'Updated Successfully!',
                'text' => "Status '{$this->Name}' updated in {$updatedApps} applications.",
                'icon' => 'success',
            ]);

            // Reset Fields
            $this->ResetFields();
            $this->Thumbnail = null;
            $this->iteration++;
            $this->Update = 0;
            $this->Relation = $relation;
        }
    }
    public function Delete($Id)
    {
        $status = Status::where('Id', $Id)->first(); // Fetch single record

        if (!$status) {
            session()->flash('Error', 'Record not found.');
            return;
        }

        $this->Old_Thumbnail = $status->Thumbnail;
        $this->Name = $status->Name;
        $relation = $status->Relation;

        // Delete Thumbnail if it exists
        if (!is_null($this->Old_Thumbnail) && Storage::disk('public')->exists($this->Old_Thumbnail)) {
            Storage::disk('public')->delete($this->Old_Thumbnail);
        }

        // Delete Status Record
        $delete = Status::where('Id', $Id)->delete();

        if ($delete) {
            // Dispatch SweetAlert Event for Livewire
            $this->dispatchBrowserEvent('swal:success-non-redirect', [
                'title' => 'Deleted Successfully!',
                'text' => "{$this->Name} has been deleted from {$this->Relation} Category.",
                'icon' => 'success',
            ]);
        } else {
            session()->flash('Error', 'Unable to delete record.');
        }
        $this->ResetFields();
        $this->Relation = $relation;
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
        $Existing_st = DB::table('status')->where('Relation', $this->Relation)->orderBy('Orderby', 'asc')->paginate(5);
        $records = Application::where('status', $this->status)->paginate(10);
        return view('livewire.admin-module.operations.status-module', ['MainServices' => $MainServices, 'Existing_st' => $Existing_st, 'status_list' => $status_list, 'records' => $records]);
    }
}
