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
                        <li><a href="{{ url('admin_home') }}">Admin</a></li><span class="span">|</span>
                    </ul>
                </div>
                <div class="pages">
                    <div class="layout">
                        @include('Layouts.admin_left_menu')
                        <div class="middle-container">
                            @livewire('documents')
                        </div>
                        @include('Layouts.right_insight')
                    </div>
                </div>
            </section>
        </div>


    </body>

    </html>
@endsection
