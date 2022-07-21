@extends('admin.admin_master')
@section('admin');

<div class="page-content" style="margin-top: -45px">

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

                    <!-- Middle Container Section -->
                    <div class="middle-container">
                    @livewire('save-application-form')
                         <!-- Table List Code  -->

                    </div>
                    <!-- Right Menu Insight Section -->


                </div>
            </div>
        </section>
    </div>
</div>


</html>










@endsection
