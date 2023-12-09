@extends('admin-module.admin_master')
@section('admin')
<div class="page-content" style="margin-top:5px">
    <div class="container=fluid">
            @livewire('admin-module.application.open-application', ['Id' => $Client_Id])
        </div>
    </div>
@endsection
