@extends('admin-module.admin_master')
<title>Carousel</title>
@section('admin')
    <div class="page-content" style="margin-top: -25px">
        <div class="container-fluid">
            @livewire('admin-module.home-page.carousel-form', ['EditData' => $EditData])
        </div>
    </div>
@endsection
