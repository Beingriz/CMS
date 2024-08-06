<div> {{-- Main Div --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Credit Ledger</h4>

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
            <li class="breadcrumb-item"><a href="{{ route('new.application') }}">New Application</a></li>
            <li class="breadcrumb-item"><a href="{{ route('Credit') }}">Credit</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    <div class="row"> {{-- buttons Row  --}}
        <div class="col-lg-6">
            <div class="d-flex flex-wrap gap-2">
                <p class="text-muted"> Show Insight</p>
                <input type="checkbox" id="profile" switch="primary" wire:model="Show_Insight">
                <label for="profile" data-on-label="Yes" data-off-label="No"></label>
            </div>
        </div>
    </div> {{-- End of Row --}}
    {{-- Form Row --}}
    <div class="row">
        <div class="col-lg-5">{{-- Start of Form Column --}}
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between"">
                    <h5>Credit Ledger</h5>
                    <h5><a href="{{ route('Credit') }}" title="Click here for New Transaction">New Entry</a></h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-4 col-form-label">Credit Id</label>
                        <div class="col-sm-8">
                            <label for="example-text-input"
                                class="col-sm-4 col-form-label">{{ $transaction_id }}</label>
                        </div>
                    </div>
                    <form wire:submit.prevent="CreditEntry">
                        @csrf
                        <div class="row mb-3">
                            <label for="example-search-input" class="col-sm-4 col-form-label">Category</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="Particular" wire:model="SourceSelected"
                                    name="Particular">
                                    <option value="">---Select---</option>
                                    @foreach ($credit_source as $creditsource)
                                        <option value="{{ $creditsource->Id }}">
                                            {{ $creditsource->Name }}</option>
                                    @endforeach
                                </select>
                                <span class="error">
                                    @error('SourceSelected')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-search-input" class="col-sm-4 col-form-label">Sub Category</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="Particular" wire:model="SelectedSources"
                                    name="Particular">
                                    <option value="">---Select---</option>
                                    @if (!empty($SourceSelected))
                                        @foreach ($credit_sources as $key)
                                            <option value="{{ $key->Source }}">
                                                {{ $key->Source }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="error">
                                    @error('SelectedSource')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Date" class="col-sm-4 col-form-label">Date</label>
                            <div class="col-sm-8">
                                <input type="date" id="date" name="Date" wire:model="Date"
                                    value="{{ date('Y-m-d') }}" class="form-control" />
                                <span class="error">
                                    @error('Date')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Date" class="col-sm-4 col-form-label">Payment Details</label>
                            <div class="col-sm-2">
                                <input type="number" wire:model="Unit_Price" name="Total_Amount" class="form-control"
                                    placeholder="Amount" pattern="[0-9]" readonly>
                                <span class="error">
                                    @error('Unit_Price')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" id="" wire:model="Quantity" name="Total_Amount"
                                    class="form-control" placeholder="Quantity" pattern="[0-9]">
                                <span class="error">
                                    @error('Quantity')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-sm-2">
                                <input type="number" id="amount" value="{{ $Total_Amount }}"
                                    name="Total_Amount" class="form-control" placeholder="Total" pattern="[0-9]"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Date" class="col-sm-4 col-form-label">Paid / Bal </label>
                            <div class="col-sm-4">
                                <input type="number" id="paid" wire:model.lazy="Amount_Paid" name="Amount_Paid"
                                    class="form-control" placeholder="Paid" <span class="error">
                                @error('Amount_Paid')
                                    {{ $message }}
                                @enderror
                                </span>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" id="bal" name="Balance" wire:model="Balance"
                                    class="form-control" placeholder="Bal" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Date" class="col-sm-4 col-form-label">Description</label>
                            <div class="col-sm-8">
                                <textarea id="Description" wire:model="Description" name="Description" class="form-control"
                                    placeholder="Credit Description" rows="3" resize="none"></textarea>
                                <span class="error">
                                    @error('Description')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="example-search-input" class="col-sm-4 col-form-label">Payment</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="Payment_mode" wire:model="Payment_Mode"
                                    name="Payment_mode" wire:change="Change($event.target.value)">
                                    <option value="">---Select---</option>
                                    @foreach ($payment_mode as $payment_mode)
                                        <option value="{{ $payment_mode->Payment_Mode }}">
                                            {{ $payment_mode->Payment_Mode }}</option>
                                    @endforeach
                                </select>
                                <span class="error">
                                    @error('Payment_mode')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        @if ($Payment_Mode != 'Cash')
                            <div class="row mb-3">
                                <label for="example-search-input" class="col-sm-4 col-form-label">Payment</label>
                                <div class="col-sm-8">
                                    <div class="md-form">
                                        <input type="file" id="Attachment{$itteration}" wire:model="Attachment"
                                            name="Attachment" class="form-control" accept="image/*">
                                        <span class="error">
                                            @error('Attachment')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div wire:loading wire:target="Attachment">Uploading...</div>
                            @if (!is_Null($Attachment))
                                <div class="row">
                                    <div class="col-45">
                                        <img class="col-75" src="{{ $Attachment->temporaryUrl() }}""
                                            alt="Thumbnail" />
                                    </div>
                                </div>
                            @elseif(!is_Null($Old_Attachment))
                                <div class="row">
                                    <div class="col-45">
                                        <img class="col-75" src="{{ url('storage/' . $Old_Attachment) }}""
                                            alt="Existing Thumbnail" />
                                    </div>
                                </div>
                            @endif
                        @endif

                        <div class="form-data-buttons"> {{-- Buttons --}}
                            <div class="row">
                                <div class="col-100">
                                    @if ($update == 0)
                                        <button type="submit" value="submit" name="submit"
                                            class="btn btn-primary btn-rounded btn-sm">Save</button>
                                        <a href="{{ route('Credit') }}"
                                            class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    @elseif($update == 1)
                                        <a href="#" class="btn btn-success btn-rounded btn-sm"
                                            wire:click.prevent="Update('{{ $transaction_id }}')">Update</button>
                                            <a href="{{ route('Credit') }}"
                                                class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    @endif

                                    <a href="{{ route('admin.home') }}"
                                        class="btn btn-warning btn-rounded btn-sm">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> {{-- End of Form Column --}}

        @if ($Show_Insight)
            <div class="col-lg-7">{{-- Record Column --}}
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
                                                <h6 class="mb-2">&#x20B9; {{ $total_revenue }}/-</h6>
                                                <p class="text-muted mb-0"><span
                                                        class="text-success fw-bold font-size-12 me-2"><i
                                                            class="ri-arrow-right-up-line me-1 align-middle"></i>{{ $previous_revenue }}</span>Yesterday
                                                </p>
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
                                                <p class="text-truncate font-size-14 mb-2">Earnings From</p>
                                                <h6 class="mb-2">&#x20B9; {{ $SelectedSources }}</h6>
                                                <p class="text-muted mb-0"><span
                                                        class="text-primary fw-bold font-size-12 me-2"><i
                                                            class="ri-arrow-right-up-line me-1 align-middle"></i>{{ $source_total }}</span>Till
                                                    Date</p>
                                            </div>
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-light text-primary rounded-3">
                                                    <i class="ri-user-3-line font-size-24"></i>
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
                                                <p class="text-truncate font-size-14 mb-2">Percentage Contribution</p>
                                                <h6 class="mb-2">&#x20B9;{{ $contribution }}/-</h6>
                                                <p class="text-muted mb-0"><span
                                                        class="text-danger fw-bold font-size-12 me-2"><i
                                                            class="ri-arrow-right-up-line me-1 align-middle"></i>{{ $prev_earning }}/-</span>%
                                                </p>
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
            </div> {{-- Record Column --}}
        @endif
        {{-- Table Row --}}
        {{-- Daily Transaction Display Panel --}}
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between"">
                    <h5>Credit Transactions</h5>
                    <h5>&#x20B9 {{ $total }}</h5>
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        Earnings as on
                        @if (empty($Select_Date))
                            {{ \Carbon\Carbon::parse($today)->format('d-M-Y') }} is &#x20B9 {{ $total }}
                        @endif
                        @if (!empty($Select_Date))
                            {{ \Carbon\Carbon::parse($Select_Date)->format('d-M-Y') }}
                            <strong>
                                {{ \Carbon\Carbon::parse($Select_Date)->diffForHumans() }} is &#x20B9
                            </strong>
                            {{ $total }}
                        @endif
                    </h5>
                    @if (session('Error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('Error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($clearButton)
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-tittle">
                                        <h5>Balance Update</h5>
                                    </div>
                                </div>
                                <span class="info-text">Balance Due Found for {{ count($balCollection) }}
                                    Records!.</span>
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
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
                                        @foreach ($balCollection as $item)
                                            <tr>
                                                <td style="width:25%">{{ $item['Id'] }}</td>
                                                <td style="width:25%">{{ $item['Description'] }}</td>
                                                <td style="width:25%">&#x20B9; {{ $item['Total_Amount'] }}</td>
                                                <td style="width:25%">&#x20B9; {{ $item['Amount_Paid'] }}</td>
                                                <td style="width:25%">&#x20B9; {{ $item['Balance'] }}</td>
                                                <td style="width:25%">
                                                    <a class="btn-sm btn-primary" href="#"
                                                        title="Clear Balance"
                                                        wire:click="UpdateBalance('{{ $item['Id'] }}')"
                                                        style = "color: white">Clear</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <span class="info-text">Total Balance Due :
                                            &#x20B9;{{ $balCollection->sum('Balance') }}</span>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    @endif

                    <div class="progress" style="height: 15px">
                        <div class="progress-bar" role="progressbar" style="width:{{ $percentage }}%"
                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            {{ $percentage }}%
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <div class="row">
                            <div class="col-sm-7">
                                <label class="form-label" for="paginate">Show Pages</label>
                            </div>
                            <div class="col-sm-5">
                                <select name="datatable_length" wire:model="paginate" aria-controls="datatable"
                                    class="custom-select custom-select-sm form-control form-control-sm form-select form-select-sm">
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
                                <input type="text" wire:model="filterby" class="form-control form-control-sm"
                                    placeholder="Filter">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="form-label" for="paginate">Search By Date</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="date" id="date" name="Select_Date" wire:model="Select_Date"
                                wire:change="RefreshPage()"class="form-control form-control-sm"  />
                            </div>
                        </div>
                    </div>
                    @if (count($creditdata) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <div class="row">
                                            <div class="d-flex align-items-center ml-4">
                                                @if ($Checked)
                                                    <div class="btn-group" role="group"
                                                        aria-label="Button group with nested dropdown">
                                                        <div class="btn-group btn-group-sm btn-rounded"
                                                            role="group">
                                                            <button id="btnGroupDrop1" type="button"
                                                                class="btn btn-danger btn-sm dropdown-toggle"
                                                                data-mdb-toggle="dropdown" aria-expanded="false">
                                                                Cheched ({{ count($Checked) }})
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                                                <li><a class=" dropdown-item"
                                                                        onclick="confirm('Are you sure you want to Delete these records Permanently!!') || event.stopImmediatePropagation()"
                                                                        wire:click="MultipleDelete()">Delete</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </tr>
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
                                    @foreach ($creditdata as $data)
                                        <tr>
                                            <td>{{ $creditdata->firstItem() + $loop->index }}</td>
                                            <td><input type="checkbox" id="checkbox" name="checkbox"
                                                    value="{{ $data->Id }}" wire:model="Checked"></td>
                                            <td>{{ $data->Category }},{{ $data->Sub_Category }}</td>
                                            <td>{{ $data->Amount_Paid }}</td>
                                            <td>{{ $data->Description }}</td>
                                            <td>
                                                <a href="{{ route('edit.credit', $data->Id) }}" title="Edit"
                                                    class="btn btn-sm btn-primary font-size-15" id="editData"><i
                                                        class="mdi mdi-circle-edit-outline"></i></a>

                                                <a href="{{ route('delete.credit', $data->Id) }}" title="Delete"
                                                    class="btn btn-sm btn-danger font-size-15" id="delete"><i
                                                        class=" mdi mdi-trash-can"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>


                            </table>
                        </div>
                        <p class="card-text"><small class="text-bold">Last Entry at {{ $lastRecTime }} </small></p>

                </div>
                @endif
                <div class="row no-gutters align-items-center">
                    <div class="col-md-8">
                        <p class="text-muted">Showing {{ count($creditdata) }} of
                            {{ $creditdata->total() }} entries</p>
                    </div>
                    <div class="col-md-4">
                        <span class="pagination pagination-rounded float-end">
                            {{ $creditdata->links() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
