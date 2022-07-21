<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" sizes="32x32"
        href=" {{ URL::asset('/public/template/img/favicon_io/favicon-32x32.png')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Cyberpe</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href=" {{ URL::asset('/public/Bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="{{ URL::asset('/public/Bootstrap/css/mdb.min.css') }}" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="{{ URL::asset('/public/Bootstrap/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('/public/Bootstrap/css/600.css') }}" rel="stylesheet">
    @livewireStyles
</head>

<body>

    <!-- Start your project here-->
    @include('Layouts.navigation')

    @yield('content')

    @include('Layouts.footer')

{{-- Script Tag Starts From Here  --}}
   @livewireScripts
    <script src="{{ URL::asset('public/Bootstrap/js/jquery-3.4.1.min.js') }}">
    </script>
    <!-- Bootstrap tooltips -->
    <script src="{{ URL::asset('/public/Bootstrap/js/popper.min.js') }}">
    </script>
    <!-- Bootstrap core JavaScript -->
    <script src="{{ URL::asset('/public/Bootstrap/js/bootstrap.min.js') }}">
    </script>
    <!-- MDB core JavaScript -->
    <script src="{{ URL::asset('/public/Bootstrap/js/mdb.min.js') }}">
    </script>
    <script src="{{ URL::asset('/public/Bootstrap/js/js/js.js') }}">
    </script>
    <script src="{{ URL::asset('/public/Bootstrap/js/js/javascript.js') }}">
    </script>

</body>

</html>
