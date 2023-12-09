@extends('admin-module.admin_master')
@section('admin')
    <div class="page-content" style="margin-top: 5px">
        <div class="container=fluid">
            @livewire('admin-module.application.edit-application', ['Id' => $Id, 'ForceDelete' => $ForceDelete])
        </div>
    </div>
@endsection
