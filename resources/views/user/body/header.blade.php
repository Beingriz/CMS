    <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
        <div class="container-fluid bg-light p-0">
            <div class="row gx-0 d-none d-lg-flex">
                <div class="col-lg-7 px-5 text-start">
                    <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                        <small class="fa fa-map-marker-alt text-primary me-2"></small>
                        @foreach ($records as $key )


                        <small><a href="https://goo.gl/maps/tx5L1kcc46qmedYGA" target="_blank_">{{$key->Address}}</a></small>
                    </div>
                    <div class="h-100 d-inline-flex align-items-center py-3">
                        <small class="far fa-clock text-primary me-2"></small>
                        <small>Mon - Fri : {{$key->Time_From}} - {{$key->Time_To}}</small>
                    </div>
                </div>
                <div class="col-lg-5 px-5 text-end">
                    <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                        <a href="https://wa.me/+91{{$key->Phone_No}}" target="_blank_" >
                            <small class="fa fa-phone-alt text-primary me-2"></small>
                            <small>+91 {{$key->Phone_No}}</a></small>
                        </a>
                    </div>
                    <div class="h-100 d-inline-flex align-items-center">
                        <a class="btn btn-sm-square bg-white text-primary me-1" href="{{$key->Facebook}}" target="_blank_"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-sm-square bg-white text-primary me-1" href="{{$key->Twitter}}" target="_blank_"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-sm-square bg-white text-primary me-1" href="{{$key->LinkedIn}}" target="_blank_"><i class="fab fa-linkedin-in"></i></a>
                        <a class="btn btn-sm-square bg-white text-primary me-0" href="{{$key->Instagram}}" target="_blank_"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    <!-- Topbar End -->

    <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
            <a href="{{route('home')}}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
                <h2 class="m-0 text-primary">{{$key->Company_Name}}</h2>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    @if (Auth::check())
                    <a href="{{route('home')}}" class="nav-item nav-link active">Home</a>
                    <a href="{{route('service.list')}}" class="nav-item nav-link">Service</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{Auth::user()->name}}</a>
                        <div class="dropdown-menu fade-up m-0">
                            {{-- <a href="{{route('features')}}" class="dropdown-item">Feature</a> --}}
                            <a href="{{route('user.home',Auth::user()->id)}}" class="dropdown-item">My Account</a>
                            <a href="{{route('admin.logout')}}" id="logout" class="dropdown-item">Logout</a>

                        </div>
                    </div>
                    @else
                    <a href="{{route('home')}}" class="nav-item nav-link active">Home</a>
                    <a href="{{route('aboutus')}}" class="nav-item nav-link">About</a>
                    <a href="{{route('services')}}" class="nav-item nav-link">Service</a>
                    <a href="{{route('contact_us')}}" class="nav-item nav-link">Contact</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Account</a>
                        <div class="dropdown-menu fade-up m-0">
                            {{-- <a href="{{route('features')}}" class="dropdown-item">Feature</a> --}}
                            <a href="{{route('register')}}" class="dropdown-item">Register</a>
                            <a href="{{route('login')}}" class="dropdown-item">Login</a>
                        </div>
                    </div>
                    @endif
                </div>
                @if(!Auth::check())
                <a href="{{route('contact_us')}}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Get A Quote<i class="fa fa-arrow-right ms-3"></i></a>
                @endif

            </div>
        </nav>
    <!-- Navbar End -->

