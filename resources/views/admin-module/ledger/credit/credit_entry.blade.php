@extends('admin-module.admin_master')
@section('admin')
    <div class="page-content" style="margin-top: 5px">
        <div class="container=fluid">
            @livewire('admin-module.ledger.credit.credit', ['EditData' => $EditData, 'DeleteData' => $DeleteData])
        </div>
    </div>
@endsection
