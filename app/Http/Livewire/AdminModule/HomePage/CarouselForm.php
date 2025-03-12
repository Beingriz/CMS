<?php

namespace App\Http\Livewire\AdminModule\HomePage;

use App\Models\Carousel_DB;
use App\Models\MainServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;


class CarouselForm extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $Tittle, $Description, $Button1_Name, $Button1_Link, $Button2_Link, $Image, $Update, $Count, $Sl = 1, $Id, $Old_Image, $New_Image, $Services, $Service_Id, $Clearr;

    protected $rules = [
        'Tittle' => 'Required',
        'Description' => 'Required |min:10|max:110',
        'Image' => 'required|file|mimes:jpeg,png|max:2048',
    ];
    protected $messages = [
        'Tittle' => 'Please Enter Catchy Tittle',
        'Description' => 'Description should be less than 50 characters',
        'Image' => 'Image  Cannot be empty',
    ];

    protected $listeners = ['delete' => 'delete', 'edit'=> 'edit'];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    } //End Function

    public function mount($EditData)
    {
        # code...
        $this->Id = 'SB' . time();
        $this->Count = Carousel_DB::all()->count();
        $this->Update = 0;
    } //End Function


    public function ResetFields()
    {
        # code...
        $this->Id = 'SB' . time();
        $this->Tittle = "";
        $this->Description = "";
        $this->Image = null;
        $this->Update = 0;
        $this->Clearr++;
    } //End Function

    public function Save()
    {
        $this->validate();
        try {
            // Process Image Upload
            $imagePath = null;
            if (!empty($this->Image)) {
                $filename = 'Carousel_' . Str::slug($this->Tittle) . '_' . time() . '.' . $this->Image->getClientOriginalExtension();
                $imagePath = $this->Image->storePubliclyAs('Carousel/', $filename, 'public');
            }
            // Save Data to Database
            $data = new Carousel_DB();
            $data->Id = $this->Id;
            $data->Tittle = $this->Tittle;
            $data->Description = $this->Description;
            $data->Service_Id = $this->Service_Id;
            $data->Image = $imagePath;
            $data->save();

            // Reset Form Fields
            $this->ResetFields();
            $this->Update = 0;

            // Show success message without page refresh
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Success!',
                'text' => 'Carousel added successfully.',
                'icon' => 'success',
                'redirect_url' => route('new.carousel'),
                'timer' => 3000,
            ]);
        } catch (\Exception $e) {
            \Log::error("Save Error: " . $e->getMessage());

            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Error!',
                'text' => 'Something went wrong while saving. Please try again.',
                'icon' => 'error',
            ]);
        }
    }

    public function edit($Id)
    {
        $fetch = Carousel_DB::find($Id);

        if (!$fetch) {
            // Handle case where the record is not found
            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Not Found!',
                'text' => 'The selected record does not exist.',
                'icon' => 'error',
            ]);
            return;
        }

        $this->Id = $fetch->Id;
        $this->Tittle = $fetch->Tittle ?? ''; // Handle null values
        $this->Service_Id = $fetch->Service_Id ?? '';
        $this->Description = $fetch->Description ?? '';
        $this->Old_Image = $fetch->Image ?? '';
        $this->Update = 1;
    }

    public function delete($Id)
    {
        $fetch = Carousel_DB::find($Id);

        if (!$fetch) {
            // Handle case where the record is not found
            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Not Found!',
                'text' => 'The selected record does not exist.',
                'icon' => 'error',
            ]);
            return;
        }

        try {
            // Delete the record from the database
            $delete = Carousel_DB::where('Id', $Id)->delete();

            // Delete the image from storage
            if (!empty($fetch->Image) && Storage::disk('public')->exists($fetch->Image)) {
                Storage::disk('public')->delete($fetch->Image);
            }

            // Show success notification
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Deleted Successfully!',
                'text' => 'The carousel data has been deleted.',
                'icon' => 'success',
                'redirect_url' => route('new.carousel'),
                'timer' => 1000,
            ]);
        } catch (\Exception $e) {
            \Log::error("Delete Error: " . $e->getMessage());

            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Delete Failed!',
                'text' => 'Something went wrong. Please try again.',
                'icon' => 'error',
                'timer' => 1000,
                'redirect_url' => route('new.carousel'),

            ]);
        }
    }

    public function Image()
    {
        if (!empty($this->Image)) // New image selected
        {
            $path = 'Carousel/';
            $filename = 'Carousel_' .Str::slug($this->Tittle) . '_' . time() . '.' . $this->Image->getClientOriginalExtension();

            // If old image exists, delete it
            if (!empty($this->Old_Image) && Storage::disk('public')->exists($this->Old_Image)) {
                Storage::disk('public')->delete($this->Old_Image); // Delete existing image
            }

            // Store new image and update path
            $this->New_Image = $this->Image->storePubliclyAs($path, $filename, 'public');
        } else {
            $this->New_Image = $this->Old_Image; // Keep old image if no new image is selected
        }
    }

    public function Update()
    {
        $this->validate([
            'Tittle' => 'required|string|max:255',
            'Description' => 'required|min:10|max:110',
        ]);

        try {
            $this->Image(); // Process Image Upload

            DB::table('carousel')->where('Id', $this->Id)->update([
                'Tittle' => $this->Tittle,
                'Description' => $this->Description,
                'Service_Id' => $this->Service_Id,
                'Image' => $this->New_Image,
            ]);

            $this->ResetFields();
            $this->Update = 0;

            // Show success notification
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Updated Successfully!',
                'text' => 'The carousel data has been updated.',
                'icon' => 'success',
                'redirect_url' => route('new.carousel'),
            ]);
        } catch (\Exception $e) {
            \Log::error("Update Error: " . $e->getMessage());

            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Update Failed!',
                'text' => 'Something went wrong. Please try again.',
                'icon' => 'error',
            ]);
        }
    }

    public function autoCapitalize()
    {
        $this->Tittle = ucwords($this->Tittle);
        $this->Description = ucwords($this->Description);
    }

    public function render()
    {
        $this->autoCapitalize();
        if (!empty($this->Tittle)) {
            $getId = MainServices::where('Name', $this->Tittle)->get();
            foreach ($getId as $key) {
                $this->Service_Id = $key['Id'];
            }
        }
        $Records = Carousel_DB::all();
        $this->Services = MainServices::where('Service_Type', 'Public')->get();
        return view('livewire.admin-module.home-page.carousel-form', compact('Records'));
    }
}
