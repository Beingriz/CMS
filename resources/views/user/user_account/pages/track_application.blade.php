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
                    <li class="breadcrumb-item"><a class="text-white" href="{{route('user.home',Auth::user()->id)}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="{{route('about.us')}}">Services</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Track</li>
                </ol>
            </nav>
        </div>
        </div>
    </div>
<!-- Page Header End -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between">
                    <h5 class="card-title ">Track Application</h5>
                    <h5 class="card-title ">Applied {{$time}}</h5>
                </div>
                <div class="card-body">
                    @foreach ($records as $item )
                    <div class="row ">
                        <p for="App_Id" class="col-sm-3 text-primary " >Application Id</p>
                        <label for="App_Id" class="col-sm-1 d-none d-sm-block">:</label>
                        <p for="App_Id" class="col-sm-8  text-black">{{$Id}}</p>
                    </div>
                    <hr>
                    <div class="row ">
                        <p for="Name" class="col-sm-3 text-primary " >Name</p>
                        <label for="Name" class="col-sm-1 d-none d-sm-block">:</label>
                        <p for="Name" class="col-sm-8  text-black">{{$item->Name}}</p>
                    </div>
                    <hr>
                    <div class="row ">
                        <p for="Name" class="col-sm-3 text-primary " >Mobile Number</p>
                        <label for="Name" class="col-sm-1 d-none d-sm-block">:</label>
                        <p for="Name" class="col-sm-8  text-black">{{$item->Mobile_No}}</p>
                    </div>
                    <hr>
                    <div class="row ">
                        <p for="Name" class="col-sm-3 text-primary " >Date of Birth</p>
                        <label for="Name" class="col-sm-1 d-none d-sm-block">:</label>
                        <p for="Name" class="col-sm-8  text-black">{{$item->Dob}}</p>
                    </div>
                    <hr>
                    <div class="row ">
                        <p for="App_Id" class="col-sm-3 text-primary " >Father Name</p>
                        <label for="App_Id" class="col-sm-1 d-none d-sm-block">:</label>
                        <p for="App_Id" class="col-sm-8  text-black">{{$item->Relative_Name}}</p>
                    </div>
                    <hr>
                    <div class="row ">
                        <p for="App_Id" class="col-sm-3 text-primary " >Service</p>
                        <label for="App_Id" class="col-sm-1 d-none d-sm-block">:</label>
                        <p for="App_Id" class="col-sm-8  text-black">{{$item->Application}}</p>
                    </div>
                    <hr>
                    <div class="row ">
                        <p for="App_Id" class="col-sm-3 text-primary " >Service Type</p>
                        <label for="App_Id" class="col-sm-1 d-none d-sm-block">:</label>
                        <p for="App_Id" class="col-sm-8  text-black">{{$item->Application_Type}}</p>
                    </div>
                    <hr>
                    <div class="row ">
                        <p for="App_Id" class="col-sm-3 text-primary " >Status</p>
                        <label for="App_Id" class="col-sm-1 d-none d-sm-block">:</label>
                        <p for="App_Id" class="col-sm-8  text-black">{{$item->Status}}</p>
                    </div>
                    Applied {{$time}}

                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row ">
                        <p for="App_Id" class="col-sm-3 text-primary " >Acknowledgment No</p>
                        <label for="App_Id" class="col-sm-1 d-none d-sm-block">:</label>
                        <p for="App_Id" class="col-sm-8  text-black">{{$item->Ack_No}}</p>
                        {{-- <a href="{{ route('download_ack',$Id) }}" id="download">Dowload Ack</a> --}}

                    </div>
                    <hr>
                    <div class="row ">
                        <p for="Name" class="col-sm-3 text-primary " >Document No</p>
                        <label for="Name" class="col-sm-1 d-none d-sm-block">:</label>
                        <p for="Name" class="col-sm-8  text-black">{{$item->Doc_No}}</p>
                    </div>
                    <hr>
                    <div class="row ">
                        <p for="Name" class="col-sm-3 text-primary " >Total Amount</p>
                        <label for="Name" class="col-sm-1 d-none d-sm-block">:</label>
                        <p for="Name" class="col-sm-8  text-black">{{$item->Total_Amount}}</p>
                    </div>
                    <hr>
                    <div class="row ">
                        <p for="Name" class="col-sm-3 text-primary " >Amount Paid</p>
                        <label for="Name" class="col-sm-1 d-none d-sm-block">:</label>
                        <p for="Name" class="col-sm-8  text-black">{{$item->Amount_Paid}}</p>
                    </div>
                    <hr>
                    <div class="row ">
                        <p for="App_Id" class="col-sm-3 text-primary " >Balance</p>
                        <label for="App_Id" class="col-sm-1 d-none d-sm-block">:</label>
                        <p for="App_Id" class="col-sm-8  text-danger">{{$item->Balance}}</p>
                    </div>
                    <hr>
                    <div class="row ">
                        <p for="App_Id" class="col-sm-3 text-primary " >Updated on</p>
                        <label for="App_Id" class="col-sm-1 d-none d-sm-block">:</label>
                        <p for="App_Id" class="col-sm-8  text-black">{{$item->Delivered_Date}}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
