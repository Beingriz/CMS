@extends('admin-module.admin_master')
@section('admin')

    <div class="page-content" style="margin-top: 5px">
        <div class="container-fluid">
            @livewire('branches.registration', ['EditId' => $EditId, 'DeleteId' => $DeleteId])
        </div>
    </div>
@endsection