@extends('admin-module.admin_master')
<title>Whatsapp Templates</title>
@section('admin')
    <div class="page-content" style="margin-top: 5px">
        <div class="container=fluid">
            @livewire('whats-app.template-manager',['sid'=>$sid])
        </div>
    </div>
@endsection
