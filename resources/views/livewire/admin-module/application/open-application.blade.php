<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Application View</h4>

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
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Application</a></li>
                        <li class="breadcrumb-item"><a href="#">View</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('view.application',$Id) }}">{{ $Name }}</a></li>
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
            <li class="breadcrumb-item"><a href="{{ route('update_application') }}">Update</a></li>
            <li class="breadcrumb-item"><a href="{{ route('Credit') }}">Credit</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    <div class="row"> {{-- Start of Insight on Service Row --}}
        <a href="#" class="col-xl-3 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1 align-items-center">
                            <h5 class="text-truncate text-primary font-size-20 mb-2">{{ $Name }}</h5>
                            <div class="col-8">
                                <div class="text-center mt-8">
                                    <h5>Applied {{ $count_app }}</h5>
                                    <p class="mb-2 text-truncate">Deleted {{ $app_deleted }} Applications</p>
                                </div>
                            </div>
                        </div>
                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" <img
                            class="d-flex me-3 rounded-circle img-thumbnail avatar-lg"
                            src="{{ $Profile_Image != 'Not Available' ? asset('storage/' . $Profile_Image) : url('storage/no_image.jpg') }}"
                            alt="Profile">
                    </div>
                </div>
            </div>
        </a>
        {{-- Applications Deliverd --}}
        <a href="#" class="col-xl-3 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1 align-items-center">
                            <h5 class="text-truncate text-warning font-size-20 mb-2">Applications Deliverd</h5>
                            <div class="col-8">
                                <div class="text-center mt-8">
                                    <h5>Delivered : {{ $app_delivered }}</h5>
                                    <p class="mb-2 text-truncate">Pending {{ $app_pending }}</p>
                                </div>
                            </div>
                        </div>
                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg"
                            src="{{ url('storage/delivered.png') }}" alt="">

                    </div>
                </div>
            </div>
        </a>
        {{-- Revenue Earned --}}
        <a href="#" class="col-xl-3 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1 align-items-center">
                            <h5 class="text-truncate text-info font-size-20 mb-2">Revenue Earned</h5>
                            <div class="col-8">
                                <div class="text-center mt-8">
                                    <h5 class="text-green"> Total &#x20B9; {{ $total }}/-</h5>
                                    <p class="mb-2 text-truncate text-danger"> Balance <span> &#x20B9;{{ $balance }}</span>
                                    </p>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg"
                            src="{{ url('storage/Revenue.png') }}" alt="">
                    </div>
                </div>
            </div>
        </a>
        {{-- Balance Due --}}
        <a href="#" class="col-xl-3 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1 align-items-center">
                            <h5 class="text-truncate text-danger font-size-20 mb-2">Balance Due</h5>
                            <div class="col-8">
                                <div class="text-center mt-8">
                                    <h5>Payble &#x20B9; {{ $balance }}/-</h5>
                                    <p class="mb-2 text-truncate">Paid <span> &#x20B9;{{ $total-$balance }}</span>
                                    </p>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg"
                            src="{{ url('storage/Revenue.png') }}" alt="">

                    </div>
                </div>
            </div>
        </a>
    </div> {{-- End of Row --}}


    {{-- Data View Container --}}
    <div class="row">
        <div class="col-lg-7 col-md-12">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between">
                    <h2 class="card-title mb-4 fs-4">Application Details of <span>{{ $Name }}</span></h2>
                    <h3 class="card-title mb-4">
                        <a id="editData" href="{{ route('edit_application', $Id) }}">
                            <i class="ri-refresh-line"></i> Edit Application
                        </a>
                    </h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- First Column for Labels -->
                        <div class="col-md-3">
                            <p class="fw-bold fs-4">Client ID</p>
                            <p class="fw-bold fs-4">Application ID</p>
                            <p class="fw-bold fs-4">Applied Date</p>
                            <p class="fw-bold fs-4">Phone Number</p>
                            <p class="fw-bold fs-4">Date of Birth</p>
                            <p class="fw-bold fs-4">Ack. No</p>
                            <p class="fw-bold fs-4">Document No</p>
                            <p class="fw-bold fs-4">Status</p>
                            <p class="fw-bold fs-4">Reason</p>
                        </div>

                        <!-- Second Column for Values -->
                        <div class="col-md-3 text-primary fs-4">
                            <p>{{ $Client_Id }}</p>
                            <p class="fw-bold">{{ $Id }}</p>
                            <p class="text-info">
                                {{ \Carbon\Carbon::parse($Applied_Date)->diffForHumans() }}
                                <small>{{ \Carbon\Carbon::parse($Applied_Date)->format('d-m-Y') }}</small>
                            </p>
                            <p>{{ $Mobile_No }}</p>
                            <p>{{ \Carbon\Carbon::parse($Dob)->format('d-m-Y') }}</p>
                            <p><a href="{{ route('download_ack', $Id) }}">{{ $Ack_No }}</a></p>
                            <p><a href="{{ route('download_doc', $Id) }}">{{ $Document_No }}</a></p>
                            <p class="fw-bolder">{{ $Status }}</p>
                            <p>{{ $Reason }}</p>
                        </div>

                        <!-- Third Column for Labels -->
                        <div class="col-md-3">
                            <p class="fw-bold fs-4">Service</p>
                            <p class="fw-bold fs-4">Service Type</p>
                            <p class="fw-bold fs-4">Received Date</p>
                            <p class="fw-bold fs-4">Total Amount</p>
                            <p class="fw-bold fs-4">Amount Paid</p>
                            <p class="fw-bold fs-4">Balance</p>
                            <p class="fw-bold fs-4">Payment Mode</p>
                            <p class="fw-bold fs-4">Updated On</p>
                            <p class="fw-bold fs-4">Delivered In</p>
                        </div>

                        <!-- Fourth Column for Values -->
                        <div class="col-md-3 text-primary fs-4">
                            <p class="text-success">{{ $Application }}</p>
                            <p class="text-danger">{{ $Application_Type }}</p>
                            <p>
                                {{ \Carbon\Carbon::parse($Received_Date)->diffForHumans() }}
                                <small>{{ \Carbon\Carbon::parse($Received_Date)->format('d-m-Y') }}</small>
                            </p>
                            <p>&#x20B9;{{ $Total_Amount }}.00/-</p>
                            <p>&#x20B9;{{ $Amount_Paid }}.00/-</p>
                            <p class="fw-bolder text-danger">&#x20B9;{{ $Balance }}.00/-</p>
                            <p>{{ $PaymentMode }}</p>
                            <p>
                                {{ \Carbon\Carbon::parse($updated_at)->diffForHumans() }}
                                <small>{{ \Carbon\Carbon::parse($updated_at)->format('d-m-Y') }}</small>
                            </p>
                            <p class="text-success">{{ \Carbon\Carbon::parse($Received_Date)->diffInDays(\Carbon\Carbon::parse($Delivered_Date)) }} Days</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4 text-center">
                        <div class="col-lg-12">
                            <a href="{{ route('edit_application', $Id) }}" class="btn btn-success  btn-rounded"> Edit Application</a>
                            <a href="{{ route('download_doc', $Id) }}" class="btn btn-warning  btn-rounded">Download</a>
                            <a href="{{ route('new.application') }}" class="btn btn-info  btn-rounded">New Application</a>
                        </div>
                    </div>
                </div>
            </div>

                {{-- End --}}
                <div class="row"></div>
                {{-- End --}}
            {{-- End of Data View Container --}}
        </div>
        {{-- ------------------------------------------------ --}}
        {{-- Document List Table  --}}
        @if (count($Doc_Files) > 0)
        <div class="col-lg-5 col-md-12">
            <div class="card shadow-sm border-0">
                <h5 class="card-header bg-primary text-white">Available Documents</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Document Name</th>
                                    <th>Uploaded on</th>
                                    <th>Actions</th> {{-- Merged Download & Delete --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Doc_Files as $index => $File)
                                    <tr>
                                        <td>{{ $Doc_Files->firstItem() + $index }}</td>
                                        <td>{{ Str::title($File->Document_Name) }}</td>
                                        <td>{{ $File->created_at->diffForHumans()}} | {{ $File->created_at->format('F d, Y')}}</td>

                                        <td>
                                            <a class="btn btn-outline-primary btn-sm mx-1" id="download"
                                                href="{{ route('download_documents', $File->Id) }}"
                                            title="Download" >
                                                <i class="mdi mdi-download"></i>
                                            </a>

                                            <a class="btn btn-outline-danger btn-sm mx-1" id="deleteFile" funName="delete" recId = "{{ $File->Id }}"
                                            title="Delete" >
                                                <i class="ri-delete-bin-6-line"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination & Entries Info --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <p class="text-muted mb-0">Showing {{ count($Doc_Files) }} of {{ $Doc_Files->total() }} entries</p>
                            <span class="pagination pagination-rounded">
                                {{ $Doc_Files->links() }}
                            </span>
                        </div>
                    </div>

                    {{-- Last Uploaded File Info --}}
                    <p class="card-text text-end mt-2">
                        <small class="text-muted">Last File Uploaded: {{ $created }}</small>
                    </p>
                </div>
            </div>
        </div>
        @endif {{-- End of Table --}}
    </div>
    {{-- End of Row --}}

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <h5 class="card-header bg-primary text-white">Application History</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover mb-0">
                            <thead class="table-dark text-white">
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Action</th>
                                    <th>Branch</th>
                                    <th>Operator</th>
                                    <th>Service</th>
                                    <th>Service Type</th>
                                    <th>Status</th>
                                    <th>Reason</th>
                                    <th>Updated On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($History as $File)
                                    <tr>
                                        <td>{{ $History->firstItem() + $loop->index }}</td>
                                        <td>{{ $File->action }}</td>
                                        <td>{{ $File->branch->name }}</td>
                                        <td>{{ $File->employee->Name }}</td>
                                        <td>{{ $File->application }}</td>
                                        <td>{{ $File->application_type }}</td>
                                        <td>
                                            <span class="badge
                                                @if($File->status == 'Approved') bg-success
                                                @elseif($File->status == 'Pending') bg-warning
                                                @else bg-danger @endif">
                                                {{ $File->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $File->reason }}">
                                                {{ Str::limit($File->reason, 30) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span data-bs-toggle="tooltip" title="{{ $File->updated_at }}">
                                                {{ \Carbon\Carbon::parse($File->updated_at)->diffForHumans() }}
                                            </span>
                                            <br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($File->updated_at)->format('d-m-Y') }}</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $History->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
