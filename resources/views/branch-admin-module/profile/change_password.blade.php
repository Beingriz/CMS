@extends('branch-admin-module.branch-admin_master')
@section('branch-admin')
    <div class="page-content" style="margin-top: 5px">
        <div class="container-fluid">
            @livewire('admin-module.profile.admin-change-password')
        </div>
    </div>
@endsection();
