@extends('admin-module.admin_master')
<title>Whatsapp Blocklist</title>
@section('admin')
    <div class="page-content" style="margin-top: 5px">
        <div class="container=fluid">
            @livewire('whats-app.black-listed-contacts')
        </div>
    </div>
@endsection