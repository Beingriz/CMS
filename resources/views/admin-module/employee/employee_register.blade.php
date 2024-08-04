@extends('admin-module.admin_master')
<title>Employee Registration</title>
@section('admin')
    <div class="page-content" style="margin-top: 5px">
        <div class="container=fluid">
            @livewire('admin-module.employee.employee-register')
        </div>
    </div>
@endsection
