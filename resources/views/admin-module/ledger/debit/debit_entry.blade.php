@extends('admin-module.admin_master')
<title>Debit Entry</title>

@section('admin')
    <div class="page-content" style="margin-top: 5px">
        <div class="container=fluid">
            @livewire('admin-module.ledger.debit.debit-ledger', ['EditData' => $EditData, 'DeleteData' => $DeleteData])
        </div>
    </div>
@endsection
