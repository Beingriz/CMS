@extends('admin.admin_master')
@section('admin');

<div class="page-content" style="margin-top: -45px">
    <div class="container=fluid">
        @livewire('edit-application', ['Id' => $Id,'ForceDelete'=>$ForceDelete])
    </div>
</div>

@endsection

