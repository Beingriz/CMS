@extends('user\user_account\user_account_master')
@section('UserAccount')
<div class="page-content" style="margin-top: -15px">
    <div class="container-fluid">
        @livewire('user-module.quick-apply',['Id'=>$Id,'Price'=>$Price])
    </div>
</div>


@endsection
