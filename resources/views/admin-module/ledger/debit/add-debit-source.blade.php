@extends('admin-module.admin_master')
@section('admin');

<div class="page-content" style="margin-top: -45px">
    <div class="container=fluid">
        @livewire('admin-module.ledger.debit.add-debit-source',['EditData'=>$EditData,'DeleteData'=>$DeleteData,'editid'=>$editid,'deleteid'=>$deleteid])
    </div>
</div>

@endsection


<script>
    window.addEventListener('refresh-page', event => {
       window.location.reload(false);
    })
  </script>








{{--

@extends('Layouts.main')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
    <div class="container-fluid top">
        <section class="work-area">
            <div class="sub-nav-menu">
                <ul>
                    <li><a href="{{ url('debit_entry') }}">New Debit Entry</a></li><span class="span">|</span>
                    <li><a href="{{ url('add_credit_source') }}">Add Credit Source</a></li><span class="span">|</span>
                </ul>
            </div>
            <div class="pages">
                <div class="layout">
                    @include('Layouts.left_menu')
                    <div class="middle-container">
                        @livewire('add-credit-source')
                    </div>
                    @include('Layouts.right_insight')

                </div>

            </div>
        </section>
    </div>













@endsection --}}
