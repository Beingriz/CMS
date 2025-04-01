<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-lg border-light rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title text-primary">{{ $statusDetails->total() }} Search Result(s) Found</h4>
                        <h5 class="card-title text-muted">Service: {{ $Sub_Serv_Name ?? 'All' }}</h5>
                    </div>

                    <div class="filter-bar mb-4 d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <div class="ml-3">
                                <label for="paginate" class="mr-2 text-nowrap mb-0">Per Page</label>
                                <select wire:model="paginate" id="paginate" wire:change="RefreshPage()" class="form-control form-control-sm shadow-sm">
                                    <option value="5" selected>5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                </select>
                            </div>
                            <div class="ml-4">
                                <label for="filterby" class="mr-2 text-nowrap mb-0">Sort By</label>
                                <input type="text" wire:model="filterby" wire:change="RefreshPage()" class="form-control form-control-sm shadow-sm" placeholder="Filter">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover mb-0">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>Sl No</th>
                                    <th>Received</th>
                                    <th>Name</th>
                                    <th>Mobile No</th>
                                    <th>Application</th>
                                    <th>Service Type</th>
                                    <th>Ack. No</th>
                                    <th>Doc. No</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                    <th>Status</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($statusDetails as $data)
                                    <tr class="text-center">
                                        <td>{{ $n++ }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->Received_Date)->diffForHumans() }}</td>
                                        <td>{{ $data->Name }}</td>
                                        <td>{{ $data->Mobile_No }}</td>
                                        <td>{{ $data->Application }}</td>
                                        <td>{{ $data->Application_Type }}</td>
                                        <td>{{ $data->Ack_No }}</td>
                                        <td>{{ $data->Document_No }}</td>
                                        <td>{{ $data->Total_Amount }}</td>
                                        <td>{{ $data->Amount_Paid }}</td>
                                        <td>{{ $data->Balance }}</td>
                                        <td>
                                            <select class="form-control-sm form-control" wire:change="updateStatus('{{ $data->Id }}','{{ $data->Status }}',$event.target.value,'{{ $data->Application_Type }}')">
                                                <option selected>{{ $data->Status }}</option>
                                                @foreach ($status as $item)
                                                    <option value="{{ $item->Status }}">{{ $item->Status }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($data->updated_at)->diffForHumans() }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                                                    Action <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('view.application', [$data->Id]) }}">Open</a>
                                                    <a class="dropdown-item" href="{{ route('edit_application', $data->Id) }}">Edit</a>
                                                    <a class="dropdown-item" href="tel:+91{{ $data->Mobile_No }}">Call</a>
                                                    <a class="dropdown-item" href="whatsapp://send?phone=+91{{ $data->Mobile_No }}">Message</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="14" class="text-center">
                                            <img class="avatar-xl" alt="No Result" src="{{ asset('storage/no_result.png') }}">
                                            <p>No Result Found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="row mt-3">
                            <div class="col-md-8">
                                <p class="text-muted">Showing {{ count($statusDetails) }} of {{ $statusDetails->total() }} entries</p>
                            </div>
                            <div class="col-md-4">
                                <div class="pagination pagination-rounded float-end">
                                    {{ $statusDetails->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
