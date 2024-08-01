<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">New Application Form</h4>

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
            <li class="breadcrumb-item"><a href="{{ route('update_application') }}">Update</a></li>
            <li class="breadcrumb-item"><a href="{{ route('Credit') }}">Credit</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}


    @if ($Open == 1)
        <div class="row"> {{-- buttons Row  --}}
            <div class="col-lg-6">
                <h5 class="font-size-14 mb-3">Options</h5>
                <div class="d-flex flex-wrap gap-2">
                    <p class="text-muted"> Show Profile</p>
                    <input type="checkbox" id="profile" switch="primary" wire:model.lazy="Profile_Show">
                    <label for="profile" data-on-label="Yes" data-off-label="No"></label>
                    <p class="text-muted"> Show Records</p>
                    <input type="checkbox" id="records" switch="success" wire:model.lazy="Records_Show">
                    <label for="records" data-on-label="Yes" data-off-label="No"></label>
                </div>
            </div>
        </div> {{-- End of Row --}}
    @endif
    <!-- ------------------------------------------------------------------------------------------------- -->
    <div class="row"> {{-- Form,Profile,Records Panel Row --}}
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between">
                    <h2 class="card-title mb-4">Application ID: {{ $App_Id }}</h2>
                    @if ($Open == 1)
                        <h3 class="card-title mb-4">Client : {{ $C_Name }}</h3>
                    @endif
                </div>
                <div class="card-body">
                    @if ($Open == 1)
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <a href="{{ route('new.application') }}"><i class="ri-refresh-line"></i> Refresh
                        </div></a>
                    @endif



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
                                                    wire:model.debounce.600ms="Mobile_No">
                                                @error('Mobile_No')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                @if (!is_null($user_type))
                                                    <span class="text-primary">{{ $user_type }}</span>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                @if ($Open == 1)
                                                    <span><a href="#" class="btn btn-info btn-sm btn-rounded"
                                                            wire:click="Autofill()">Autofill Details</a></span>
                                                @endif
                                                @if ($clear_button == 'Enable')
                                                    <span><a href="#" class="btn btn-warning btn-sm btn-rounded"
                                                            wire:click="Clear()">Clear Fields</a></span>
                                                @endif
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
                                                    <option selected="">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
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
                                                    placeholder="Date of Birth "id="progress-basicpill-dob-input"
                                                    wire:model.lazy="Dob" max="{{ now()->toDateString() }}">
                                                @error('Dob')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label>Client Type</label>
                                                <select class="form-select" wire:model.lazy="Client_Type">
                                                    <option selected="">Select Client Type</option>
                                                    <option value="New Client">New Client</option>
                                                    <option value="Old Client">Old Client</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="Applicant_Image">Applicant
                                                    Image</label>
                                                <input type="file" class="form-control" id="Applicant_Image"
                                                    wire:model="Applicant_Image">
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
                                                @elseif(!is_Null($old_Applicant_Image) && $old_Applicant_Image == 'Not Available')
                                                    <img class="rounded avatar-md"
                                                        src="{{ asset('storage/no_image.jpg') }}"
                                                        alt="OldApplicant_Image" />
                                                @elseif(is_Null($old_Applicant_Image))
                                                    <img class="rounded avatar-md"
                                                        src="{{ asset('storage/no_image.jpg') }}"
                                                        alt="Old Applicant_Image" />
                                                @elseif(!is_Null($old_Applicant_Image))
                                                    <img class="rounded avatar-md"
                                                        src="{{ asset('storage/' . $old_Applicant_Image) }}"
                                                        alt="Applicant_Image" />
                                                @else
                                                    <img class="rounded avatar-md"
                                                        src="{{ asset('storage/no_image.jpg') }}" alt="no_image" />
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <h5 class="font-size-14 mb-3">Profile Update</h5>
                                        <div class="d-flex flex-wrap gap-2">
                                            <p class="text-muted">Do you want to update Profile Image?</p>
                                            <input type="checkbox" id="switch3" switch="none"
                                                wire:model.lazy="Profile_Update">
                                            <label for="switch3" data-on-label="Yes" data-off-label="No"></label>

                                        </div>
                                    </div>
                                    @if ($Profile_Update == 1)
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="progress-basicpill-profileimage-input">Profile
                                                        Image</label>
                                                    <input type="file" class="form-control"
                                                        id="progress-basicpill-profileimage-input"
                                                        wire:model="Client_Image">

                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="progress-basicpill-profileimage-input">Profile
                                                        View</label>
                                                    <div wire:loading wire:target="Client_Image">Uploading Profile
                                                        Image...</div>
                                                    @if (!is_null($Client_Image))
                                                        <img class="rounded avatar-md"
                                                            src="{{ $Client_Image->temporaryUrl() }}"
                                                            alt="Client_Image" />
                                                    @elseif(!is_Null($Old_Profile_Image) && $Old_Profile_Image == 'Not Available')
                                                        <img class="rounded avatar-md"
                                                            src="{{ asset('storage/no_image.jpg') }} alt="Client_Image" />
                                                    @elseif(!is_Null($Old_Profile_Image))
                                                        <img class="rounded avatar-md"
                                                            src="{{ asset('storage/' . $Old_Profile_Image) }}"
                                                            alt="Client_Image" />
                                                    @else
                                                        <img class="rounded avatar-md"
                                                            src="{{ asset('storage/no_image.jpg') }}"
                                                            alt="no_image" />
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </form>
                            </div>
                            <div class="tab-pane" id="progress-service-details" wire:ignore.self>
                                <div>
                                    <form>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label>Service</label>
                                                    <select class="form-select" wire:model.lazy="MainSelected">
                                                        <option selected="">Select Service</option>
                                                        @foreach ($main_service as $service)
                                                            <option value="{{ $service->Id }} ">{{ $service->Name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('MainSelected')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label>Service Category</label>
                                                    <select class="form-select" wire:model="SubSelected"
                                                        wire:click="UnitPrice()">
                                                        <option selected="">Select Service</option>
                                                        @foreach ($sub_service as $service)
                                                            <option value="{{ $service->Name }} ">
                                                                {{ $service->Name }}</option>
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
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="progress-payment-detail" wire:ignore.self>
                                <div>
                                    <form>
                                        <div class="row">

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="progress-basicpill-receiveddate-input">Received
                                                        Date</label>
                                                    <input type="date" class="form-control"
                                                        id="progress-basicpill-receiveddate-input"
                                                        wire:model="Received_Date">
                                                    @error('Received_Date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label>Current Status</label>
                                                    <select class="form-select" wire:model.lazy="Status">
                                                        <option selected="">Select Status</option>
                                                        @foreach ($status_list as $status)
                                                            <option value="{{ $status->Status }}">
                                                                {{ $status->Status }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('Status')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>
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

                                                    @if ($Service_Fee >= 1)
                                                        <p class="text_muted">Service Fee {{ $Service_Fee }}</p>
                                                    @endif


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
                                                        wire:model="Bal" id="Balance" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label>Payment Mode</label>
                                                    <select class="form-select" wire:model="PaymentMode">
                                                        <option selected="">Select Payment Mode</option>
                                                        @foreach ($payment_mode as $payment_mode)
                                                            <option value="{{ $payment_mode->Payment_Mode }}">
                                                                {{ $payment_mode->Payment_Mode }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('PaymentMode')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

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
                                                            wire:model="Payment_Receipt"
                                                            accept="image/jpeg, image/png">
                                                        <span class="text-danger">
                                                            @error('Payment_Receipt')
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
                                                <div class="spinner-border text-success m-1" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                            <div>
                                                <h5>Preview Detail</h5>
                                            </div>
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
                                                    class="text-primary font-size-16 {{ empty($C_Id) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($C_Id) ? $C_Id : 'Field is Empty' }}</span>
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
                                                @if (!empty($Applicant_Image))
                                                    <img class="rounded avatar-md"
                                                        src="{{ !empty($Applicant_Image) ? $Applicant_Image->temporaryUrl() : asset('storage/no_image.jpg') }}"alt="Client_Image" />
                                                @else
                                                    <img class="rounded avatar-md"
                                                        src="{{ !empty($old_Applicant_Image) ? asset('storage/' . $old_Applicant_Image) : asset('storage/no_image.jpg') }}"alt="Client_Image" />
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

                                        <!--Client Type  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Client Type</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($Client_Type) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($Client_Type) ? $Client_Type : 'Field is Empty' }}</span>
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
                                                    class="text-primary font-size-16 {{ empty($ServiceName) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($ServiceName) ? $ServiceName : 'Field is Empty' }}</span>
                                            </div>
                                        </div>

                                        <!-- Sub Service  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Service Type</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($SubSelected) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($SubSelected) ? $SubSelected : 'Field is Empty' }}</span>
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
                                                <span class="font-size-18 ">Total Payment</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($Total_Amount) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($Total_Amount) ? $Total_Amount : 'Field is Empty' }}</span>
                                            </div>
                                        </div>

                                        <!-- Amount_Paid -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Amount Paid</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ empty($Amount_Paid) ? 'text-danger font-weight-bolder' : '' }}">{{ !empty($Amount_Paid) ? $Amount_Paid : 'Field is Empty' }}</span>
                                            </div>
                                        </div>

                                        <!-- Balance  -->
                                        <div class="row">
                                            <div class="col-45">
                                                <span class="font-size-18 ">Balance</span>
                                            </div>
                                            <div class="col-55">
                                                <span
                                                    class="text-primary font-size-16 {{ $Bal == 0 ? 'text-sucess font-weight-bolder' : '' }}">{{ $Bal == 0 ? 'No Due' : '$Bal' }}</span>
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

                                {{-- Confirmation Button --}}
                                <div class="row">
                                    <h5 class="font-size-14 mb-3">Preview Confirmation</h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        <p class="text-muted">Are you sure you want to submit Form?</p>
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
                                        <div class="col-xl-12">

                                            <div class="text-center">
                                                <a href="#" wire:click.prevent="submit()"
                                                    class="btn btn-success waves-effect waves-light"><i
                                                        class="ri-check-line align-middle me-2"></i> Submit
                                                    Applicaiton</a>
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
        <!-- --------------------------------------------------------------------------------------------- -->
        @if ($Profile_Show == 1)
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><strong class="text-info">{{ $C_Name }}</strong> Profile
                            </h4>
                    </div>
                    {{-- Profile Section  --}}
                    <div class="row no-gutters align-items-center">
                        {{-- Profile Creation Time --}}
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text">{{ $C_Name }} Registered {{ $profileCreated }}</p>
                                <p class="card-text"><small class="text-muted">Profile Last updated
                                        {{ $lastProfUpdate }}</small></p>
                            </div>
                        </div>
                        {{-- Profile Section --}}
                        <div class="col-md-4">
                            @if (!empty($Client_Image))
                                <img class="rounded-circle avatar-lg" src="{{ $Client_Image->temporaryUrl() }}"
                                    alt="Client Profile">
                            @else
                                <img class="rounded-circle avatar-lg"
                                    src="{{ !empty($Old_Profile_Image) ? url('storage/' . $Old_Profile_Image) : url('storage/no_image.jpg') }} "
                                    alt="Card image cap">
                            @endif
                        </div>
                    </div>

                    <div class="row ">
                        {{-- First Half Data Display --}}
                        <div class="col-md-6 col-lg-12">
                            <!-- Client Id  -->
                            <div class="row">
                                <div class="col-45">
                                    <span class="font-size-18 ">Client ID</span>
                                </div>
                                <div class="col-55">
                                    <span
                                        class="text-primary font-size-18">{{ $C_Id != '' ? $C_Id : 'Not Available' }}</span>
                                </div>
                            </div>
                            <!-- Client Id  -->
                            <div class="row">
                                <div class="col-45">
                                    <span class="font-size-18 ">Name</span>
                                </div>
                                <div class="col-55">
                                    <span
                                        class="text-primary font-size-18">{{ $C_Name != '' ? $C_Name : 'Not Available' }}</span>
                                </div>
                            </div>
                            <!-- Client Id  -->
                            <div class="row">
                                <div class="col-45">
                                    <span class="font-size-18 ">Relative Name</span>
                                </div>
                                <div class="col-55">
                                    <span
                                        class="text-primary font-size-18">{{ $C_RName != '' ? $C_RName : 'Not Available' }}</span>
                                </div>
                            </div>
                            <!-- Client Id  -->
                            <div class="row">
                                <div class="col-45">
                                    <span class="font-size-18 ">Date of Birth</span>
                                </div>
                                <div class="col-55">
                                    <span
                                        class="text-primary font-size-18">{{ $C_Dob != '' ? $C_Dob : 'Not Available' }}</span>
                                </div>
                            </div>
                            <!-- Client Id  -->
                            <div class="row">
                                <div class="col-45">
                                    <span class="font-size-18 ">Mobile Number</span>
                                </div>
                                <div class="col-55">
                                    <span
                                        class="text-primary font-size-18">{{ $C_Mob != '' ? $C_Mob : 'Not Available' }}</span>
                                </div>
                            </div>
                            <!-- Client Id  -->
                            <div class="row">
                                <div class="col-45">
                                    <span class="font-size-18 ">Email Id</span>
                                </div>
                                <div class="col-55">
                                    <span
                                        class="text-primary font-size-18">{{ $C_Email != '' ? $C_Email : 'Not Available' }}</span>
                                </div>
                            </div>
                            <!-- Client Id  -->
                            <div class="row">
                                <div class="col-45">
                                    <span class="font-size-18 ">Client Type</span>
                                </div>
                                <div class="col-55">
                                    <span
                                        class="text-primary font-size-18">{{ $C_Ctype != '' ? $C_Ctype : 'Not Available' }}</span>
                                </div>
                            </div>
                            <!-- Client Id  -->
                            <div class="row">
                                <div class="col-45">
                                    <span class="font-size-18 ">Address</span>
                                </div>
                                <div class="col-55">
                                    <span
                                        class="text-primary font-size-18">{{ $C_Address != '' ? $C_Address : 'Not Available' }}</span>
                                </div>
                            </div>
                            <a href={{ route('edit_profile', $C_Id) }}
                                class="btn btn-primary waves-effect waves-light" id="update">Update
                                Profile</a>

                        </div>
                    </div>


                </div>
            </div>
        @endif {{-- End of Profile View --}}

        @if ($Records_Show == 1)
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Previous {{ $AppliedServices->total() }} Records for
                            {{ $C_Mob }} of {{ $C_Name }}</h5>
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-8">
                            <div class="card-body">

                                <p class="card-text text-dark">List of All Applications Applied by
                                    {{ $C_Name }}, Including Recyclebin applicaitons. </p>
                                <p class="card-text text-dark"><small class="text-muted">Last Application Applied
                                        {{ $lastMobRecTime }}</small></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            @if (!empty($Client_Image))
                                <img class="rounded-circle avatar-lg" src="{{ $Client_Image->temporaryUrl() }}"
                                    alt="Client Profile">
                            @else
                                <img class="rounded-circle avatar-lg"
                                    src="{{ !empty($Old_Profile_Image) ? url('storage/' . $Old_Profile_Image) : url('storage/no_image.jpg') }} "
                                    alt="Card image cap">
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="datatable"
                                class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"role="grid"
                                aria-describedby="datatable_info">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Service</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($AppliedServices as $key)
                                        <tr class="{{ $key->Recycle_Bin == 'Yes' ? 'bg-light text-dark' : '' }}">
                                            <td>{{ $AppliedServices->firstItem() + $loop->index }}</td>
                                            <td>{{ \Carbon\Carbon::parse($key->Received_Date)->diffForHumans() }}
                                                on
                                                {{ \Carbon\Carbon::parse($key->Received_Date)->format('d-m-Y') }}
                                            </td>
                                            <td>{{ $key->Name }}</td>
                                            <td>{{ $key->Application, $key->Application_Type }}</td>
                                            <td>
                                                <a href={{ route('view.application', $key->Id) }}
                                                    class="btn btn-sm btn-primary font-size-15" id="open"><i
                                                        class="mdi mdi-book-open-page-variant"></i></a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                    <p class="text-muted">Showing {{ count($AppliedServices) }} of
                                        {{ $AppliedServices->total() }} entries</p>
                                </div>
                                <div class="col-md-4">
                                    <span class=" pagination pagination-rounded float-end">
                                        {{ $AppliedServices->links() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div> {{-- End of Form,Profile,Records Panel Row --}}
    <!-- ------------------------------------------------------------------------------------------------- -->

    <div class="row"> {{-- Daily Transaction Display Panel --}}
        <div class="col-lg-12">
            <div class="card">
                <h5 class="card-header">Application List</h5>
                <div class="card-body">
                    <h5 class="card-title">
                        Total Credit as on
                        @if (empty($Select_Date))
                            {{ \Carbon\Carbon::parse($today)->format('d-M-Y') }} is &#x20B9 {{ $Daily_Income }}
                        @endif
                        @if (!empty($Select_Date))
                            {{ \Carbon\Carbon::parse($Select_Date)->format('d-M-Y') }}
                            <strong>
                                {{ \Carbon\Carbon::parse($Select_Date)->diffForHumans() }} is &#x20B9
                            </strong>
                            {{ $Daily_Income }}
                        @endif
                    </h5>
                    @if (session('Error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('Error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <div class="row">
                                        <div class="d-flex flex-wrap gap-2">
                                            @if ($Checked)
                                                <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                                    <div class="btn-group" role="group">
                                                        <button id="btnGroupVerticalDrop2" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Checked ({{ count($Checked) }}) <i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                                            <a class="dropdown-item" title="Multiple Delete" onclick="confirm('Are you sure you want to Delete these records Permanently!!') || event.stopImmediatePropagation()" wire:click="MultipleDelete()">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <label class="form-label" for="paginate">Show Pages</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <select name="datatable_length" wire:model="paginate" aria-controls="datatable" class="custom-select custom-select-sm form-control form-control-sm form-select form-select-sm">
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="form-label" for="paginate">Filter By</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" wire:model="filterby" class="form-control form-control-sm" placeholder="Filter">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="form-label" for="paginate">Search By Date</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="date" id="date" name="Select_Date" wire:model="Select_Date" class="form-control form-control-sm" />
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                <tr>
                                    <th>SL. No</th>
                                    <th>Check</th>
                                    <th>Name</th>
                                    <th>Mobile No</th>
                                    <th>Application</th>
                                    <th>Status</th>
                                    <th>Total | Paid | Bal.</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daily_applications as $data)
                                    <tr>
                                        <td>{{ $daily_applications->firstItem() + $loop->index }}</td>
                                        <td><input type="checkbox" id="checkbox" name="checkbox" value="{{ $data->Id }}" wire:model="Checked"></td>
                                        <td>{{ $data->Name }}</td>
                                        <td>{{ $data->Mobile_No }}</td>
                                        <td>{{ $data->Application }} , {{ $data->Application_Type }}</td>
                                        <td>{{ $data->Status }}</td>
                                        <td>{{ $data->Total_Amount }} | {{ $data->Amount_Paid }} | {{ $data->Balance }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->updated_at)->diffForHumans() }}</td>
                                        <td>
                                            <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupVerticalDrop1" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                        <a class="dropdown-item" title="Edit Application" href={{ route('edit_application', $data->Id) }} id="update">Edit</a>
                                                        <a class="dropdown-item" title="Delete Application"   wire:click="Delete('{{ $data->Id }}')" id="delete">Delete</a>
                                                        <a class="dropdown-item" title="Open Application" href={{ route('view.application', $data->Id) }} id="open">Open</a>
                                                    </div>
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
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-8">
                                <p class="text-muted">Showing {{ count($daily_applications) }} of {{ $daily_applications->total() }} entries</p>
                            </div>
                            <div class="col-md-4">
                                <span class="pagination pagination-rounded float-end">
                                    {{ $daily_applications->links() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <p class="card-text"><small class="text-muted">Last Entry at {{ $lastRecTime }} </small></p>
                </div>
            </div>
        </div>
    </div>


    <!-- --------------------------------------------------------------------------------------------- -->
</div>
