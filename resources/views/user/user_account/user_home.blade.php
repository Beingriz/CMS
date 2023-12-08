@extends('user\user_account\user_account_master')
@section('UserAccount')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row align-content-center"> {{-- Start of Services Row --}}
                <a href="#" class="col-xl-3 col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">

                                {{-- <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="fas fa-edit"></i></i>
                                </span>
                            </div> --}}
                                <div class="flex-grow-1 align-items-center">
                                    <h5 class="text-truncate text-primary font-size-20 mb-2">{{ Auth::user()->name }}</h5>
                                    <div class="col-8">
                                        <div class="text-center mt-8">
                                            <h5>Applied {{ $Applied }} Services</h5>
                                            <p class="mb-2 text-truncate">Registerd Since {{ $reg_on }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- @if ($old_Applicant_Image != 'Not Available') --}}
                                {{-- <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{asset('storage/'.$old_Applicant_Image)}}" alt="ApplicantImage"> --}}
                                {{-- @else --}}
                                <img class="rounded avatar-md" src="{{ asset('storage/no_image.jpg') }}" alt="no_image" />
                                {{-- @endif --}}


                            </div>
                        </div>
                    </div>
                </a>

                <a href="#" class="col-xl-3 col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">

                                {{-- <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="fas fa-edit"></i></i>
                                </span>
                            </div> --}}
                                <div class="flex-grow-1 align-items-center">
                                    <h5 class="text-truncate text-warning font-size-20 mb-2">Applications Deliverd</h5>
                                    <div class="col-8">
                                        <div class="text-center mt-8">
                                            <h5>Delivered : {{ $Delivered }}</h5>
                                            <p class="mb-2 text-truncate">{{ $perc }}% Completed </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{ (!empty($item->Thumbnail))?url('storage/Admin/Services/Thumbnail'.$item->Thumbnail):url('storage/no_image.jpg')}}" alt="Generic placeholder image"> --}}
                                <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg"
                                    src="{{ url('storage/no_image.jpg') }}" alt="Generic placeholder image">

                            </div>
                        </div>
                    </div>
                </a>

                <a href="#" class="col-xl-3 col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">

                                {{-- <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="fas fa-edit"></i></i>
                                </span>
                            </div> --}}
                                <div class="flex-grow-1 align-items-center">
                                    <h5 class="text-truncate text-danger font-size-20 mb-2">Payment</h5>
                                    <div class="col-8">
                                        <div class="text-center mt-8">
                                            <h5>Due &#x20B9;{{ $bal }}/-</h5>
                                            <p class="mb-2 text-truncate">Paid {{ $paid }}<span> &#x20B9;</span></p>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg"
                                    src="{{ url('storage/no_image.jpg') }}" alt="Generic placeholder image">

                            </div>
                        </div>
                    </div>
                </a>


            </div> {{-- End of Row --}}
        </div>
        <div class="container-xxl py-5">
            <div class="container">
                <div class="section-title text-center">
                    <h1 class="display-5 mb-5">Dashboard</h1>
                </div>
                <div class="row g-4">
                    @foreach ($services as $item)
                        <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="service-item">
                                <div class="overflow-hidden">
                                    <img class="img-fluid" src="{{ asset('storage/' . $item['Thumbnail']) }}" alt="">
                                </div>
                                <div class="p-4 text-center border border-5 border-light border-top-0">
                                    <h4 class="mb-3">{{ $item['Name'] }}</h4>
                                    <p>{{ $item['Description'] }}</p>
                                    <a class="fw-medium" href="{{ route('serv.details', ['id' => $item['Id']]) }}">Read More<i
                                            class="fa fa-arrow-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
