@extends('user\user_account\user_account_master')
@section('UserAccount')
<div class="page-content" style="margin-top: -25px">
    <div class="container-fluid">
        <div class="row">{{-- Messags / Notification Row--}}
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Welcome {{Auth::user()->name}}<span class="text-primary"></span> </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('services')}}">Services</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('history',Auth::user()->mobile_no)}}">My History</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>{{-- End of Row --}}
        <div class="container-fluid page-header py-5 mb-5">
            <div class="container py-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Shared Document</h1>
                <nav aria-label="breadcrumb animated slideInDown">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-white" href="{{route('user.home',Auth::user()->id)}}">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-white" href="{{route('service.list')}}">Services</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">My History</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>




    <div class="container-fluid">
        <div class="row">{{-- Messags / Notification Row--}}
            <div class="col-6">
                <div class="card">
                    @foreach ($record as $item)

                    <div class="card-header">
                        <h2 class="card-title">Shared Document</h2>
                    </div>

                    <img src="{{!empty($File)?asset('storage/'.$File):url('storage/no_image.jpg')}}" class="card-img-top" alt="...">
                    <div class="card-body">

                    <p class="card-text">Shared : {{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    @foreach ($record as $item)

                    <div class="card-header">
                        <h2 class="card-title">Read Consent</h2>
                    </div>
                    <div class="card-body">
                    <h4 class="card-title font-size-18">Consent : {{$item->Consent}}</h4>
                    <p class="card-text">Shared : {{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
