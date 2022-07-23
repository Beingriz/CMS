<div> {{-- Main Route --}}

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Application Form</h4>

                @if (session('SuccessMsg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session('SuccessMsg')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('SuccessUpdate'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{session('SuccessUpdate')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('Error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{session('Error')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">New App.</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}
    @if ($Open ==1)
    <div class="row">
        <h5 class="font-size-14 mb-3">Profile Details Available</h5>
            <div class="d-flex flex-wrap gap-2">
                <p class="text-muted">View Profile</p>
                <input type="checkbox" id="switch1" switch="none" wire:model.lazy="Profile_Show">
                <label for="switch1" data-on-label="Yes" data-off-label="No"></label>

            </div>
        </div>
    @endif

<!-- --------------------------------------------------------------------------------------------- -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Application ID:  {{$App_Id}}</h4>

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
                                            <label class="form-label" for="progress-basicpill-firstname-input">Name </label>
                                            <input type="text" class="form-control" placeholder="Applicant Name" id="progress-basicpill-firstname-input" wire:model.lazy="Name">
                                            @error('Name') <span class="text-danger">{{ $message }}</span> @enderror

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                        <label class="form-label" for="progress-basicpill-phoneno-input">Phone No</label>
                                            <input type="number" class="form-control" placeholder="Mobile Number" id="progress-basicpill-phoneno-input" wire:model.debounce.500ms="Mobile_No" onkeydown="mobile(this)">
                                            @error('Mobile_No') <span class="text-danger">{{ $message }}</span> @enderror
                                            @if(!is_null($user_type))
                                            <span class="text-primary">{{$user_type}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="progress-basicpill-dob-input">Date of Birth</label>
                                            <input type="date" class="form-control" placeholder="Date of Birth "id="progress-basicpill-dob-input" wire:model.lazy="Dob">
                                            @error('Dob') <span class="text-danger">{{ $message }}</span> @enderror

                                        </div>
                                    </div>
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
                                </div>
                                <div class="row">
                                    <h5 class="font-size-14 mb-3">Profile Update</h5>
                                        <div class="d-flex flex-wrap gap-2">
                                            <p class="text-muted">Do you want to update Profile Image?</p>
                                            <input type="checkbox" id="switch3" switch="none" wire:model.lazy="Profile_Update">
                                            <label for="switch3" data-on-label="Yes" data-off-label="No"></label>

                                        </div>
                                    </div>
                                    @if ($Profile_Update == 1)
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="progress-basicpill-profileimage-input">Profile Image</label>
                                                    <input type="file" class="form-control" id="progress-basicpill-profileimage-input" wire:model="Client_Image" >

                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="progress-basicpill-profileimage-input">Profile View</label>
                                                    <div wire:loading wire:target="Client_Image">Uploading Profile Image...</div>
                                                    @if (!is_null($Client_Image))
                                                    <img class="rounded avatar-md" src="{{$Client_Image->temporaryUrl() }}" alt="Client_Image" />
                                                    @elseif(!is_Null($Old_Profile_Image))
                                                    <img class="rounded avatar-md" src="{{$Old_Profile_Image }}" alt="Client_Image" />
                                                    @else
                                                    <img class="rounded avatar-md" src="{{asset('storage/no_image.jpg')}}" alt="no_image" />
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
                                        <select class="form-select"  wire:model.lazy="MainSelected">
                                            <option selected="">Select Service</option>
                                            @foreach ($main_service as $service)
                                                <option value="{{ $service->Id }} ">{{ $service->Name }}</option>
                                            @endforeach
                                        </select>
                                        @error('MainSelected') <span class="text-danger">{{ $message }}</span> @enderror

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label>Service</label>
                                        <select class="form-select" wire:model.lazy="SubSelected">
                                            <option selected="">Select Service</option>
                                            @foreach ($sub_service as $service)
                                                <option value="{{ $service->Name }} ">
                                                    {{ $service->Name }}</option>
                                                @endforeach
                                        </select>
                                        @error('SubSelected') <span class="text-danger">{{ $message }}</span> @enderror

                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="progress-basicpill-ackno-input">Acknowledgment No. </label>
                                            <input type="text" class="form-control" placeholder="Acknowledgment No"id="progress-basicpill-ackno-input" wire:model.lazy = "Ack_No">
                                            @error('Ack_No') <span class="text-danger">{{ $message }}</span> @enderror

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="progress-basicpill-docno-input">Document No.</label>
                                            <input type="text" class="form-control"  placeholder="Document No"id="progress-basicpill-docno-input" wire:model.lazy = "Document_No" >
                                            @error('Document_No') <span class="text-danger">{{ $message }}</span> @enderror

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @if ($Ack_No !='Not Available' )
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="progress-basicpill-ackfile-input">Acknowledgment File</label>
                                            <input type="file" class="form-control" id="progress-basicpill-ackfile-input" wire:model="Ack_File" accept="application/pdf">
                                            @error('Ack_File') <span class="text-danger">{{ $message }}</span> @enderror

                                        </div>
                                    </div>
                                    @endif

                                    @if ($Document_No!='Not Available')
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="progress-basicpill-docfile-input">Document File</label>
                                            <input type="file" class="form-control" id="progress-basicpill-docfile-input" accept="application/pdf" wire:model="Doc_File">
                                            @error('Doc_File') <span class="text-danger">{{ $message }}</span> @enderror

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
                                                <label class="form-label" for="progress-basicpill-receiveddate-input">Received Date</label>
                                                <input type="date" class="form-control" id="progress-basicpill-receiveddate-input" wire:model="Received_Date">
                                                @error('Received_Date') <span class="text-danger">{{ $message }}</span> @enderror

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label>Current Status</label>
                                                <select class="form-select" wire:model.lazy="Status">
                                                    <option selected="">Select Status</option>
                                                    @foreach ($status_list as $status)
                                                        <option value="{{ $status->Status }} ">
                                                            {{ $status->Status }}</option>
                                                        @endforeach
                                                </select>
                                                @error('Status') <span class="text-danger">{{ $message }}</span> @enderror

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="progress-basicpill-totalamount-input">Total Amount</label>
                                                <input type="number" class="form-control" id="total"  wire:model.lazy="Total_Amount">
                                                @error('Total_Amount') <span class="text-danger">{{ $message }}</span> @enderror

                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="progress-basicpill-amountpaid-input">Amount paidr</label>
                                                <input type="number" class="form-control" id="paid"  onblur="balance()" wire:model.lazy="Amount_Paid">
                                                @error('Amount_Paid') <span class="text-danger">{{ $message }}</span> @enderror

                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="progress-basicpill-balance-input">Balance</label>
                                                <input type="number" class="form-control" id="bal" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label>Payment Mode</label>
                                                <select class="form-select" wire:model="PaymentMode">
                                                    <option selected="">Select Payment Mode</option>
                                                    @foreach ($payment_mode as $payment_mode)
                                                    <option value="{{ $payment_mode ->Payment_Mode }}">
                                                        {{ $payment_mode ->Payment_Mode }}</option>
                                                    @endforeach
                                                </select>
                                                @error('PaymentMode') <span class="text-danger">{{ $message }}</span> @enderror

                                            </div>
                                        </div>
                                        @if (!is_Null($PaymentMode) && $PaymentMode != 'Cash')

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="progress-basicpill-ackfile-input">Payment Receipt</label>
                                                <input type="file" class="form-control" id="progress-basicpill-ackfile-input" wire:model="Payment_Receipt"  accept="image/jpeg, image/png">
                                                <span class="text-danger">@error('Payment_Receipt'){{$message}}@enderror</span>

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
                            <div class="row">
                                <div class="col-lg-4 d-flex">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"> Name</li>
                                        <li class="list-group-item"> Mobile No</li>
                                        <li class="list-group-item"> DOB</li>
                                        <li class="list-group-item"> Client Type</li>
                                        <li class="list-group-item"> Profile</li>

                                    </ul>


                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            @if(empty($Name))
                                            <strong class="text-danger">Field is Empty</strong></li>
                                            @else
                                            <strong class="text-primary">{{$Name}}</strong>

                                            @endif
                                        </li>
                                        <li class="list-group-item">
                                            @if(empty($Name))
                                            <strong class="text-danger">Field is Empty</strong></li>
                                            @else
                                            <strong class="text-primary">{{$Mobile_No}}</strong>

                                            @endif
                                        </li>
                                        <li class="list-group-item">
                                            @if(empty($Name))
                                            <strong class="text-danger">Field is Empty</strong></li>
                                            @else
                                            <strong class="text-primary">{{$Dob}}</strong>

                                            @endif
                                        </li>
                                        <li class="list-group-item">
                                            @if(empty($Name))
                                            <strong class="text-danger">Field is Empty</strong></li>
                                            @else
                                            <strong class="text-primary">{{$Client_Type}}</strong>

                                            @endif
                                        </li>
                                        <li class="list-group-item">
                                            @if(empty($Client_Image))
                                            <strong class="text-danger">Field is Empty</strong></li>
                                            @else
                                            <img class="rounded avatar-md" src="{{$Client_Image->temporaryUrl() }}" alt="Client_Image" />

                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 d-flex">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"> Service</li>
                                        <li class="list-group-item"> Category</li>
                                        <li class="list-group-item"> Acknowledgment No</li>
                                        <li class="list-group-item"> Document No</li>

                                    </ul>


                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            @if(empty($MainSelected))
                                            <strong class="text-danger">Field is Empty</strong></li>
                                            @else
                                            <strong class="text-primary">{{$ServiceName}}</strong>

                                            @endif
                                        </li>
                                        <li class="list-group-item">
                                            @if(empty($SubSelected))
                                            <strong class="text-danger">Field is Empty</strong></li>
                                            @else
                                            <strong class="text-primary">{{$SubSelected}}</strong>

                                            @endif
                                        </li>
                                        <li class="list-group-item">
                                            @if(empty($Ack_No))
                                            <strong class="text-danger">Field is Empty</strong></li>
                                            @else
                                            <strong class="text-primary">{{$Ack_No}}</strong>

                                            @endif
                                        </li>
                                        <li class="list-group-item">
                                            @if(empty($Document_No))
                                            <strong class="text-danger">Field is Empty</strong></li>
                                            @else
                                            <strong class="text-primary">{{$Document_No}}</strong>

                                            @endif
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-lg-4 d-flex">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"> Received Date</li>
                                        <li class="list-group-item"> Status No</li>
                                        <li class="list-group-item"> Total Amount</li>
                                        <li class="list-group-item"> Amount Paid</li>
                                        <li class="list-group-item"> Balance</li>
                                        <li class="list-group-item"> Payment Mode</li>

                                    </ul>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            @if(empty($Received_Date))
                                            <strong class="text-danger">Field is Empty</strong></li>
                                            @else
                                            <strong class="text-primary">{{$Received_Date}}</strong>
                                            @endif
                                        </li>
                                        <li class="list-group-item">
                                            @if(empty($Status))
                                            <strong class="text-danger">Field is Empty</strong></li>
                                            @else
                                            <strong class="text-primary">{{$Status}}</strong>
                                            @endif
                                        </li>
                                        <li class="list-group-item">
                                            @if(empty($Total_Amount))
                                            <strong class="text-danger">Field is Empty</strong></li>
                                            @else
                                            <strong class="text-primary">{{$Total_Amount}}</strong>
                                            @endif
                                        </li>
                                        <li class="list-group-item">
                                            @if(empty($Amount_Paid))
                                            <strong class="text-danger">Field is Empty</strong></li>
                                            @else
                                            <strong class="text-primary">{{$Amount_Paid}}</strong>
                                            @endif
                                        </li>
                                        <li class="list-group-item">
                                            @if(empty($Balance))
                                            <strong class="text-danger">Field is Empty</strong></li>
                                            @else
                                            <strong class="text-primary">{{$Balance}}</strong>
                                            @endif
                                        </li>
                                        <li class="list-group-item">
                                            @if(empty($PaymentMode))
                                            <strong class="text-danger">Field is Empty</strong></li>
                                            @else
                                            <strong class="text-primary">{{$PaymentMode}}</strong>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>




                                    <div class="row">
                                    <h5 class="font-size-14 mb-3">Preview Confirmation</h5>
                                        <div class="d-flex flex-wrap gap-2">
                                            <p class="text-muted">Are you sure you want to submit Form?</p>
                                            <input type="checkbox" id="switch2" switch="none" wire:model.lazy="Confirmation">
                                            <label for="switch2" data-on-label="Yes" data-off-label="No"></label>
                                            @if($Confirmation==1)
                                            <p><i class="mdi mdi-check-circle-outline text-success font-size-20 display-4"></i></p>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($Confirmation==1)
                                    <div class="row">
                                        <div class="col-xl-12">

                                            <div class="text-center">
                                                <a href="#" wire:click.prevent="submit()" class="btn btn-success waves-effect waves-light"><i class="ri-check-line align-middle me-2"></i> Submit Applicaiton</a>
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
    @if($Profile_Show == 1)
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4"><strong class="text-success">{{$C_Name}}</strong>  Profile </h4>
                    <center>
                    @if (!empty($Client_Image))
                    <img class="rounded avatar-lg"  src="{{$Client_Image->temporaryUrl() }}" alt="Client Profile">
                    @else
                    <img class="rounded avatar-lg" src="{{ (!empty($Old_Profile_Image))?url($Old_Profile_Image):url('storage/no_image.jpg')}} " alt="Card image cap">
                    @endif
                    </center>
                </div>
                <div class="col-lg-12 d-flex">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"> Client ID :</li>
                        <li class="list-group-item"> Name :</li>
                        <li class="list-group-item"> Mobile No :</li>
                        <li class="list-group-item"> DOB :</li>
                        <li class="list-group-item"> Client Type :</li>
                        <li class="list-group-item"> Address: </li>

                    </ul>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            @if (!$C_Id)
                            <strong class="text-danger">Not Avaialble</strong>
                            @else
                            <strong class="text-primary">{{$C_Id}}</strong>
                            @endif
                        </li>
                        <li class="list-group-item">
                            @if (!$C_Name)
                            <strong class="text-danger">Not Available</strong>
                            @else
                            <strong class="text-primary">{{$C_Name}}</strong>
                            @endif

                        </li>
                        <li class="list-group-item">
                            @if (!$C_Name)
                            <strong class="text-danger">Not Available</strong>
                            @else
                            <strong class="text-primary">{{$C_Mob}}</strong>
                            @endif
                        </li>
                        <li class="list-group-item">
                            @if (!$C_Dob)
                            <strong class="text-danger">Not Available</strong>
                            @else
                            <strong class="text-primary">{{$C_Dob}}</strong>
                            @endif
                        </li>
                        <li class="list-group-item">
                            @if (!$C_Ctype)
                            <strong class="text-danger">Not Available</strong>
                            @else
                            <strong class="text-primary">{{$C_Ctype}}</strong>
                            @endif
                        </li>
                        <li class="list-group-item">
                            @if (!$C_Address)
                            <strong class="text-danger">Not Available</strong>
                            @else
                            <strong class="text-primary">{{$C_Address}}</strong>
                            @endif
                        </li>
                    </ul>
                </div>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
        </div>
    @endif {{-- End of Profile View --}}
</div>

    @if (count($daily_applications)>0)
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Application List</h4>
                    <center>
                        <p class="text-primary">
                            Total Credit as on
                            @if (empty($Select_Date)) {{ $today }} is &#x20B9 {{$Daily_Income}} @endif
                            @if (!empty($Select_Date)) {{ $Select_Date }} is &#x20B9 {{$Daily_Income}} @endif
                        </p>
                    </center>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <div class="row">
                                <div class="col-lg-6 d-flex">
                                    @if ($Checked)
                                        <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupVerticalDrop2" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Cheched ({{count($Checked)}}) <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2" style="">
                                                    <a class="dropdown-item" title="Multiple Delete" onclick="confirm('Are you sure you want to Delete these records Permanently!!') || event.stopImmediatePropagation()" wire:click="MultipleDelete()">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                        <div class="dataTables_length float-lg-right " >
                                            <label>Show
                                                <select name="datatable_length"  wire:model="paginate" aria-controls="datatable" class="custom-select custom-select-sm form-control form-control-sm form-select form-select-sm">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select> entries</label>
                                        </div>
                                        <div class="dataTables_filter float-lg-right ">
                                            <label class="form-label" for="paginate">Sort</label>
                                            <input  type="text"  wire:model="filterby" class="form-control form-control-sm" placeholder="Filter">
                                        </div>
                                        <div class="dataTables_filter float-end">
                                            <label class="form-label" for="paginate">Date</label>
                                            <input type="date" id="date" name="Select_Date" wire:model="Select_Date" class="form-control form-control-sm"/>
                                        </div>
                                    </div>
                                </div>

                        </tr>
                        <tr>
                            <th>SL. No</th>
                            <th>Check</th>
                            <th>Name</th>
                            <th>Application</th>
                            <th>Mobile No</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($daily_applications as $data)
                        <tr>
                            <td>{{$n++}}</td>
                            <td><input type="checkbox" id="checkbox" name="checkbox" value="{{$data->Id}}" wire:model="Checked"></td>
                            <td>{{ $data->Name }}</td>
                            <td>{{ $data->Application }} , {{ $data->Application_Type }}</td>
                            <td>{{ $data->Mobile_No }}</td>
                            <td>{{ $data->Amount_Paid }}</td>
                            <td>
                                <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupVerticalDrop1" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <i class="mdi mdi-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                                            <a class="dropdown-item" title="Edit  Application" href='./edit_app/{{ $data->Id }}' onclick="confirm('Are You Sure!? You Want to Edit {{$data->Name}}  Record?')||event.stopImmediatePropagation" >Edit</a>
                                            <a class="dropdown-item" title="Delete Application" onclick="confirm('Are You Sure!? You Want to Delete This Record?')||event.stopImmediatePropagation" wire:click="Delete('{{$data->Id}}')">Delete</a>
                                            <a class="dropdown-item" title="View Application"  href='./open_app/{{ $data->Id }}'>View</a>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <span>
                        {{$daily_applications->links()}}
                    </span>
                </table>
                </div>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
            </div>
        </div>
    @endif {{-- End of Profile View --}}


</div>

<!-- --------------------------------------------------------------------------------------------- -->
</div>
