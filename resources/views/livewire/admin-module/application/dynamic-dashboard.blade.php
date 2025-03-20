<div class="container-fluid">
    {{-- Dashboard Header --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="fw-bold text-uppercase text-primary">{{ $ServName }} Dashboard</h4>

                {{-- Success Message --}}
                @if (session('SuccessMsg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('SuccessMsg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Breadcrumbs --}}
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">🏠 Digital Cyber</a></li>
                        <li class="breadcrumb-item active">📌 Services Board</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Navigation Breadcrumbs --}}
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('app.home') }}">🏠 Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.application') }}">🆕 New Application</a></li>
            <li class="breadcrumb-item"><a href="{{ route('update_application') }}">🔄 Update</a></li>
        </ol>
    </div>

    {{-- Services Section --}}
    <div class="row">
        @foreach ($SubServices as $item)
            <a href="#status" class="col-xl-3 col-md-6 mb-4" wire:click.prevent="ChangeService('{{ $item->Name }}')">
                <div class="card service-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="text-primary fw-bold text-uppercase mb-2">{{ $item->Name }}</h5>
                                <p class="text-muted mb-0">
                                    <strong>📄 Applications:</strong> {{ $item->Total_Count }}
                                </p>
                            </div>
                            {{-- Service Image --}}
                            <img class="rounded-circle img-thumbnail avatar-lg"
                                src="{{ !empty($item->Thumbnail) ? url('storage/' . $item->Thumbnail) : url('storage/no_image.jpg') }}"
                                alt="Service Image">
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Status Section (If Available) --}}
    @if ($temp_count > 0)
        <div class="row" id="status">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="text-danger fw-bold">Status of {{ $Serv_Name }} , {{ $Sub_Serv_Name }}</h4>

                    @if (session('SuccessMsg'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('SuccessMsg') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($status as $item)
                <a href="#table" class="col-xl-3 col-md-6 mb-4" wire:click="ShowDetails('{{ $item->Status }}')">
                    <div class="card status-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <img class="rounded-circle img-thumbnail avatar-lg"
                                    src="{{ !empty($item->Thumbnail) ? asset('storage/' . $item->Thumbnail) : url('storage/no_image.jpg') }}"
                                    alt="Status Image">

                                <div class="flex-grow-1 ms-3">
                                    <h5 class="fw-bold mb-1">{{ $item->Status }}</h5>
                                    @if ($item->Temp_Count > 0)
                                        <span class="text-black"> {{ $item->Temp_Count }} Applications</span>
                                    @else
                                        <span class="badge bg-success">✅ No Pending Applications</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
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
    <div class="bookmark-container">
        <div class="data-table-header">
            <h4 class="fw-bold text-primary">🔖 All Bookmarks for {{ $ServName }}</h4>
        </div>
        <div class="d-flex flex-wrap justify-content-center">
            @foreach ($bookmarks as $bookmark)
                <a href="{{ $bookmark->Hyperlink }}" target="_blank" class="bookmark">
                    <div class="bookmark-content shadow-sm p-3 rounded text-center">
                        <img class="bookmark-img rounded"
                            src="{{ !empty($bookmark->Thumbnail) ? url('storage/' . $bookmark->Thumbnail) : url('storage/no_image.jpg') }}"
                            alt="Bookmark Icon">
                        <p class="text-dark mt-2">{{ $bookmark->Name }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
