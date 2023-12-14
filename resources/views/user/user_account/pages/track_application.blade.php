@extends('user\user_account\user_account_master')
@section('UserAccount')
    <div class="page-content" style="margin-top: -15px">
        <div class="container-fluid">
            <!-- Page Header Start -->
            <div class="container-fluid page-header py-5 mb-5">
                <div class="container py-5">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Track App.</h1>
                    <nav aria-label="breadcrumb animated slideInDown">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-white"
                                    href="{{ route('user.home', Auth::user()->id) }}">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('about.us') }}">Services</a>
                            </li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Track</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header End -->

        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="card">
                        <div class="card-header d-sm-flex align-items-center justify-content-between">
                            <h5 class="card-title ">Track Application</h5>
                            <h5 class="card-title ">Applied {{ $time }}</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($records as $item)
                                <div class="row ">
                                    <div class="col-md-6 col-lg-6">
                                        {{-- ID --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="">Application Id</label>
                                            </div>
                                            <div class="col-6">
                                                <label for="">{{ $Id }}</label>
                                            </div>
                                        </div>
                                        {{-- Name --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="">Name</label>
                                            </div>
                                            <div class="col-6">
                                                <label
                                                    class="{{ !empty($item->Delivered_Date) ? 'text-success' : 'text-primary' }}">{{ $item->Name }}</label>
                                            </div>
                                        </div>
                                        {{-- Mobile Number --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="">Mobile Number</label>
                                            </div>
                                            <div class="col-6">
                                                <label for="">{{ $item->Mobile_No }}</label>
                                            </div>
                                        </div>
                                        {{-- Date of Birth --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="">Date of Birth</label>
                                            </div>
                                            <div class="col-6">
                                                <label for="">{{ $item->Dob }}</label>
                                            </div>
                                        </div>
                                        {{-- Father Name --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="">Father Name</label>
                                            </div>
                                            <div class="col-6">
                                                <label for="">{{ $item->Relative_Name }}</label>
                                            </div>
                                        </div>
                                        {{-- Service --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="">Service</label>
                                            </div>
                                            <div class="col-6">
                                                <label for="">{{ $item->Application }}</label>
                                            </div>
                                        </div>
                                        {{-- Service Type --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="">Service Type</label>
                                            </div>
                                            <div class="col-6">
                                                <label
                                                    class="{{ !empty($item->Delivered_Date) ? $item->Delivered_Date : 'text-info' }}">{{ $item->Application_Type }}</label>
                                            </div>
                                        </div>
                                        {{-- Status --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="">Status</label>
                                            </div>
                                            <div class="col-6">
                                                <label
                                                    class="{{ !empty($item->Status) ? 'text-success' : 'text-danger' }}">{{ $item->Status }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-6">
                                        {{-- Acknowledgment --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="">Acknowledgment No</label>
                                            </div>
                                            <div class="col-6">
                                                <label
                                                    class="{{ !empty($item->Ack_No) ? 'text-success' : 'text-danger' }}">{{ !empty($item->Ack_No) ? strtoupper( $item->Ack_No) : 'Not Available' }}</label>
                                            </div>
                                        </div>
                                        {{-- Document --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="">Document No</label>
                                            </div>
                                            <div class="col-6">
                                                <?php
                                                    $Doc_No = $item->Document_No;
                                                    $visiblePart = substr($Doc_No, -4); // Get the last 4 characters
                                                    $Doc_No  =  strtoupper(str_pad($visiblePart, strlen($Doc_No), 'x', STR_PAD_LEFT));
                                                ?>
                                                <label
                                                    class="{{ !empty($Doc_No) ? 'text-success' : 'text-danger' }}">{{ !empty($Doc_No) ? $Doc_No : 'Not Available' }}</label>
                                            </div>
                                        </div>
                                        {{-- Total Amount --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="">Total Amount</label>
                                            </div>
                                            <div class="col-6">
                                                <label
                                                    class="{{ !empty($item->Total_Amount) ? $item->Total_Amount : 'text-danger' }}">{{ !empty($item->Total_Amount) ? $item->Total_Amount : 'Not Available' }}</label>
                                            </div>
                                        </div>
                                        {{-- Amount Paid --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="">Amount Paid</label>
                                            </div>
                                            <div class="col-6">
                                                <label
                                                    class="{{ !empty($item->Amount_Paid) ? $item->Amount_Paid : 'text-danger' }}">{{ !empty($item->Amount_Paid) ? $item->Amount_Paid : 'Not Available' }}</label>
                                            </div>
                                        </div>
                                        {{-- Balance --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="">Balance</label>
                                            </div>
                                            <div class="col-6">
                                                <label
                                                    class="{{ !empty($item->Balance) ? $item->Balance : 'text-danger' }}">{{ !empty($item->Balance) ? $item->Balance : 'Not Available' }}</label>
                                            </div>
                                        </div>
                                        {{-- Updated on --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="">Updated on</label>
                                            </div>
                                            <div class="col-6">
                                                <label
                                                    class="{{ !empty($item->Delivered_Date) ? 'text-info bg-light' : 'text-danger' }}">{{ !empty($item->Delivered_Date) ? \Carbon\Carbon::parse($item->Delivered_Date)->diffForHumans().' on '. \Carbon\Carbon::parse($item->Delivered_Date)->format('d-m-Y') : 'Not Available' }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                Applied {{ $time }}
                                <a class="btn btn-sn btn-info btn-rounded" href='{{route('history', Auth::user()->mobile_no)}}'>Goto My Orders</a>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
