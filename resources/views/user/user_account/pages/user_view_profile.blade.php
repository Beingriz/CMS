@extends('user\user_account\user_account_master')
@section('UserAccount')
<div class="page-content" style="margin-top: -25px">
    <div class="container-fluid">
        @livewire('user-view-profile',['Id'=>$Id])
    </div>
</div>

@endsection
