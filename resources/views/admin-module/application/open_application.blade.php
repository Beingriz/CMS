@extends('admin.admin_master')
@section('admin')
    ;
    <div class="page-content" style="margin-top: -45px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Application Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Digital Cyber</a></li>
                                <li class="breadcrumb-item active">Services Board</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('Dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('new.application') }}">New Application</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('update_application') }}">Update</a></li>
                </ol>
            </div>{{-- End of Page Tittle --}}
            {{-- @include('Layouts.left_menu') --}}
            @livewire('open-application', ['Id' => $Client_Id])
            {{-- @include('Layouts.right_insight') --}}
        @endsection
