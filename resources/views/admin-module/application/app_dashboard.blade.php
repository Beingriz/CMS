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
                    <div class="card-body d-flex flex-column align-items-center text-center">

                        {{-- Service Thumbnail --}}
                        <div class="service-img-wrapper mb-3">
                            <img class="rounded-circle img-fluid service-img"
                                src="{{ !empty($service['Thumbnail']) ? url('storage/' . $service['Thumbnail']) : url('storage/no_image.jpg') }}"
                                alt="Service Image">
                        </div>

                        {{-- Service Title --}}
                        <h5 class="text-black fw-bold text-uppercase mb-2">
                            {{ $service['Name'] }}
                        </h5>

                        {{-- Total Applications --}}
                        <p class="mb-1">
                            📄 <strong class="text-primary fs-5">Applications:</strong>
                            <span class="text-success fw-bold fs-4">
                                {{ $service['Total_Count'] }}
                            </span>
                        </p>

                        {{-- Total Revenue --}}
                        <p class=" mb-1 fs-5">
                            💰 <strong class="text-warning">Total Revenue:</strong>
                            <span class="text-dark fw-bold">
                                ₹{{ number_format($service['Total_Amount'], 2) }}
                            </span>
                        </p>

                        {{-- Pending Applications --}}
                        @if ($service['Temp_Count'] > 0)
                            <p class="mb-0 fs-5">
                                ⏳ <strong class="text-info">Pending:</strong>
                                <span class="badge bg-danger text-white fs-6 px-3 py-2">
                                    {{ $service['Temp_Count'] }}
                                </span>
                            </p>
                        @else
                            <p class="mb-0">
                                ✅ <span class="badge bg-success fs-6 px-3 py-2">
                                    No Pending Applications
                                </span>
                            </p>
                        @endif
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div


        </div>
    </div>


{{-- CSS Enhancements --}}
<style>
    /* Card Styling */
.service-card {
    height: 100%;
    border-radius: 10px;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

/* Hover Effect */
.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.15);
}

/* Service Image */
.service-img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border: 3px solid #ddd;
    padding: 5px;
    transition: transform 0.3s ease-in-out;
}

/* Image Hover Effect */
.service-card:hover .service-img {
    transform: scale(1.1);
}

/* Badge Styling */
.badge {
    font-size: 0.9rem;
    border-radius: 8px;
}

</style>
@endsection
