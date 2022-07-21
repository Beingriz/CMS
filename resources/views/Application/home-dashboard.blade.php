@extends('Layouts\main')
@section('content')
<!DOCTYPE html>
<html lang="en">

<body>
    <div class="container">
        <section class="content">
            <section class="work-area">
                <div class="sub-nav-menu">
                    <ul>
                        <li><a href="{{url('admin_home')}}">Admin</a></li><span class="span">|</span>
                        <li><a href="{{url('app_home')}}">Application</a></li><span class="span">|</span>
                        <li><a href="{{url('app_form')}}">New Application</a></li><span class="span">|</span>
                    </ul>
                </div>
                <div class="pages">
                    <div class="data-table-header">
                        <p class="heading">Home Dashboard || Application Status Board</p>
                    </div>
                    <div class="dashboard-insight">
                        <div class="dash-insight-sec">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Applications Served</p>
                                <p class="section-value">Total {{$applications_served}}</p>
                                <p class="section-pre-values"><a href="{{url('previous_day_app')}}">Yesterday {{$previous_day_app}}</a>
                                    </p>
                            </div>
                        </div>
                        <div class="dash-insight-sec">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">New Applications</p>
                                <p class="section-value">Today {{$new_clients}}</p>
                                <p class="section-pre-values"><a href="{{url('previous_day_new_clients')}}">Yesterday {{$previous_day_new_clients}}</a>
                                    </p>
                            </div>
                        </div>
                        <div class="dash-insight-sec">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Applications Deliverd</p>
                                <p class="section-value">Delivered : {{$applications_delivered}}</p>
                                <p class="section-pre-values">Yesterday {{$previous_day_app_delivered}}</p>
                            </div>
                        </div>
                        <div class="dash-insight-sec">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Revenue Generated</p>
                                <p class="section-value">Gross &#x20B9; {{$total_revenue}}/-</p>
                                <p class="section-pre-values">Yesterday &#x20B9; <span>{{$previous_revenue}}</span></p>
                            </div>
                        </div>
                        <div class="dash-insight-sec">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Balance Due Amount</p>
                                <a class="section-value" href="{{url('balance_list')}}">Gross Bal: &#x20B9; {{$balance_due}}/-</a>
                                <a class="section-pre-values" href="#">Yesterday &#x20B9; <span>{{$previous_bal}}</span></a>
                            </div>
                        </div>
                    </div>


                    <div class="border">
                        @foreach($status as $key)
                        <section class="dashboard">
                            <a href="{{url('app_status_list')}}/{{ $key->Status}}" class="section">
                                <div class="sec-header">
                                    <div class="sec-icon">
                                        <img src="{{$key->Thumbnail}}" alt="">
                                    </div>
                                    <div class="sec-info">
                                        <div class="sec-heading">
                                            <p>{{ $key->Status}}</p>
                                        </div>
                                        <p class="sec-content">Total App : {{ $key->Total_Count}}</p>
                                    </div>
                                </div>
                                <div class="sec-footer">
                                    <p class="sec-footer">Amount :
                                        &#x20B9;{{ $key->Total_Amount}} /-</p>
                                </div>
                            </a>
                            @endforeach
                        </section>

                    </div>
                    {{-- Bookmar Section --}}
                    <div class="row"></div>

                    <div class="border">
                        <div class="bookmark-container">
                            <div class="data-table-header">
                                <p class="heading">Bookmarks </p>
                            </div>
                            @foreach($bookmarks as $bookmark)
                            <a href="{{ $bookmark->Hyperlink }}" target="_blank" class="bookmark">
                                <img class="b-img" src="{{$bookmark->Thumbnail}}" alt="Bookmark Icon">
                                <p class="b-name" >{{$bookmark->Name}}</p>
                            </a>
                            @endforeach
                        </div>
                    </div>


                </div>
    </div>

</body>

</html>
@endsection
