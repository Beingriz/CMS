<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="row">
        {{-- For User Data records --}}
        @if ($User)
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $records->total() }} Users for this Month</h4>
                    </div>
                </div>
            </div>

            @foreach ($records as $item)
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-sm-flex align-items-center justify-content-between">
                            <h5 class="card-title {{ $item->role == 'admin' ? 'text-info text-bold' : '' }}">
                                {{ $item->name }}: {{ $item->role }}
                            </h5>
                            <h5 class="card-title">
                                {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                            </h5>
                            <h5 class="card-title {{ $item->role == 'admin' ? 'text-info text-bold' : '' }}">
                                {{ $item->Client_Id }}
                            </h5>
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-3">
                                <img class="img-thumbnail rounded-circle avatar-xl" alt="100x100"
                                    src="{{ !empty($item->profile_image) ? asset('storage/' . $item->profile_image) : url('storage/no_image.jpg') }}"
                                    data-holder-rendered="true">
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    <h5 class="card-title">Email: {{ $item->email }}</h5>
                                    <h5 class="card-title">Mobile: {{ $item->mobile_no }}</h5>
                                    <h5 class="card-title">Username: {{ $item->username }}</h5>

                                    @if ($item->role == 'user')
                                        <a href="" data-bs-placement="top" data-bs-toggle="tooltip"
                                            class="btn btn-sm btn-rounded btn-primary"
                                            data-bs-original-title="Change User role to Admin"
                                            aria-label="Info" wire:click.prevent="UpdateAdmin('{{ $item->id }}')">Admin</a>
                                        <a href="{{ route('global_search', $item->mobile_no) }}" data-bs-placement="top"
                                            data-bs-toggle="tooltip" class="btn btn-sm btn-rounded btn-info"
                                            data-bs-original-title="Get Insight Details"
                                            aria-label="Info">Get Details</a>
                                        <a href="{{ route('wa.great', $item->mobile_no) }}" data-bs-placement="top"
                                            data-bs-toggle="tooltip" class="btn btn-sm btn-rounded btn-info"
                                            data-bs-original-title="Send WhatsApp Message"
                                            aria-label="Info">WhatsApp</a>
                                    @elseif($item->role == 'admin' && Auth::user()->id != $item->id)
                                        <a href="" data-bs-placement="top" data-bs-toggle="tooltip"
                                            class="btn btn-sm btn-rounded btn-primary"
                                            data-bs-original-title="Change Admin role to User"
                                            aria-label="Info" wire:click.prevent="UpdateUser('{{ $item->id }}')">User</a>
                                    @endif

                                    <p class="card-text"><small class="text-muted">Registered:
                                        {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }} ago</small>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-body">
                                    <p class="card-text">Address: {{ $item->address }}</p>
                                    <p class="card-text"><small class="text-muted">Updated:
                                        {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }} ago</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{ $records->links() }}

        {{-- For Apply now Data records --}}
        @elseif($Orders)
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $records->total() }} Orders Pending for this Month</h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Applications Overview</h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Profile</th>
                                        <th>Applicant Details</th>
                                        <th>Application Info</th>
                                        <th>Contact & Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($records as $index => $item)
                                        <tr>
                                            {{-- SL No --}}
                                            <td>{{ $loop->iteration }}</td>

                                            {{-- Profile --}}
                                            <td class="text-center">
                                                <img class="img-thumbnail rounded-circle avatar-md mb-2"
                                                    src="{{ !empty($item->profile_image) ? asset('storage/' . $item->profile_image) : url('storage/no_image.jpg') }}"
                                                    alt="Profile">

                                                <div>
                                                    <strong>{{ $item->name }}</strong><br>
                                                    <small>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small><br>
                                                    <small>ID: {{ $item->client_id }}</small>
                                                </div>
                                            </td>

                                            {{-- Applicant Details --}}
                                            <td>
                                                <p><strong>Relative:</strong> {{ $item->relative_name }}</p>
                                                <p><strong>Mobile:</strong> {{ $item->mobile_no }}</p>
                                                <p><strong>DOB:</strong> {{ $item->dob }}</p>
                                            </td>

                                            {{-- Application Info --}}
                                            <td>
                                                <p><strong>Service:</strong> {{ $item->application }}</p>
                                                <p><strong>Type:</strong> {{ $item->application_type }}</p>
                                                <p><strong>Status:</strong> <span class="badge bg-info">{{ $item->status }}</span></p>
                                                <p><strong>Consent:</strong> {{ Str::limit($item->user_consent, 50) }}</p>
                                                <small class="text-muted">Updated {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</small>
                                            </td>

                                            {{-- Actions --}}
                                            <td class="text-center">
                                                <a href="{{ route('edit_application', $item->id) }}"
                                                    class="btn btn-sm btn-primary mb-1"
                                                    data-bs-toggle="tooltip" title="Edit">
                                                    <i class="mdi mdi-pencil"></i>Edit
                                                </a><br>

                                                <a href="{{ route('global_search', $item->mobile_no) }}"
                                                    class="btn btn-sm btn-info mb-1"
                                                    data-bs-toggle="tooltip" title="Details">
                                                    <i class="mdi mdi-account-search"></i>Search
                                                </a><br>

                                                <a href="{{ route('wa.applynow', [$item->mobile_no, $item->name, $item->application, $item->application_type]) }}"
                                                    class="btn btn-sm btn-success mb-1"
                                                    data-bs-toggle="tooltip" title="WhatsApp">
                                                    <i class="mdi mdi-whatsapp"></i>WhatsApp
                                                </a><br>

                                                <a href="tel:+91{{ $item->mobile_no }}"
                                                    class="btn btn-sm btn-warning"
                                                    data-bs-toggle="tooltip" title="Call">
                                                    <i class="mdi mdi-phone"></i>Call
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No records found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Optional Pagination --}}
                        <div class="d-flex justify-content-end mt-3">
                            {{ $records->links() }}
                        </div>
                    </div>
                </div>
            </div>


            {{ $records->links() }}

        {{-- For Callback Data records --}}
        @elseif($Callback)
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $records->total() }} Callback Requests Pending for this Month</h4>
                    </div>
                </div>
            </div>

            @foreach ($records as $item)
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-sm-flex align-items-center justify-content-between">
                            <h5 class="card-title">{{ $item->Name }}</h5>
                            <h5 class="card-title">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</h5>
                            <h5 class="card-title">{{ $item->Client_Id }}</h5>
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-3">
                                <img class="img-thumbnail rounded-circle avatar-xl" alt="100x100"
                                    src="{{ !empty($item->Profile_Image) ? asset('storage/' . $item->Profile_Image) : url('storage/no_image.jpg') }}"
                                    data-holder-rendered="true">
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    <h5 class="card-title">Service: {{ $item->Service }}</h5>
                                    <h5 class="card-title">Type: {{ $item->Service_Type }}</h5>
                                    <h5 class="card-title">Status: {{ $item->Status }}</h5>
                                    <a href="{{ route('update.cb.status', [$item->Id, $item->Client_Id, $item->Name]) }}"
                                        data-bs-placement="top" data-bs-toggle="tooltip"
                                        class="btn btn-sm btn-rounded btn-primary"
                                        data-bs-original-title="Change Status"
                                        aria-label="Info">Status</a>
                                    <a href="{{ route('global_search', $item->Mobile_No) }}" data-bs-placement="top"
                                        data-bs-toggle="tooltip" class="btn btn-sm btn-rounded btn-info"
                                        data-bs-original-title="Get {{ $item->Name }} Details"
                                        aria-label="Info">Details</a>
                                    <a href="{{ route('wa.callback', [$item->Mobile_No, $item->Name, $item->Service, $item->Service_Type]) }}"
                                        data-bs-placement="top" data-bs-toggle="tooltip"
                                        class="btn btn-sm btn-rounded btn-success"
                                        data-bs-original-title="Send WhatsApp Message"
                                        aria-label="Info">WhatsApp</a>
                                    <a href="tel:+91{{ $item->Mobile_No }}" data-bs-placement="top"
                                        data-bs-toggle="tooltip" class="btn btn-sm btn-rounded btn-warning"
                                        data-bs-original-title="Call {{ $item->Name }}"
                                        aria-label="Info">Call</a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-body">
                                    <h5 class="card-title">Phone No: {{ $item->Mobile_No }}</h5>
                                    <p class="card-text">Message: {{ $item->Message }}</p>
                                    <p class="card-text"><small class="text-muted">Updated:
                                        {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }} ago</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{ $records->links() }}

        {{-- For Enquiry Data records --}}
        @elseif($Enquiry)
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $records->total() }} Enquiries Pending for this Month</h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-light text-white">
                        <h5 class="mb-0">Enquiries (Total: {{ $records->count() }})</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center align-middle">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>#</th>
                                        <th>Name / ID</th>
                                        <th>Phone</th>
                                        <th>Service</th>
                                        <th>Status</th>
                                        <th>Lead</th>
                                        <th>Conversion</th>
                                        <th>Message</th>
                                        <th>Feedback</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($records as $index => $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $item->Name }}</strong><br>
                                                <small class="text-muted">ID: {{ $item->Id }}</small>
                                            </td>
                                            <td>+91 {{ $item->Phone_No }}</td>
                                            <td>{{ $item->Service }}</td>
                                            <td>
                                                <span class=" badge-{{ $item->Status == 'Completed' ? 'success' : 'warning' }}">
                                                    {{ $item->Status }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class=" badge-{{ $item->Lead_Status == 'Hot' ? 'danger' : 'warning' }}">
                                                    {{ $item->Lead_Status }}
                                                </span>
                                            </td>
                                            <td>{{ $item->Conversion }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($item->Message, 30) }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($item->Feedback, 30) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                                            <td>
                                                <a id="editData" href="{{ route('update.enquiry.dashboard', $item->Id) }}" class="btn btn-sm btn-primary mb-1" data-toggle="tooltip" title="Update Status">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ route('global_search', $item->Phone_No) }}" class="btn btn-sm btn-info mb-1" data-toggle="tooltip" title="View Details">
                                                    <i class="fa fa-search"></i>
                                                </a>

                                                </a>
                                                <a href="tel:+91{{ $item->Phone_No }}" class="btn btn-sm btn-warning text-white mb-1" data-toggle="tooltip" title="Call Now">
                                                    <i class="fa fa-phone"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-muted">No records found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Optional pagination section --}}
                        {{-- If using Laravel pagination, uncomment below --}}
                        {{-- <div class="d-flex justify-content-between align-items-center mt-3">
                            <p class="text-muted mb-0">Showing {{ $records->count() }} of {{ $records->total() }} entries</p>
                            <nav>
                                {{ $records->links('pagination::bootstrap-4') }}
                            </nav>
                        </div> --}}
                    </div>
                </div>
            </div>



            {{ $records->links() }}

        {{-- For Applications Data records --}}
        @else
            @foreach ($records as $item)
                <div class="col-lg-6">
                    <div class="card">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-3">
                                <img class="img-thumbnail rounded-circle avatar-xl" alt="100x100"
                                    src="{{ asset('storage/no_image.jpg') }}" data-holder-rendered="true">
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->Name }}</h5>
                                    <p class="card-text">This is a wider card with supporting text below as
                                        a natural lead-in to additional content.</p>
                                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->Name }}</h5>
                                    <p class="card-text">This is a wider card with supporting text below as
                                        a natural lead-in to additional content.</p>
                                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{ $records->links() }}
        @endif
    </div>
</div>
