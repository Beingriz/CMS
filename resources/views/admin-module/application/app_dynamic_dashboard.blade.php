@extends('admin-module.admin_master')
<title>Service Dashboard</title>
@section('admin')
    ;

    <div class="page-content" style="margin-top: -45px">
        <div class="container-fluid">
            @livewire('admin-module.application.dynamic-dashboard', ['MainServiceId' => $MainServiceId])
        </div>
    </div>
@endsection
