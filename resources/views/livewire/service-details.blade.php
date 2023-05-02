<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
     <!-- Page Header Start -->
     <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">{{$ServiceName}}</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="{{route('about_us')}}">About Us</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Services</li>
                </ol>
            </nav>
        </div>
    </div>
<!-- Page Header End -->
    <!-- Service Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="section-title text-center">
                    <h1 class="display-5 mb-5">{{$ServiceName}}</h1>
                </div>
                <div class="row g-4">
                    @foreach ($subservices as $item )
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">

                        <div class="service-item">
                            <div class="overflow-hidden">
                                {{-- <img class="img-fluid" src="{{asset('storage/'.$item['Thumbnail'])}}" alt=""> --}}
                            </div>
                            <div class="p-4 text-center border border-5 border-light border-top-0">
                                <h4 class="mb-3">{{$item['Name']}}</h4>
                                {{-- <p>{{$item['Description']}}</p> --}}
                                <a class="fw-medium" href="#details" wire:click="GetDetails('{{$item->Id}}')">Read More<i class="fa fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    <!-- Service End -->
        {{-- Service Details  Start--}}

    <!-- About Start -->
    <div id="details" class="container-fluid bg-light overflow-hidden my-5 px-lg-0">
        @if($display)
            <div >
                <div class="container about px-lg-0">
                    <div class="row g-0 mx-lg-0">
                        <div class="col-lg-6 ps-lg-0" style="min-height: 400px;">
                            <div class="position-relative h-100">
                                @foreach ($SubServices as $item)
                                <img class="position-absolute img-fluid w-100 h-100" src="{{asset('storage/'.$item['Thumbnail'])}}" style="object-fit: cover;" alt="">
                            </div>
                        </div>
                        <div class="col-lg-6 about-text py-5 wow fadeIn" data-wow-delay="0.5s">
                            <div class="p-lg-5 pe-lg-0">
                                <div class="section-title text-start">
                                    <h1 class="display-5 mb-4">{{$item['Name']}}</h1>
                                </div>
                                <p class="mb-4 pb-2">{{$item['Description']}}</p>
                                <div class="row g-4 mb-4 pb-2">
                                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white" style="width: 60px; height: 60px;">
                                                <i class="fa fa-users fa-2x text-primary"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h2 class="text-primary mb-1" data-toggle="counter-up">{{$item['Total_Amount']}}</h2>
                                                <p class="fw-medium mb-0">Happy Clients</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white" style="width: 60px; height: 60px;">
                                                <i class="fa fa-check fa-2x text-primary"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h2 class="text-primary mb-1" data-toggle="counter-up">{{$item['Total_Count']}}</h2>
                                                <p class="fw-medium mb-0">Services Delivered</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="#documents" wire:click="Documents('{{$item['Id']}}')" class="btn btn-primary py-3 px-3">View Documents</a>
                                <a href="" class="btn btn-primary py-3 px-3">Apply Now</a>
                                <a href="{{route('contact_us')}}" class="btn btn-primary py-3 px-3">Get Callback</a>
                            </div>
                        </div>
                    </div>
                    <div id="documents">
                        @if ($show)
                        <div class="col-lg-6 about-text py-5 wow fadeIn" data-wow-delay="0.5s">
                            <div class="p-lg-5 pe-lg-0">
                                <div class="p-4 text-center border border-5 border-light border-top-0">
                                    <h4 class="mb-3">Required Documents for {{$item['Name']}}</h4>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th>Sl_No</th>
                                        <th>Docment Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($documents as $item )
                                        <tr>
                                            <td>{{$sl++}}</td>
                                            <td>{{$item['Name']}}</td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
<!-- About End -->
    {{-- Service Details  End--}}
</div>
