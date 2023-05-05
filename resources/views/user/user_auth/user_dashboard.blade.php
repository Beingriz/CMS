@extends('user.user_auth.user_auth_master')
@section('user_auth')


    @include('user.user_home.user-content.carousel-content')
    @include('user.user_home.user-content.features-content')
    {{-- @include('user.user_home.user-content.about-content') --}}
    @include('user.user_home.user-content.services-content')
    @include('user.user_home.user-content.features_bottom-content')
    {{-- @include('user.user_home.user-content.projects-content') --}}
    {{-- @include('user.user_home.user-content.enquiry-form-content') --}}
    {{-- @include('user.user_home.user-content.team-content')
    @include('user.user_home.user-content.Testimonial-content') --}}

@endsection
