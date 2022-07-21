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
                                <div class="flex-grow-1 align-items-center">
                                    <h5 class="text-truncate font-size-20 mb-2">{{$service->Name}} </h5>

                                    @if (($service->Temp_Count)>=1)
                                    <p  class="text-muted mb-0 font-size-16">Pending : <span class="badge bg-warning">{{$service->Temp_Count}}</span></p>
                                    @else
                                    <p class="text-muted mb-0">Pending : <span class="badge bg-info">0</span></p>
                                    @endif
                                    <p class="text-muted mb-0 font-size-16"><span class="text-info fw-bold font-size-17 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>{{$service->Total_Amount}}</span> Total Revenue</p>

                                    <p class="text-muted mb-0 font-size-16">Total Applications <span class="text-success fw-bold font-size-17 me-2"><i class="ri-arrow-right-up-line me-1  align-middle"></i>{{$service->Total_Count}}</span></p>
                                </div>

                                <div>
                                    <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{ (!empty($service->Thumbnail))?url('storage/Admin/Services/Thumbnail'.$service->Thumbnail):url('storage/no_image.jpg')}}" alt="Generic placeholder image">
                                </div>

                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </a>
            @endforeach
        </div>
        <div class="bookmark-container">
            <div class="data-table-header">
                <p class="heading">Bookmarks </p>
            </div>
            @foreach($bookmarks as $bookmark)
            <a href="{{ $bookmark->Hyperlink }}" target="_blank" class="bookmark">
                <img class="b-img" src="{{(!empty($bookmark->Thumbnail))?url('storage/Bookmarks/Thumbnail/'.$bookmark->Thumbnail):url('storage/no_image.jpg')}}" alt="Bookmark Icon">
                <p class="b-name" >{{$bookmark->Name}}</p>
            </a>
            @endforeach
        </div>

    </div>
</div>
@endsection
