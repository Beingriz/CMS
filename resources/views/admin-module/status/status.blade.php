@extends('admin-module.admin_master')
<title>Status Manager</title>

@section('admin')

    <div class="page-content" style="margin-top: 5px">
        <div class="container-fluid">
            @livewire('admin-module.operations.status-module', ['Id' => $EditId, 'ViewStatus' => $ViewStatus, 'DelId' => $DeleteId])
        </div>
    </div>
@endsection
