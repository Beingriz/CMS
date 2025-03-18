<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Digital Cyber</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

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

        @livewireStyles

    </head>




    <body>



        <!-- header-area -->
        @include('user.body.header')
        <!-- header-area-end -->

        <!-- main-area -->
        <main>

            @yield('user_auth')

        </main>
        <!-- main-area-end -->

        <!-- Footer-area -->
        @include('user.body.footer')
        <!-- Footer-area-end -->



        <!-- JavaScript Libraries -->
        @livewireScripts
        {{-- Toaset Script  --}}

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('frontend/assets/js/custome.js') }}"></script>

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
    </body>
</html>
