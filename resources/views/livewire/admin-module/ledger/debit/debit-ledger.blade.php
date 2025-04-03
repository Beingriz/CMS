<div> {{-- Main Div --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Debit Ledger</h4>

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
            <li class="breadcrumb-item"><a href="{{ route('Debit') }}">Debit</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    {{-- Form Row --}}
    <div class="row">
        <div class="col-lg-5">
            {{-- Start of Form Column --}}
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header d-flex align-items-center justify-content-between bg-danger text-white">
                    <h5 class="mb-0 text-light" >💰 Debit Ledger</h5>
                    <h5><a href="{{ route('Debit') }}" class="text-white" title="New Transaction">➕ New Entry</a></h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label fw-bold">Debit ID</label>
                        <div class="col-sm-8">
                            <p class="mb-0">{{ $transaction_id }}</p>
                        </div>
                    </div>

                    <form wire:submit.prevent="Save">
                        @csrf

                        {{-- Category --}}
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Category</label>
                            <div class="col-sm-8">
                                <select class="form-control" wire:model="Category">
                                    <option value="">--- Select ---</option>
                                    <option value="Expenses">Expenses</option>
                                    <option value="Loan">Loan</option>
                                    <option value="Credit Card Loan">Credit Card Loan</option>
                                    <option value="CD Loan">CD Loan</option>
                                </select>
                                @error('Category') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- Sub Category --}}
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Sub Category</label>
                            <div class="col-sm-8">
                                <select class="form-control" wire:model="SubCategory">
                                    <option value="">--- Select ---</option>
                                    @if (!empty($Category))
                                        @foreach ($DebitSource as $item)
                                            <option value="{{ $item->Id }}">{{ $item->Name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('SubCategory') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-search-input" class="col-sm-4 col-form-label">Particular</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="Particular" wire:model="Particular" name="Particular">
                                    <option value="">---Select---</option>
                                    @if (!empty($SubCategory))
                                        @foreach ($DebitSources as $item)
                                            <option value="{{ $item->Id }}">{{ $item->Name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="error">
                                    @error('Particular')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        {{-- Date --}}
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Date</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" wire:model="Date" value="{{ date('Y-m-d') }}">
                                @error('Date') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- Payment Details --}}
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Payment Details</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" wire:model="Unit_Price" placeholder="Amount" readonly>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" wire:model="Quantity" placeholder="Quantity">
                            </div>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" value="{{ $Total_Amount }}" readonly>
                            </div>
                        </div>

                        {{-- Paid & Balance --}}
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Paid / Bal</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" wire:model.lazy="Amount_Paid" placeholder="Paid">
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" wire:model="Balance" placeholder="Bal" readonly>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Description</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" wire:model="Description" rows="3" placeholder="Debit Description"></textarea>
                                @error('Description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- Payment Mode --}}
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Payment</label>
                            <div class="col-sm-8">
                                <select class="form-control" wire:model="Payment_Mode" name="Payment_Mode">
                                    <option value="">--- Select ---</option>
                                    @foreach ($PaymentMode as $mode)
                                        <option value="{{ $mode->Payment_Mode }}">{{ $mode->Payment_Mode }}</option>
                                    @endforeach
                                </select>
                                @error('Payment_Mode') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- File Upload for Non-Cash Payments --}}
                        @if ($Payment_Mode != 'Cash')
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label fw-bold">Upload Proof</label>
                                <div class="col-sm-8">
                                    <input type="file" class="form-control" wire:model="Attachment" accept="image/*">
                                    @error('Attachment') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div wire:loading wire:target="Attachment">Uploading...</div>
                            @if ($Attachment)
                                <img src="{{ $Attachment->temporaryUrl() }}" class="img-thumbnail mt-2" width="100">
                            @elseif($Old_Attachment)
                                <img src="{{ url('storage/' . $Old_Attachment) }}" class="img-thumbnail mt-2" width="100">
                            @endif
                        @endif

                        {{-- Form Buttons --}}
                        <div class="text-center mt-4 gap-2">
                            @if ($update == 0)
                                <button type="submit" class="btn btn-danger">💾 Save</button>
                                <a href="{{ route('Debit') }}" class="btn btn-info">🔄 Reset</a>
                            @elseif($update == 1)
                                <a href="#" class="btn btn-success gap-2" wire:click.prevent="UpdateLedger('{{ $transaction_id }}')">✅ Update</a>
                                <a href="{{ route('Debit') }}" class="btn btn-info">🔄 Reset</a>
                            @endif
                            <a href="{{ route('admin.home') }}" class="btn btn-warning">❌ Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    {{-- Daily Transaction Display Panel --}}
    {{-- Daily Transaction Display Panel --}}
    <div class="col-lg-7">
        <div class="card shadow">
            <div class="card-header bg-danger text-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Debit Transactions</h5>
                <h5 class="fw-bold">&#x20B9; {{ number_format($total, 2) }}</h5>
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    Expenses as on
                    @if (empty($Select_Date))
                        {{ \Carbon\Carbon::parse($today)->format('d-M-Y') }} is
                    @endif
                    @if (!empty($Select_Date))
                        {{ \Carbon\Carbon::parse($Select_Date)->format('d-M-Y') }}
                        <strong>{{ \Carbon\Carbon::parse($Select_Date)->diffForHumans() }}</strong>
                    @endif
                    <span class="fw-bold text-danger">&#x20B9; {{ number_format($total, 2) }}</span>
                </h5>

                @if (session('Error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('Error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($clearButton)
                    <div class="row mt-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Balance Update</h5>
                                <span class="info-text">Balance Due Found for {{ count($balCollection) }} Records!</span>
                                <table class="table table-sm table-bordered table-hover">
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
                                                <td>{{ $item['Id'] }}</td>
                                                <td>{{ $item['Description'] }}</td>
                                                <td>&#x20B9; {{ number_format($item['Total_Amount'], 2) }}</td>
                                                <td>&#x20B9; {{ number_format($item['Amount_Paid'], 2) }}</td>
                                                <td>&#x20B9; {{ number_format($item['Balance'], 2) }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-primary text-white" href="#"
                                                       wire:click="UpdateBalance('{{ $item['Id'] }}')">
                                                       Clear
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <span class="fw-bold text-danger">Total Balance Due: &#x20B9;{{ number_format($balCollection->sum('Balance'), 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endif



                <div class="d-flex flex-wrap gap-3 mt-3">
                    <div class="row">
                        <div class="col-sm-7">
                            <label class="form-label">Show Pages</label>
                        </div>
                        <div class="col-sm-5">
                            <select wire:model="paginate" class="form-select form-select-sm">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <label class="form-label">Filter By</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" wire:model="filterby" class="form-control form-control-sm" placeholder="Filter">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label class="form-label">Search By Date</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="date" wire:model="Select_Date" wire:change="RefreshPage()" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>

                @if (count($Transactions) > 0)
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="table-dark text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Particular</th>
                                    <th>Name</th>
                                    <th>Amount &#x20B9;</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-dark">
                                @foreach ($Transactions as $data)
                                    <tr>
                                        <td>{{ $Transactions->firstItem() + $loop->index }}</td>
                                        <td>{{ $data->Category }}</td>
                                        <td>{{ $data->Source }}, {{ $data->Name }}</td>
                                        <td class="fw-bolder">&#x20B9; {{ number_format($data->Amount_Paid, 2) }}</td>
                                        <td style="width: 40%">{{ $data->Description }}</td>
                                        <td>
                                            <a id="editRecord" funName="edit" recId="{{ $data->Id }}" class="btn btn-sm btn-primary" title="Edit">
                                                <i class="mdi mdi-circle-edit-outline"></i>
                                            </a>
                                            <a id="deleteRecord" funName="delete" recId="{{ $data->Id }}" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="mdi mdi-trash-can"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="card-text"><small class="fw-bold">Last Entry at {{ $lastRecTime }}</small></p>
                @endif

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="text-muted">Showing {{ count($Transactions) }} of {{ $Transactions->total() }} entries</p>
                    <div class="pagination pagination-rounded">
                        {{ $Transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</div>
