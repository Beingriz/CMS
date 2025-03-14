<?php

namespace App\Http\Livewire\AdminModule\HomePage;

use App\Models\About_Us;
use App\Models\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;


class AboutUsForm extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $Tittle, $Description, $Image, $editMode = false, $Count, $Sl = 1, $Id, $Old_Image, $New_Image, $Selected, $Delivered, $Iteration = 0;
    public $Clients;
    protected $rules = [
        'Tittle' => 'Required|max:30',
        'Description' => 'Required |min:10|max:500',
        'Image' => 'required|file|mimes:jpeg,png|max:2048',
    ];
    protected $messages = [
        'Tittle' => 'Please Enter Catchy Tittle',
        'Description' => 'Description should be less than 50 characters',
        'Image' => 'Image  Cannot be empty',
    ];
    protected $listeners = ['delete' => 'delete', 'edit' => 'edit', 'select' => 'select'];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($EditData, $SelectId)
    {
        # code...
        $this->Id = 'AU' . time();
        $this->Clients = Application::all()->count();
        $this->Delivered = Application::where('Status', '=', 'Delivered to Client')->get()->count();


    }
    public function ResetFields()
    {
        # code...
        $this->Tittle = "";
        $this->Description = "";
        $this->Image = NULL;
        $this->Iteration++;
        $this->editMode = false;
    }

    public function Save()
    {
        $this->validate();

        try {
            // Process Image Upload
            $imagePath = null;
            if (!empty($this->Image)) {
                $filename = 'AboutUs_' . Str::slug($this->Tittle) . '_' . time() . '.' . $this->Image->getClientOriginalExtension();
                $imagePath = $this->Image->storePubliclyAs('About Us/', $filename, 'public');
            }

            // Save Data to Database
            $data =  new About_Us();
            $data->Id = $this->Id;
            $data->Tittle = $this->Tittle;
            $data->Description = $this->Description;
            $data->Total_Clients = $this->Clients;
            $data->Delivered = $this->Delivered;
            $data->Image = $imagePath;
            $data->save();


            // Reset Form Fields
            $this->ResetFields();
            $this->editMode= false;

            // Show success message without page refresh
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Success!',
                'text' => 'New About Us Added Successfully.',
                'icon' => 'success',
                'timer' => 3000,
                'redirect_url' => route('new.about_us'),

            ]);
        } catch (\Exception $e) {
            \Log::error("Save Error: " . $e->getMessage());

            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Error!',
                'text' => 'Something went wrong while saving. Please try again.',
                'icon' => 'error',
                'timer' => 3000,
                'redirect_url' => route('new.about_us'),
            ]);
        }
    }
    public function autoCapitalize()
    {
        $this->Tittle = ucwords($this->Tittle);
        $this->Description = ucwords($this->Description);

    }
    public function edit($Id)
    {
        $fetch = About_Us::find($Id);
        $this->Id = $Id;
        $this->Tittle = $fetch['Tittle'];
        $this->Description = $fetch['Description'];
        $this->Old_Image = $fetch['Image'];
        $this->editMode = true;
    }
    public function Image()
    {
        # code...
        # if image is selected, check if database has any image, else update the new image
        # if image is not selected, dont update image. remove validation for image selection


        if (!empty($this->Image)) //if new image is selected
        {
            if (!empty($this->Old_Image)) // check if old image is available in db
            {
                if (Storage::disk('public')->exists($this->Old_Image)) // Check for existing File
                {
                    unlink(storage_path('app/public/' . $this->Old_Image)); // Deleting Existing File

                    $extension = $this->Image->getClientOriginalExtension();
                    $path = 'AboutUS/';
                    $filename = 'AboutUS' . $this->Tittle . '_' . time() . '.' . $extension;
                    $url = $this->Image->storePubliclyAs($path, $filename, 'public');
                    $this->New_Image = $url;
                    $data = array();
                    $data['Image'] = $url;
                    DB::table('about_us')->where([['Id', '=', $this->Id]])->update($data); // update db wil empty string
                } else // if file not avaialbe then upload new selected image
                {
                    $extension = $this->Image->getClientOriginalExtension();
                    $path = 'AboutUS/';
                    $filename = 'AboutUS' . $this->Tittle . '_' . time() . '.' . $extension;
                    $url = $this->Image->storePubliclyAs($path, $filename, 'public');
                    $this->New_Image = $url;
                }
            } else // if old image is not available id db then upload image
            {
                $extension = $this->Image->getClientOriginalExtension();
                $path = 'AboutUS/';
                $filename = 'AboutUS' . $this->Tittle . '_' . time() . '.' . $extension;
                $url = $this->Image->storePubliclyAs($path, $filename, 'public');
                $this->New_Image = $url;
            }
        } else // if no image is selected then leave this field as it is with old image.
        {
            $this->New_Image = $this->Old_Image;
        }
    }
    public function updateAboutus()
    {

        if (!empty($this->Old_Image)) {
            $this->validate([
                'Tittle' => 'required|max:30',
                'Description' => 'required|min:10|max:500',
            ]);
        }

        $data = [];
        $data['Tittle'] = $this->Tittle;
        $data['Description'] = $this->Description;
        $data['Total_Clients'] = $this->Clients;
        $data['Delivered'] = $this->Delivered;
        $this->Image(); // Process the new image
        $data['Image'] = $this->New_Image;

        DB::table('about_us')->where('Id', $this->Id)->update($data);

        // Emit event for SweetAlert in Livewire
        $this->dispatchBrowserEvent('swal:success', [
            'title' => 'Updated!',
            'text' => 'About Us Details Updated Successfully!',
            'icon' => 'success',
            'redirect_url' => route('new.about_us') // Optional: Redirect after confirmation
        ]);

        $this->ResetFields();
        $this->editMode = false;
    }

    public function select($Id)
    {
        try {
            // Unselect all records first
            About_Us::query()->update(['Selected' => 'No']);

            // Select the new record
            $update = About_Us::where('Id', $Id)->update(['Selected' => 'Yes']);

            if ($update) {
                $this->dispatchBrowserEvent('swal:success', [
                    'title' => 'Selection Updated!',
                    'text' => 'The selected About Us record has been updated.',
                    'icon' => 'success',
                    'redirect_url' => route('new.about_us'),

                ]);

                // Refresh the Livewire component to reflect changes
                $this->emit('refreshComponent');
            }
        } catch (\Exception $e) {
            \Log::error("Select Error: " . $e->getMessage());

            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Error!',
                'text' => 'Something went wrong. Please try again.',
                'icon' => 'error',
                'redirect_url' => route('new.about_us'),

            ]);
        }
    }


    public function delete($Id)
    {
        try {
            $fetch = About_Us::find($Id);

            if (!$fetch) {
                $this->dispatchBrowserEvent('swal:error', [
                    'title' => 'Not Found!',
                    'text' => 'The record does not exist.',
                    'icon' => 'error',
                ]);
                return;
            }

            // Delete Image if Exists
            if ($fetch->Image && Storage::disk('public')->exists($fetch->Image)) {
                Storage::disk('public')->delete($fetch->Image);
            }

            // Delete Record
            $delete = About_Us::where('Id', $Id)->delete();

            // Success Message
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Deleted!',
                'text' => 'Record deleted successfully.',
                'icon' => 'success',
                'redirect_url' => route('new.about_us'),
                'timer' => 3000,
            ]);

            // Refresh Livewire Component
            $this->emit('refreshComponent');
        } catch (\Exception $e) {
            \Log::error("Delete Error: " . $e->getMessage());

            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Error!',
                'text' => 'Something went wrong. Please try again.',
                'icon' => 'error',
                'redirect_url' => route('new.about_us'),
                'timer' => 3000,
            ]);
        }
    }

    public function render()
    {
        $this->autoCapitalize();
        $Records = About_Us::all();
        return view('livewire.admin-module.home-page.about-us-form', compact('Records'));
    }
}
