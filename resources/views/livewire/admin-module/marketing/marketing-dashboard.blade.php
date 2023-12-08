<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="row">
        <a class="col-xl-3 col-md-6" href="#" wire:click.prevent="show()"title="Enquiry Dashboard">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Total Users</p>
                            <h4 class="mb-2" data-toggle="counter-up">nos</h4>
                            <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i
                                        class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from previous
                                period</p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="mdi mdi-currency-usd font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </a><!-- end col -->
        <a class="col-xl-3 col-md-6" href="#" title="New User Dashboard">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">New Orders</p>
                            <h4 class="mb-2">sas</h4>
                            <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i
                                        class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>from previous
                                period</p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-success rounded-3">
                                <i class="ri-shopping-cart-2-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </a><!-- end col -->
        <a class="col-xl-3 col-md-6" href="#" title="New User Dashboard">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">New Users</p>
                            <h4 class="mb-2">sas</h4>
                            <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i
                                        class="ri-arrow-right-up-line me-1 align-middle"></i>16.2%</span>from previous
                                period</p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="ri-user-3-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </a><!-- end col -->
        <a class="col-xl-3 col-md-6" href="#" title="New User Dashboard">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Call Back </p>
                            <h4 class="mb-2">as</h4>
                            <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i
                                        class="ri-arrow-right-up-line me-1 align-middle"></i>11.7%</span>from previous
                                period</p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-success rounded-3">
                                <i class="ri-phone-fill font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </a><!-- end col -->
    </div><!-- end row -->


    {{-- Table of content  --}}
    <div class="col-lg-12">
        <div class="row"> {{-- Start of Search Result Details Row --}}
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">{{ $StatusDetails->total() }} Search Result found. </h4>
                            <h4 class="card-title">Service : {{ !is_null($Sub_Serv_Name) ? $Sub_Serv_Name : 'All' }}
                                {{ $StatusDetails->total() }} </h4>
                        </div>

                        <div class="filter-bar">
                            <div class="d-flex justify-content-between align-content-center mb-2">
                                <div class="d-flex">
                                    <div>
                                        <div class="d-flex align-items-center ml-4">
                                            <label for="paginate" class="text-nowrap mr-2 mb-0">Per Page</label>
                                            <select wire:model="paginate" name="paginate" id="paginate"
                                                class="form-control form-control-sm">
                                                <option value="5" selected>5</option>
                                                <option value="10">10</option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                            </select>

                                            <div class="row"></div>
                                            <label for="filterby" class="text-nowrap mr-2 mb-0">Sort By</label>
                                            <input type="text" wire:model="filterby"
                                                class="form-control form-control-sm" placeholder="Filter">
                                            <div class="row"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">

                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Application</th>
                                        <th>Service Type</th>
                                        <th>Ack. No</th>
                                        <th>Doc. No</th>
                                        <th>Total</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Change Status</th>
                                        <th>Action</th>
                                        <th>Updated</th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse( $StatusDetails as $data )
                                        <tr>
                                            <td>{{ $n++ }}</td>
                                            <td>{{ \Carbon\Carbon::parse($data->Received_Date)->diffForHumans() }}</td>
                                            <td>{{ $data->Name }}</td>
                                            <td>{{ $data->Mobile_No }}</td>
                                            <td>{{ $data->Application }}</td>
                                            <td>
                                                <select name="ChangeSType" id="ChangeSType"
                                                    class="form-control-sm form-control"
                                                    wire:change="UpdateServiceType('{{ $data->Id }}','{{ $data->Application_Type }}',$event.target.value,'{{ $data->Status }}')">
                                                    <option selected>{{ $data->Application_Type }}</option>
                                                    @foreach ($SubServices as $item)
                                                        <option value="{{ $item->Name }}">{{ $item->Name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>{{ $data->Ack_No }}</td>
                                            <td>{{ $data->Document_No }}</td>
                                            <td>{{ $data->Total_Amount }}</td>
                                            <td>{{ $data->Amount_Paid }}</td>

                                            <td>{{ $data->Balance }}</td>
                                            <td>
                                                <select name="ChangeStatus" id="ChangeStatus"
                                                    class="form-control-sm form-control"
                                                    wire:change="UpdateStatus('{{ $data->Id }}','{{ $data->Status }}',$event.target.value,'{{ $data->Application_Type }}')">
                                                    <option selected>{{ $data->Status }}</option>
                                                    @foreach ($status as $item)
                                                        <option value="{{ $item->Status }}">{{ $item->Status }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>

                                                <div class="btn-group-vertical" role="group"
                                                    aria-label="Vertical button group">
                                                    <div class="btn-group" role="group">
                                                        <button id="btnGroupVerticalDrop1" type="button"
                                                            class="btn btn-light dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Action <i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu"
                                                            aria-labelledby="btnGroupVerticalDrop1" style="">
                                                            <a class="dropdown-item" title="View  Application"
                                                                id="open"
                                                                href={{ route('open_applicaiton', [$data->Id]) }}>Open</a>
                                                            <a class="dropdown-item" title="Edit Application"
                                                                id="update"href={{ route('edit_application', $data->Id) }}>Edit</a>
                                                            <a class="dropdown-item"
                                                                title="Call on {{ $data->Mobile_No }}"
                                                                href="tel:+91{{ $data->Mobile_No }}">Call</a>
                                                            <a class="dropdown-item"
                                                                title="Send Message {{ $data->Mobile_No }}"href="whatsapp://send?phone=+91{{ $data->Mobile_No }}">Message</a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($data->updated_at)->diffForHumans() }}</td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11">
                                                <img class=" avatar-xl" alt="No Result"
                                                    src="{{ asset('storage/no_result.png') }}">
                                                <p>No Result Found</p>
                                            </td>
                                        </tr>
                                    @endforelse()
                                </tbody>

                            </table>
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                    <p class="text-muted">Showing {{ count($StatusDetails) }} of
                                        {{ $StatusDetails->total() }} entries</p>
                                </div>
                                <div class="col-md-4">
                                    <span class=" pagination pagination-rounded float-end">
                                        {{ $StatusDetails->links() }}
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
