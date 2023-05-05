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
                            <li class="breadcrumb-item active"><a href="{{route('my.history',Auth::user()->mobile_no)}}">My History</a></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>{{-- End of Row --}}

        <div class="row"> {{-- Start of Search Result Details Row --}}
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">{{count($services)}} Search Result found. </h4>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">

                                <thead class="table-light">
                                    <tr>
                                        <th>Sl.No</th>
                                        <th >Received</th>
                                        <th >Name</th>
                                        <th >Application</th>
                                        <th >Services</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse( $services as $data )
                                    <tr>
                                        <td>{{$services->firstItem()+$loop->index }}</td>
                                        <td>{{ $data->Received_Date }}</td>
                                        <td>{{ $data->Name }}</td>
                                        <td>{{ $data->Mobile_No }}</td>
                                        <td>{{ $data->Application}}</td>
                                        <td>{{$data->Application_Type}}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                                                    <a class="dropdown-item" title="View Applicaiton" href="#">View</a>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11">
                                                <img class=" avatar-xl" alt="No Result" src="{{asset('storage/no_result.png')}}">
                                                <p>No Result Found</p>
                                            </td>
                                        </tr>
                                    @endforelse()
                                </tbody>

                            </table>
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                <p class="text-muted">Showing {{count($services)}} of {{$services->total()}} entries</p>
                                </div>
                                {{-- <span>{{$services->links()}}</span> --}}
                                <div class="col-md-4">
                                    <span class="pagination pagination-rounded float-end" >
                                        {{$services->links()}}
                                    </span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
