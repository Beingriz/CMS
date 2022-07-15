@extends('admin.admin_master')
@section('admin');
<div class="page-content" style="margin-top: -45px">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Application Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Digital Cyber</a></li>
                            <li class="breadcrumb-item active">Services Board</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{url('home_dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('admin_home')}}">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{url('app_form')}}">New Application</a></li>
            </ol>
        </div>

        <div class="row">
            @foreach($Mainservices as $service)
                <a  href="{{url('dynamic_dashboard')}}/{{$service->Id}}" class="col-xl-3 col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate text-primary font-size-20 mb-2">{{$service->Name}}
                                    @if (($service->Temp_Count)>=1)
                                    <h5 class="me-2">Pending : <span class="badge bg-info">{{$service->Temp_Count}}</span></h5>
                                    @else
                                    <h5 class="mb-2">0</h5>
                                    @endif
                                    <p class="text-muted mb-0"><span class="text-success fw-bold font-size-17 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>{{$service->Total_Amount}}</span>Total Revenue</p>
                                </div>

                                <div>
                                    <img src="{{$service->Thumbnail}}"  class="rounded-circle avatar-md">
                                    <p class="text-muted mb-0"><span class="text-dark fw-bold font-size-15 me-2"><i class="dripicons-folder"></i>App : {{$service->Total_Count}}</span>
                                </div>

                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </a>
            @endforeach
        </div>


                    <div class="row"></div>
                    {{-- Applicaiton Insight --}}
                    <div class="dashboard-insight">
                        <div class="right-menu-section">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Prime Service</p>
                                <p class="section-value">Service Name</p>
                                <p class="section-pre-values">Application Count </p>
                            </div>
                        </div>
                        <div class="right-menu-section">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Montly Revenue</p>
                                <p class="section-value">Total Amount</p>
                                <p class="section-pre-values">Balance Due</p>
                            </div>
                        </div>
                        <div class="right-menu-section">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Delivered</p>
                                <p class="section-value">Total</p>
                                <p class="section-pre-values">This Month</p>
                            </div>
                        </div>
                        <div class="right-menu-section">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Pending</p>
                                <p class="section-value">Total </p>
                                <p class="section-pre-values">This Month</span></p>
                            </div>
                        </div>

                    </div>

                    <div class="row"></div>
                     {{-- Application Book Marks BookMarks --}}

                     <div class="border">
                        <div class="bookmark-container">
                            <div class="data-table-header">
                                <p class="heading">Bookmarks </p>
                            </div>
                            @foreach($bookmarks as $bookmark)
                            <a href="{{ $bookmark->Hyperlink }}" target="_blank" class="bookmark">
                                <img class="b-img" src="./{{$bookmark->Thumbnail}}" alt="Bookmark Icon">
                                <p class="b-name" >{{$bookmark->Name}}</p>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
    </div>
@endsection
