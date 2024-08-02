@extends('admin-module.admin_master')
<title>New Application</title>
@section('admin')
    <div class="page-content" style="margin-top: 5px">
        <div class="container=fluid">
            @livewire('admin-module.application.application-form')
        </div>
    </div>
@endsection
