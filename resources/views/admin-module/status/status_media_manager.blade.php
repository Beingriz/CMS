@extends('admin-module.admin_master')
<title>Bookmarks</title>
@section('admin')

    <div class="page-content" style="margin-top: 5px">
        <div class="container-fluid">
            @livewire('admin-module.operations.status-media-manager', ['EditId' => $EditId, 'DeleteId' => $DeleteId])
        </div>
    </div>
@endsection
