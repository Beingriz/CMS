<?php

namespace App\Http\Livewire\AdminModule\Application;

use Livewire\Component;
use App\Models\ClientRegister;
use App\Models\Application;

class AppSearch extends Component
{
    public $Mobile_No = NULL;
    public $user_type = NULL;

    public function render()
    {
        $this->determineUserType();
        return view('livewire.app-search', ['user_type' => $this->user_type]);
    }

    /**
     * Determine the user type based on the mobile number provided.
     */
    private function determineUserType()
    {
        // Check if the mobile number exists in the ClientRegister table
        $client = ClientRegister::where('Mobile_No', $this->Mobile_No)->first();

        if ($client) {
            // Registered user: get the count of services availed
            $applications = Application::where('Mobile_No', $this->Mobile_No)->get();
            $this->user_type = "Registered User!! Availed " . $applications->count() . " Services";
        } else {
            // Unregistered or new user: check if the mobile number exists in the Application table
            $applications = Application::where('Mobile_No', $this->Mobile_No)->get();

            if ($applications->isNotEmpty()) {
                // Unregistered user: get the count of services availed
                $this->user_type = "Unregistered User!! Availed " . $applications->count() . " Services";
            } else {
                // New user: no record found
                $this->user_type = "New Client";
            }
        }
    }
}
