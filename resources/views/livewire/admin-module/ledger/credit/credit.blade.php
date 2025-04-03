
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
        <div class="col-lg-5">
            {{-- Start of Form Column --}}
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header d-flex align-items-center justify-content-between bg-primary text-white">
                    <h5 class="mb-0">💳 Credit Ledger</h5>
                    <h5><a href="{{ route('Credit') }}" class="text-white" title="New Transaction">➕ New Entry</a></h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label fw-bold">Credit ID</label>
                        <div class="col-sm-8">
                            <p class="mb-0">{{ $transaction_id }}</p>
                        </div>
                    </div>

                    <form wire:submit.prevent="CreditEntry">
                        @csrf

                        {{-- Category --}}
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Category</label>
                            <div class="col-sm-8">
                                <select class="form-control" wire:model="SourceSelected">
                                    <option value="">--- Select ---</option>
                                    @foreach ($credit_source as $creditsource)
                                        <option value="{{ $creditsource->Id }}">{{ $creditsource->Name }}</option>
                                    @endforeach
                                </select>
                                @error('SourceSelected') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- Sub Category --}}
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Sub Category</label>
                            <div class="col-sm-8">
                                <select class="form-control" wire:model="SelectedSources">
                                    <option value="">--- Select ---</option>
                                    @if (!empty($SourceSelected))
                                        @foreach ($credit_sources as $key)
                                            <option value="{{ $key->Source }}">{{ $key->Source }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('SelectedSource') <small class="text-danger">{{ $message }}</small> @enderror
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
                                <textarea class="form-control" wire:model="Description" rows="3" placeholder="Credit Description"></textarea>
                                @error('Description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- Payment Mode --}}
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Payment</label>
                            <div class="col-sm-8">
                                <select class="form-control" wire:model="Payment_Mode" wire:change="Change($event.target.value)">
                                    <option value="">--- Select ---</option>
                                    @foreach ($payment_mode as $mode)
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
                        <div class="text-center mt-4">
                            @if ($update == 0)
                                <button type="submit" class="btn btn-primary">💾 Save</button>
                                <a href="{{ route('Credit') }}" class="btn btn-info">🔄 Reset</a>
                            @elseif($update == 1)
                                <a href="#" class="btn btn-success" wire:click.prevent="Update('{{ $transaction_id }}')">✅ Update</a>
                                <a href="{{ route('Credit') }}" class="btn btn-info">🔄 Reset</a>
                            @endif
                            <a href="{{ route('admin.home') }}" class="btn btn-warning">❌ Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        @if ($Show_Insight)
        <div class="col-lg-4">
            {{-- Insight Cards Section --}}
            <div class="card shadow-sm rounded-lg">
                <div class="card-body">
                    <h4 class="mb-sm-3 fw-bold">📊 Insights</h4>
                    <div class="row g-3">
                        {{-- Total Revenue --}}
                        <div class="col-xl-12 col-md-6">
                            <div class="card shadow-sm border-0 rounded-lg insight-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-muted text-uppercase font-size-12 mb-1">Total Revenue</p>
                                            <h5 class="fw-bold text-dark">&#x20B9; {{ $total_revenue }}/-</h5>
                                            <p class="text-muted mb-0">
                                                <span class="text-success fw-bold font-size-12 me-2">
                                                    <i class="ri-arrow-up-line me-1"></i>{{ $previous_revenue }}
                                                </span>Yesterday
                                            </p>
                                        </div>
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-gradient bg-success text-white rounded-lg">
                                                <i class="ri-shopping-cart-2-line font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Earnings From --}}
                        <div class="col-xl-12 col-md-6">
                            <div class="card shadow-sm border-0 rounded-lg insight-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-muted text-uppercase font-size-12 mb-1">Earnings From</p>
                                            <h5 class="fw-bold text-dark">&#x20B9; {{ $SelectedSources }}</h5>
                                            <p class="text-muted mb-0">
                                                <span class="text-primary fw-bold font-size-12 me-2">
                                                    <i class="ri-arrow-right-up-line me-1"></i>{{ $source_total }}
                                                </span>Till Date
                                            </p>
                                        </div>
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-gradient bg-primary text-white rounded-lg">
                                                <i class="ri-user-3-line font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Percentage Contribution --}}
                        <div class="col-xl-12 col-md-6">
                            <div class="card shadow-sm border-0 rounded-lg insight-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-muted text-uppercase font-size-12 mb-1">Percentage Contribution</p>
                                            <h5 class="fw-bold text-dark">&#x20B9;{{ $contribution }}/-</h5>
                                            <p class="text-muted mb-0">
                                                <span class="text-danger fw-bold font-size-12 me-2">
                                                    <i class="ri-arrow-right-up-line me-1"></i>{{ $prev_earning }}/-
                                                </span>%
                                            </p>
                                        </div>
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-gradient bg-danger text-white rounded-lg">
                                                <i class="ri-bar-chart-box-line font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @endif
        {{-- Table Row --}}
        {{-- Daily Transaction Display Panel --}}
        <div class="col-lg-7">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Credit Transactions</h5>
                    <h5 class="fw-bold">&#x20B9; {{ number_format($total, 2) }}</h5>
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        Earnings as on
                        @if (empty($Select_Date))
                            {{ \Carbon\Carbon::parse($today)->format('d-M-Y') }} is
                        @endif
                        @if (!empty($Select_Date))
                            {{ \Carbon\Carbon::parse($Select_Date)->format('d-M-Y') }}
                            <strong>{{ \Carbon\Carbon::parse($Select_Date)->diffForHumans() }}</strong>
                        @endif
                        <span class="fw-bold text-success">&#x20B9; {{ number_format($total, 2) }}</span>
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

                    <div class="custom-progress-container">
                        <div id="progressBar" class="custom-progress-bar">
                            <span id="progressText">{{ $percentage }}%</span>
                        </div>
                    </div>



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

                    @if (count($creditdata) > 0)
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="table-dark text-white">
                                    <tr>
                                        <th>#</th>
                                        <th>Particular</th>
                                        <th>Amount &#x20B9;</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark">
                                    @foreach ($creditdata as $data)
                                        <tr>
                                            <td>{{ $creditdata->firstItem() + $loop->index }}</td>

                                            <td>{{ $data->Category }}, {{ $data->Sub_Category }}</td>
                                            <td class="fw-bolder">&#x20B9; {{ number_format($data->Amount_Paid, 2) }}</td>
                                            <td style="width: 50%" >{{ $data->Description }}</td>
                                            <td>
                                                <a id="editRecord" funName="edit" recId="{{ $data->Id }}" class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="mdi mdi-circle-edit-outline"></i>
                                                </a>
                                                <a id="deleteRecord" funName="delete" recId="{{ $data->Id  }}" class="btn btn-sm btn-danger" title="Delete">
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
                        <p class="text-muted">Showing {{ count($creditdata) }} of {{ $creditdata->total() }} entries</p>
                        <div class="pagination pagination-rounded">
                            {{ $creditdata->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
<style>
    .insight-card {
    transition: all 0.3s ease-in-out;
}

.insight-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}
.custom-progress-container {
        width: 100%;
        height: 22px;
        background-color: #f1f1f1;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
    }

    .custom-progress-bar {
        height: 100%;
        width: {{ $percentage }}%;
        transition: width 0.6s ease-in-out;
        border-radius: 12px;
        text-align: center;
        font-weight: bold;
        color: white;
        line-height: 22px;
    }

    /* Dynamic Color based on Percentage */
    @if($percentage <= 30)
        .custom-progress-bar { background-color: #dc3545; } /* Red */
    @elseif($percentage <= 60)
        .custom-progress-bar { background-color: #ffc107; } /* Yellow */
    @elseif($percentage <= 90)
        .custom-progress-bar { background-color: #17a2b8; } /* Blue */
    @else
        .custom-progress-bar { background-color: #28a745; } /* Green */
    @endif
</style>
</div>
