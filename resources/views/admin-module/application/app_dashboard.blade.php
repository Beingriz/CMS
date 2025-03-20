@extends('admin-module.admin_master')
<title>Dashboard</title>

@section('admin')
    <div class="page-content" >
        <div class="container-fluid">

            {{-- Page Title Section --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">SERVICE Dashboard</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Digital Cyber</a></li>
                                <li class="breadcrumb-item active">Services Board</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Breadcrumb Navigation --}}
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('Dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('new.application') }}">New Application</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('update_application') }}">Update</a></li>
                </ol>
            </div>
{{-- Services Grid --}}
<div class="row">
    @foreach ($Mainservices as $service)
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
            <a href="{{ url('dynamic_dashboard', $service['Id']) }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm border-0 service-card">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center">
                            {{-- Service Title and Info --}}
                            <div class="flex-grow-1">
                                <h5 class="text-black fw-bold text-uppercase">
                                    <i class="ri-briefcase-line"></i> {{ $service['Name'] }}
                                </h5>

                                {{-- Total Revenue --}}
                                <p class="text-muted mb-1">
                                    <i class="ri-money-dollar-circle-line text-success"></i>
                                    <strong>Total Revenue:</strong>
                                    <span class="text-info fw-bold">
                                        {{ number_format($service['Total_Amount'], 2) }}
                                    </span>
                                </p>

                                {{-- Total Applications --}}
                                <p class="text-muted mb-1">
                                    <i class="ri-file-list-line text-primary"></i>
                                    <strong>Total Applications:</strong>
                                    <span class="text-success fw-bold">
                                        {{ $service['Total_Count'] }}
                                    </span>
                                </p>

                                {{-- Pending Applications --}}
                                @if ($service['Temp_Count'] > 0)
                                    <p class="mb-0">
                                        <i class="ri-time-line text-warning"></i>
                                        <strong>Pending:</strong>
                                        <span class="badge bg-warning text-dark">
                                            {{ $service['Temp_Count'] }}
                                        </span>
                                    </p>
                                @else
                                    <p class="mb-0">
                                        <span class="badge bg-success">
                                            No Pending Applications
                                        </span>
                                    </p>
                                @endif
                            </div>

                            {{-- Service Thumbnail --}}
                            <div class="ms-3">
                                <img class="rounded-circle img-fluid service-img"
                                    src="{{ !empty($service['Thumbnail']) ? url('storage/' . $service['Thumbnail']) : url('storage/no_image.jpg') }}"
                                    alt="Service Image">
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

        </div>
    </div>


    {{-- CSS Enhancements --}}
    <style>
/* Fixed height for uniform design */
.service-card {
    height: 100%;
    border-radius: 10px;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

/* Elegant hover effect */
.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.15);
}

/* Service image size consistency */
.service-img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border: 2px solid #ddd;
    padding: 2px;
}

/* Making sure text truncates and aligns well */
h5 {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 18px;
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
