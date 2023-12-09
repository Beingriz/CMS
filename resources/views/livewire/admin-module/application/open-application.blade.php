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
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Digital Cyber</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('new.application') }}">Application</a></li>
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
        <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-header d-sm-flex align-items-center justify-content-between">
                        <h2 class="card-title mb-4">Application Details of <span>{{ $Name }}</h2>
                        <h3 class="card-title mb-4"><a href="{{ route('edit_application', $Id) }}"><i
                                    class="ri-refresh-line"></i> Edit Applicaiton</a>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            {{-- First Half Data Display --}}
                            <div class="col-md-6 col-lg-6">
                                <!-- Client Id  -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18 ">Client ID</span>
                                    </div>
                                    <div class="col-55">
                                        <span class="imp-label font-size-18">{{ $Client_Id }}</span>
                                    </div>
                                </div>

                                <!-- Application Id  -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18">Application ID</span>
                                    </div>
                                    <div class="col-55">
                                        <span
                                            class="text-primary font-weight-bolder font-size-18">{{ $Id }}</span>
                                    </div>
                                </div>



                                <!-- Applied Date -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18">Applied Date</span>
                                    </div>
                                    <div class="col-55">
                                        <span class="text-primary font-weight-bolder font-size-18">
                                            {{ \Carbon\Carbon::parse($Applied_Date)->diffForHumans() }} on
                                            {{ \Carbon\Carbon::parse($Applied_Date)->format('d-m-Y') }}</span>
                                    </div>
                                </div>

                                <!-- Mobile No -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18">Phone Number</span>
                                    </div>
                                    <div class="col-55">
                                        <span
                                            class="text-primary font-weight-bolder font-size-18">{{ $Mobile_No }}</span>
                                    </div>
                                </div>

                                <!-- DOB -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18">Date of Birth</span>
                                    </div>
                                    <div class="col-55">
                                        <span
                                            class="text-primary font-weight-bolder  font-size-18">{{ \Carbon\Carbon::parse($Dob)->format('d-m-Y') }}</span>
                                    </div>
                                </div>
                                <!-- Ack No -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18">Ack..</span>
                                    </div>
                                    <div class="col-55">
                                        <span class="text-primary font-weight-bolder font-size-18"><a
                                                href="{{ route('download_ack', $Id) }}" id="download"
                                                class="label">{{ $Ack_No }}</a></span>
                                    </div>
                                </div>
                                <!-- Document No -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18">Document No</span>
                                    </div>
                                    <div class="col-55">
                                        <span class="text-primary font-weight-bolder font-size-18"> <a
                                                href="{{ route('download_doc', $Id) }}" id="download"
                                                class="label">{{ $Document_No }}</a></span>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18">Status</span>
                                    </div>
                                    <div class="col-55">
                                        <span class="text-primary font-weight-bolder font-size-18">
                                            {{ $Status }}</span>
                                    </div>
                                </div>
                            </div>
                            {{-- End --}}

                            {{-- Second Half Data Display --}}
                            <div class="col-md-6 col-lg-6">

                                <!-- Application Type -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18">Service</span>
                                    </div>
                                    <div class="col-55">
                                        <span
                                            class="text-primary font-weight-bolder  font-size-18">{{ $Application }}</span>
                                    </div>
                                </div>
                                <!-- Service Type -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18">Service Type</span>
                                    </div>
                                    <div class="col-55">
                                        <span class="text-primary font-weight-bolder font-size-18">
                                            {{ $Application_Type }}</span>
                                    </div>
                                </div>
                                <!-- Received_Date -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18">Received Date</span>
                                    </div>
                                    <div class="col-55">
                                        <span class="text-primary font-weight-bolder font-size-18">
                                            {{ \Carbon\Carbon::parse($Received_Date)->diffForHumans() }} on
                                            {{ \Carbon\Carbon::parse($Received_Date)->format('d-m-Y') }} </span>
                                    </div>
                                </div>

                                <!-- Total_Amount -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18">Total Amount</span>
                                    </div>
                                    <div class="col-55">
                                        <span class="text-primary font-weight-bolder font-size-18">
                                            &#x20B9;{{ $Total_Amount }}.00/-</span>
                                    </div>
                                </div>
                                <!-- Amount_Paid -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18">Amount Paid</span>
                                    </div>
                                    <div class="col-55">
                                        <span class="text-primary font-weight-bolder font-size-18">
                                            &#x20B9;{{ $Amount_Paid }}.00/-</span>
                                    </div>
                                </div>
                                <!-- Balance -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18">Balance</span>
                                    </div>
                                    <div class="col-55">
                                        <span class="imp-label font-weight-bolder font-size-18">
                                            &#x20B9;{{ $Balance }}.00/-</span>
                                    </div>
                                </div>
                                <!-- PaymentMode -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18">PaymentMode</span>
                                    </div>
                                    <div class="col-55">
                                        <span class="text-primary font-weight-bolder font-size-18">
                                            {{ $PaymentMode }}</span>
                                    </div>
                                </div>
                                <!-- Updated -->
                                <div class="row">
                                    <div class="col-45">
                                        <span class="font-size-18">Updated On</span>
                                    </div>
                                    <div class="col-55">
                                        <span
                                            class="text-primary font-weight-bolder font-size-18">{{ \Carbon\Carbon::parse($updated_at)->diffForHumans() }}
                                            on {{ \Carbon\Carbon::parse($updated_at)->format('d-m-Y') }}</span>
                                        <p>Delivered in
                                            {{ \Carbon\Carbon::parse($Received_Date)->diffInDays(\Carbon\Carbon::parse($Delivered_Date)) }}
                                            Days</p>

                                    </div>
                                </div>

                            </div>
                            {{-- End --}}
                        </div>
                        <div class="row ">
                            <div class="col-md-6 col-lg-12 justify-center">
                                <a href="{{ route('edit_application', $Id) }}"
                                    class="btn btn-success btn-sm btn-rounded">Edit</a>
                                <a href="{{ route('download_doc', $Id) }}" id="download"
                                    class="btn btn-warning btn-sm btn-rounded">Download</a>
                                <a href="{{ route('new.application') }}" class="btn btn-sm btn-rounded">New</a>
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
            <div class="col-lg-4">
                <div class="card">
                    <h5 class="card-header">Available Documents </h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="d-flex flex-wrap gap-2">
                                @if ($Checked)
                                    <div class="btn-group-vertical" role="group"
                                        aria-label="Vertical button group">
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupVerticalDrop2" type="button"
                                                class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                Cheched ({{ count($Checked) }}) <i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2"
                                                style="">
                                                <a class="dropdown-item" title="Multiple Delete"
                                                    onclick="confirm('Are you sure you want to Delete these records Permanently!!') || event.stopImmediatePropagation()"
                                                    wire:click="MultipleDelete()">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Select</th>
                                        <th>Name</th>
                                        <th>Download</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Doc_Files as $File)
                                        <tr>
                                            <td>{{ $Doc_Files->firstItem() + $loop->index }}</td>
                                            <td><input type="checkbox" id="checkbox" name="checkbox"
                                                    value="{{ $File->Id }}" wire:model="Checked"></td>

                                            <td>{{ $File->Document_Name }}</td>
                                            <td>
                                                <a class="btn btn-light font-size-20" id="download"
                                                    href="{{ route('download_documents', $File->Id) }}"><i
                                                        class="mdi mdi-download"></i></a>

                                            </td>
                                            <td>
                                                <a class="btn btn-danger font-size-15" id="deletefile"
                                                    href="{{ route('delete_document', $File->Id) }}"><i
                                                        class=" ri-delete-bin-6-line"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                    <p class="text-muted">Showing {{ count($Doc_Files) }} of
                                        {{ $Doc_Files->total() }} entries</p>
                                </div>
                                <div class="col-md-4">
                                    <span class=" pagination pagination-rounded float-end">
                                        {{ $Doc_Files->links() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <p class="card-text"><small class="text-muted">Last File Uploaded
                                {{ $created }}</small></p>
                    </div>
                </div>
            </div>
        @endif {{-- End of Table --}}
    </div>
</div>
