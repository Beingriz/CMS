@extends('user\user_account\user_account_master')
@section('UserAccount')
<div class="page-content" style="margin-top: -25px">
    <div class="container-fluid">
        <div class="row">{{-- Messags / Notification Row--}}
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Welcome {{Auth::user()->name}}<span class="text-primary"></span> </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('services')}}">Services</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('history',Auth::user()->mobile_no)}}">My History</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>{{-- End of Row --}}
        <div class="container-fluid page-header py-5 mb-5">
            <div class="container py-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Shared Document</h1>
                <nav aria-label="breadcrumb animated slideInDown">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-white" href="{{route('user.home',Auth::user()->id)}}">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-white" href="{{route('service.list')}}">Services</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">My History</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>




<!-- Shared Documents Section -->
<div class="container">
    <div class="row g-4">

        <!-- Shared Documents Card -->
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="bi bi-file-earmark me-2 fs-4"></i>
                    <h5 class="mb-0">Shared Document</h5>
                </div>
                <div class="card-body">
                    @foreach ($record as $item)
                        @php
                            $fileExtension = pathinfo($item->file, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']);
                            $isPdf = strtolower($fileExtension) === 'pdf';
                            $isDoc = in_array(strtolower($fileExtension), ['doc', 'docx']);
                        @endphp

                        <div class="d-flex flex-column align-items-center text-center">

                            <!-- Image Preview -->
                            @if ($isImage)
                                <img src="{{ asset('storage/'.$item->file) }}" class="img-fluid rounded shadow-sm border"
                                    style="max-width: 100%; max-height: 250px; object-fit: cover;"
                                    alt="Shared Image">

                            <!-- PDF Preview -->
                            @elseif ($isPdf)
                                <iframe src="{{ asset('storage/'.$item->file) }}"
                                    width="100%" height="250px" class="rounded border shadow-sm"></iframe>
                                <a href="{{ asset('storage/'.$item->file) }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm mt-3 shadow">
                                    <i class="bi bi-file-earmark-pdf"></i> View Full PDF
                                </a>

                            <!-- DOC Preview -->
                            @elseif ($isDoc)
                                <i class="bi bi-file-earmark-word text-primary fs-1 mb-2"></i>
                                <p class="text-muted">📜 Word Document</p>
                                <a href="{{ asset('storage/'.$item->file) }}" target="_blank"
                                    class="btn btn-outline-info btn-sm shadow">
                                    <i class="bi bi-download"></i> Download Document
                                </a>

                            <!-- Default File Type -->
                            @else
                                <i class="bi bi-file-earmark-text fs-1 text-secondary mb-2"></i>
                                <p class="text-muted">📁 File Preview Not Available</p>
                                <a href="{{ asset('storage/'.$item->file) }}" target="_blank"
                                    class="btn btn-outline-secondary btn-sm shadow">
                                    <i class="bi bi-download"></i> Download File
                                </a>
                            @endif

                            <p class="text-muted mt-3 small">
                                <i class="bi bi-clock-history"></i> Shared: {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Read Consent Card -->
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="bi bi-shield-lock me-2 fs-4"></i>
                    <h5 class="mb-0">Read Consent</h5>
                </div>
                <div class="card-body">
                    @foreach ($record as $item)
                    <div class="border rounded p-3 shadow-sm bg-light">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle text-success fs-4 me-2"></i>
                            <h6 class="mb-0 text-dark fw-bold">Consent</h6>
                        </div>
                        <hr class="mt-2 mb-3">
                        <p class="text-muted fst-italic">{{ $item->user_consent }}</p>
                        <p class="text-muted small">
                            <i class="bi bi-clock-history"></i> Shared: {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                        </p>
                    </div>
                @endforeach

                </div>
            </div>
        </div>

    </div> <!-- End Row -->

    <!-- Action Buttons -->
    <div class="text-center mt-4">
        <a class="btn btn-warning btn-lg px-4 shadow-lg me-2" href="{{ route('history', Auth::user()->Client_Id) }}">
            <i class="bi bi-clock-history"></i> Service History
        </a>
        <a class="btn btn-success btn-lg px-4 shadow-lg" href="{{ route('orders', Auth::user()->Client_Id) }}">
            <i class="bi bi-box-seam"></i> Orders
        </a>
    </div>

</div> <!-- End Container -->


@endsection
