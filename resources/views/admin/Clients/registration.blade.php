@extends('Layouts.main')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
</head>
@livewireStyles
<body>
    <div class="container-fluid top">
        <section class="work-area">
            <div class="sub-nav-menu">
                <ul>
                    <li><a href="{{url('admin_home')}}">Admin</a></li><span class="span">|</span>
                    <li><a href="{{url('app_form')}}">New Application</a></li><span class="span">|</span>
                </ul>
            </div>
            <div class="pages">
                <div class="layout">
                    @include('Layouts.admin_left_menu')

                    <!-- Middle Container Section -->
                    <div class="middle-container">
                        <div class="form-container">
                            <div class="form-header">
                                <p class="heading">New Client Registration</p>
                            </div>
                            <livewire:client-search />


                        <!-- Table List Code  -->

                        </div>
                    </div>

                    <!-- Right Menu Insight Section -->
                    @include('Layouts.right_insight')

                </div>
            </div>
        </section>
    </div>
    @livewireScripts
</body>
</html>










@endsection
