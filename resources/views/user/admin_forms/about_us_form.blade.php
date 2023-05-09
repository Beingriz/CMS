@extends('admin.admin_master')
@section('admin')
<div class="page-content" style="margin-top: -25px">
    <div class="container-fluid">
        @livewire('admin.user.about-us-form',['EditData'=>$EditData,'SelectId'=>$SelectId])
    </div>
</div>

@endsection
