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

                    <li><a href="{{ url('add_credit_source') }}">Add Credit Source</a></li><span class="span">|</span>
                    <li><a href="{{ url('debit_entry') }}">New Debit Entry</a></li><span class="span">|</span>
                </ul>
            </div>
            <div class="pages">
                <div class="layout">
                    @include('Layouts.left_menu')
                    <div class="middle-container">
                       @livewire('bookmarks')
                    </div>
                    @include('Layouts.right_insight')

                </div>

            </div>
        </section>
    </div>


</body>
<script>
function Selected_date_List($date) {
    document.location.href = "/digital/cyber/selected_date/" + $date;
}
</script>

</html>










@endsection
