@extends('admin-module.admin_master')
<title>Header</title>
@section('admin')
    <div class="page-content" style="margin-top: -25px">
        <div class="container-fluid">
            @livewire('admin-module.home-page.header-footer-form', ['editData' => $editData, 'selectId' => $selectId])
        </div>
    </div>
@endsection
