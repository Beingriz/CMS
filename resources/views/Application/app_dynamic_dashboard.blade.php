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
                        <li><a href="{{url('app_home')}}">Dashboard</a></li><span class="span">|</span>
                        <li><a href="{{url('client_registration')}}">New Client</a></li><span class="span">|</span>
                        <li><a href="{{url('app_form')}}">New Applicaiton</a></li><span class="span">|</span>
                    </ul>
                </div>
                <div class="pages">

                    @livewire('dynamic-dashboard',['MainServiceId'=>$MainServiceId])


                </div>
            </section>
        </section>
    </div>
</body>
</html>
@endsection
