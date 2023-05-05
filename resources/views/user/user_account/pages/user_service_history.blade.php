@extends('user\user_account\user_account_master')
@section('UserAccount')
<div class="page-content" style="margin-top: -25px">
    <div class="container-fluid">
        @livewire('user.service-history',['id'=> $mobile_no])
    </div>
</div>

@endsection
