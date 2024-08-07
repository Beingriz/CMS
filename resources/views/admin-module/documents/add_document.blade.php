@extends('admin-module.admin_master')
<title>Document Advisor</title>
@section('admin')

    <div class="page-content" style="margin-top: 5px">
        <div class="container-fluid">
            @livewire('admin-module.operations.documents',['Edit_Id'=>$Edit_Id,'Delete_Id'=>$Delete_Id])
        </div>
    </div>
@endsection
