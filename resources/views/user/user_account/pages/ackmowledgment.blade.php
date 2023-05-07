@extends('user\user_account\user_account_master')
@section('UserAccount')
<div class="page-content" style="margin-top: -15px">
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
                                    <a href="" wire:click.prevent="TrackApplication" class="btn btn-primary btn-rounded waves-effect waves-light m-t-5">Track Application</a>

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
