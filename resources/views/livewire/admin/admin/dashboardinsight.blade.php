<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="row">
        <div class="col-xl-6">

            <div class="card">
                <div class="card-body pb-0">
                    <div class="float-end d-none d-md-inline-block">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">Report<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#" wire:click.prevent="Today">Credit </a>
                                <a class="dropdown-item" href="#" wire:click.prevent="Debit">Debit</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mb-4">Revenue Insight</h4>

                    <div class="text-center pt-3">
                        <div class="row">
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <div class="d-inline-flex">
                                    <h5 class="me-2">&#x20B9;{{$totalRevenue}}</h5>
                                    <div class="text-success font-size-12">
                                        {{-- <i class="mdi mdi-menu-up font-size-14"> </i>2.2 % --}}
                                    </div>
                                </div>
                                <p class="text-muted text-truncate mb-0">{{$Caption}}</p>
                            </div><!-- end col -->
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <div class="d-inline-flex">
                                    <h5 class="me-2"> &#x20B9; {{$lastWeekAmount[0]->lastWeekamount}}</h5>
                                    <div class="text-success font-size-12">
                                        {{-- <i class="mdi mdi-menu-up font-size-14"> </i>1.2 % --}}
                                    </div>
                                </div>
                                <p class="text-muted text-truncate mb-0">Last Week</p>
                            </div><!-- end col -->
                            <div class="col-sm-4">
                                <div class="d-inline-flex">
                                    <h5 class="me-2"> &#x20B9;{{$lastMonthAmount}}</h5>
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
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body pb-0">
                    <div class="float-end d-none d-md-inline-block">
                        <div class="dropdown">
                            <a class="text-reset" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">This Years<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#" wire:click.prevent="ServToday">Today</a>
                                <a class="dropdown-item" href="#" wire:click.prevent="ServLastWeek">Last Week</a>
                                <a class="dropdown-item" href="#" wire:click.prevent="ServLastMonth">Last Month</a>
                                <a class="dropdown-item" href="#" wire:click.prevent="ServThisYear">This Year</a>
                                <a class="dropdown-item" href="#" wire:click.prevent="ServLastYear">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mb-4">{{$ServCaption}}</h4>

                    <div class="text-center pt-3">
                        <div class="row">
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <div>
                                    <h5>{{$officeApp}}</h5>
                                    <p class="text-muted text-truncate mb-0">Office Applications</p>
                                </div>
                            </div><!-- end col -->
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <div>
                                    <h5>{{$directApp}}</h5>
                                    <p class="text-muted text-truncate mb-0">Direct Apply</p>
                                </div>
                            </div><!-- end col -->
                            <div class="col-sm-4">
                                <div>
                                    <h5>{{$callBackApp}}</h5>
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
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-end">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        </div>
                    </div>

                    <h4 class="card-title mb-4">Latest Transactions</h4>

                    <div class="table-responsive">
                        <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Sl No</th>
                                    <th>Name</th>
                                    <th>Phone No</th>
                                    <th>Service</th>
                                    <th>Amount</th>
                                    <th>Balance</th>
                                    <th>Action</th>
                                    {{-- <th>Start date</th> --}}
                                    {{-- <th style="width: 120px;">Salary</th> --}}
                                </tr>
                            </thead><!-- end thead -->
                            <tbody>
                                @foreach ($Applist as $item)
                                <tr>
                                    <td>{{$Applist->firstItem()+$loop->index}}</td>
                                    <td><h6 class="mb-0">{{$item->Name}}</h6></td>
                                    <td>{{$item->Mobile_No}}</td>
                                    <td>{{$item->Application}} | {{$item->Application_Type}}</td>
                                    <td>{{$item->Amount_Paid}} </td>
                                    <td>{{$item->Balance}} </td>
                                    <td>23</td>
                                </tr>
                                @endforeach

                                 <!-- end -->

                            </tbody><!-- end tbody -->
                        </table> <!-- end table -->
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-8">
                            <p class="text-muted">Showing {{count($Applist)}} of {{$Applist->total()}} entries</p>
                            </div>
                            {{-- <span>{{$services->links()}}</span> --}}
                            <div class="col-md-4">
                                <span class="pagination pagination-rounded float-end" >
                                    {{$Applist->links()}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-4">
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
        </div><!-- end col -->
    </div>
</div>
