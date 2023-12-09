<div>
    @if (session('SuccessUpdate'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{ session('SuccessUpdate') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('Error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session('Error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('SuccessMsg'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('SuccessMsg') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row"> {{-- Start of Services Row --}}
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
                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg"
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
                                    <h5>Payble &#x20B9; {{ $total }}/-</h5>
                                    <p class="mb-2 text-truncate"> Balance <span> &#x20B9;{{ $balance }}</span>
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
                                    <p class="mb-2 text-truncate">Paid <span> &#x20B9;{{ $total }}</span>
                                    </p>
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
    <div class="form-container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Application Details of <span>{{ $Name }}</h4>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-6 col-lg-6">
                 <!-- Client Id  -->
                <div class="row">
                    <div class="col-45">
                        <span>Client ID</span>
                    </div>
                    <div class="col-55">
                        <span class="imp-label">{{ $Client_Id }}</span>
                    </div>
                </div>

                <!-- Application Id  -->
                <div class="row">
                    <div class="col-45">
                        <span>Application ID</span>
                    </div>
                    <div class="col-55">
                        <span class="text-primary font-weight-bolder">{{ $Id }}</span>
                    </div>
                </div>

                <!-- Application Type -->
                <div class="row">
                    <div class="col-45">
                        <span>Service</span>
                    </div>
                    <div class="col-55">
                        <span class="text-primary font-weight-bolder">{{ $Application }}</span>
                    </div>
                </div>

                <!-- Applied Date -->
                <div class="row">
                    <div class="col-45">
                        <span>Applied Date</span>
                    </div>
                    <div class="col-55">
                        <span class="text-primary font-weight-bolder">{{ $Applied_Date }}</span>
                    </div>
                </div>

                <!-- Mobile No -->
                <div class="row">
                    <div class="col-45">
                        <span>Phone Number</span>
                    </div>
                    <div class="col-55">
                        <span class="text-primary font-weight-bolder">{{ $Mobile_No }}</span>
                    </div>
                </div>

                <!-- DOB -->
                <div class="row">
                    <div class="col-45">
                        <span>Date of Birth</span>
                    </div>
                    <div class="col-55">
                        <span class="text-primary font-weight-bolder">{{ $Dob }}</span>
                    </div>
                </div>
                <!-- Ack No -->
                <div class="row">
                    <div class="col-45">
                        <span>Acknowledgment</span>
                    </div>
                    <div class="col-55">
                        <span class="text-primary font-weight-bolder"><a href="/digital/cyber/download_ack/{{ $Id }}"
                            class="label">{{ $Ack_No }}</a></span>
                    </div>
                </div>
                <!-- Document No -->
                <div class="row">
                    <div class="col-45">
                        <span>Document No</span>
                    </div>
                    <div class="col-55">
                        <span class="text-primary font-weight-bolder">  <a href="/digital/cyber/download_doc/{{ $Id }}"
                            class="label">{{ $Document_No }}</a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">

            </div>
        </div>
    </div>


            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <!-- Status -->
                <div class="row">
                    <div class="col-45">
                        <label class="label">Status</label>

                    </div>
                    <div class="col-55">
                        <label class="imp-label">{{ $Status }}</label>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
</div>

<div class="form-container">
    <h4 class="card-title">Application Details of <span>{{ $Name }}
    </h4>
    <div class="form-data-container">
        <div class="form-data">
            <form action="" method="POST">
                @csrf






        </div>
        <div class="form-data">
            <!-- Name -->
            <div class="row">
                <div class="col-45">
                    <label class="label">Name</label>

                </div>
                <div class="col-55">
                    <label class="imp-label">{{ $Name }}</label>
                </div>
            </div>
            <!-- Service Type-->
            <div class="row">
                <div class="col-45">
                    <label class="label">Service Type</label>

                </div>
                <div class="col-55">
                    <label class="label-value">{{ $Application_Type }}</label>
                </div>
            </div>
            <!-- Received Date -->
            <div class="row">
                <div class="col-45">
                    <label class="label">Received Date</label>

                </div>
                <div class="col-55">
                    <label class="label-value">{{ $Received_Date }}</label>
                </div>
            </div>


            <!-- Total Amount -->
            <div class="row">
                <div class="col-45">
                    <label class="label">Total Amount</label>

                </div>
                <div class="col-55">
                    <label class="label-value">{{ $Total_Amount }}</label>
                </div>
            </div>

            <!-- Amount Paid -->
            <div class="row">
                <div class="col-45">
                    <label class="label">Amount Paid</label>

                </div>
                <div class="col-55">
                    <label class="label-value">{{ $Amount_Paid }}</label>
                </div>
            </div>
            <!-- Balance Amount -->
            <div class="row">
                <div class="col-45">
                    <label class="label">Balance</label>

                </div>
                <div class="col-55">
                    <label class="imp-label">{{ $Balance }}</label>
                </div>
            </div>
            <!-- Payment Mode -->
            <div class="row">
                <div class="col-45">
                    <label class="label">Payment Mode</label>

                </div>
                <div class="col-55">
                    <a href="/digital/cyber/download_pay/{{ $Id }}" class="label">{{ $PaymentMode }}</a>
                </div>
            </div>
            <!-- Updated on -->
            <div class="row">
                <div class="col-45">
                    <label class="label">Updated Date</label>

                </div>
                <div class="col-55">
                    <label class="label-value">{{ $Delivered_Date }}</label>
                </div>
            </div>
        </div>
    </div>
    <div class="form-data-buttons">
        <!-- Submitt Buttom -->
        <div class="row">
            <div class="col-100">
                <a href="{{ url('edit_app') }}/{{ $Id }}"
                    class="btn btn-success btn-sm btn-rounded">Edit</a>
                <a href="{{ url('download_doc') }}/{{ $Id }}"
                    class="btn btn-warning btn-sm btn-rounded">Download</a>
                @if (count($Doc_Files) > 0)
                    <a class="btn btn-info btn-sm btn-rounded" data-mdb-toggle="collapse" href="#collapseExample"
                        role="button" aria-expanded="false" aria-controls="collapseExample">
                        {{ count($Doc_Files) }}+ Documents
                    </a>
                @endif

                <a href="{{ url('app_form') }}" class="btn btn-sm btn-rounded">New</a>
            </div>
        </div>
        </form>
    </div>

</div>
<!-- Collapsed content -->
<div class="collapse mt-3" id="collapseExample">
    @if (count($Doc_Files) > 0)
        <div class="table-container width-50">
            <div class="table-information">
                <span class="info-text"> {{ count($Doc_Files) }} Available Documents </span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Sl.No</th>
                        <th>File Name</th>
                        <th>Download</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Doc_Files as $File)
                        <tr>
                            <td>{{ $n++ }}</td>
                            <td>{{ $File->Document_Name }}</td>
                            <td>
                                <a class="btn btn-success btn-sm "
                                    onclick="confirm('Are You Sure!? You Want to Download this file?')||event.stopImmediatePropagation()"
                                    href='{{ url('download_docs') }}/{{ $File->Id }}'>Download</a>
                            </td>
                            <td>
                                <a class="btn btn-info btn-sm  "
                                    onclick="confirm('Are You Sure!? You Want to Delete this file?')||event.stopImmediatePropagation()"
                                    wire:click.prevent="Delete_Doc('{{ $File->Id }}')">Delete</a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <span>
            </span>
        </div>
    @endif
</div>




</div>
