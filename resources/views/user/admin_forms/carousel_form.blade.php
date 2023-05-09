@extends('admin.admin_master')
@section('admin')
<div class="page-content" style="margin-top: -25px">
    <div class="container-fluid">
        @livewire('admin.user.carousel-form',['EditData'=>$EditData])
    </div>
</div>

@endsection
