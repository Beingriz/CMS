@extends('admin-module.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Admin Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Digital Cyber</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('Dashboard')}}">Home</a> </li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{route('new.application')}}">New Application</a></li>
                <li class="breadcrumb-item"><a href="{{route('Credit')}}">Credit</a></li>
                <li class="breadcrumb-item"><a href="{{route('Debit')}}">Debit</a></li>
            </ol>
        </div>{{-- End of Page Tittle --}}

        <div class="row">
            <a class="col-xl-3 col-md-6" href="{{route('update.dashboard','Enquiry')}}" title="Enquiry Dashboard">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Enquiry Leads</p>
                                <h4 class="mb-2" data-toggle="counter-up">{{$totalEnquiries}}</h4>
                                <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from previous period</p>
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
            <a class="col-xl-3 col-md-6" href="{{route('update.dashboard','Orders')}}" title="New User Dashboard">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">New Orders</p>
                                <h4 class="mb-2">{{$totalOrders}}</h4>
                                <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>from previous period</p>
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
            <a class="col-xl-3 col-md-6" href="{{route('update.dashboard','User')}}" title="New User Dashboard">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">New Users</p>
                                <h4 class="mb-2">{{$newUsers}}</h4>
                                <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>16.2%</span>from previous period</p>
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
            <a class="col-xl-3 col-md-6" href="{{route('update.dashboard','Callback')}}" title="New User Dashboard">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Call Back </p>
                                <h4 class="mb-2">{{$callBack}}</h4>
                                <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>11.7%</span>from previous period</p>
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

        @livewire('admin-module.dashboard.dashboard-insight')
        <!-- end row -->

        {{-- resources\views\livewire\admin-module\dashboard\dashboardinsight.blade.php --}}
        <!-- end row -->
    </div>

</div>

@endsection
