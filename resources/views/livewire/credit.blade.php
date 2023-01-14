<div> {{--Main Div--}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Credit Ledger</h4>

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
                        <li class="breadcrumb-item active"><a href="{{route('new_application')}}">New Form</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}


    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('add_services')}}">Services</a></li>
            <li class="breadcrumb-item"><a href="{{url('add_status')}}">Status</a></li>
            <li class="breadcrumb-item"><a href="{{route('update_application')}}">Update</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

<div class="row">
    <div class="col-lg-7">{{--Start of Form Column --}}
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"> Credit Ledger</h4>
                    <p class="card-title-desc">Add New Credit Entry</p>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Credit Id</label>
                        <div class="col-sm-10">
                            <label for="example-text-input" class="col-sm-2 col-form-label">{{$transaction_id}}</label>
                        </div>
                    </div>
                    <form wire:submit.prevent="CreditEntry">
                        @csrf
                        <div class="row mb-3">
                            <label for="example-search-input" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="Particular" wire:model="SourceSelected" name="Particular">
                                    <option value="">---Select---</option>
                                    @foreach($credit_source as $creditsource)
                                    <option value="{{ $creditsource->Id }}">
                                        {{ $creditsource->Name }}</option>
                                    @endforeach
                                </select>
                                <span class="error">@error('SourceSelected'){{$message}}@enderror</span>                    </div>
                        </div>
                        @if(!empty($SourceSelected))
                        <div class="row mb-3">
                            <label for="example-search-input" class="col-sm-2 col-form-label">Sub Category</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="Particular" wire:model="SelectedSources" name="Particular">
                                    <option value="">---Select---</option>
                                    @foreach($credit_sources as $key)
                                    <option value="{{ $key->Source }}">
                                        {{ $key->Source }}</option>
                                    @endforeach
                                </select>
                                <span class="error">@error('SelectedSource'){{$message}}@enderror</span>                    </div>
                        </div>
                        @endif
                        <div class="row mb-3">
                            <label for="Date" class="col-sm-2 col-form-label">Date</label>
                            <div class="col-sm-10">
                                <input type="date" id="date" name="Date" wire:model="Date" value="{{ date('Y-m-d') }}"
                                    class="form-control" />
                                <span class="error">@error('Date'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Date" class="col-sm-2 col-form-label">Payment Details</label>
                            <div class="col-sm-2">
                                <input type="number"  wire:model="Unit_Price"  name="Total_Amount" class="form-control"
                                    placeholder="Amount" pattern="[0-9]" readonly>
                                <span class="error">@error('Unit_Price'){{$message}}@enderror</span>
                            </div>
                            <div class="col-sm-2">
                                <input type="number" id=""  wire:model="Quantity"  name="Total_Amount" class="form-control"
                                    placeholder="Quantity" pattern="[0-9]">
                                <span class="error">@error('Quantity'){{$message}}@enderror</span>
                            </div>
                            <div class="col-sm-2">
                                <input type="number" id="amount"  value="{{$Total_Amount}}"  name="Total_Amount" class="form-control"
                                placeholder="Total" pattern="[0-9]" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Date" class="col-sm-2 col-form-label">Paid / Bal </label>
                            <div class="col-sm-5">
                                <input type="number" id="paid" wire:model="Amount_Paid" name="Amount_Paid" class="form-control"
                                    placeholder="Paid" onblur="balance()">
                                <span class="error">@error('Amount_Paid'){{$message}}@enderror</span>
                            </div>
                            <div class="col-sm-5">
                                <input type="number" id="bal" name="Balance" class="form-control"
                                placeholder="Bal" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Date" class="col-sm-2 col-form-label">Date</label>
                            <div class="col-sm-10">
                                <textarea id="Description" wire:model="Description" name="Description" class="form-control"
                                    placeholder="Credit Description" rows="3" resize="none"></textarea>
                                <span class="error">@error('Description'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="example-search-input" class="col-sm-2 col-form-label">Payment</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="Payment_mode" wire:model="Payment_Mode" name="Payment_mode" wire:change="Change($event.target.value)"">
                                    <option value="">---Select---</option>
                                    @foreach ($payment_mode as $payment_mode)
                                    <option value="{{$payment_mode->Payment_Mode}}">
                                        {{$payment_mode->Payment_Mode}}</option>
                                    @endforeach
                                </select>
                                <span class="error">@error('Payment_mode'){{$message}}@enderror</span>
                            </div>
                        </div>
                        @if ($Payment_Mode!="Cash")
                            <div class="row mb-3">
                                <label for="example-search-input" class="col-sm-2 col-form-label">Payment</label>
                                <div class="col-sm-10">
                                    <div class="md-form">
                                        <input type="file" id="Attachment{$itteration}" wire:model="Attachment" name="Attachment" class="form-control" accept="image/*">
                                        <span class="error">@error('Attachment'){{$message}}@enderror</span>
                                    </div>
                                </div>
                            </div>

                            <div wire:loading wire:target="Attachment">Uploading...</div>                            @if (!is_Null($Attachment))
                                <div class="row">
                                    <div class="col-45">
                                        <img class="col-75" src="{{ $Attachment->temporaryUrl() }}"" alt="Thumbnail" />
                                    </div>
                                </div>

                            @elseif(!is_Null($Old_Attachment))
                            <div class="row">
                                <div class="col-45">
                                    <img class="col-75" src="{{ url('storage/'.$Old_Attachment) }}"" alt="Existing Thumbnail" />
                                </div>
                            </div>
                            @endif
                        @endif
                </div>
        </div>
    </div> {{-- End of Form Column --}}
    <div class="col-lg-5">{{--Record Column--}}
       <div class="card">
        <div class="card-body">
              <h4 class="mb-sm-0">Insight</h4>
            <div class="row">
                <div class="col-xl-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Revenue</p>
                                    <h4 class="mb-2">&#x20B9; {{$total_revenue}}/-</h4>
                                    <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>{{$previous_revenue}}</span>Yesterday</p>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-shopping-cart-2-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div>
            <div class="row">
                <div class="col-xl-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Revenue</p>
                                    <h4 class="mb-2">&#x20B9; {{$total_revenue}}/-</h4>
                                    <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>{{$previous_revenue}}</span>Yesterday</p>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-shopping-cart-2-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div>
            <div class="row">
                <div class="col-xl-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Revenue</p>
                                    <h4 class="mb-2">&#x20B9; {{$total_revenue}}/-</h4>
                                    <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>{{$previous_revenue}}</span>Yesterday</p>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-shopping-cart-2-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div>
        </div>
       </div>

    </div> {{--Record Column--}}
</div>



        <form wire:submit.prevent="CreditEntry">
            @csrf
            <div class="form-data-container">
                {{--Form Data 1--}}


                <div class="form-data"> {{--Form Insight--}}
                    <div class="right-menu">
                        <p class="heading2">Revenue Insight</p>
                        <div class="form-insight-section">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="form-sec-data">
                                <p class="section-heading">Revenue Generated</p>
                                <p class="section-value">Gross &#x20B9; {{$total_revenue}}/-</p>
                                <p class="section-pre-values">Yesterday &#x20B9; <span>{{$previous_revenue}}</span></p>
                            </div>
                        </div>
                        <div class="form-insight-section" >
                            <img src="\digital/cyber/photo_gallery\insight-2.png" alt="" >
                            <div class="form-sec-data">
                                <p class="section-heading">Reveniue From </p>
                                <p class="section-value">{{$SelectedSources}}</p>
                                <p class="section-value"> &#x20B9; <span style="color:green">{{$source_total}} </span>/-</p>
                            </div>
                        </div>
                        <div class="form-insight-section" >
                            <img src="\digital/cyber/photo_gallery\insight-3.png" alt="" >
                            <div class="form-sec-data">
                                <p class="section-heading">Percentage Contribution</p>
                                <p class="section-value"><span style="color:red">{{$contribution}}</span> %  Percentage </p>
                                <p class="section-pre-values">Yesterday Earned &#x20B9; <span>{{$prev_earning}}/-</span> By {{$SelectedSources}}</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="form-data-buttons"> {{--Buttons--}}
                    <div class="row">
                        <div class="col-100">
                            @if ($update == 0 )
                            <button type="submit" value="submit" name="submit"
                                class="btn btn-primary btn-rounded btn-sm">Add Credit</button>
                                <a href='#' wire:click.prevent="ResetFields()"class="btn  btn-info btn-rounded btn-sm">Reset</a>
                                @elseif ($update == 1 )
                                <a href='#' class="btn btn-success btn-rounded btn-sm" wire:click="Update('{{$transaction_id}}')">Update</a>
                                <a href='#' wire:click.prevent="ResetFields()"class="btn  btn-info btn-rounded btn-sm">Reset</a>
                            @else

                            @endif

                            <a href='credit_entry' class="btn btn-rounded btn-sm">Cancel</a>
                        </div>
                    </div>
                </div>
        </form>

@if (count($creditdata)>0)


        <div class="table-container"> {{--Table Container--}}
            <div class="form-header">
                <p class="heading">Daily Collection </p>
            </div>
            <div class="table-information">
                <span class="info-text">Total Credit as on
                @if (empty($Select_Date))
                    {{ $today }} is
                    &#x20B9; {{ $total }}
                @endif
                @if (!empty($Select_Date))
                    {{ $Select_Date }} is
                    &#x20B9; {{ $total }}
                @endif</span>
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
                                <label for="paginate" class="text-nowrap mr-2 mb-0">Search By Date</label>

                                <input type="date" id="date" name="Select_Date" wire:model="Select_Date" class="form-control form-control-sm"/>

                            </div>
                        </div>
                    </div>
                </div>
                @if (sizeof($collection)>0)
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
                                                <td style="width:25%">{{$item['Id']}}</td>
                                                <td style="width:25%">{{$item['Description']}}</td>
                                                <td style="width:25%">&#x20B9; {{$item['Total_Amount']}}</td>
                                                <td style="width:25%">&#x20B9; {{$item['Amount_Paid']}}</td>
                                                <td style="width:25%">&#x20B9; {{$item['Balance']}}</td>
                                                <td style="width:25%">
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

            <div class="progress" style="height: 15px">
                <div class="progress-bar" role="progressbar" style="width:{{$percentage}}%"
                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    {{$percentage}}%
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>SL.No</th>
                        <th>Check</th>
                        <th>Particular</th>
                        <th>Amount &#x20B9;</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($creditdata as $data)
                    <tr>
                        <td>{{ $n++ }}</td>
                        <td><input type="checkbox" name="checked" id="checked" value="{{$data->Id}}" wire:model="Checked"></td>
                        <td style="width:30%">{{ $data->Category }},{{ $data->Sub_Category }}</td>
                        <td style="width:14%">{{ $data->Amount_Paid }}</td>
                        <td style="width:50%">{{ $data->Description }}</td>
                        <td style="width:15%">
                            <div class="btn-group" role="group"
                                aria-label="Button group with nested dropdown">
                                <div class="btn-group btn-group-sm " role="group">
                                    <button id="btnGroupDrop2" type="button"
                                        class="btn btn-info dropdown-toggle" data-mdb-toggle="dropdown"
                                        aria-expanded="false">
                                        Edit
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                                        <li>
                                            <a class="dropdown-item " href='#' onclick="confirm('Are you sure you want to Edit this Recored ?') || event.stopImmediatePropagation()" wire:click="Edit('{{$data->Id}}')">Edit</a>
                                        </li>
                                        <li>
                                            <a class=" dropdown-item" onclick="confirm('Are you sure you want to Delete this Recored Permanently!!') || event.stopImmediatePropagation()"
                                            wire:click="Delete('{{$data->Id}}')">Delete</a>
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
                {{$creditdata->links()}}
            </span>
        </div>
        @endif
    </div>
</div>
