@extends('user\user_account\user_account_master')
@section('UserAccount')

<div class="page-content" style="margin-top: -20px">
    <div class="container=fluid">
        {{Auth::user()->name}} welcome back
    </div>
</div>

@endsection

