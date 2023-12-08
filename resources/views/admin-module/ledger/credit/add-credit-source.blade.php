@extends('admin-module.admin_master')
@section('admin')
    ;

    <div class="page-content" style="margin-top: -45px">
        <div class="container=fluid">
            @livewire('admin-module.ledger.credit.add-credit-source', ['EditData' => $EditData, 'DeleteData' => $DeleteData, 'editid' => $editid, 'deleteid' => $deleteid])
        </div>
    </div>
@endsection


<script>
    window.addEventListener('refresh-page', event => {
        window.location.reload(false);
    })
</script>

