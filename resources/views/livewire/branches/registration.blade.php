<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Branch Registration</h4>

                @if (session('SuccessMsg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('SuccessMsg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('SuccessUpdate'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('SuccessUpdate') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('Error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('Error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Digital Cyber</a></li>
                        <li class="breadcrumb-item active">Bookmarks</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ url('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('app_home') }}">Application</a></li>
            <li class="breadcrumb-item"><a href="{{ url('app_form') }}">New Application</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    {{-- ---------------------------------------------------------------------------------------------------- --}}
    <div class="row">
        <!-- Branch Registration Form -->
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h5 class="mb-0">New Branch</h5>
                    <a href="{{ route('branch_register') }}" class="btn btn-light btn-sm">Create New</a>
                </div>
                <div class="card-body">
                    <p class="card-title-desc text-muted">Welcome to Branch Registration</p>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Branch ID:</label>
                        <span class="text-primary">{{ $Br_Id }}</span>
                    </div>

                    <form wire:submit.prevent="Save">
                        @csrf

                        <div class="mb-3">
                            <label for="Name" class="form-label">Branch Name</label>
                            <input class="form-control" type="text" placeholder="Enter Branch Name" wire:model.lazy="Name" id="Name">
                            @error('Name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Address" class="form-label">Address</label>
                            <textarea class="form-control" placeholder="Enter Address" rows="3" wire:model.lazy="Address"></textarea>
                            @error('Address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="MapLink" class="form-label">Google Map Link</label>
                            <input class="form-control" type="text" placeholder="Enter Google Map Link" wire:model="MapLink">
                            @error('MapLink') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex gap-2">
                            @if ($Update == 0)
                                <button type="submit" class="btn btn-primary w-100">Save</button>
                            @else
                            <br>
                            <button type="button" wire:click.prevent="updateBranch('{{ $Br_Id }}')" class="btn btn-success w-100">
                                Update
                            </button>
                            @endif
                            <button type="button" wire:click.prevent="ResetFields()" class="btn btn-secondary w-100">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Branch Registration Form -->

        @if ($Existing_branches->count() > 0)
            <!-- Existing Branches Table -->
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Total Branches: {{ $Existing_branches->total() }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Map</th>
                                        <th>Applicants</th>
                                        <th>Employees</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Existing_branches as $key)
                                        <tr>
                                            <td>{{ $Existing_branches->firstItem() + $loop->index }}</td>
                                            <td class="fw-bold">{{ ucfirst($key->name) }}</td>
                                            <td class="text-truncate" style="max-width: 150px;">{{ $key->address }}</td>
                                            <td>
                                                <a href="{{ $key->google_map_link }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="mdi mdi-map-marker"></i> View Map
                                                </a>
                                            </td>
                                            <td class="text-center">{{ $key->user_count }}</td>
                                            <td class="text-center">{{ $key->employee_count }}</td>
                                            <td>
                                                <a id="editRecord" funName="edit" recId="{{ $key->branch_id }}" class="btn btn-sm btn-primary">
                                                    <i class="mdi mdi-pencil"></i>Edit
                                                </a>
                                                <button class="btn btn-sm btn-danger" id="deleteRecord" funName="delete" recId="{{ $key->branch_id }}" ">
                                                    <i class="mdi mdi-delete"></i>Delete
                                                </button>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <p class="text-muted mb-0">Showing {{ $Existing_branches->count() }} of {{ $Existing_branches->total() }} entries</p>
                            <nav>
                                {{ $Existing_branches->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Existing Branches Table -->
        @endif
    </div>

</div>
