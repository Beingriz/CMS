@extends('user.user_main_master')
@section('user')
    @livewire('admin-module.operations.service-details', ['Id' => $ServiceId])
@endsection
