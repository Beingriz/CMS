@extends('admin-module.admin_master')
<title>Profile</title>

@section('admin')
    <div class="page-content" style="margin-top: -45px">
        <div class="container-fluid">
            @livewire('admin-module.profile.admin-panel')
        </div>
    </div>
@endsection();
