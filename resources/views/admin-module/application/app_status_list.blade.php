@extends('Layouts.main')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
    <div class="container-fluid top">
        <section class="work-area">
            <div class="sub-nav-menu">
                <ul>
                    <li><a href="{{ url('home_dashboard') }}">Home</a></li><span class="span">|</span>
                    <li><a href="{{ url('app_home') }}">Applicaiton Dashboard</a></li><span class="span">|</span>
                    <li><a href="{{ url('app_form') }}">New Application</a></li><span class="span">|</span>
                </ul>
            </div>
            <div class="pages">
                <div class="layout">
                    <!-- Left Menu Section -->
                    <div class="left-menu">
                    <div class="left-menu-section">
                        <div class="left-menu-sec-heading">
                            <img src="\digital/cyber/photo_gallery\home-menu.jpg" alt="heading-icon">
                            <p>Main Menu</p>
                        </div>
                        <div class="left-menu-link">
                            <a href="{{url('app_home')}}">Application Dashboard</a>
                            <a href="{{url('app_form')}}">New Application</a>
                            <a href="">Update</a>
                            <a href="">Search</a>
                            <a href="">Status</a>
                        </div>
                    </div>
                    <div class="left-menu-section">
                        <div class="left-menu-sec-heading">
                        <img src="\digital/cyber/photo_gallery\sub-menu.jpg" alt="heading-icon">
                            <p>Sub Menu</p>
                        </div>
                        <div class="left-menu-link">
                            <a href="">Reports</a>
                            <a href="">Filter</a>
                        </div>
                    </div>

                </div>
                <!-- Middle Container Section -->
                <div class="middle-container">
                    {{-- {{$service}} --}}
                    <!-- Table List Code  -->
                    {{-- <livewire:app-status-list /> --}}
                    @livewire('app-status-list', ['service' => $service])

                </div>
                <div class="right-menu">
                    <p class="heading">Insight</p>
                    <div class="right-menu-section">
                        <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                        <div class="sec-data">
                            <p class="section-heading">Applications Served</p>
                            <p class="section-value">Total {{$applications_served}}</p>
                            <p class="section-pre-values">Yesterday {{$previous_day_app}}</p>
                        </div>
                    </div>
                    <div class="right-menu-section">
                        <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                        <div class="sec-data">
                            <p class="section-heading">Applications Deliverd</p>
                            <p class="section-value">Delivered : {{$applications_delivered}}</p>
                            <p class="section-pre-values">Yesterday {{$previous_day_app_delivered}}</p>
                        </div>
                    </div>
                    <div class="right-menu-section">
                        <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                        <div class="sec-data">
                            <p class="section-heading">Revenue Generated</p>
                            <p class="section-value">Gross &#x20B9; {{$total_revenue}}/-</p>
                            <p class="section-pre-values">Yesterday &#x20B9; <span>{{$previous_revenue}}</span></p>
                        </div>
                    </div>
                    <div class="right-menu-section">
                        <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                        <div class="sec-data">
                            <p class="section-heading">Balance Due Amount</p>
                            <a class="section-value" href="{{url('balance_list')}}">Gross Bal: &#x20B9; {{$balance_due}}/-</a>
                            <a class="section-pre-values" href="#">Yesterday &#x20B9; <span>{{$previous_bal}}</span></a>
                        </div>
                    </div>
                </div>
                </div>
        </section>
    </div>
</body>
<script>
function SelectService($value) {
    document.location.href = "/digital/cyber/app_list/" + $value;
}
</script>

</html>










@endsection
