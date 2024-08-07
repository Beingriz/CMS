@extends('admin-module.admin_master')
<title>About Us</title>
@section('admin')
    <div class="page-content" style="margin-top: -25px">
        <div class="container-fluid">
            @livewire('admin-module.home-page.about-us-form', ['EditData' => $EditData, 'SelectId' => $SelectId])
        </div>
    </div>
@endsection
