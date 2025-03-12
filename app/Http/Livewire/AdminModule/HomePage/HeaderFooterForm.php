<?php

namespace App\Http\Livewire\AdminModule\HomePage;

use App\Models\UserTopBar;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HeaderFooterForm extends Component
{
    public $Id, $Company_Name, $Address, $Phone_No, $Facebook, $Instagram, $LinkedIn, $Twitter, $Time_From, $Time_To, $Update, $Youtube;
    protected $rules = [
        'Company_Name' => 'Required',
        'Address' => 'Required',
        'Phone_No' => 'Required',
        'Time_From' => 'Required',
        'Time_To' => 'Required',
    ];

    protected $messages = [
        'Company_Name' => 'Company Name Cannot be Blank',
        'Address' => 'Please Enter Company Address',
        'Phone_No' => 'Phone Number shuld not be empty',
        'Time_From' => 'Companys From Timming shuld not be blank ',
        'Time_To' => 'Companys To Timming shuld not be blank ',
    ];

    protected $listeners = ['delete' => 'delete', 'edit' => 'edit', 'select' => 'select'];

    public function mount($editData,$selectId)
    {
        $this->Id = 'UTB' . time();
        if(!empty($editData)){
            $this->edit($editData);
        }
        if(!empty($selectId)){
            $this->select($selectId);
        }
    }
    public function ResetFields()
    {
        $fields = [
            'Company_Name', 'Address', 'Phone_No', 'Time_From', 'Time_To',
            'Facebook', 'Instagram', 'LinkedIn', 'Twitter', 'Youtube', 'Update'
        ];

        foreach ($fields as $field) {
            $this->$field = ($field === 'Update') ? 0 : ''; // Set 'Update' to 0, others to ''
        }
    }

    public function Save()
    {
        $this->validate();
        $save = new UserTopBar();
        $save->Id = $this->Id;
        $save->Company_Name = $this->Company_Name;
        $save->Address = $this->Address;
        $save->Phone_No = $this->Phone_No;
        $save->Time_From = $this->Time_From;
        $save->Time_To = $this->Time_To;
        $save->Facebook = $this->Facebook;
        $save->Instagram = $this->Instagram;
        $save->LinkedIn = $this->LinkedIn;
        $save->Twitter = $this->Twitter;
        $save->save();
        session()->flash('SuccessMsg', 'Details Updated Successfully');
        $this->ResetFields();
    }

    public function edit($id)
    {
        $fetch = UserTopBar::find($id);

        if ($fetch) {
            $this->Id = $fetch->Id;
            $this->Company_Name = $fetch->Company_Name;
            $this->Address = $fetch->Address;
            $this->Phone_No = $fetch->Phone_No;
            $this->Time_From = $fetch->Time_From;
            $this->Time_To = $fetch->Time_To;
            $this->Facebook = $fetch->Facebook;
            $this->Instagram = $fetch->Instagram;
            $this->LinkedIn = $fetch->LinkedIn;
            $this->Twitter = $fetch->Twitter;
            $this->Youtube = $fetch->Youtube;
            $this->Update = 1;
        }
    }

    public function select($Id)
    {
        // Reset selection for all records
        DB::table('user_top_bar')->update(['Selected' => 'No']);

        // Select the new record
        $update = DB::table('user_top_bar')->where('Id', '=', $Id)->update(['Selected' => 'Yes']);

        if ($update) {
            // session()->flash('SuccessMsg', 'Details Updated Successfully');

            // Emit an event to trigger SweetAlert
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Selection Updated!',
                'text' => 'Company details have been selected successfully.',
                'icon' => 'success',
                'redirect_url' => route('user_top_bar'), // Laravel route helper
            ]);

            $this->ResetFields();
            $this->Update = 0;
        }
    }

    public function Update()
    {
        // Validate input before updating
        $this->validate([
            'Company_Name' => 'required|string|max:255',
            'Address' => 'required|string|max:500',
            'Phone_No' => 'required|string|max:20',
            'Time_From' => 'required',
            'Time_To' => 'required',
            'Facebook' => 'nullable|url',
            'Instagram' => 'nullable|url',
            'LinkedIn' => 'nullable|url',
            'Twitter' => 'nullable|url',
            'Youtube' => 'nullable|url',
        ]);

        try {
            // Use Eloquent for cleaner and safer updates
            $update = UserTopBar::where('Id', $this->Id)->update([
                'Company_Name' => $this->Company_Name,
                'Address' => $this->Address,
                'Phone_No' => $this->Phone_No,
                'Time_From' => $this->Time_From,
                'Time_To' => $this->Time_To,
                'Facebook' => $this->Facebook,
                'Instagram' => $this->Instagram,
                'LinkedIn' => $this->LinkedIn,
                'Twitter' => $this->Twitter,
                'Youtube' => $this->Youtube,
            ]);

            if ($update) {
                // Emit SweetAlert event
                $this->dispatchBrowserEvent('swal:success', [
                    'title' => 'Success!',
                    'text' => 'Company details have been updated successfully.',
                    'icon' => 'success',
                    'redirect_url' => route('user_top_bar'), // Redirect URL
                ]);
            } else {
                // Handle case where no rows were updated
                $this->dispatchBrowserEvent('swal:warning', [
                    'title' => 'No Changes!',
                    'text' => 'No updates were made because the data was unchanged.',
                    'icon' => 'info',
                ]);
            }
        } catch (\Exception $e) {
            // Log the error and show an alert
            \Log::error("Update Error: " . $e->getMessage());

            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Error!',
                'text' => 'An unexpected error occurred while updating. Please try again.',
                'icon' => 'error',
            ]);
        }
    }

    public function delete($id)
    {

        $delete = UserTopBar::where('Id', $id)->get();
        $Company_Name = $delete[0]->Company_Name;
        $delete = UserTopBar::where('Id', $id)->delete();
        if ($delete) {

            // Refresh component after deletion
            $this->dispatchBrowserEvent('swal:success', [
                'title' => 'Deleted!',
                'text' => $Company_Name. ' has been deleted successfully.',
                'icon' => 'success',
                'redirect_url' => route('user_top_bar'), // Laravel route helper
            ]);
        }else{
            $this->dispatchBrowserEvent('swal:error', [
                'title' => 'Error!',
                'text' => 'An unexpected error occurred while deleting. Please try again.',
                'icon' => 'error',
            ]);
        }
    }

    public function autoCapitalize()
    {
        $this->Company_Name = ucwords(strtolower($this->Company_Name));
        $this->Address = ucwords(strtolower($this->Address));
    }


    public function render()
    {
        $this->autoCapitalize();
        $Records = UserTopBar::all();
        return view('livewire.admin-module.home-page.header-footer-form', compact('Records'));
    }
}
