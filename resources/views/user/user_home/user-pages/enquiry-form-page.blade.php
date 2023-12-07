@extends('user.user_main_master')
@section('user')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Contact Us</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="{{route('aboutus')}}">About Us</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Consultation</li>
                </ol>
            </nav>
        </div>
    </div>
<!-- Page Header End -->
    @livewire('user-module.enquiry-form')
@endsection

