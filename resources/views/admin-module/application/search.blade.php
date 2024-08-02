@extends('admin-module.admin_master')
<title>Search </title>
@section('admin')
    <div class="page-content" style="margin-top: -45px">
        <div class="container=fluid">
            @livewire('admin-module.application.global-search', ['key' => $search])
        </div>
    </div>
@endsection
