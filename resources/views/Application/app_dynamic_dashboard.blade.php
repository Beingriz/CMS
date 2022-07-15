@extends('admin.admin_master')
@section('admin');
<!DOCTYPE html>
<html lang="en">
    <div class="page-content" style="margin-top: -45px">
        <div class="container-fluid">
             @livewire('dynamic-dashboard',['MainServiceId'=>$MainServiceId])
        </div>
    </div>
</html>
@endsection
