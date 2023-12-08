@extends('admin-module.admin_master')
@section('admin')

    <div class="page-content" style="margin-top: -45px">
        <div class="container=fluid">
            @livewire('admin-module.application.edit-client-profile', ['Id' => $Id])
        </div>
    </div>
@endsection
