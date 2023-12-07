<div> {{-- Main Route --}}

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">New Application Form</h4>

                @if (session('SuccessMsg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session('SuccessMsg')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('SuccessUpdate'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
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
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Digital Cyber</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('new.application')}}">New Form</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('add_services')}}">Services</a></li>
            <li class="breadcrumb-item"><a href="{{route('new.status')}}">Status</a></li>
            <li class="breadcrumb-item"><a href="{{route('update_application')}}">Update</a></li>
            <li class="breadcrumb-item"><a href="{{route('Credit')}}">Credit</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}


        <div class="row"> {{-- buttons Row  --}}
            <div class="col-lg-6">
                <h5 class="font-size-14 mb-3">Options</h5>
                <div class="d-flex flex-wrap gap-2">
                    <p class="text-muted"> Show Profile</p>
                    <input type="checkbox" id="profile" switch="primary" wire:model.lazy="Profile_Show">
                    <label for="profile" data-on-label="Yes" data-off-label="No" ></label>
                    <p class="text-muted"> Show Records</p>
                    <input type="checkbox" id="records" switch="success"  wire:model.lazy="Records_Show">
                    <label for="records" data-on-label="Yes" data-off-label="No" ></label>
                </div>
            </div>
        </div> {{-- End of Row --}}

<!-- ------------------------------------------------------------------------------------------------- -->
    <div class="row"> {{-- Form,Profile,Records Panel Row --}}
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between">
                    <h2 class="card-title mb-4">Application ID:  {{$App_Id}}</h2>
                    @if ($Open ==1)
                    <h3 class="card-title mb-4">Client : {{$C_Name}}</h3>
                    @endif
                </div>
                <div class="card-body">
                    @if ($Open==1)
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <a href="{{route('new.application')}}"><i class="ri-refresh-line"></i> Refresh
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
                                            <label class="form-label" for="progress-basicpill-phoneno-input">Phone No</label>
                                                <input type="number" class="form-control" placeholder="Mobile Number" id="progress-basicpill-phoneno-input" wire:model.debounce.600ms="Mobile_No">
                                                @error('Mobile_No') <span class="text-danger">{{ $message }}</span> @enderror
                                                @if(!is_null($user_type))
                                                <span class="text-primary">{{$user_type}}</span>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                @if($Open==1)
                                                <span><a href="#" class="btn btn-info btn-sm btn-rounded" wire:click="Autofill()">Autofill Details</a></span>
                                                @endif
                                                @if ($clear_button =='Enable')
                                                <span><a href="#" class="btn btn-warning btn-sm btn-rounded" wire:click="Clear()">Clear Fields</a></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
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
                                                <label class="form-label" for="RelativeName">Relative Name </label>
                                                <input type="text" class="form-control" placeholder="Relative Name" id="RelativeName" wire:model.lazy="RelativeName">
                                                @error('RelativeName') <span class="text-danger">{{ $message }}</span> @enderror

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="progress-basicpill-firstname-input">Gender </label>
                                                <select class="form-select" wire:model.lazy="Gender">
                                                    <option selected="">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                                @error('Gender') <span class="text-danger">{{ $message }}</span> @enderror

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="progress-basicpill-dob-input">Date of Birth</label>
                                                <input type="date" class="form-control" placeholder="Date of Birth "id="progress-basicpill-dob-input" wire:model.lazy="Dob">
                                                @error('Dob') <span class="text-danger">{{ $message }}</span> @enderror

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
                                                        <label class="form-label" for="Applicant_Image">Applicant Image</label>
                                                        <input type="file" class="form-control" id="Applicant_Image" wire:model="Applicant_Image" >
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="Applicant_Image_View">Photo</label>
                                                        <div wire:loading wire:target="Applicant_Image">Uploading Profile Image...</div>
                                                        @if (!is_null($Applicant_Image))
                                                        <img class="rounded avatar-md" src="{{$Applicant_Image->temporaryUrl() }}" alt="Applicant_Image" />
                                                        @elseif((!is_Null($old_Applicant_Image)) && ($old_Applicant_Image=='Not Available'))
                                                        <img class="rounded avatar-md" src="{{asset('storage/no_image.jpg')}}" alt="OldApplicant_Image" />
                                                        @elseif(is_Null($old_Applicant_Image))
                                                        <img class="rounded avatar-md" src="{{asset('storage/no_image.jpg')}}" alt="Old Applicant_Image" />
                                                        @elseif(!is_Null($old_Applicant_Image))
                                                        <img class="rounded avatar-md" src="{{asset('storage/'.$old_Applicant_Image) }}" alt="Applicant_Image" />
                                                        @else
                                                        <img class="rounded avatar-md" src="{{asset('storage/no_image.jpg')}}" alt="no_image" />
                                                        @endif
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
                                                        @elseif((!is_Null($Old_Profile_Image)) && ($Old_Profile_Image == 'Not Available'))
                                                        <img class="rounded avatar-md" src="{{asset('storage/no_image.jpg')}} alt="Client_Image" />
                                                        @elseif(!is_Null($Old_Profile_Image))
                                                        <img class="rounded avatar-md" src="{{asset('storage/'.$Old_Profile_Image) }}" alt="Client_Image" />
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
                                            <label>Service Category</label>
                                            <select class="form-select" wire:model="SubSelected" wire:click="UnitPrice()">
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
                                                <input type="file" class="form-control" id="progress-basicpill-ackfile-input" wire:model="Ack_File" >
                                                @error('Ack_File') <span class="text-danger">{{ $message }}</span> @enderror

                                            </div>
                                        </div>
                                        @endif

                                        @if ($Document_No!='Not Available')
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="progress-basicpill-docfile-input">Document File</label>
                                                <input type="file" class="form-control" id="progress-basicpill-docfile-input"  wire:model="Doc_File">
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
                                                            <option value="{{ $status->Status }}">
                                                                {{ $status->Status }}</option>
                                                            @endforeach
                                                    </select>
                                                    @error('Status') <span class="text-danger">{{ $message }}</span> @enderror

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Total_Amount">Total Amount</label>
                                                    <input type="number"  name="Total_Amount" class="form-control" id="Total_Amount" wire:model.lazy="Total_Amount">
                                                    @error('Total_Amount') <span class="text-danger">{{ $message }}</span> @enderror

                                                    @if ($Service_Fee>=1)
                                                    <p class="text_muted">Service Fee {{$Service_Fee}}</p>
                                                    @endif


                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label class="form-label"  for="Amount_Paid">Amount paid</label>
                                                    <input type="number" name="Amount_Paid" class="form-control" id="Amount_Paid"  onblur="Balance()" wire:model.lazy="Amount_Paid">
                                                    @error('Amount_Paid') <span class="text-danger">{{ $message }}</span> @enderror

                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label class="form-label" for="Balance">Balance</label>
                                                    <input type="number" name="Balance" class="form-control" wire:model="Bal" id="Balance" readonly>
                                                </div>
                                            </div>
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
                                                @if(empty($Bal))
                                                <strong class="text-danger">Field is Empty</strong></li>
                                                @else
                                                <strong class="text-primary">{{$Bal}}</strong>
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
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><strong class="text-info">{{$C_Name}}</strong>  Profile </h4>
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-text">{{$C_Name}} Registered {{$profileCreated}}</p>
                                <p class="card-text"><small class="text-muted">Profile Last updated {{$lastProfUpdate}}</small></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            @if (!empty($Client_Image))
                            <img class="rounded-circle avatar-lg"  src="{{$Client_Image->temporaryUrl() }}" alt="Client Profile">
                            @else
                            <img class="rounded-circle avatar-lg" src="{{ (!empty($Old_Profile_Image))?url('storage/'.$Old_Profile_Image):url('storage/no_image.jpg')}} " alt="Card image cap">
                            @endif
                        </div>
                    </div>
                    <div class="row no-gutters align-items-center">
                    <div class="col-lg-12 d-flex">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"> Client ID :</li>
                            <li class="list-group-item"> Name :</li>
                            <li class="list-group-item"> Relative Name :</li>
                            <li class="list-group-item"> Gender :</li>
                            <li class="list-group-item"> Mobile No :</li>
                            <li class="list-group-item"> Email ID :</li>
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
                                @if (!$C_RName)
                                <strong class="text-danger">Not Available</strong>
                                @else
                                <strong class="text-primary">{{$C_RName}}</strong>
                                @endif

                            </li>
                            <li class="list-group-item">
                                @if (!$C_Gender)
                                <strong class="text-danger">Not Available</strong>
                                @else
                                <strong class="text-primary">{{$C_Gender}}</strong>
                                @endif

                            </li>
                            <li class="list-group-item">
                                @if (!$C_Mob)
                                <strong class="text-danger">Not Available</strong>
                                @else
                                <strong class="text-primary">{{$C_Mob}}</strong>
                                @endif
                            </li>
                            <li class="list-group-item">
                                @if (!$C_Email)
                                <strong class="text-danger">Not Available</strong>
                                @else
                                <strong class="text-primary">{{$C_Email}}</strong>
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
                    <a href="#" class="btn btn-primary waves-effect waves-light" id="update">Update Profile</a>
                    </div>

                </div>
            </div>
        @endif {{-- End of Profile View --}}

        @if($Records_Show == 1)
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Previous {{$AppliedServices->total()}}  Records for {{$C_Mob}} of {{$C_Name}}</h5>
                    </div>
                <div class="row no-gutters align-items-center">
                        <div class="col-md-8">
                            <div class="card-body">

                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                                <p class="card-text"><small class="text-muted">Last Application Applied  {{$lastMobRecTime}}</small></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            @if (!empty($Client_Image))
                        <img class="rounded-circle avatar-lg"  src="{{$Client_Image->temporaryUrl() }}" alt="Client Profile">
                        @else
                        <img class="rounded-circle avatar-lg" src="{{ (!empty($Old_Profile_Image))?url('storage/'.$Old_Profile_Image):url('storage/no_image.jpg')}} " alt="Card image cap">
                        @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" >
                            <table id="datatable" class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"role="grid" aria-describedby="datatable_info">
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
                                    <tr>
                                        <td>{{$AppliedServices->firstItem()+$loop->index}}</td>
                                        <td>{{$key->Received_Date}}</td>
                                        <td>{{$key->Name}}</td>
                                        <td>{{$key->Application , $key->Application_Type}}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary font-size-15" id="open"><i class="mdi mdi-book-open-page-variant" ></i></a>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                <p class="text-muted">Showing {{count($AppliedServices)}} of {{$AppliedServices->total()}} entries</p>
                                </div>
                                <div class="col-md-4">
                                    <span class=" pagination pagination-rounded float-end" >
                                        {{$AppliedServices->links()}}
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
        @if (count($daily_applications)>0)

                <div class="col-lg-12">
                    <div class="card">

                        <h5 class="card-header">Application List</h5>
                        <div class="card-body">
                            <h5 class="card-title">
                                Total Credit as on
                                @if (empty($Select_Date)) {{ \Carbon\Carbon::parse($today)->format('d-M-Y'); }} is &#x20B9 {{$Daily_Income}} @endif
                                @if (!empty($Select_Date))
                                    {{ \Carbon\Carbon::parse($Select_Date)->format('d-M-Y'); }}
                                    <strong>
                                        {{ \Carbon\Carbon::parse($Select_Date)->diffForHumans() }} is &#x20B9
                                    </strong>
                                    {{$Daily_Income}}
                                @endif
                            </h5>
                            @if (session('Error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{session('Error')}}
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
                                                            Cheched ({{count($Checked)}}) <i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2" style="">
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
                                                        <select name="datatable_length"  wire:model="paginate" aria-controls="datatable" class="custom-select custom-select-sm form-control form-control-sm form-select form-select-sm">
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
                                                        <input  type="text"  wire:model="filterby" class="form-control form-control-sm" placeholder="Filter">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="paginate">Search By Date</label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="date" id="date" name="Select_Date" wire:model="Select_Date" class="form-control form-control-sm"/>
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
                                        <th>Total | Paid | Bal. </th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach($daily_applications as $data)
                                    <tr>
                                        <td>{{$daily_applications->firstItem()+$loop->index}}</td>
                                        <td><input type="checkbox" id="checkbox" name="checkbox" value="{{$data->Id}}" wire:model="Checked"></td>
                                        <td>{{ $data->Name }}</td>
                                        <td>{{ $data->Mobile_No }}</td>
                                        <td>{{ $data->Application }} , {{ $data->Application_Type }}</td>
                                        <td>{{ $data->Status }}</td>
                                        <td>{{ $data->Total_Amount }} | {{ $data->Amount_Paid }}  | {{ $data->Balance }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->updated_at)->diffForHumans() }}</td>
                                        <td>
                                            <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupVerticalDrop1" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                                                        <a class="dropdown-item" title="Edit  Application" href={{route('edit_application',$data->Id)}} id="update">Edit</a>

                                                        <a class="dropdown-item" title="Delete Application" onclick="confirm('Are You Sure!? You Want to Delete This Record?')||event.stopImmediatePropagation" wire:click="Delete('{{$data->Id}}')">Delete</a>
                                                        <a class="dropdown-item" title="View Application"  href='./open_app/{{ $data->Id }}'>View</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                <p class="text-muted">Showing {{count($daily_applications)}} of {{$daily_applications->total()}} entries</p>
                                </div>
                                <div class="col-md-4">
                                    <span class=" pagination pagination-rounded float-end" >
                                        {{$daily_applications->links()}}
                                    </span>
                                </div>
                            </div>
                            </div>

                            <p class="card-text"><small class="text-muted">Last Entry at {{$lastRecTime  }}   </small></p>


                        </div>
                    </div>
                </div>
        @endif {{-- End of Daily Transaction Display Panel --}}
    </div>

<!-- --------------------------------------------------------------------------------------------- -->
</div>
