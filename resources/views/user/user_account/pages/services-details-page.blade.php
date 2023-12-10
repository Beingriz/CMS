@extends('user\user_account\user_account_master')
@section('UserAccount')
@livewire('user-module.service-details',['Id'=>$ServiceId])
@endsection

