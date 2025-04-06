<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="row">
        <div class="col-lg-4">{{-- Start of Form Column --}}
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between"">
                    <h5>{{ $Name }}</h5>
                    <h5><a href="#" title="Click here for New Transaction">Status Update</a></h5>
                </div>
                @if (session('SuccessMsg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('SuccessMsg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-4 col-form-label">Client Id</label>
                        <div class="col-sm-8">
                            <label for="example-text-input" class="col-sm-8 col-form-label">{{ $Id }}</label>
                        </div>
                    </div>
                    <form wire:submit.prevent="CreditEntry">
                        @csrf
                        <div class="row mb-3">
                            <label for="Service" class="col-sm-4 col-form-label">Service</label>
                            <div class="col-sm-8">

                                <select class="form-control" id="Service" wire:model="Service" name="Service">
                                    <option value="">---Select---</option>
                                    <option value="{{ $Service }}" selected>{{ $Service }}</option>
                                    @foreach ($MainServices as $item)
                                        <option value="{{ $item->Id }}">
                                            {{ $item->Name }}</option>
                                    @endforeach
                                </select>
                                <span class="error">
                                    @error('Service')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="SubService" class="col-sm-4 col-form-label">Sub service</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="SubService" wire:model="SubService" name="SubService">
                                    <option value="">---Select---</option>
                                    <option value="{{ $SubService }}" selected>{{ $SubService }}</option>
                                    @if (!empty($Service))
                                        @foreach ($SubServices as $item)
                                            <option value="{{ $item->Name }}">
                                                {{ $item->Name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="error">
                                    @error('SubService')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Message" class="col-sm-4 col-form-label">Message</label>
                            <div class="col-sm-8">
                                <textarea id="Message" wire:model="Message" name="Description" class="form-control" placeholder="Credit Description"
                                    rows="3" resize="none" disabled></textarea>
                                <span class="error">
                                    @error('Message')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Status" class="col-sm-4 col-form-label">Status</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="Status" wire:model="Status" name="Status">
                                    <option value="">---Select---</option>
                                    @foreach ($status as $item)
                                        <option value="{{ $item->Status }}">
                                            {{ $item->Status }}</option>
                                    @endforeach
                                </select>
                                <span class="error">
                                    @error('Status')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Feedback" class="col-sm-4 col-form-label">Feedback</label>
                            <div class="col-sm-8">
                                <textarea id="Feedback" wire:model="Feedback" name="Feedback" class="form-control" placeholder="Service Feedback"
                                    rows="3" resize="none"></textarea>
                                <span class="error">
                                    @error('Feedback')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="LeadStatus" class="col-sm-4 col-form-label">Lead Status</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="LeadStatus" wire:model="LeadStatus" name="LeadStatus">
                                    <option value="">---Select---</option>
                                    <option value="Hot">Hot</option>
                                    <option value="Warm">Warm</option>
                                    <option value="Cold">Cold</option>
                                    <option value="Converted">Converted</option>
                                    <option value="Not Intrested">Not Intrested</option>

                                </select>
                                <span class="error">
                                    @error('LeadStatus')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Conversion" class="col-sm-4 col-form-label">Conversion</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="Conversion" wire:model="Conversion"
                                    name="Conversion">
                                    <option value="">---Select---</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Not Intrested">Not Intrested</option>

                                </select>
                                <span class="error">
                                    @error('Conversion')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Amount" class="col-sm-4 col-form-label">Amount</label>
                            <div class="col-sm-8">
                                <input id="Amount" type="number" wire:model="Amount" name="Amount"
                                    class="form-control" placeholder="Enter Amount">
                                <span class="error">
                                    @error('Amount')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="form-data-buttons"> {{-- Buttons --}}
                            <div class="row">
                                <div class="col-100">
                                    <a href="#" class="btn btn-success btn-rounded btn-sm"
                                        wire:click.prevent="Update('{{ $Id }}')">Update</button>
                                        <a href="{{ route('admin.home') }}"
                                            class="btn btn-warning btn-rounded btn-sm">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> {{-- End of Form Column --}}

        {{-- Old Callback Request by same user  --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Previous {{ $requests->total() }} Request{{ $requests->total() > 1 ? 's' : '' }} Found</h5>
                    <h5 class="mb-0 text-primary">{{ $Name }}</h5>
                </div>

                <div class="card-body">
                    @if ($requests->count())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>SL.No</th>
                                        <th>Service</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Feedback</th>
                                        <th>Lead</th>
                                        <th>Conversion</th>
                                        <th>Amount</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $data)
                                        <tr>
                                            <td>{{ $requests->firstItem() + $loop->index }}</td>
                                            <td>{{ $data->Service }}<br><small class="text-muted">{{ $data->Service_Type }}</small></td>
                                            <td class="text-wrap text-start">{{ $data->Message }}</td>
                                            <td><span class="badge bg-info">{{ $data->Status }}</span></td>
                                            <td class="text-wrap text-start">{{ $data->Feedback }}</td>
                                            <td>
                                                <span class="badge
                                                    {{ $data->Lead_Status === 'Hot' ? 'bg-danger' : 'bg-warning text-dark' }}">
                                                    {{ $data->Lead_Status }}
                                                </span>
                                            </td>
                                            <td>{{ $data->Conversion }}</td>
                                            <td>&#8377; {{ number_format($data->Amount, 2) }}</td>
                                            <td><small>{{ $data->created_at->diffForHumans() }}</small></td>
                                            <td><small>{{ $data->updated_at->diffForHumans() }}</small></td>
                                            <td>
                                                <a href="{{ route('edit.status.enquiry', $data->Id) }}"
                                                   class="btn btn-outline-primary btn-sm"
                                                   data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Request">
                                                    <i class="mdi mdi-circle-edit-outline"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <p class="card-text mt-3">
                            <small class="text-muted">
                                Last entry at: <strong>{{ \Carbon\Carbon::parse($lastRecTime)->format('d M Y, h:i A') }}</strong>
                            </small>
                        </p>

                        <div class="row align-items-center mt-3">
                            <div class="col-md-6 text-start">
                                <small class="text-muted">
                                    Showing {{ $requests->count() }} of {{ $requests->total() }} entries
                                </small>
                            </div>
                            <div class="col-md-6 text-end">
                                {{ $requests->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0" role="alert">
                            <strong>No requests found.</strong> Try adjusting your filters or come back later.
                        </div>
                    @endif
                </div>
            </div>
        </div>


    </div>
</div>
