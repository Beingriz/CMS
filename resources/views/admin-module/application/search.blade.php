@extends('admin.admin_master')
@section('admin')
    ;

    <div class="page-content" style="margin-top: -45px">
        <div class="container=fluid">
            @livewire('global-search', ['key' => $search])
        </div>
    </div>
@endsection
