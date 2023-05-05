@extends('user\user_account\user_account_master')
@section('UserAccount')

<div class="page-content" style="margin-top: -45px">
    <div class="container=fluid">
        @livewire('user.edit-profile',['Id' => $Id,])
    </div>
</div>

@endsection

