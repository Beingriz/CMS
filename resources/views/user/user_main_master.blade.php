<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon --> {{-- {{asset('backend/')}} --}}

    <link rel="shortcut icon" href="{{asset('backend/assets/images/favicon.ico')}}">

    <!-- jquery.vectormap css -->
    {{-- <link href="{{asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css" /> --}}

    <!-- DataTables -->
    {{-- <link href="{{asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" /> --}}

    <!-- Responsive datatable examples -->
    {{-- <link href="{{asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" /> --}}

    <!-- Bootstrap Css -->
    <link href="{{asset('backend/assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    {{-- <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" /> --}}
    <!-- App Css-->

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
    @livewireStyles
     <!-- Libraries Stylesheet -->
     <link href="{{asset('frontend/assets/lib/animate/animate.min.css')}}" rel="stylesheet">
     <link href="{{asset('frontend/assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
     <link href="{{asset('frontend/assets/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">


     <!-- Customized Bootstrap Stylesheet -->
     <link href="{{asset('frontend/assets/css/bootstrap.min.css')}}" rel="stylesheet">

     <!-- Template Stylesheet -->
     <link href="{{asset('frontend/assets/css/style.css')}}" rel="stylesheet">
     <link href="{{asset('frontend/assets/img/favicon.ico')}}" rel="icon">

     <!-- Google Web Fonts -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">

     <!-- Icon Font Stylesheet -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

</head>
    <body>
        <!-- header-area -->
        @include('user.body.header')
        <!-- header-area-end -->

        <!-- main-area -->
        <main>

            @yield('user')

        </main>
        <!-- main-area-end -->

        <!-- Footer-area -->
        @include('user.body.footer')
        <!-- Footer-area-end -->








        <!-- JavaScript Libraries -->
        @livewireScripts
        {{-- Toaset Script  --}}

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
        {{-- <script src="{{asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script> --}}
        {{-- <script src="{{asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script> --}}
        {{-- <script src="{{asset('backend/assets/js/pages/datatables.init.js')}}"></script> --}}
        <!-- twitter-bootstrap-wizard js -->
        {{-- <script src="{{asset('backend/assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script> --}}

        {{-- <script src="{{asset('backend/assets/libs/twitter-bootstrap-wizard/prettify.js')}}"></script> --}}
        {{-- <script src="{{asset('backend/assets/js/pages/materialdesign.init.js')}}"></script> --}}
        <!-- form wizard init -->
        {{-- <script src="{{asset('backend/assets/js/pages/form-wizard.init.js')}}"></script> --}}

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="{{ asset('backend/assets/js/code.js') }}"></script>

        {{-- ------------------------------------------------------------------- --}}
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

    </body>
</html>
