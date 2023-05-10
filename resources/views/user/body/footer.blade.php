 <!-- Footer Start -->
 @foreach ($records as $key)


 <div class="container-fluid bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Address</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i><a href="https://goo.gl/maps/tx5L1kcc46qmedYGA" target="_blank_">{{$key->Address}}</a></p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"><a href="https://wa.me/+91{{$key->Phone_No}}" target="_blank_"></i>+91 {{$key->Phone_No}}</a></p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>{{$key->Email_Id}}</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social"  href="{{$key->Twitter}}" target="_blank_"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social" href="{{$key->Twitter}}" target="_blank_"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href="{{$key->Instagram}}" target="_blank_"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-outline-light btn-social"href="{{$key->Youtube}}" target="_blank_"><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-outline-light btn-social" href="{{$key->Instagram}}" target="_blank_"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Services</h4>
                <a class="btn btn-link" href="">Aadhar Update</a>
                <a class="btn btn-link" href="">Passport Assist.</a>
                <a class="btn btn-link" href="">Election ID</a>
                <a class="btn btn-link" href="">Senior Citizen Card</a>
                <a class="btn btn-link" href="">Pan Card</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Quick Links</h4>
                <a class="btn btn-link" href="{{route('aboutus')}}" title="Know More">About Us</a>
                <a class="btn btn-link" href="{{route('contact_us')}}" title="Get Callback">Contact Us</a>
                <a class="btn btn-link" href="{{route('services')}}" title="Apply Now">Our Services</a>
                <a class="btn btn-link" href="">Terms & Condition</a>
                <a class="btn btn-link" href="">Support</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Newsletter</h4>
                <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                <div class="position-relative mx-auto" style="max-width: 400px;">
                    <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                    <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="{{route('aboutus')}}">Digital Cyber</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By Md Rizwan<a class="border-bottom" href="http://mdrizwan.great-site.net"></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-0 back-to-top"><i class="bi bi-arrow-up"></i></a>
  @endforeach
