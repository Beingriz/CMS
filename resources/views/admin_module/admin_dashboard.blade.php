@extends('Layouts\main')
@section('content')
<!DOCTYPE html>
<html lang="en">

<body>
    <div class="container-fluid top">
            <section class="work-area">
                <div class="sub-nav-menu">
                    <ul>
                        <li><a href="{{url('home_dashboard')}}">Home</a></li><span class="span">|</span>
                        <li><a href="{{url('app_home')}}">Application</a></li><span class="span">|</span>
                        <li><a href="{{url('app_form')}}">New Applicaiton</a></li><span class="span">|</span>
                    </ul>
                </div>
                <div class="pages">
                    <div class="pages">
                        <div class="layout">
                            @include('Layouts.admin_left_menu')


                            <!-- Middle Container Section -->
                            <div class="middle-container">
                                <div class="data-table-header">
                                    <p class="heading"> Application Dashboard | Services Board</p>
                                </div>
                                <div class="row"></div>
                                <div class="border">

                                    <section class="dashboard">
                                        <a href="{{url('dynamic_dashboard')}}" class="main-section">
                                            <div class="sec-title">
                                                <div class="sec-title-name">
                                                    <p></p>
                                                </div>
                                                {{-- @if ()
                                                <div class="sec-notification">
                                                    <p></p>
                                                </div>
                                                @endif --}}

                                            </div>

                                            <div class="sec-middle">
                                                <div class="sec-middle-1">
                                                    <div class="sec-mid-icon">
                                                        <img src="" alt="">
                                                    </div>
                                                </div>
                                                <div class="sec-middle-2">
                                                    <p class="sec-content">App : </p>
                                                    <p class="sec-footer">&#x20B9; /-</p>
                                                </div>
                                            </div>

                                            <div class="sec-footer">
                                            <p class="sec-footer"> </p>
                                            </div>
                                        </a>
                                    </section>

                                </div>

                            </div>
                            <!-- Right Menu Insight Section -->
                            @include('Layouts.right_insight')

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
