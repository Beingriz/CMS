<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ $ServName }} Dashboard</h4>

                @if (session('SuccessMsg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('SuccessMsg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Digital Cyber</a></li>
                        <li class="breadcrumb-item active">Services Board</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('Dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.application') }}">New Application</a></li>
            <li class="breadcrumb-item"><a href="{{ route('update_application') }}">Update</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    <div class="data-table-header">
        <p class="heading"> {{ $ServName }} Dashboard</p>
    </div>{{-- End of Header --}}



    <div class="row"> {{-- Start of Services Row --}}
        @foreach ($SubServices as $item)
            <a href="#" class="col-xl-3 col-md-10" wire:click.prevent="ChangeService('{{ $item->Name }}')">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">

                            {{-- <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fas fa-edit"></i></i>
                            </span>
                        </div> --}}
                            <div class="flex-grow-1 align-items-center">
                                <h5 class="text-truncate text-primary font-size-20 mb-2">{{ $item->Name }}</h5>
                                <div class="col-4">
                                    <div class="text-center mt-4">
                                        <h5>{{ $item->Total_Count }}</h5>
                                        <p class="mb-2 text-truncate">Applications</p>
                                    </div>
                                </div>
                            </div>

                            <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg"
                                src="{{ !empty($item->Thumbnail) ? url('storage/' . $item->Thumbnail) : url('storage/no_image.jpg') }}"
                                alt="Generic placeholder image">

                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div> {{-- End of Row --}}

    @if ($temp_count > 0)
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Status of {{ $Serv_Name }} , {{ $Sub_Serv_Name }}</h4>

                    @if (session('SuccessMsg'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('SuccessMsg') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif


                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Digital Cyber</a></li>
                            <li class="breadcrumb-item active">Services Board</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>{{-- End of Row --}}

        <div class="row"> {{-- Start of Status Count Row --}}
            <div class="dynamic-table-header">
            </div>
            @foreach ($status as $item)
                <a href="#table" class="col-xl-3 col-md-10" wire:click="ShowDetails('{{ $item->Status }}')">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg"
                                    src="{{ !empty($item->Thumbnail) ? asset('storage/' . $item->Thumbnail) : url('storage/no_image.jpg') }}"
                                    alt="">

                                <div class="flex-grow-1">
                                    <h5 class="mt-0 font-size-18 mb-1">{{ $item->Status }}</h5>
                                    @if ($item->Temp_Count > 0)
                                        <p class="text-muted font-size-14">Found <span
                                                class="badge rounded-pill bg-danger font-size-14">{{ $item->Temp_Count }}</span>
                                            App.</p>
                                    @else
                                        <p class="text-muted font-size-14">No Pending Applications Found for this
                                            Status.</p>
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>{{-- End of Status Count Row --}}
    @endif

    @if ($ShowTable)
        <div class="" id="table">
            @include('admin-module.application.dynamic-table')
        </div>
    @endif
    <div class="bookmark-container">
        <div class="data-table-header">
            <p class="heading">Bookmarks</p>
        </div>
        <div class="bookmarks-row justify-content-center">
            @foreach ($bookmarks as $bookmark)
                <a href="{{ $bookmark->Hyperlink }}" target="_blank" class="bookmark">
                    <div class="bookmark-content">
                        <img class="b-img"
                            src="{{ !empty($bookmark->Thumbnail) ? url('storage/' . $bookmark->Thumbnail) : url('storage/no_image.jpg') }}"
                            alt="Bookmark Icon">
                        <p class="b-name">{{ $bookmark->Name }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div> <!-- End of Livewire Tag -->
