@extends('user\user_account\user_account_master')
@section('UserAccount')

<div class="page-content" style="margin-top: -45px">
    <div class="container=fluid">

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">About Us</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="{{route('user.home',Auth::user()->id)}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="{{route('service.list')}}">Services</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">About</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
<!-- Top Feature Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
                                <i class="fa fa-user-check fa-2x text-primary"></i>
                            </div>
                            <h1 class="display-1 text-light mb-0">01</h1>
                        </div>
                        <h5>Documentation Specialist</h5>
                    </div>
                    <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
                                <i class="fa fa-check fa-2x text-primary"></i>
                            </div>
                            <h1 class="display-1 text-light mb-0">02</h1>
                        </div>
                        <h5>Ontime Service Delivery</h5>
                    </div>
                    <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.5s">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
                                <i class="fa fa-drafting-compass fa-2x text-primary"></i>
                            </div>
                            <h1 class="display-1 text-light mb-0">03</h1>
                        </div>
                        <h5>Free Consultation</h5>
                    </div>
                    <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.7s">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
                                <i class="fa fa-headphones fa-2x text-primary"></i>
                            </div>
                            <h1 class="display-1 text-light mb-0">04</h1>
                        </div>
                        <h5>Customer Support</h5>
                    </div>
                </div>
            </div>
        </div>
<!--  Top Feature Start -->


<!-- About Start -->
        <div class="container-fluid bg-light overflow-hidden my-5 px-lg-0">
            <div class="container about px-lg-0">
                <div class="row g-0 mx-lg-0">
                    <div class="col-lg-6 ps-lg-0" style="min-height: 400px;">
                        <div class="position-relative h-100">
                            @foreach ($aboutus as $item)


                            <img class="position-absolute img-fluid w-100 h-100" src="{{asset('storage/'.$item['Image'])}}" style="object-fit: cover;" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 about-text py-5 wow fadeIn" data-wow-delay="0.5s">
                        <div class="p-lg-5 pe-lg-0">
                            <div class="section-title text-start">
                                <h1 class="display-5 mb-4">{{$item['Tittle']}}</h1>
                            </div>
                            <p class="mb-4 pb-2">{{$item['Description']}}</p>
                            <div class="row g-4 mb-4 pb-2">
                                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white" style="width: 60px; height: 60px;">
                                            <i class="fa fa-users fa-2x text-primary"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h2 class="text-primary mb-1" data-toggle="counter-up">{{$item['Total_Clients']}}</h2>
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
                                            <h2 class="text-primary mb-1" data-toggle="counter-up">{{$item['Delivered']}}</h2>
                                            <p class="fw-medium mb-0">Services Delivered</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="" class="btn btn-primary py-3 px-5">Explore More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
<!-- About End -->

<!--Bottom Feature Start -->
    <div class="container-fluid bg-light overflow-hidden my-5 px-lg-0">
        <div class="container feature px-lg-0">
            <div class="row g-0 mx-lg-0">
                <div class="col-lg-6 feature-text py-5 wow fadeIn" data-wow-delay="0.5s">
                    <div class="p-lg-5 ps-lg-0">
                        <div class="section-title text-start">
                            <h1 class="display-5 mb-4">Why Choose Us</h1>
                        </div>
                        <p class="mb-4 pb-2">The team at DIGITAL CYBER is knowledgeable and experienced in handling various government-related tasks and can provide guidance and assistance to customers throughout the process</p>
                        <div class="row g-4">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white" style="width: 60px; height: 60px;">
                                        <i class="fa fa-check fa-2x text-primary"></i>
                                    </div>
                                    <div class="ms-4">
                                        <p class="mb-2">Quality</p>
                                        <h5 class="mb-0">Services</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white" style="width: 60px; height: 60px;">
                                        <i class="fa fa-user-check fa-2x text-primary"></i>
                                    </div>
                                    <div class="ms-4">
                                        <p class="mb-2">Document</p>
                                        <h5 class="mb-0">Experts</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white" style="width: 60px; height: 60px;">
                                        <i class="fa fa-drafting-compass fa-2x text-primary"></i>
                                    </div>
                                    <div class="ms-4">
                                        <p class="mb-2">Free</p>
                                        <h5 class="mb-0">Consultation</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white" style="width: 60px; height: 60px;">
                                        <i class="fa fa-headphones fa-2x text-primary"></i>
                                    </div>
                                    <div class="ms-4">
                                        <p class="mb-2">Customer</p>
                                        <h5 class="mb-0">Support</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pe-lg-0" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute img-fluid w-100 h-100" src="{{asset('frontend/assets/img/Feature-1.jpg')}}" style="object-fit: cover;" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
<!--Bottom  Feature End -->
@endsection
