@extends('Layouts.main')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
</head>
<body>
    <div class="container=fluid top">
        <section class="work-area">
            <div class="sub-nav-menu">
                <ul>
                    <li><a href="{{url('home_dashboard')}}">Home</a></li><span class="span">|</span>
                    <li><a href="{{url('admin_home')}}">Admin</a></li><span class="span">|</span>
                    <li><a href="{{url('app_home')}}">Application</a></li><span class="span">|</span>
                </ul>
            </div>
            <div class="pages">
                <div class="layout">
                    @include('Layouts.left_menu')

                    <!-- Middle Container Section -->
                    <div class="middle-container">
                    @livewire('save-application-form')
                         <!-- Table List Code  -->

                    </div>
                    <!-- Right Menu Insight Section -->
                    @include('Layouts.right_insight')

                </div>
            </div>
        </section>
    </div>
</body>

</html>










@endsection
