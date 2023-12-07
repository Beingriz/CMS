@extends('admin.admin_master')
@section('admin');

<div class="page-content" style="margin-top: -45px">
    <div class="container=fluid">
        @livewire('debit-ledger',['EditData'=>$EditData,'DeleteData'=>$DeleteData])
    </div>
</div>

@endsection
