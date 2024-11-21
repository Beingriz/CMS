<div>{{-- Livewire Edit Application by Id   --}}

    <div class="row">{{-- Messags / Notification Row --}}
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Application of <span class="text-primary">{{ $Name }}</span> </h4>
                @if (session('SuccessMsg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('SuccessMsg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('SuccessUpdate'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
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
                        <li class="breadcrumb-item"><a href="{{ route('new.application') }}">Application</a></li>
                        <li class="breadcrumb-item active">Update</li>
                        <li class="breadcrumb-item active"> <a href="{{ route('view.application', $App_Id) }}"
                                id="open">View</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('Dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.application') }}">New Application</a></li>
            <li class="breadcrumb-item"><a href="{{ route('Credit') }}">Credit</a></li>
            <li class="breadcrumb-item"><a href="{{ route('Debit') }}">Debit</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    <div class="row"> {{-- Start of Services Row --}}
        <a href="#table" class="col-xl-3 col-md-10" wire:click="ShowApplications('{{ $Mobile_No }}')">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">

                        {{-- <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fas fa-edit"></i></i>
                            </span>
                        </div> --}}
                        <div class="flex-grow-1 align-items-center">
                            <h5 class="text-truncate text-primary font-size-20 mb-2">{{ $Name }}</h5>
                            <div class="col-8">
                                <div class="text-center mt-8">
                                    <h5>Applied {{ $count_app }}</h5>
                                    <p class="mb-2 text-truncate">Deleted {{ $app_deleted }} Applications</p>
                                </div>
                            </div>
                        </div>
                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg"
                            src="{{ $old_Applicant_Image != 'Not Available' ? asset('storage/' . $old_Applicant_Image) : url('storage/no_image.jpg') }}"
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
                                    <h5>Payble &#x20B9; {{ $total }}/-</h5>
                                    <p class="mb-2 text-truncate">Balance <span> &#x20B9;{{ $balance }}</span></p>
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
                                    <p class="mb-2 text-truncate">Paid <span> &#x20B9;{{ $total }}</span></p>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg"
                            src="{{ !empty($Profile_Image) ? url('storage/' . $Profile_Image) : url('storage/balance.png') }}"
                            alt="">

                    </div>
                </div>
            </div>
        </a>


    </div> {{-- End of Row --}}
    {{-- ----------------------------------------------------------------------------------------------------- --}}
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between">
                    <h3 class="card-title mb-4">Application ID: {{ $Client_Id }}</h3>
                    <h4 class="card-title mb-6">Update Section</h4>
                    <h3 class="card-title mb-4"> <a href="{{ route('view.application', $Id) }}">View : Mr / Mrs :
                            {{ $Name }} App</a></h3>
                </div>
                <div class="card-body">


                    <div id="progrss-wizard" class="twitter-bs-wizard">
                        <ul class="twitter-bs-wizard-nav nav-justified nav nav-pills">
                            <li class="nav-item" wire:ignore>
                                <a href="#progress-applicant-details" class="nav-link active" data-toggle="tab">
                                    <span class="step-number">01</span>
                                    <span class="step-title">Applicant Details</span>
                                </a>
                            </li>
                            <li class="nav-item" wire:ignore>
                                <a href="#progress-service-details" class="nav-link" data-toggle="tab">
                                    <span class="step-number">02</span>
                                    <span class="step-title">Service Details</span>
                                </a>
                            </li>

                            <li class="nav-item" wire:ignore>
                                <a href="#progress-payment-detail" class="nav-link" data-toggle="tab">
                                    <span class="step-number">03</span>
                                    <span class="step-title">Payment Details</span>
                                </a>
                            </li>
                            <li class="nav-item" wire:ignore>
                                <a href="#progress-confirm-detail" class="nav-link" data-toggle="tab">
                                    <span class="step-number">04</span>
                                    <span class="step-title">Confirm Detail</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content twitter-bs-wizard-tab-content">
                            <div class="tab-pane active" id="progress-applicant-details" wire:ignore.self>
                                <form>
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="progress-basicpill-phoneno-input">Phone
                                                    No</label>
                                                <input type="number" class="form-control"
                                                    placeholder="Mobile Number" id="progress-basicpill-phoneno-input"
                                                    wire:model.debounce.500ms="Mobile_No" readonly>
                                                @error('Mobile_No')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="progress-basicpill-firstname-input">Name </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Applicant Name"
                                                    id="progress-basicpill-firstname-input" wire:model.lazy="Name">
                                                @error('Name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="RelativeName">Relative Name </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Relative Name" id="RelativeName"
                                                    wire:model.lazy="RelativeName">
                                                @error('RelativeName')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="progress-basicpill-firstname-input">Gender </label>
                                                <select class="form-select" wire:model.lazy="Gender">

                                                    @if (!empty($Gender) || is_Null($Gender))
                                                        <option value="{{ $Gender }}">{{ $Gender }}
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        </option>
                                                    @endif
                                                </select>
                                                @error('Gender')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="progress-basicpill-dob-input">Date of
                                                    Birth</label>
                                                <input type="date" class="form-control"
                                                    placeholder="Date of Birth" max="{{now()->toDateString()}}" id="progress-basicpill-dob-input"
                                                    wire:model.lazy="Dob">
                                                @error('Dob')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="Applicant_Image">Applicant
                                                    Image</label>
                                                <input type="file" class="form-control" id="Applicant_Image"
                                                    wire:model="Applicant_Image" accept="image/jpeg, image/png">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">

                                                <label class="form-label" for="Applicant_Image_View">Photo</label>
                                                <div wire:loading wire:target="Applicant_Image">Uploading Profile
                                                    Image...</div>
                                                @if (!is_null($Applicant_Image))
                                                    <img class="rounded avatar-md"
                                                        src="{{ $Applicant_Image->temporaryUrl() }}"
                                                        alt="Applicant_Image" />
                                                @elseif($old_Applicant_Image != 'Not Available')
                                                    <img class="rounded avatar-md"
                                                        src="{{ asset('storage/' . $old_Applicant_Image) }}"
                                                        alt="no_image" />
                                                @else
                                                    <img class="rounded avatar-md"
                                                        src="{{ asset('storage/no_image.jpg') }}" alt="no_image" />
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="progress-service-details" wire:ignore.self>
                                <div>
                                    <form>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label>Service</label>
                                                    <select class="form-select" wire:model.lazy="MainService" disabled>
                                                        <option value="{{ $Application }}" selected>
                                                            {{ $Application }}</option>
                                                        @foreach ($MainServices as $Service)
                                                            <option value="{{ $Service->Id }}">
                                                                {{ $Service->Name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('MainService')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label>Service Category</label>
                                                    <select class="form-select" wire:model.lazy="SubService" disabled>
                                                        <option value="{{ $Application_Type }}" selected>
                                                            {{ $Application_Type }}</option>
                                                        @foreach ($SubServices as $service)
                                                            <option value="{{ $service->Name }}">{{ $service->Name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    @error('SubSelected')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="progress-basicpill-ackno-input">Acknowledgment No.
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Acknowledgment No"id="progress-basicpill-ackno-input"
                                                        wire:model.lazy = "Ack_No">
                                                    @error('Ack_No')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    @if ($AckFileDownload == 'Enable')
                                                        <a href="{{ route('download_ack', $Id) }}"
                                                            id="download">Dowload Ack</a>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="progress-basicpill-docno-input">Document No.</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Document No"id="progress-basicpill-docno-input"
                                                        wire:model.lazy = "Document_No">
                                                    @error('Document_No')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    @if ($DocFileDownload == 'Enable')
                                                        <a href="{{ route('download_doc', $Id) }}"
                                                            id="download">Dowload Ack</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @if ($Ack_No != 'Not Available')
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                            for="progress-basicpill-ackfile-input">Acknowledgment
                                                            File</label>
                                                        <input type="file" class="form-control"
                                                            id="progress-basicpill-ackfile-input"
                                                            wire:model="Ack_File">
                                                        @error('Ack_File')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror

                                                    </div>
                                                </div>
                                            @endif

                                            @if ($Document_No != 'Not Available')
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                            for="progress-basicpill-docfile-input">Document
                                                            File</label>
                                                        <input type="file" class="form-control"
                                                            id="progress-basicpill-docfile-input"
                                                            wire:model="Doc_File">
                                                        @error('Doc_File')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror

                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <h5 class="font-size-14 mb-3">Upload Document Section</h5>
                                            <div class="d-flex flex-wrap gap-2">
                                                <p class="text-muted">Do you want to Upload Files?</p>
                                                <input type="checkbox" id="document-upload" switch="none"
                                                    wire:model.lazy="Doc_Yes">
                                                <label for="document-upload" data-on-label="Yes"
                                                    data-off-label="No"></label>

                                            </div>
                                        </div>
                                        @if ($Doc_Yes == 1)
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="uploadfile">Upload File
                                                        </label>
                                                        <a href="#"
                                                            class="btn btn-sm btn-success font-size-15 float-end"
                                                            wire:click.prevent="AddNewText({{ $i }})"
                                                            name="add"><i class="ri-folder-add-fill"></i></a>
                                                        <input type="text" class="form-control" name="Doc_Name"
                                                            id="Doc_Name" wire:model.lazy="Doc_Name"
                                                            placeholder="Document Name">
                                                        <input type="file" class="form-control"
                                                            name="Document_Name" id="uploadfile"
                                                            wire:model.lazy="Document_Name"
                                                            accept="image/jpeg, image/png, application/pdf">
                                                        @error('Doc_Name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach ($NewTextBox as $item => $value)
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="uploadfile">Upload
                                                                File:{{ $n++ }} </label>
                                                            <!-- <i class="mdi mdi-delete-alert-outline"></i> -->
                                                            <a href="#"
                                                                class="btn btn-sm btn-danger font-size-15 float-end"
                                                                wire:click.prevent="Remove('{{ $value }}')"
                                                                name="add"><i
                                                                    class="mdi mdi-delete-alert-outline"></i></a>
                                                            <input type="text" class="form-control"
                                                                name="Doc_Names"
                                                                placeholder="Document Name"id="Doc_Names"
                                                                wire:model.lazy="Doc_Names.{{ $value }}"
                                                                required>
                                                            <input type="file" class="form-control"
                                                                name="Document_Files" id="Document_Files"
                                                                wire:model="Document_Files.{{ $value }}"
                                                                accept="image/jpeg, image/png, application/pdf">
                                                            @error('Document_Files')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="progress-payment-detail" wire:ignore.self>
                                <div>
                                    <form>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="progress-basicpill-receiveddate-input">Received
                                                        Date</label>
                                                    <input type="date" class="form-control"
                                                        id="progress-basicpill-receiveddate-input"
                                                        wire:model="Received_Date" disabled>
                                                    @error('Received_Date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="progress-basicpill-receiveddate-input">Applied
                                                        Date</label>
                                                    <input type="date" class="form-control"
                                                        id="progress-basicpill-receiveddate-input"
                                                        wire:model="Applied_Date">
                                                    @error('Applied_Date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="progress-basicpill-receiveddate-input">Updated
                                                        Date</label>
                                                    <input type="date" class="form-control"
                                                        value="{{ now()->toDateString() }}"
                                                        id="progress-basicpill-receiveddate-input"
                                                        wire:model="Updated_Date">
                                                    @error('Updated_Date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label>Current Status</label>
                                                    <select class="form-select" wire:model.lazy="Status">
                                                        <option value="{{ $Status }}" selected>{{ $Status }}</option>
                                                        @foreach ($status as $item)
                                                            <option value="{{ $item->Status }} ">
                                                                {{ $item->Status }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('Status')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>
                                            @if (trim($Status) == 'Rejected' || trim($Status) == 'On Hold' || trim($Status) == 'Returned')
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label>{{ $Status }} Reason</label>
                                                        <textarea type="text" class="form-control" placeholder="Reason for {{ $Status }}"
                                                            id="progress-basicpill-firstname-input" wire:model.lazy="Reason" cols="15" rows="3"></textarea>
                                                        @error('Status')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror

                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Total_Amount">Total Amount</label>
                                                    <input type="number" name="Total_Amount" class="form-control"
                                                        id="Total_Amount" wire:model.lazy="Total_Amount">
                                                    @error('Total_Amount')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Amount_Paid">Amount paid</label>
                                                    <input type="number" name="Amount_Paid" class="form-control"
                                                        id="Amount_Paid" onblur="Balance()"
                                                        wire:model.lazy="Amount_Paid">
                                                    @error('Amount_Paid')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Balance">Balance</label>
                                                    <input type="number" name="Balance" class="form-control"
                                                        wire:model="Balance" id="Balance" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label>Payment Mode</label>
                                                    <select class="form-select" wire:model.lazy="PaymentMode">
                                                        @if (!empty($PaymentMode))
                                                            <option selected="">{{ $PaymentMode }}</option>
                                                        @else
                                                            <option selected="">Select Payment Mode</option>
                                                        @endif
                                                        @foreach ($paymentModes as $payment)
                                                            <option value="{{ $payment->Payment_Mode }}">
                                                                {{ $payment->Payment_Mode }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('PaymentMode')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    @if ($PayFileDownload == 'Enable')
                                                        <a href="{{ route('download_pay', $Id) }}"
                                                            id="download">{{ $PaymentMode }} Receipt</a>
                                                    @endif

                                                </div>
                                            </div>
                                            @if (!is_Null($PaymentMode) && $PaymentMode != 'Cash')
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                            for="progress-basicpill-ackfile-input">Payment
                                                            Receipt</label>
                                                        <input type="file" class="form-control"
                                                            id="progress-basicpill-ackfile-input"
                                                            wire:model="Payment_File"
                                                            accept="image/jpeg, image/png">
                                                        <span class="text-danger">
                                                            @error('Payment_File')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>

                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="progress-confirm-detail" wire:ignore.self>
                                <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="text-center">
                                            <div class="mb-1">
                                                <div class="spinner-border text-info m-1" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                            <div>
                                                <h5>Preview Detail</h5>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Error / Missing Filed Indicators --}}
                                    <div id="errorlist">
                                        @error('Name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('Mobile_No')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('Dob')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('RelativeName')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('Gender')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('MainService')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('SubService')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('Received_Date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('Applied_Date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('Updated_Date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('Total_Amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('Amount_Paid')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('Balance')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('Status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('Received_Date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('PaymentMode')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row ">
                                    {{-- First Half Data Display --}}
                                    <div class="col-md-6 col-lg-6">

                                        <!-- Client Id  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-16 ">Client ID</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($Client_Id) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($Client_Id) ? $Client_Id : 'Field is Empty' }}</span>
                                            </div>
                                        </div>
                                        <!-- Name  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Name</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($Name) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($Name) ? $Name : 'Field is Empty' }}</span>
                                            </div>
                                        </div>

                                        <!-- Applicant Image  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Applicant Image</span>
                                            </div>



                                            <div class="col-55">
                                                @if (!is_null($Applicant_Image))
                                                <img class="rounded avatar-md"
                                                    src="{{ $Applicant_Image->temporaryUrl() }}"
                                                    alt="Applicant_Image" />
                                            @elseif($old_Applicant_Image != 'Not Available')
                                                <img class="rounded avatar-md"
                                                    src="{{ asset('storage/' . $old_Applicant_Image) }}"
                                                    alt="no_image" />
                                            @else
                                                <img class="rounded avatar-md"
                                                    src="{{ asset('storage/no_image.jpg') }}" alt="no_image" />
                                            @endif
                                            </div>
                                        </div>

                                        <!-- Relative Name  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Relative Name</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($RelativeName) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($RelativeName) ? $RelativeName : 'Field is Empty' }}</span>
                                            </div>
                                        </div>

                                        <!-- Gender  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Gender</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($Gender) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($Gender) ? $Gender : 'Field is Empty' }}</span>
                                            </div>
                                        </div>
                                        <!-- Mobile Number  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Mobile Number</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($Mobile_No) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($Mobile_No) ? $Mobile_No : 'Field is Empty' }}</span>
                                            </div>
                                        </div>

                                        <!-- Date of Birth -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Date of Birth</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($Dob) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($Dob) ? $Dob : 'Field is Empty' }}</span>
                                            </div>
                                        </div>



                                    </div>

                                    {{-- First Half Data Display --}}
                                    <div class="col-md-6 col-lg-6">
                                        <!-- ServiceName  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Service</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($ServiceName) ? 'text-info font-weight-bolder' : '' }}">{{ !empty($ServiceName) ? $ServiceName : $Application }}</span>
                                            </div>
                                        </div>

                                        <!-- Sub Service  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Service Type</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($SubService) ? 'text-info font-weight-bolder' : '' }}">{{ !empty($SubService) ? $SubService : $Application_Type }}</span>
                                            </div>
                                        </div>

                                        <!-- Ack_No  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Ack No.</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($Ack_No) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($Ack_No) ? $Ack_No : 'Field is Empty' }}</span>
                                            </div>
                                        </div>

                                        <!-- Client Id  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Doc No</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($Document_No) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($Document_No) ? $Document_No : 'Field is Empty' }}</span>
                                            </div>
                                        </div>


                                        <!-- Total_Amount   -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Total Amount</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-success font-size-20 {{ empty($Total_Amount) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($Total_Amount) ? $Total_Amount : 'Field is Empty' }}</span>
                                            </div>
                                        </div>

                                        <!-- Amount_Paid -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Amount Paid</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-danger font-size-16 {{ empty($Amount_Paid) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($Amount_Paid) ? $Amount_Paid : 'Field is Empty' }}</span>
                                            </div>
                                        </div>

                                        <!-- Balance  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Balance</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ $Balance == 0 ? 'text-sucess font-weight-bolder' : '' }}">{{ $Balance == 0 ? 'No Due' : '$Balance' }}</span>
                                            </div>
                                        </div>

                                        <!-- Statusd  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Status</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($Status) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($Status) ? $Status : 'Field is Empty' }}</span>
                                            </div>
                                        </div>
                                        <!-- PaymentMode  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Payment Mode</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($PaymentMode) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($PaymentMode) ? $PaymentMode : 'Field is Empty' }}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <h5 class="font-size-14 mb-3">Preview Confirmation</h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        <p class="text-muted">Are you sure you want to Update?</p>
                                        <input type="checkbox" id="switch2" switch="none"
                                            wire:model.lazy="Confirmation">
                                        <label for="switch2" data-on-label="Yes" data-off-label="No"></label>
                                        @if ($Confirmation == 1)
                                            <p><i
                                                    class="mdi mdi-check-circle-outline text-success font-size-20 display-4"></i>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                @if ($Confirmation == 1)
                                <div class="row">
                                    <h5 class="font-size-14 mb-3 text-danger">WhatsApp Notification</h5>
                                    <p class="text-danger"><b>Alert :</b>  Check this button only if you don't want to send whatsapp notification to this update</p>

                                    <div class="d-flex flex-wrap gap-2">
                                        <input type="checkbox" id="switch3" switch="none"
                                            wire:model.lazy="whatsAppNotificatin">
                                        <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                                        @if ($whatsAppNotificatin)
                                            <p>
                                                <i class="mdi mdi-check-circle-outline text-success font-size-20 display-4"></i>
                                                <small>Whatsapp Notification is Off Now.</small>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-xl-12">

                                            <div class="text-center">
                                                <a href="" wire:click.prevent="Update('{{ $Id }}')"
                                                    class="btn btn-success waves-effect waves-light"><i
                                                        class="ri-check-line align-middle me-2"></i> Update </a>
                                                <a href="{{ route('new.application') }}"
                                                    class="btn btn-light waves-effect waves-light">Cancel</a>

                                            </div>

                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <ul class="pager wizard twitter-bs-wizard-pager-link">
                            <li class="previous disabled"><a href="javascript: void(0);">Previous</a></li>
                            <li class="next"><a href="javascript: void(0);">Next</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- ---------------------------------------------------------------------------------------------------- --}}
        @if (count($docFiles) > 0) {{-- Document List Table  --}}
            <div class="col-lg-5">
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
                                    @foreach ($docFiles as $File)
                                        <tr>
                                            <td>{{ $docFiles->firstItem() + $loop->index }}</td>
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
                                    <p class="text-muted">Showing {{ count($docFiles) }} of
                                        {{ $docFiles->total() }} entries</p>
                                </div>
                                <div class="col-md-4">
                                    <span class=" pagination pagination-rounded float-end">
                                        {{ $docFiles->links() }}
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
    {{-- ---------------------------------------------------------------------------------------------------- --}}

    {{-- List of Applicaiton  Start --}}
    <div id="table">
        @if ($ShowTable)
            @include('admin-module.application.dynamic-table')
        @endif
    </div>
    {{-- List of Applicaiton  End --}}


</div> {{-- End of Livewire   --}}
