@extends('admin-module.admin_master')
<title>Telegram Bot</title>
@section('admin')
    <div class="page-content" style="margin-top: 5px">
        <div class="container=fluid">
            @livewire('admin-module.schedules.link-checker')
        </div>
    </div>
@endsection
