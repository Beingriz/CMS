<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Details for {{ $search }} </h4>

                @if (session('SuccessMsg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('SuccessMsg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('SuccessUpdate'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('SuccessUpdate') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('Error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('Error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Digital Cyber</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('new.application') }}">New Form</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('Dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('add_services') }}">Services</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.status') }}">Status</a></li>
            <li class="breadcrumb-item"><a href="{{ route('Credit') }}">Credit</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}
    <div class="row">
        {{-- Start of Insight Row --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="text-primary font-size-20 mb-2">Services</h5>
                        <div class="text-center">
                            <h5 class="fw-bold">Applied {{ $Service_Count }}</h5>
                            <p><a href="#" wire:click.prevent="ApplicationsbyStatus('Received')" class="text-warning fw-bold">Pending {{ $Pending_App }} Applications</a></p>
                        </div>
                    </div>
                    <img class="rounded-circle avatar-md" src="{{ asset('storage/service.jpg') }}" alt="Service">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="text-info font-size-20 mb-2">Delivery Report</h5>
                        <div class="text-center">
                            <h5><a href="#" wire:click.prevent="ApplicationsbyStatus('Delivered to Client')" class="text-success fw-bold">Delivered {{ $Delivered }}</a></h5>
                            <p><a href="#" wire:click.prevent="ApplicationsbyStatus('Received')" class="text-warning fw-bold">Pending {{ $Pending_App }} Applications</a></p>
                        </div>
                    </div>
                    <img class="rounded-circle avatar-md" src="{{ url('storage/delivered.png') }}" alt="Delivery">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="text-success font-size-20 mb-2">Revenue</h5>
                        <div class="text-center">
                            <h5 class="fw-bold">&#x20B9;{{ $Revenue }}/-</h5>
                            <p class="text-danger fw-bold">Balance: &#x20B9;{{ $Balance }}</p>
                        </div>
                    </div>
                    <img class="rounded-circle avatar-md" src="{{ url('storage/revenue_2.png') }}" alt="Revenue">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="text-danger font-size-20 mb-2">Balance Due</h5>
                        <div class="text-center">
                            <h5 class="fw-bold">Payable: &#x20B9; {{ $Balance }}/-</h5>
                            <p class="text-success fw-bold">Received: &#x20B9;{{ $Revenue }}</p>
                        </div>
                    </div>
                    <img class="rounded-circle avatar-md" src="{{ url('storage/balance.png') }}" alt="Balance Due">
                </div>
            </div>
        </div>

        @if (count($Registered) == 0)
            <div class="col-12 text-center mt-3">
                <div class="alert alert-warning d-inline-block" role="alert">
                    <i class="mdi mdi-alert-outline me-2"></i>
                    Unregistered Client! Please Register.. {{ $search }}
                </div>
            </div>
        @endif

        @if (count($Registered) > 0)
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="card-title">{{ $Registered_Count }} Registered Clients for <span class="text-primary fw-bold">{{ $Name }}</span></h4>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Relative Name</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>Profile</th>
                                        <th>Registered</th>
                                        <th>Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Registered as $item)
                                        <tr>
                                            <td>{{ $n++ }}</td>
                                            <td>{{ $item['Id'] }}</td>
                                            <td>{{ $item['Name'] }}</td>
                                            <td>{{ $item['Relative_Name'] ?? 'Not Available' }}</td>
                                            <td>{{ $item['DOB'] ?? 'Not Available' }}</td>
                                            <td>{{ $item['Gender'] ?? 'Not Available' }}</td>
                                            <td>
                                                <a href="tel:+91{{ $item['Mobile_No'] }}" class="btn btn-warning btn-sm">Call</a>
                                                <a href="whatsapp://send?phone=+91{{ $item['Mobile_No'] }}" class="btn btn-success btn-sm">WhatsApp</a>
                                            </td>
                                            <td>{{ $item['Address'] ?? 'Not Available' }}</td>
                                            <td>
                                                <img src="{{ !empty($item['Profile_Image']) ? url('storage/' . $item['Profile_Image']) : url('storage/no_image.jpg') }}" class="rounded-circle avatar-md" alt="Profile">
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item['created_at'])->diffForHumans() }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item['updated_at'])->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('edit_profile', $item['Id']) }}" class="btn btn-primary btn-sm"><i class="mdi mdi-account-edit"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>


    <div class="row">{{-- Start of Balance Details Row --}}
        @if (count($Balance_Collection) > 0)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Bordered Table</h4>
                        <p class="card-title-desc">Add <code>.table-bordered</code> for borders on all sides of the
                            table and cells.</p>

                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Description</th>
                                        <th>Total</th>
                                        <th>Amount Paid</th>
                                        <th>Balance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Balance_Collection as $item)
                                        <tr>
                                            <td style="width:10%">{{ $item['Id'] }}</td>
                                            <td style="width:40%">{{ $item['Description'] }}</td>
                                            <td style="width:10%">&#x20B9; {{ $item['Total_Amount'] }}</td>
                                            <td style="width:10%">&#x20B9; {{ $item['Amount_Paid'] }}</td>
                                            <td style="width:10%">&#x20B9; {{ $item['Balance'] }}</td>
                                            <td style="width:20%">
                                                <a href="#"
                                                    onclick="confirm('Do you Want to Clear the Balance of &#x20B9;{{ $item['Balance'] }}? ') || event.stopImmediatePropagation()"
                                                    wire:click.prevent="ClearBalanceDue('{{ $item['Id'] }}','{{ $item['Client_Id'] }}')">Clear
                                                    Balance</a>
                                                <br>
                                                <a href="#"
                                                    wire:click.prevent="MoveRecycle('{{ $item['Id'] }}','{{ $item['Client_Id'] }}')">Move
                                                    to Recycle</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <div class="header" style="text-align:center">
                                        <span class="important"> Balance Due Found for This ID : {{ $item->Id }}
                                            Records!. Total Balance Due :
                                            &#x20B9;{{ $Balance_Collection->sum('Balance') }}</span>
                                    </div>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="row"> {{-- Start of Search Result Details Row --}}
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title text-primary">📊 {{ $Service_Count }} Search Results Found</h4>
                        <h4 class="card-title">🔍 Status: <span class="badge bg-info">{{ !is_null($Status) ? $Status : 'All' }} ({{ $StatusCount }})</span></h4>
                    </div>

                    <div class="filter-bar mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                @if ($Checked)
                                    <div class="btn-group">
                                        <button class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown">
                                            🗑 Checked ({{ count($Checked) }})
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item text-danger"
                                                onclick="confirm('Move selected records to Recycle Bin?') || event.stopImmediatePropagation()"
                                                wire:click="MultipleDelete()">Delete</a>
                                        </div>
                                    </div>
                                @endif

                                <label class="text-nowrap">Per Page</label>
                                <select wire:model="paginate" class="form-select form-select-sm">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                </select>

                                <label class="text-nowrap">By Status</label>
                                <select wire:change="ApplicationsbyStatus(event.target.value)" class="form-select form-select-sm">
                                    <option selected>Select Status</option>
                                    @foreach ($status_list as $status)
                                        <option value="{{ $status->Status }}">{{ $status->Status }}</option>
                                    @endforeach
                                </select>

                                <label class="text-nowrap">Sort By</label>
                                <input type="text" wire:model="filterby" class="form-control form-control-sm" placeholder="Filter">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Received</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Application</th>
                                    <th>Services</th>
                                    <th>Ref No</th>
                                    <th>Document</th>
                                    <th>Status</th>
                                    <th>Profile</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($search_data as $data)
                                    <tr>
                                        <td>{{ $search_data->firstItem() + $loop->index }}</td>
                                        <td>{{ $data->Received_Date }}</td>
                                        <td>{{ $data->Name }}</td>
                                        <td><a href="tel:+91{{ $data->Mobile_No }}" class="text-decoration-none">📞 {{ $data->Mobile_No }}</a></td>
                                        <td>{{ $data->Application }}</td>
                                        <td>{{ $data->Application_Type }}</td>
                                        <td>{{ $data->Ack_No }}</td>
                                        <td>{{ $data->Document_No ?? 'Not Available' }}</td>
                                        <td>
                                            <select wire:change="UpdateStatus('{{ $data->Id }}', event.target.value)" class="form-select form-select-sm">
                                                <option selected>{{ $data->Status }}</option>
                                                @foreach ($status_list as $status)
                                                    <option value="{{ $status->Status }}">{{ $status->Status }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <img src="{{ !empty($data['Applicant_Image']) && $data['Applicant_Image'] !== 'Not Available' ? url('storage/' . $data['Applicant_Image']) : url('storage/no_image.jpg') }}" alt="Profile" class="rounded-circle avatar-md">
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                    @if ($data->Registered == 'No')
                                                        Register <i class="mdi mdi-shield-account"></i>
                                                    @elseif($data->Registered == 'Yes')
                                                        Action <i class="mdi mdi-square-edit-outline"></i>
                                                    @endif
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if ($data->Registered == 'No')
                                                        <a class="dropdown-item text-success" onclick="confirm('Register {{ $data->Name }} ({{ $data->Mobile_No }})?') || event.stopImmediatePropagation()" wire:click="Register('{{ $data->Id }}')">Register</a>
                                                    @endif
                                                    <a class="dropdown-item" id="open" href={{ route('view.application', [$data->Id]) }}>🔍 View</a>
                                                    <a class="dropdown-item text-warning" id="editData" href="{{ route('edit_application', $data->Id) }}">✏ Edit</a>
                                                    <a class="dropdown-item text-info" href="tel:+91{{ $data->Mobile_No }}">📞 Call</a>
                                                    <a class="dropdown-item text-success" href="whatsapp://send?phone=+91{{ $data->Mobile_No }}">📩 Message</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">
                                            <img class="avatar-xl" alt="No Result" src="{{ asset('storage/no_result.png') }}">
                                            <p>No Result Found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between mt-3">
                            <p class="text-muted">Showing {{ count($search_data) }} of {{ $search_data->total() }} entries</p>
                            <div class="pagination pagination-rounded">{{ $search_data->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
