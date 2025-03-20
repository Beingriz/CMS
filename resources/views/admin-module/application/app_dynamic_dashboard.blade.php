@extends('admin-module.admin_master')
<title>Service Dashboard</title>
@section('admin')
    ;

    <div class="page-content" >
        <div class="container-fluid">
            @livewire('admin-module.application.dynamic-dashboard', ['MainServiceId' => $MainServiceId])
        </div>
    </div>
<style>
    /* Service Cards */
.service-card {
    border-radius: 10px;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.15);
}

/* Status Cards */
.status-card {
    border-radius: 10px;
    border-left: 4px solid red;
}

/* Image Styling */
.avatar-lg {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border: 2px solid #ddd;
    padding: 2px;
}
/* Bookmark Card Styling */
.bookmark-card {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    border-radius: 10px;
}

.bookmark-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

/* Bookmark Image */
.bookmark-img {
    height: 140px;
    object-fit: cover;
    border-radius: 10px 10px 0 0;
}


</style>

@endsection
