@extends('admin.admin_master')
@section('admin');

<div class="page-content" style="margin-top: -45px">
    <div class="container=fluid">
        @livewire('edit-client-profile',['Id' => $Id,])
    </div>
</div>

@endsection
