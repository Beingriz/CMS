@extends('admin-module.admin_master')
@section('admin')

    <div class="page-content" style="margin-top: -45px">
        <div class="container-fluid">
            @livewire('admin-module.operations.status-module', ['Id' => $EditId, 'ViewStatus' => $VeiwStatus, 'DelId' => $DeleteId])
        </div>
    </div>
@endsection
