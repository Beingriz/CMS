<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Digital Cyber</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Favicon -->
        <link href="{{asset('frontend/assets/img/favicon.ico')}}" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{asset('frontend/assets/lib/animate/animate.min.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/assets/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{asset('frontend/assets/css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{asset('frontend/assets/css/style.css')}}" rel="stylesheet">
        {{-- Toaster Message Style Sheet --}}
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
        <!-- MDB -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet" />

        {{-- MDB Design Sheets --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="{{asset('frontend/assets/mdb/css/mdb.min.css')}}" />

        @livewireStyles

    </head>
    <body>

        <section class="vh-100" style="background-color: #eee;">
            <div class="container h-100">
              <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                  <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                      <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                          <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Forgot Password</p>
                            <!-- Pills content -->
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="text-center mb-3">
                                        <p>Reset your Password</p>
                                        </div>
                                        <p class="text-center">Enter Your <strong>E-mail</strong> and instructions will be sent to you!</p>
                                        <!-- Session Status -->
                                        <x-auth-session-status class="mb-4" :status="session('status')" />

                                        <!-- Validation Errors -->
                                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                                        <!-- Email input -->
                                        <div class="form-outline mb-4">
                                        <input type="email" id="loginName" name="email" class="form-control" />
                                        <label class="form-label"  for="loginName">Email or username</label>
                                        </div>
                                        <!-- Submit button -->
                                        <button type="submit" class="btn btn-primary btn-block mb-4">Send Email</button>

                                        <!-- Register buttons -->
                                        <div class="text-center">
                                        <p>Not a member? <a href="{{route('register')}}">Register</a></p>
                                        </div>
                                    </form>
                                    </div>
                                    <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
                                    </div>
                                </div>
                            <!-- Pills content -->
                        </div>
                        <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                            class="img-fluid" alt="Sample image">

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>


























        <!-- JavaScript Libraries -->
        @livewireScripts
        {{-- Toaset Script  --}}

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset('frontend/assets/lib/wow/wow.min.js')}}"></script>
        <script src="{{asset('frontend/assets/lib/easing/easing.min.js')}}"></script>
        <script src="{{asset('frontend/assets/lib/waypoints/waypoints.min.js')}}"></script>
        <script src="{{asset('frontend/assets/lib/counterup/counterup.min.js')}}"></script>
        <script src="{{asset('frontend/assets/lib/owlcarousel/owl.carousel.min.js')}}"></script>
        <script src="{{asset('frontend/assets/lib/isotope/isotope.pkgd.min.js')}}"></script>
        <script src="{{asset('frontend/assets/lib/lightbox/js/lightbox.min.js')}}"></script>

        <!-- Template Javascript -->
        <script src="{{asset('frontend/assets/js/main.js')}}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
            @if(Session::has('message'))
            var type = "{{ Session::get('alert-type','info') }}"
            switch(type){
                case 'info':
                toastr.info(" {{ Session::get('message') }} ");
                break;

                case 'success':
                toastr.success(" {{ Session::get('message') }} ");
                break;

                case 'warning':
                toastr.warning(" {{ Session::get('message') }} ");
                break;

                case 'error':
                toastr.error(" {{ Session::get('message') }} ");
                break;
            }
            @endif
        </script>

        <script type="text/javascript" src="{{asset('frontend/assets/mdb/js/mdb.min.js.map')}}"></script>
        <!-- MDB -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js" ></script>
    </body>
</html>
