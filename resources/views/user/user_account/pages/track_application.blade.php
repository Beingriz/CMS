@extends('user\user_account\user_account_master')
@section('UserAccount')
    <div class="page-content" style="margin-top: -15px">
        <div class="container-fluid">
            <!-- Page Header Start -->
            <div class="container-fluid page-header py-5 mb-5">
                <div class="container py-5">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Track App.</h1>
                    <nav aria-label="breadcrumb animated slideInDown">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-white"
                                    href="{{ route('user.home', Auth::user()->id) }}">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('about.us') }}">Services</a>
                            </li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Track</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header End -->

        <div class="container-fluid">

            <div class="row">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between">
                        <h5 class="mb-0"><i class="bi bi-search"></i> Track Application</h5>
                        <h6 class="mb-0 text-warning"><i class="bi bi-clock-history"></i> Applied {{ $time }}</h6>
                    </div>
                    <div class="card-body p-4">
                        @foreach ($records as $item)
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light shadow-sm">
                                        <h6 class="fw-bold text-primary"><i class="bi bi-person"></i> Personal Details</h6>
                                        <hr>
                                        <p><strong>🆔 Application ID:</strong> <span class="badge bg-info">{{ $Id }}</span></p>
                                        <p><strong>👤 Name:</strong> <span class="fw-bold text-dark">{{ $item->name }}</span></p>
                                        <p><strong>📞 Mobile:</strong> <span class="text-muted">{{ $item->mobile_no }}</span></p>
                                        <p><strong>🎂 Date of Birth:</strong> <span class="text-muted">{{ $item->dob }}</span></p>
                                        <p><strong>👨‍👩‍👦 Father Name:</strong> <span class="text-muted">{{ $item->relative_name }}</span></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light shadow-sm">
                                        <h6 class="fw-bold text-primary"><i class="bi bi-gear"></i> Application Details</h6>
                                        <hr>
                                        <p><strong>📌 Service:</strong> <span class="fw-bold">{{ $item->application }}</span></p>
                                        <p><strong>🔖 Type:</strong> <span class="text-success ">{{ $item->application_type }}</span></p>
                                        <p><strong>🔖 Document shared:</strong>
                                            @if (!empty($item->file) && file_exists(public_path('storage/' . $item->file)))
                                                <a href="{{ route('view.document', $item->id) }}" class="text-success text-decoration-none">
                                                    📂 View Document
                                                </a>
                                            @else
                                                <span class="badge bg-danger">No Document Available</span>
                                            @endif
                                        </p>
                                        <p><strong>📆 Updated On:</strong>
                                            <span class="text-danger">
                                                {{ !empty($item->updated_at) ? \Carbon\Carbon::parse($item->updated_at)->diffForHumans().' on '. \Carbon\Carbon::parse($item->Delivered_Date)->format('d-m-Y') : 'Not Available' }}
                                            </span>
                                        </p>
                                        <p><strong>📋 Status:</strong>
                                            <span class="badge {{ $item->status == 'Completed' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $item->status }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <a class="btn btn-warning btn-lg px-4 shadow" href="{{ route('history', Auth::user()->Client_Id) }}">
                                    📜 Service History
                                </a>
                                <a class="btn btn-success btn-lg px-4 shadow" href="{{ route('orders', Auth::user()->Client_Id) }}">
                                    📜 orders
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
