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


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">New App.</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}


    @if ($Open ==1) {{-- Existing Client Profile Section --}}
        <div class="row no-gutters align-items-center">
            <div class="col-lg-12">
               <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Client Profile</h5>
                        <p class="card-title-desc">Registered Prifile Details of <strong>{{$C_Name}}</strong></p>
                        <div class="table-responsive">
                            <table class="table mb-0">

                                <thead class="table-light">
                                    <tr>
                                        <th>Client Id</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Date of Birth</th>
                                        <th>Client Type</th>
                                        <th>Address</th>
                                        <th>profile</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">{{$C_Id}}</th>
                                        <td>{{$C_Name}}</td>
                                        <td>{{$C_Mob}}</td>
                                        <td>{{$C_Dob}}</td>
                                        <td>{{$C_Ctype}}</td>
                                        <td>{{$C_Address}}</td>
                                        <td>
                                            <img class="rounded avatar-sm" alt="200x200" src="{{asset('backend/assets/images/users/avatar-3.jpg')}}" data-holder-rendered="true">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
            </div>
        </div>
    @endif {{-- End of Client Profile Section --}}
<!-- --------------------------------------------------------------------------------------------- -->
<div> {{--Error Msg --}}
                            @if (session('SuccessUpdate'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>{{session('SuccessUpdate')}}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            @if (session('Error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{session('Error')}}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            @if (session('SuccessMsg'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{session('SuccessMsg')}}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                        </div>
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

                <div id="bar" class="progress mt-4">
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width: 25%;"></div>
                </div>
                <div class="tab-content twitter-bs-wizard-tab-content">
                    <div class="tab-pane active" id="progress-applicant-details" wire:ignore.self>
                        <form>
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="progress-basicpill-firstname-input">Name </label>
                                        <input type="text" class="form-control" id="progress-basicpill-firstname-input" wire:model.lazy="Name">
                                        @error('Name') <span class="error">{{ $message }}</span> @enderror

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                    <label class="form-label" for="progress-basicpill-phoneno-input">Phone No</label>
                                        <input type="number" class="form-control" id="progress-basicpill-phoneno-input" wire:model.debounce.500ms="Mobile_No" onkeydown="mobile(this)">
                                        @error('Mobile_No') <span class="error">{{ $message }}</span> @enderror
                                        @if(!is_null($user_type))
                                        <span class="success">{{$user_type}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="progress-basicpill-dob-input">Date of Birth</label>
                                        <input type="date" class="form-control" id="progress-basicpill-dob-input" wire:model.lazy="Dob">
                                        @error('Dob') <span class="error">{{ $message }}</span> @enderror

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
                                           <img class="rounded avatar-md" src="{{ $Client_Image->temporaryUrl() }}" alt="Client_Image" />
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
                                    <select class="form-select"  wire:model.lazy="MainSelected">
                                        <option selected="">Select Service</option>
                                        @foreach ($main_service as $service)
                                            <option value="{{ $service->Id }} ">{{ $service->Name }}</option>
                                        @endforeach
                                    </select>
                                    @error('MainSelected') <span class="error">{{ $message }}</span> @enderror

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
                                    @error('SubSelected') <span class="error">{{ $message }}</span> @enderror

                                </div>
                            </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="progress-basicpill-ackno-input">Acknowledgment No. </label>
                                        <input type="text" class="form-control" id="progress-basicpill-ackno-input" wire:model.lazy = "Ack_No">
                                        @error('Ack_No') <span class="error">{{ $message }}</span> @enderror

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="progress-basicpill-docno-input">Document No.</label>
                                        <input type="text" class="form-control" id="progress-basicpill-docno-input" wire:model.lazy = "Document_No" >
                                        @error('Document_No') <span class="error">{{ $message }}</span> @enderror

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if ($Ack_No !='Not Available' )
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="progress-basicpill-ackfile-input">Acknowledgment File</label>
                                        <input type="file" class="form-control" id="progress-basicpill-ackfile-input" wire:model="Ack_File" accept="application/pdf">
                                        @error('Ack_File') <span class="error">{{ $message }}</span> @enderror

                                    </div>
                                </div>
                                @endif

                                @if ($Document_No!='Not Available')
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="progress-basicpill-docfile-input">Document File</label>
                                        <input type="file" class="form-control" id="progress-basicpill-docfile-input" accept="application/pdf" wire:model="Doc_File">
                                        @error('Doc_File') <span class="error">{{ $message }}</span> @enderror

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
                                            @error('Received_Date') <span class="error">{{ $message }}</span> @enderror

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
                                            @error('Status') <span class="error">{{ $message }}</span> @enderror

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="progress-basicpill-totalamount-input">Total Amount</label>
                                            <input type="number" class="form-control" id="total"  wire:model.lazy="Total_Amount">
                                            @error('Total_Amount') <span class="error">{{ $message }}</span> @enderror

                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="progress-basicpill-amountpaid-input">Amount paidr</label>
                                            <input type="number" class="form-control" id="paid"  onblur="balance()" wire:model.lazy="Amount_Paid">
                                            @error('Amount_Paid') <span class="error">{{ $message }}</span> @enderror

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
                                                <option value="{{ $payment_mode ->Payment_Mode }} ">
                                                    {{ $payment_mode ->Payment_Mode }}</option>
                                                @endforeach
                                            </select>
                                            @error('PaymentMode') <span class="error">{{ $message }}</span> @enderror

                                        </div>
                                    </div>
                                    @if ($PaymentMode !== 'Cash' && $PaymentMode =='' )
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="progress-basicpill-ackfile-input">Acknowledgment File</label>
                                            <input type="file" class="form-control" id="progress-basicpill-ackfile-input" wire:model="Payment_Receipt"  accept="image/jpeg, image/png">
                                            <span class="error">@error('Payment_Receipt'){{$message}}@enderror</span>

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
                                    <div class="mb-4">
                                        <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                    </div>
                                    <div>
                                        <h5>Confirm Detail</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table mb-0">

                                        <thead class="table-light">
                                            <tr>
                                                <td>Verify Details</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="table-light">Name</th>
                                                <td>{{$Name}}</td>
                                                <th class="table-light">Mobile Number</th>
                                                <td>{{$Mobile_No}}</td>
                                                <th class="table-light">DOB</th>
                                                <td>{{$Dob}}</td>

                                            </tr>
                                            <tr>
                                                <th class="table-light">Client Type</th>
                                                <td>{{$Client_Type}}</td>
                                                <th class="table-light">Service Name</th>
                                                <td>{{$MainSelected}}</td>
                                                <th class="table-light">Service Type</th>
                                                <td>{{$SubSelected}}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">Ack No</th>
                                                <td>{{$Ack_No}}</td>
                                                <th class="table-light">Documnet No</th>
                                                <td>{{$Document_No}}</td>
                                                <th class="table-light">Status</th>
                                                <td>{{$Status}}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">Total Amount</th>
                                                <td>{{$Total_Amount}}</td>
                                                <th class="table-light">Paid Amount</th>
                                                <td>{{$Amount_Paid}}</td>
                                                <th class="table-light">Balance</th>
                                                <td>{{$Balance}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                <div>
                                    <div class="text-center">
                                    <a href="#" wire:click.prevent="submit()" class="btn btn-success waves-effect waves-light">
                                                <i class="ri-check-line align-middle me-2"></i> Submit Applicaiton</a>
                                    </div>
                                </div>
                                </div>
                            </div>

                        </div>
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
            <form wire:submit.prevent="submit">
                @csrf
                <div class="form-data-container">


                </div>
                    <div class="form-data-buttons"><!-- Submitt Buttom -->
                        <div class="row">
                            <div class="col-100">
                                <button type="submit" value="submit" name="submit"
                                    class="btn btn-primary btn-rounded btn-sm">Save Application</button>
                                <a href="{{url("app_home")}}" class="btn btn-rounded btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
            </form>
    @if (count($daily_applications)>0)
        <div class="table-container">
            <div class="form-header">
                <p class="heading"> Application List</p>
            </div>
            <div class="table-information">
                <span class="info-text">Total Credit as on
                    @if (empty($Select_Date)) {{ $today }} is &#x20B9 {{$Daily_Income}} @endif
                    @if (!empty($Select_Date)) {{ $Select_Date }} is &#x20B9 {{$Daily_Income}} @endif
                </span>
                <!-- Quick List Button -->

                <div class="d-flex justify-content-between align-content-center mb-2">
                    <div class="d-flex">
                        <div>
                            <div class="d-flex align-items-center ml-4">
                                @if ($Checked)
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <div class="btn-group btn-group-sm btn-rounded" role="group">
                                        <button id="btnGroupDrop1" type="button"
                                            class="btn btn-danger btn-sm dropdown-toggle" data-mdb-toggle="dropdown"
                                            aria-expanded="false">
                                            Cheched ({{count($Checked)}})
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                            <li><a class=" dropdown-item" onclick="confirm('Are you sure you want to Delete these records Permanently!!') || event.stopImmediatePropagation()" wire:click="MultipleDelete()">Delete</a>
                                            </li>
                                            </ul>
                                    </div>
                                </div>
                                <div class="row"></div>


                                @endif

                                <label for="paginate" class="text-nowrap mr-2 mb-0">Per Page</label>
                                <select wire:model="paginate" name="paginate" id="paginate" class="form-control form-control-sm">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                </select>
                                <div class="row"></div>
                                <label for="paginate" class="text-nowrap mr-2 mb-0">Sort By</label>
                                <input  type="text"  wire:model="filterby" class="form-control form-control-sm" placeholder="Filter">
                                <div class="row"></div>
                                <label for="date" class="text-nowrap mr-2 mb-0">Search By Date</label>

                                <input type="date" id="date" name="Select_Date" wire:model="Select_Date" class="form-control form-control-sm"/>

                            </div>
                        </div>
                    </div>
                </div>
                @if (!is_null($collection))
                                    <br>
                                    <span class="info-text">Balance Due Found for {{count($collection)}} Records!.</span>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Description</th>
                                                <th>Total Amount</th>
                                                <th>Amount Paid</th>
                                                <th>Balance</th>
                                                <th>Update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($collection as $item)
                                            <tr>
                                                <td style="width:10%">{{$item['Id']}}</td>
                                                <td style="width:35%">{{$item['Description']}}</td>
                                                <td style="width:5%">&#x20B9; {{$item['Total_Amount']}}</td>
                                                <td style="width:5%">&#x20B9; {{$item['Amount_Paid']}}</td>
                                                <td style="width:5%">&#x20B9; {{$item['Balance']}}</td>
                                                <td style="width:5%">
                                                    <a class="btn-sm btn-primary"  wire:click="UpdateBalance('{{$item['Id']}}')" style = "color: white">Update</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <span class="info-text">Total Balance Due : &#x20B9;{{
                                             $collection->sum('Balance') }}</span>
                                        </tbody>
                                    </table>
                                    <div class="row"></div>
                                    @endif

            </div>
            <table>
                <thead>
                    <tr>
                        <th >Sl.No</th>
                        <th >Select</th>
                        <th>Name</th>
                        <th>Application</th>
                        <th>Mobile No</th>
                        <th>Amount &#x20B9;</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daily_applications as $data)
                  <tr>
                        <td class="show">{{ $n++ }}</td>
                        <td class="show"><input type="checkbox" id="checkbox" name="checkbox" value="{{$data->Id}}" wire:model="Checked"></td>
                        <td class="show">{{ $data->Name }}</td>
                        <td class="show">{{ $data->Application }} , {{ $data->Application_Type }}</td>
                        <td class="show">{{ $data->Mobile_No }}</td>
                        <td class="show">{{ $data->Amount_Paid }}</td>
                        <td class="show">
                            <div class="btn-group" role="group"
                                aria-label="Button group with nested dropdown">
                                <div class="btn-group btn-group-sm " role="group">
                                    <button id="btnGroupDrop2" type="button"
                                        class="btn btn-info dropdown-toggle" data-mdb-toggle="dropdown"
                                        aria-expanded="false">
                                        Edit
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                                        <li><a class="dropdown-item " href='./edit_app/{{ $data->Id }}' onclick="confirm('Are You Sure!? You Want to Edit {{$data->Name}}  Record?')||event.stopImmediatePropagation" >Edit</a>
                                        </li>
                                        <li><a class="dropdown-item "
                                                href='./open_app/{{ $data->Id }}'>Open</a>
                                        </li>
                                        <li><a class=" dropdown-item"
                                                onclick="confirm('Are You Sure!? You Want to Delete This Record?')||event.stopImmediatePropagation" wire:click="Delete('{{$data->Id}}')">Delete</a>
                                        </li>
                                        <li><a class=" dropdown-item"
                                                href='./print_ack/{{ $data->Id }}'>Print</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>

                    </tr>

                    @endforeach
                </tbody>
            </table>
            <span>
                {{$daily_applications->links()}}
            </span>
        </div>
    @endif
    </div>
