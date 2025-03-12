<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">About Us</h4>

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
                        <li class="breadcrumb-item active">About Us</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.application') }}">New Application</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.about_us') }}">New About-Us</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}


    <div class="row">
        <!-- About Us Form Section -->
        <div class="col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-info-circle me-2"></i> <h5 class="mb-0">About Us</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Provide a short description about the company.</p>

                    <div class="mb-3">
                        <label class="text-muted"><strong>ID:</strong> {{ $Id }}</label>
                    </div>

                    <form wire:submit.prevent="Save">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="Tittle" class="form-label fw-bold">Title</label>
                            <input class="form-control " type="text" placeholder="Enter Title" wire:model.lazy="Tittle" id="Tittle">
                            @error('Tittle') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="Description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control " rows="4" placeholder="Enter description..." wire:model.lazy="Description" id="Description"></textarea>
                            @error('Description') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="Image" class="form-label fw-bold">Upload Image</label>
                            <input class="form-control " type="file" id="ImageUpload" accept="image/jpeg, image/png" wire:model="Image">
                            @error('Image') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Image Preview -->
                        <div class="mb-3 text-center">
                            @if ($Image)
                                <div wire:loading wire:target="Image" class="text-info fw-bold">
                                    <i class="fas fa-spinner fa-spin"></i> Uploading...
                                </div>
                                <img class="rounded border border-primary shadow-lg img-fluid mt-2"
                                    src="{{ $Image->temporaryUrl() }}"
                                    alt="Uploaded Image" style="max-width: 100%; height: auto;">
                            @elseif($Old_Image)
                                <img class="rounded border border-secondary shadow-lg img-fluid mt-2"
                                    src="{{ asset('storage/' . $Old_Image) }}"
                                    alt="Existing Image" style="max-width: 100%; height: auto;">
                            @endif
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-3 justify-content-center">
                            @if ($Update == 0)
                                <button type="submit" class="btn btn-primary px-4 shadow">
                                    <i class="fas fa-save"></i> Save
                                </button>
                                <a type="button" class="btn btn-warning text-white px-4 shadow" href="{{ route('new.about_us') }}">
                                    <i class="fas fa-redo"></i>Reset</a>
                                </button>
                            @elseif($Update == 1)
                                <button type="button" class="btn btn-success px-4 shadow" wire:click.prevent="Update()">
                                    <i class="fas fa-edit"></i> Update
                                </button>
                                <button type="button" class="btn btn-warning text-white px-4 shadow" wire:click.prevent="ResetFields()">
                                    <i class="fas fa-redo"></i> Reset
                                </button>
                            @endif
                            <a href="{{ route('admin.home') }}" class="btn btn-secondary px-4 shadow">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->

        <!-- About Us Table Section -->
        <div class="col-lg-7">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-dark text-white d-flex align-items-center">
                    <i class="fas fa-table me-2"></i> <h5 class="mb-0">About Us Records</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Manage about us details.</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($Records as $index => $key)
                                    <tr class="{{ $key->Selected == 'Yes' ? 'table-success' : '' }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $key->Tittle ?? 'N/A' }}</td>
                                        <td>{{ Str::limit($key->Description, 50) }}</td>
                                        <td>
                                            <img class="avatar-sm rounded border border-secondary shadow-sm"
                                                 src="{{ url('storage/' . $key->Image) }}" alt="Image">
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                                                    <i class="fas fa-cogs"></i> Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item text-primary" funName="edit" recId="{{ $key->Id }}" id="editRecord" >
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item text-success" funName="select" recId="{{ $key->Id }}" id="selectRecord" >
                                                        <i class="fas fa-check"></i> Select
                                                    </a>
                                                    <a class="dropdown-item text-danger" funName="delete" recId="{{ $key->Id }}" id="deleteRecord" >
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            <strong>No Records Available</strong>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div>
</div>
