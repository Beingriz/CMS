@extends('admin-module.admin_master')
<title>Change Password</title>

@section('admin')
    <div class="page-content" style="margin-top: -45px">
        <div class="container-fluid">
            @livewire('admin-module.profile.admin-change-password')
        </div>
    </div>
@endsection();
