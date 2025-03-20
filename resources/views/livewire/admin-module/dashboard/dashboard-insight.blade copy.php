<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="row">
        <div class="col-xl-8">

            <div class="card">
                <div class="card-body pb-0">
                    <div class="float-end d-none d-md-inline-block">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="text-muted">Report<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#" wire:click.prevent="Today">Credit </a>
                                <a class="dropdown-item" href="#" wire:click.prevent="Debit">Debit</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mb-4">Revenue Insight</h4>

                    <div class="text-center pt-4">
                        <div class="row">
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <div class="d-inline-flex">
                                    <h5 class="me-2">&#x20B9;{{ $totalSales }}</h5>
                                    <div class="text-success font-size-12">
                                        {{-- <i class="mdi mdi-menu-up font-size-14"> </i>2.2 % --}}
                                    </div>
                                </div>
                                <p class="text-muted text-truncate mb-0">Monthly</p>
                            </div><!-- end col -->
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <div class="d-inline-flex">
                                    <h5 class="me-2">&#x20B9;{{ $totalRevenue }}</h5>
                                    <div class="text-success font-size-12">
                                        {{-- <i class="mdi mdi-menu-up font-size-14"> </i>2.2 % --}}
                                    </div>
                                </div>
                                <p class="text-muted text-truncate mb-0">{{ $Caption }}</p>
                            </div><!-- end col -->
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <div class="d-inline-flex">
                                    <h5 class="me-2"> &#x20B9; {{ $lastWeekAmount[0]->lastWeekamount }}</h5>
                                    <div class="text-success font-size-12">
                                        {{-- <i class="mdi mdi-menu-up font-size-14"> </i>1.2 % --}}
                                    </div>
                                </div>
                                <p class="text-muted text-truncate mb-0">Last Week</p>
                            </div><!-- end col -->
                            <div class="col-sm-3">
                                <div class="d-inline-flex">
                                    <h5 class="me-2"> &#x20B9;{{ $lastMonthAmount }}</h5>
                                    <div class="text-success font-size-12">
                                        {{-- <i class="mdi mdi-menu-up font-size-14"> </i>1.7 % --}}
                                    </div>
                                </div>
                                <p class="text-muted text-truncate mb-0">Last Month</p>
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div>
                </div>

            </div><!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body pb-0">
                    <div class="float-end d-none d-md-inline-block">
                        <div class="dropdown">
                            <a class="text-reset" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="text-muted">This Years<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#" wire:click.prevent="ServToday">Today</a>
                                <a class="dropdown-item" href="#" wire:click.prevent="ServLastWeek">Last Week</a>
                                <a class="dropdown-item" href="#" wire:click.prevent="ServLastMonth">Last
                                    Month</a>
                                <a class="dropdown-item" href="#" wire:click.prevent="ServThisYear">This Year</a>
                                <a class="dropdown-item" href="#" wire:click.prevent="ServLastYear">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mb-4">{{ $ServCaption }}</h4>

                    <div class="text-center pt-3">
                        <div class="row">
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <div>
                                    <h5>{{ $officeApp }}</h5>
                                    <p class="text-muted text-truncate mb-0">Office Applications</p>
                                </div>
                            </div><!-- end col -->
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <div>
                                    <h5>{{ $directApp }}</h5>
                                    <p class="text-muted text-truncate mb-0">Direct Apply</p>
                                </div>
                            </div><!-- end col -->
                            <div class="col-sm-4">
                                <div>
                                    <h5>{{ $callBackApp }}</h5>
                                    <p class="text-muted text-truncate mb-0">Call Back</p>
                                </div>
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div>
                </div>

            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-end">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="" class="dropdown-item" wire:click.prevent="CreditLedger">Credit Ledger</a>
                            <a href="" class="dropdown-item" wire:click.prevent="DebitLedger">Debit Ledger</a>
                            <a href="" class="dropdown-item" wire:click.prevent="Leads">New Leads</a>
                            <a href="" class="dropdown-item" wire:click.prevent="CallBack">Call Back
                                Request</a>
                            <a href="" class="dropdown-item" wire:click.prevent="FeedBack">Feedback</a>
                        </div>
                    </div>

                    <h4 class="card-title mb-4">Latest Transactions</h4>

                    @if ($appReport)
                        <p class="text-truncate font-size-20 mb-2">Application</p>
                        <div class="table-responsive">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Name</th>
                                        <th>Phone No</th>
                                        <th>Service</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Created</th>
                                        <th>Upated</th>
                                        <th>Action</th>
                                        {{-- <th>Start date</th> --}}
                                        {{-- <th style="width: 120px;">Salary</th> --}}
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    @forelse ( $Applist as $item )
                                    <tr>
                                        <td>{{ $Applist->firstItem() + $loop->index }}</td>
                                        <td>
                                            <h6 class="mb-0">{{ $item->Name }}</h6>
                                        </td>
                                        <td>{{ $item->Mobile_No }}</td>
                                        <td>{{ $item->Application }} | {{ $item->Application_Type }}</td>
                                        <td>{{ $item->Amount_Paid }} </td>
                                        <td>{{ $item->Balance }} </td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('edit_application', $item->Id) }}" title="Edit"
                                                class="btn btn-sm btn-primary font-size-15" id="editData"><i
                                                    class="mdi mdi-circle-edit-outline"></i></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11">
                                            <img class=" avatar-xl" alt="No Result"
                                                src="{{ asset('storage/no_result.png') }}">
                                            <p>No Result Found</p>
                                        </td>
                                    </tr>
                                    @endforelse ()
                                    <!-- end -->

                                </tbody><!-- end tbody -->
                            </table> <!-- end table -->
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                    <p class="text-muted">Showing {{ count($Applist) }} of {{ $Applist->total() }}
                                        entries</p>
                                </div>
                                {{-- <span>{{$services->links()}}</span> --}}
                                <div class="col-md-4">
                                    <span class="pagination pagination-rounded float-end">
                                        {{ $Applist->links() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($creditReport)
                        <p class="text-truncate font-size-20 mb-2">Credit Ledger</p>

                        <div class="table-responsive">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Category</th>
                                        <th>Perticular</th>
                                        <th>Total Amount</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                        {{-- <th>Start date</th> --}}
                                        {{-- <th style="width: 120px;">Salary</th> --}}
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    @forelse ( $CreditLedger as $item )
                                    <tr>
                                        <td>{{ $CreditLedger->firstItem() + $loop->index }}</td>
                                        <td>
                                            <h6 class="mb-0">{{ $item->Category }}</h6>
                                        </td>
                                        <td>{{ $item->Sub_Category }}</td>
                                        <td>{{ $item->Total_Amount }}</td>
                                        <td>{{ $item->Amount_Paid }} </td>
                                        <td>{{ $item->Balance }} </td>
                                        <td class="text-wrap">{{ $item->Description }} </td>
                                        <td>
                                            <a href="{{ route('edit.credit', $item->Id) }}" title="Edit"
                                                class="btn btn-sm btn-primary font-size-15" id="editData"><i
                                                    class="mdi mdi-circle-edit-outline"></i></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11">
                                            <img class=" avatar-xl" alt="No Result"
                                                src="{{ asset('storage/no_result.png') }}">
                                            <p>No Result Found</p>
                                        </td>
                                    </tr>
                                    @endforelse ()

                                    <!-- end -->

                                </tbody><!-- end tbody -->
                            </table> <!-- end table -->
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                    <p class="text-muted">Showing {{ count($CreditLedger) }} of
                                        {{ $CreditLedger->total() }} entries</p>
                                </div>
                                {{-- <span>{{$services->links()}}</span> --}}
                                <div class="col-md-4">
                                    <span class="pagination pagination-rounded float-end">
                                        {{ $CreditLedger->links() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($debitReport)
                        <p class="text-truncate font-size-20 mb-2">Debit Ledger</p>

                        <div class="table-responsive">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Category</th>
                                        <th>Source </th>
                                        <th>Total Amount</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                        {{-- <th>Start date</th> --}}
                                        {{-- <th style="width: 120px;">Salary</th> --}}
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    @forelse ($DebitLedger as $item)
                                        <tr>
                                            <td>{{ $DebitLedger->firstItem() + $loop->index }}</td>
                                            <td>
                                                <h6 class="mb-0">{{ $item->Category }}</h6>
                                            </td>
                                            <td>{{ $item->Source }} | {{ $item->Name }}</td>
                                            <td>{{ $item->Total_Amount }}</td>
                                            <td>{{ $item->Amount_Paid }} </td>
                                            <td>{{ $item->Balance }} </td>
                                            <td class="text-wrap">{{ $item->Description }} </td>
                                            <td>
                                                <a href="{{ route('edit.debit', $item->Id) }}" title="Edit"
                                                    class="btn btn-sm btn-primary font-size-15" id="editData"><i
                                                        class="mdi mdi-circle-edit-outline"></i></a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="11">
                                                <img class=" avatar-xl" alt="No Result"
                                                    src="{{ asset('storage/no_result.png') }}">
                                                <p>No Result Found</p>
                                            </td>
                                        </tr>
                                        @endforelse ()

                                </tbody><!-- end tbody -->
                            </table> <!-- end table -->
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                    <p class="text-muted">Showing {{ count($DebitLedger) }} of
                                        {{ $DebitLedger->total() }} entries</p>
                                </div>
                                {{-- <span>{{$services->links()}}</span> --}}
                                <div class="col-md-4">
                                    <span class="pagination pagination-rounded float-end">
                                        {{ $DebitLedger->links() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif


                    {{-- Call Back Report Start --}}
                    @if ($callBackReport)
                        <p class="text-truncate font-size-20 mb-2">Callback Requests</p>

                        <div class="table-responsive">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Service</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    @forelse ($callbacks as $item)
                                        <tr>
                                            <td>{{ $callbacks->firstItem() + $loop->index }}</td>
                                            <td>
                                                <h6 class="mb-0">{{ $item->Name }}</h6>
                                            </td>
                                            <td>{{ $item->Mobile_No }}</td>
                                            <td>{{ $item->Service }} | {{ $item->Service_Type }} </td>
                                            <td>{{ $item->Status }} </td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('edit.status.callback', [$item->Id, $item->Client_Id, $item->Name]) }}"
                                                    title="Edit" class="btn btn-sm btn-primary font-size-15"
                                                    id="editData"><i class="mdi mdi-circle-edit-outline"></i></a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="11">
                                                <img class=" avatar-xl" alt="No Result"
                                                    src="{{ asset('storage/no_result.png') }}">
                                                <p>No Result Found</p>
                                            </td>
                                        </tr>
                                        @endforelse ()

                                </tbody><!-- end tbody -->
                            </table> <!-- end table -->
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                    <p class="text-muted">Showing {{ count($callbacks) }} of
                                        {{ $callbacks->total() }} entries</p>
                                </div>
                                {{-- <span>{{$services->links()}}</span> --}}
                                <div class="col-md-4">
                                    <span class="pagination pagination-rounded float-end">
                                        {{ $callbacks->links() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- Call Back Report End --}}


                    {{-- Feedback Report Start --}}
                    @if ($feedbackReport)
                        <p class="text-truncate font-size-20 mb-2">Feedbacks</p>
                        <div class="table-responsive">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Name</th>
                                        <th>Phone No</th>
                                        <th>Message</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    @forelse ($feedbacks as $item)
                                        <tr>
                                            <td>{{ $feedbacks->firstItem() + $loop->index }}</td>
                                            <td>
                                                <h6 class="mb-0">{{ $item->Name }}</h6>
                                            </td>
                                            <td>{{ $item->Phone_No }}</td>
                                            <td class="text-wrap">{{ $item->Message }} </td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }} </td>
                                            <td>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }} </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="11">
                                                <img class=" avatar-xl" alt="No Result"
                                                    src="{{ asset('storage/no_result.png') }}">
                                                <p>No Result Found</p>
                                            </td>
                                        </tr>
                                        @endforelse ()

                                </tbody><!-- end tbody -->
                            </table> <!-- end table -->
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                    <p class="text-muted">Showing {{ count($feedbacks) }} of
                                        {{ $feedbacks->total() }} entries</p>
                                </div>
                                {{-- <span>{{$services->links()}}</span> --}}
                                <div class="col-md-4">
                                    <span class="pagination pagination-rounded float-end">
                                        {{ $feedbacks->links() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- Feedback Report End --}}


                    {{-- Lead Report Start --}}
                    @if ($leadReport)
                        <p class="text-truncate font-size-20 mb-2">Lead Report</p>
                        <div class="table-responsive">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Name</th>
                                        <th>Mobile No </th>
                                        <th>Application</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    @forelse ($leads as $item)
                                        <tr>
                                            <td>{{ $leads->firstItem() + $loop->index }}</td>
                                            <td>
                                                <h6 class="mb-0">{{ $item->Name }}</h6>
                                            </td>
                                            <td>{{ $item->App_MobileNo }} | {{ $item->Mobile_No }}</td>
                                            <td>{{ $item->Application }} | {{ $item->Application_Type }}</td>
                                            <td class="text-wrap">{{ $item->Message }} </td>
                                            <td>{{ $item->Status }} </td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }} </td>
                                            <td>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }} </td>
                                            <td>
                                                <a href="{{ route('edit_application', $item->Id) }}" title="Edit"
                                                    class="btn btn-sm btn-primary font-size-15" id="editData"><i
                                                        class="mdi mdi-circle-edit-outline"></i></a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="11">
                                                <img class=" avatar-xl" alt="No Result"
                                                    src="{{ asset('storage/no_result.png') }}">
                                                <p>No Result Found</p>
                                            </td>
                                        </tr>
                                        @endforelse ()

                                </tbody><!-- end tbody -->
                            </table> <!-- end table -->
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                    <p class="text-muted">Showing {{ count($leads) }} of {{ $leads->total() }}
                                        entries</p>
                                </div>
                                {{-- <span>{{$services->links()}}</span> --}}
                                <div class="col-md-4">
                                    <span class="pagination pagination-rounded float-end">
                                        {{ $leads->links() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- Lead Report End --}}

                </div><!-- end card -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
        {{-- <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-end">
                        <select class="form-select shadow-none form-select-sm">
                            <option selected>Apr</option>
                            <option value="1">Mar</option>
                            <option value="2">Feb</option>
                            <option value="3">Jan</option>
                        </select>
                    </div>
                    <h4 class="card-title mb-4">Monthly Earnings</h4>

                    <div class="row">
                        <div class="col-4">
                            <div class="text-center mt-4">
                                <h5>3475</h5>
                                <p class="mb-2 text-truncate">Market Place</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-4">
                            <div class="text-center mt-4">
                                <h5>458</h5>
                                <p class="mb-2 text-truncate">Last Week</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-4">
                            <div class="text-center mt-4">
                                <h5>9062</h5>
                                <p class="mb-2 text-truncate">Last Month</p>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="mt-4">
                        <div id="donut-chart" class="apex-charts"></div>
                    </div>
                </div>
            </div><!-- end card -->
        </div><!-- end col --> --}}
    </div>
</div>
