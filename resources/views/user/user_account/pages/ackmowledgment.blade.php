@extends('user\user_account\user_account_master')
@section('UserAccount')
    {{-- The whole world belongs to you. --}}
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
    <div class="container-fluid page-header py-5 ">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Acknowledgment</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="{{route('user.home',Auth::user()->id)}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="{{route('service.list')}}">Services</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">My History</li>
                </ol>
            </nav>
        </div>
    </div>
<div class="page-content" >
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <section id="cd-timeline" class="cd-container">
                            <div class="cd-timeline-block">
                                <div class="cd-timeline-img cd-success">
                                    <i class="mdi mdi-adjust"></i>
                                </div> <!-- cd-timeline-img -->

                                <div class="cd-timeline-content">
                                    <h3>Thank You!. Application Submitted</h3>
                                    <p class="mb-0 text-muted font-14">Please Note down your Application Id <strong>{{$App_Id}}</strong> </p>
                                    <span class="cd-date">{{$date->format('d-M-Y')}}</span>
                                </div> <!-- cd-timeline-content -->
                            </div> <!-- cd-timeline-block -->

                            <div class="cd-timeline-block">
                                <div class="cd-timeline-img cd-danger">
                                    <i class="mdi mdi-adjust"></i>
                                </div> <!-- cd-timeline-img -->

                                <div class="cd-timeline-content">
                                    <h3>Payment & Validation</h3>
                                    <p class="m-b-20 text-muted font-14">The provided document and application will undergo a validation process.</p>
                                    <a href="{{route('track',$App_Id)}}" class="btn btn-primary btn-rounded waves-effect waves-light m-t-5">Track Application</a>

                                    <span class="cd-date">{{$date->addDays(2)->format('d-M-Y')}}</span>
                                </div> <!-- cd-timeline-content -->
                            </div> <!-- cd-timeline-block -->

                            <div class="cd-timeline-block">
                                <div class="cd-timeline-img cd-info">
                                    <i class="mdi mdi-adjust"></i>
                                </div> <!-- cd-timeline-img -->

                                <div class="cd-timeline-content">
                                    <h3>Processing.</h3>
                                    <p class="mb-0 text-muted font-14">After succesfull Validation of Payment and Documents the applied services will be processed and Delivered within the timeline.</a></p>
                                    <span class="cd-date">{{$date->addDays(4)->format('d-M-Y')}}</span>
                                </div> <!-- cd-timeline-content -->
                            </div> <!-- cd-timeline-block -->

                            <div class="cd-timeline-block">
                                <div class="cd-timeline-img cd-pink">
                                    <i class="mdi mdi-adjust"></i>
                                </div> <!-- cd-timeline-img -->

                                <div class="cd-timeline-content">
                                    <h3>Delivery.</h3>
                                    <p class="m-b-20 text-muted font-14">On Successfull Completion of applied service from the concern department our team will contact you back on the Registered Mobile Number for the Delivery. </p>
                                    <img src="assets/images/small/img-1.jpg" alt="" class="rounded" style="width: 120px;">
                                    <img src="assets/images/small/img-2.jpg" alt="" class="rounded" style="width: 120px;">
                                    <span class="cd-date">Updated soon...</span>
                                </div> <!-- cd-timeline-content -->
                            </div> <!-- cd-timeline-block -->

                            <div class="cd-timeline-block">
                                <div class="cd-timeline-img cd-warning">
                                    <i class="mdi mdi-adjust"></i>
                                </div> <!-- cd-timeline-img -->

                                <div class="cd-timeline-content">
                                    <h3>Thank You!</h3>
                                    <p class="m-b-20 text-muted font-14">Thank you for choosing our service! We greatly appreciate your decision to apply for our service and we hope to exceed your expectations. We kindly ask if you could take a moment to provide us with feedback on your experience so we can continue to improve our service and better serve our customers in the future. Thank you again for your trust and confidence in our team.</p>



                                    <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light">Feedback</button>
                                    <span class="cd-date">Updated Soon..</span>
                                </div> <!-- cd-timeline-content -->
                            </div> <!-- cd-timeline-block -->
                        </section> <!-- cd-timeline -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
