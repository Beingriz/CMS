@extends('admin-module.admin_master')
@section('admin')
<div class="page-content" style="margin-top: -25px">
    <div class="container-fluid">
        @livewire('admin-module.home-page.header-footer-form',['EditData'=>$EditData])
    </div>
</div>

@endsection
