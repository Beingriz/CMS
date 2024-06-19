@extends('admin-module.admin_master')
@section('admin')

    <div class="page-content" style="margin-top: 5px">
        <div class="container-fluid">
            @livewire('admin-module.operations.add-services', ['EditData' => $EditData, 'DeleteData' => $DeleteData, 'Type' => $Type])
        </div>
    </div>
@endsection
