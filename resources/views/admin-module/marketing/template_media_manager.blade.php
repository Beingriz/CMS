@extends('admin-module.admin_master')
<title>Media Manager</title>
@section('admin')

    <div class="page-content" style="margin-top: 5px">
        <div class="container-fluid">
            @livewire('admin-module.marketing.template-media-manager', ['EditId' => $EditId, 'DeleteId' => $DeleteId])
        </div>
    </div>
@endsection
