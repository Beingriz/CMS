@extends('admin.admin_master')
@section('admin');
<!DOCTYPE html>
<html lang="en">

<body>
    <div class="container">
        <section class="content">
            <section class="work-area">
                <div class="sub-nav-menu">
                    <ul>
                        <li><a href="{{url('home_dashboard')}}">Home</a></li><span class="span">|</span>
                        <li><a href="{{url('admin_home')}}">Admin</a></li><span class="span">|</span>
                        <li><a href="{{url('app_form')}}">New Application</a></li><span class="span">|</span>
                    </ul>
                </div>
                <div class="pages">

                    <div class="data-table-header">
                        <p class="heading"> Application Dashboard | Services Board</p>
                    </div>

                    <div class="row"></div>
                    <div class="border">
                        @foreach($Mainservices as $service)
                        <section class="dashboard">
                            <a href="{{url('dynamic_dashboard')}}/{{$service->Id}}" class="main-section">
                                <div class="sec-title">
                                    <div class="sec-title-name">
                                        <p>{{$service->Name}}</p>
                                    </div>
                                    @if (($service->Temp_Count)>=1)
                                    <div class="sec-notification">
                                        <p>{{$service->Temp_Count}}</p>
                                    </div>
                                    @endif

                                </div>

                                <div class="sec-middle">
                                    <div class="sec-middle-1">
                                        <div class="sec-mid-icon">
                                            <img src="{{$service->Thumbnail}}" alt="">
                                        </div>
                                    </div>
                                    <div class="sec-middle-2">
                                        <p class="sec-content">App : {{$service->Total_Count}}</p>
                                        <p class="sec-footer">&#x20B9;{{$service->Total_Amount}} /-</p>
                                    </div>
                                </div>

                                <div class="sec-footer">
                                <p class="sec-footer"> </p>
                                </div>
                            </a>
                            @endforeach
                        </section>

                    </div>
                    <div class="row"></div>
                    {{-- Applicaiton Insight --}}
                    <div class="dashboard-insight">
                        <div class="right-menu-section">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Prime Service</p>
                                <p class="section-value">Service Name</p>
                                <p class="section-pre-values">Application Count </p>
                            </div>
                        </div>
                        <div class="right-menu-section">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Montly Revenue</p>
                                <p class="section-value">Total Amount</p>
                                <p class="section-pre-values">Balance Due</p>
                            </div>
                        </div>
                        <div class="right-menu-section">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Delivered</p>
                                <p class="section-value">Total</p>
                                <p class="section-pre-values">This Month</p>
                            </div>
                        </div>
                        <div class="right-menu-section">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Pending</p>
                                <p class="section-value">Total </p>
                                <p class="section-pre-values">This Month</span></p>
                            </div>
                        </div>

                    </div>

                    <div class="row"></div>
                     {{-- Application Book Marks BookMarks --}}

                     <div class="border">
                        <div class="bookmark-container">
                            <div class="data-table-header">
                                <p class="heading">Bookmarks </p>
                            </div>
                            @foreach($bookmarks as $bookmark)
                            <a href="{{ $bookmark->Hyperlink }}" target="_blank" class="bookmark">
                                <img class="b-img" src="./{{$bookmark->Thumbnail}}" alt="Bookmark Icon">
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
