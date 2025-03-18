<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Authentication</title>
    <!-- MDB icon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}">
    <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="{{asset('frontend/assets/mdb/css/mdb.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
    <link rel="stylesheet" href="{{asset('frontend/assets/mdb/css/mdb.min.css')}}" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @livewireStyles()
  </head>
  <style>
    /* Overlay styles */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }
</style>
<style>
    body {
        background-color: #f3f4f6;
    }
    .form-container {
        max-width: 600px;
        margin: auto;
        padding: 30px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .info-icon {
        font-size: 18px;
        color: #007bff;
        cursor: pointer;
        margin-left: 5px;
    }
</style>
  <body>
 <!-- Scripts -->
 <script src="{{asset('frontend/assets/mdb/js/mdb.min.js')}}"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Loading Spinner Overlay -->
    <div id="loading-overlay" wire:loading.class="d-block" wire:loading.class.remove="d-none" class="loading-overlay d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Start your project here-->
    @yield('auth')
    <!-- End your project here-->

    <!-- MDB -->
    @livewireScripts()
    <script type="text/javascript" src="{{asset('frontend/assets/mdb/js/mdb.min.js')}}"></script>
    <!-- Custom scripts -->
    <script type="text/javascript"></script>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="{{ asset('frontend/assets/js/custome.js') }}"></script>
            <script src="{{ asset('frontend/assets/js/main.js') }}"></script>


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
                                window.location.href = event.detail['redirect-url']; // Correct key reference
                            }
                        });
                    });
                });

                document.addEventListener('DOMContentLoaded', function () {
                    window.addEventListener('swal:success-non-redirect', event => {
                        Swal.fire({
                            title: event.detail.title,
                            text: event.detail.text,
                            icon: event.detail.icon,
                            confirmButtonText: 'OK'
                        })
                    });
                });
            </script>

  </body>
</html>
