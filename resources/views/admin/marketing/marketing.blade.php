@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Marketing Dashboard</h4>

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


        @livewire('admin.marketing.marketing-dashboard')
        <!-- end row -->


        <!-- end row -->
    </div>

</div>

@endsection
