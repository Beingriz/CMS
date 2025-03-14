<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    {{-- <!-- App favicon --> {{asset('backend/')}} --}}

    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}">

    <!-- jquery.vectormap css -->
    <link href="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    @livewireStyles
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/loadingoverlay.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">



    {{-- My old Website CSS  --}}
    <link href="{{ asset('Bootstrap/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('Bootstrap/css/600.css') }}" rel="stylesheet">

</head>

<!-- Bootstrap & Custom CSS -->
<style>
    /* Fullscreen Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    /* DC Animated Letters */
    .dc-text {
        font-size: 60px;
        font-weight: bold;
        font-family: 'Poppins', sans-serif;
        color: #007bff; /* Bootstrap primary blue */
        text-transform: uppercase;
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .dc-letter {
        display: inline-block;
        animation: bounce 1.5s infinite alternate ease-in-out;
    }

    .dc-letter:nth-child(1) { animation-delay: 0s; }
    .dc-letter:nth-child(2) { animation-delay: 0.2s; }

    /* Animated Progress Bar */
    .progress {
        width: 250px;
        height: 6px;
        background: #f0f0f0;
        border-radius: 50px;
        overflow: hidden;
    }

    .progress-bar {
        background: linear-gradient(90deg, #007bff, #0056b3);
        transition: width 1s ease-in-out;
    }

    /* Loading Text */
    .loading-text {
        font-size: 18px;
        font-weight: 500;
        font-family: 'Poppins', sans-serif;
        color: #333;
        animation: fade-in 2s infinite alternate ease-in-out;
    }

    /* Keyframes */
    @keyframes bounce {
        0% { transform: translateY(0); opacity: 0.8; }
        100% { transform: translateY(-8px); opacity: 1; }
    }

    @keyframes fade-in {
        0% { opacity: 0.5; }
        100% { opacity: 1; }
    }
</style>


<body data-topbar="dark">

    <!-- Loading Overlay -->
    @include('template.overlay-loader.overlay-loader')


    <!-- Begin page -->
    <div id="layout-wrapper">


        @include('admin-module.body.header')

        <!-- ========== Left Sidebar Start ========== -->
        @include('admin-module.body.sidebar')
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            @yield('admin')
            <!-- End Page-content -->

            @include('admin-module.body.footer')

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->

    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->{{-- {{asset('backend/')}} --}}
    @livewireScripts
    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <!-- jquery.vectormap map -->
    <script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}">
    </script>
    <script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script>
    <!-- Required datatable js -->
    <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('backend/assets/js/pages/dashboard.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script src="{{ asset('backend/assets/js/custom.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- JavaScript to Control Loading Screen -->
<script>

</script>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('backend/assets/js/custome.js') }}"></script>

    <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/datatables.init.js') }}"></script>
    <!-- twitter-bootstrap-wizard js -->
    <script src="{{ asset('backend/assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>

    <script src="{{ asset('backend/assets/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/materialdesign.init.js') }}"></script>
    <!-- form wizard init -->
    <script src="{{ asset('backend/assets/js/pages/form-wizard.init.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('swal:success', event => {
                Swal.fire({
                    title: event.detail.title,
                    text: event.detail.text,
                    icon: event.detail.icon,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed || result.isDismissed) {
                        window.location.href = event.detail.redirect_url; // Redirect after alert
                    }
                });
            });
        });
    </script>


</body>

</html>
