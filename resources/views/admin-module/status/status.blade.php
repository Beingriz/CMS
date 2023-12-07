@extends('admin.admin_master')
@section('admin');

    <div class="page-content" style="margin-top: -45px">
        <div class="container-fluid">
            @livewire('status-module',['Id'=>$EditId,'ViewStatus'=>$VeiwStatus,'DelId'=>$DeleteId])
        </div>
    </div>

@endsection
