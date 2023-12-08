@extends('admin-module.admin_master')
@section('admin');

    <div class="page-content" style="margin-top: -45px">
        <div class="container-fluid">
            @livewire('admin-module.operations.bookmarks',['EditId'=>$EditId,'DeleteId'=>$DeleteId])
        </div>
    </div>

@endsection
