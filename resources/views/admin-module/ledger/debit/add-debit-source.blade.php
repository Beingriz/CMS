@extends('admin-module.admin_master')
<title>Debit Source</title>

@section('admin')
    <div class="page-content" style="margin-top: 5px">
        <div class="container=fluid">
            @livewire('admin-module.ledger.debit.add-debit-source', ['EditData' => $EditData, 'DeleteData' => $DeleteData, 'editid' => $editid, 'deleteid' => $deleteid])
        </div>
    </div>
@endsection


<script>
    window.addEventListener('refresh-page', event => {
        window.location.reload(false);
    })
</script>




