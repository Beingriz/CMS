<div>
    <!-- Notification Button -->
    <div class="dropdown d-inline-block">
        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="ri-notification-3-line"></i>
            @if($enquiryCount + $applyNowCount > 0)
                <span class="noti-dot"></span>
            @endif
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 notification-dropdown"
            aria-labelledby="page-header-notifications-dropdown">
            <div class="p-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0">Notifications</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="small">View All</a>
                    </div>
                </div>
            </div>
            <div data-simplebar style="max-height: 300px;">
                @forelse($notifications as $notification)
                    <div class="text-reset notification-item">
                        <div class="d-flex">
                            <div class="avatar-xs me-3">
                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                    <i class="ri-information-line"></i>
                                </span>
                            </div>
                            <div class="flex-1">
                                <h6 class="mb-1">{{ $notification['Name'] ?? 'Service Name' }}</h6>
                                <p class="mb-0"><strong>Service:</strong> {{ $notification['Service'] ?? 'Not Available' }} | {{ $notification['Service_Type'] ?? 'Not Available' }} </p>
                                <p class="mb-0"><strong>Contact:</strong> {{ $notification['Phone_No'] ?? 'Not Available' }}</p>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-1 text-wrap" style="white-space: normal;"><strong>Message : </strong>{{ $notification['Message'] ?? 'New Notification' }}</p>
                                    <p class="mb-0">
                                        <i class="mdi mdi-clock-outline"></i>
                                        {{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center p-3">No new notifications</p>
                @endforelse
            </div>
            <div class="p-2 border-top">
                <div class="d-grid">
                    <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                        <i class="mdi mdi-arrow-right-circle me-1"></i> Close..
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
