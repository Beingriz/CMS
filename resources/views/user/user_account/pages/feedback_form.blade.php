@extends('user\user_account\user_account_master')
@section('UserAccount')
<div class="page-content" style="margin-top: -15px">
    <div class="container-fluid">
        @livewire('user-module.feedback-form',['Id'=>$Id])
    </div>
</div>

@endsection
