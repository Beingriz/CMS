<?php

namespace App\Http\Livewire\AdminModule\Operations;

use App\Models\ApplyServiceForm;
use App\Models\EnquiryDB;
use Livewire\Component;

class HeaderNotification extends Component
{
    public $enquiryCount;
    public $applyNowCount;
    public $notifications = [];

    protected $listeners = ['refreshNotifications' => '$refresh'];

    public function mount()
    {
        $this->fetchNotifications();
    }

    public function fetchNotifications()
    {
        // Fetch the branch ID dynamically from the authenticated user
        $branchId = auth()->user()->branch_id; // Assumes the User model has a `branch_id` attribute

        // Get the current date and subtract 2 days from it
        $twoDaysAgo = now()->subDays(2);

        // Fetch counts for Enquiry and ApplyNow tables
        $this->enquiryCount = EnquiryDB::where('Branch_Id', $branchId)
            ->where('Status', 'Pending')
            ->where('created_at', '>=', $twoDaysAgo) // Only include records created in the last 2 days
            ->count();

        $this->applyNowCount = ApplyServiceForm::where('Branch_Id', $branchId)
            ->where('Status', 'Submitted')
            ->where('created_at', '>=', $twoDaysAgo) // Only include records created in the last 2 days
            ->count();

        // Combine notifications, fetching the latest 5 from each with a filter for the last 2 days
        $this->notifications = array_merge(
            EnquiryDB::where('Branch_Id', $branchId)
                ->where('Status', 'Pending')
                ->where('created_at', '>=', $twoDaysAgo) // Filter by created_at
                ->latest()
                ->take(5)
                ->get()
                ->toArray(),

            ApplyServiceForm::where('Branch_Id', $branchId)
                ->where('Status', 'Submitted')
                ->where('created_at', '>=', $twoDaysAgo) // Filter by created_at
                ->latest()
                ->take(5)
                ->get()
                ->toArray()
        );
    }

    public function render()
    {
        return view('livewire.admin-module.operations.header-notification');
    }
}
