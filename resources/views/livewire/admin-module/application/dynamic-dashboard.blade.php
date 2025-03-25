<div class="container-fluid">
    {{-- Dashboard Header --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="fw-bold text-uppercase text-primary">{{ $ServName }} Dashboard</h4>

                {{-- Success Message --}}
                @if (session('SuccessMsg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('SuccessMsg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">🏠 Digital Cyber</a></li>
                        <li class="breadcrumb-item active">📌 Services Board</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Navigation Links --}}
    <div class="d-flex gap-2 mt-3">
        <a href="{{ route('app.home') }}" class="btn btn-outline-primary">🏠 Dashboard</a>
        <a href="{{ route('new.application') }}" class="btn btn-outline-success">🆕 New Application</a>
        <a href="{{ route('update_application') }}" class="btn btn-outline-warning">🔄 Update</a>
    </div>

    {{-- Services Section --}}
    <div class="row mt-4">
        @foreach ($SubServices as $item)
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="#status" class="text-decoration-none" wire:click.prevent="ChangeService('{{ $item->Name }}')">
                    <div class="card service-card shadow-sm border-0">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="text-primary fw-bold text-uppercase mb-2">{{ $item->Name }}</h5>
                                <p class="text-muted mb-0">
                                    <strong>📄 Applications:</strong> {{ $item->Total_Count }}
                                </p>
                            </div>
                            <img class="rounded-circle img-thumbnail avatar-lg"
                                src="{{ !empty($item->Thumbnail) ? url('storage/' . $item->Thumbnail) : url('storage/no_image.jpg') }}"
                                alt="Service Image">
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
{{-- Status Section --}}
@if ($temp_count > 0)

    <h4 class="text-danger fw-bold text-uppercase">📌 Status of {{ $Serv_Name }} , {{ $Sub_Serv_Name }}</h4>

    <div class="row justify-content-center">
        @foreach ($status as $item)
            <div class="col-xl-2 col-md-6 mb-4">
                <a href="#table" wire:click="ShowDetails('{{ $item->Status }}')" class="text-decoration-none">
                    <div class="card status-card text-center shadow-sm">
                        <div class="card-body">
                            {{-- Status Image --}}
                            <img class="status-img rounded-circle img-thumbnail avatar-lg"
                                src="{{ !empty($item->Thumbnail) ? asset('storage/' . $item->Thumbnail) : url('storage/no_image.jpg') }}"
                                alt="Status Image">

                            {{-- Status Title --}}
                            <h5 class="fw-bold text-dark mt-3">{{ $item->Status }}</h5>

                            {{-- Status Count --}}
                            @if ($item->Temp_Count > 0)
                                <span class="badge bg-warning text-dark">📋 {{ $item->Temp_Count }} Applications</span>
                            @else
                                <span class="badge bg-success">✅ No Pending Applications</span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endif


    {{-- Dynamic Table --}}
    @if ($ShowTable)
        <div class="mt-4" id="table">
            @include('admin-module.application.dynamic-table')
        </div>
    @endif

    {{-- Bookmarks Section --}}
    <div class="bookmark-container mt-5">
        <div class="data-table-header">
            <h4 class="fw-bold text-primary">🔖 Bookmarks for {{ $ServName }}</h4>
        </div>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            @foreach ($bookmarks as $bookmark)
                <a href="{{ $bookmark->Hyperlink }}" target="_blank" class="bookmark text-decoration-none">
                    <div class="bookmark-content shadow-sm p-3 rounded text-center">
                        <img class="bookmark-img rounded"
                            src="{{ !empty($bookmark->Thumbnail) ? url('storage/' . $bookmark->Thumbnail) : url('storage/no_image.jpg') }}"
                            alt="Bookmark Icon">
                        <p class="text-dark mt-2 fw-bold">{{ $bookmark->Name }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- 🔥 CSS Styling Enhancements --}}
<style>
/* Service & Status Cards */
.service-card, .status-card {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    border-radius: 10px;
}

.service-card:hover, .status-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.15);
}

/* Service Image */
.avatar-lg {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border: 3px solid #ddd;
    padding: 5px;
    transition: transform 0.3s ease-in-out;
}

/* Hover Effect */
.service-card:hover .avatar-lg, .status-card:hover .avatar-lg {
    transform: scale(1.1);
}

/* Badge Styling */
.badge {
    font-size: 0.9rem;
    border-radius: 8px;
}

/* Bookmark Container */
.bookmark-container {
    max-width: 100%;
    overflow-x: hidden; /* Prevents horizontal overflow */
    text-align: center;
}

/* Bookmark Item */
.bookmark-content {
    width: 150px; /* Set a fixed width for consistency */
    max-width: 100%;
    transition: all 0.3s ease-in-out;
}

.bookmark-content:hover {
    transform: scale(1.05);
    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
}

/* Bookmark Image */
.bookmark-img {
    width: 80px; /* Restrict image size */
    height: 80px;
    object-fit: cover; /* Ensures proper image scaling */
    border: 2px solid #ddd;
    padding: 5px;
}
/* Status Card Styling */
.status-card {
    border-radius: 10px;
    transition: all 0.3s ease-in-out;
    min-height: 160px; /* Prevents height mismatch */
}

.status-card:hover {
    transform: scale(1.05);
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
}

/* Status Image */
.status-img {
    width: 70px;
    height: 70px;
    object-fit: contain;
    border: 2px solid #ddd;
    padding: 5px;
}

/* Badge Customization */
.badge {
    font-size: 14px;
    padding: 6px 12px;
}


/* Responsive Fix */
@media (max-width: 768px) {
    .bookmark-content {
        width: 120px;
    }
    .bookmark-img {
        width: 60px;
        height: 60px;
    }
    .status-card {
        min-height: 180px;
    }
    .status-img {
        width: 60px;
        height: 60px;
    }
    .badge {
        font-size: 12px;
    }
    h5 {
        font-size: 1rem;
    }
    .fs-5 {
        font-size: 0.9rem !important;
    }
    .fs-4 {
        font-size: 1.2rem !important;
    }
}

</style>
