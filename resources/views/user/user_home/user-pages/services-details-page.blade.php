@extends('user.user_main_master')
@section('user')
    @livewire('user-module.service-details', ['Id' => $ServiceId])
@endsection
