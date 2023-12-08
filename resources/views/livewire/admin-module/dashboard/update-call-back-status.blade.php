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
                            <label for="example-text-input" class="col-sm-8 col-form-label">{{ $Client_Id }}</label>
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
                                    rows="3" resize="none"></textarea>
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

                        <div class="form-data-buttons"> {{-- Buttons --}}
                            <div class="row">
                                <div class="col-100">
                                    <a href="#" class="btn btn-success btn-rounded btn-sm"
                                        wire:click.prevent="Update('{{ $Id }}')">Update</button>
                                        <a href="{{ route('dashboard') }}"
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
                <div class="card-header d-sm-flex align-items-center justify-content-between"">
                    <h5>Previous Requests</h5>
                    <h5>{{ $Name }}</h5>
                </div>
                <div class="card-body">
                    {{-- <h5 class="card-title">Last Request on {{ \Carbon\Carbon::parse($created_at)->format('d-M-Y'); }}</h5> --}}

                    @if (count($requests) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>SL.No</th>
                                        <th>Service</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Message</th>
                                        <th>created</th>
                                        <th>updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($requests as $data)
                                        <tr>
                                            <td>{{ $requests->firstItem() + $loop->index }}</td>
                                            <td>{{ $data->Service }}</td>
                                            <td>{{ $data->Service_Type }}</td>
                                            <td>{{ $data->Status }}</td>
                                            <td>{{ $data->Message }}</td>
                                            <td>{{ \Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</td>
                                            <td>{{ \Carbon\Carbon::parse($data->updated_at)->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('edit.status.callback', [$data->Id, $data->Client_Id, $data->Name]) }}"
                                                    title="Edit" class="btn btn-sm btn-primary font-size-15"
                                                    id="editData"><i class="mdi mdi-circle-edit-outline"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-8">
                                        <p class="text-muted">Showing {{ count($requests) }} of
                                            {{ $requests->total() }} entries</p>
                                    </div>
                                    <div class="col-md-4">
                                        <span class=" pagination pagination-rounded float-end">
                                            {{ $requests->links() }}
                                        </span>
                                    </div>
                                </div>
                            </table>
                        </div>
                        <p class="card-text"><small class="text-bold">Last Entry at {{ $lastRecTime }} </small></p>
                </div>
                <span> {{ $requests->links() }} </span>
                @endif
            </div>
        </div>

    </div>
</div>
