<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Carousel</h4>

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
                        <li class="breadcrumb-item active">UserTopBar</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('app.home') }}">App Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.application') }}">New Application</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.carousel') }}">New Carousel</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    <div class="row">
        <!-- Carousel Form Section -->
        <div class="col-lg-5">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-images me-2"></i> <h5 class="mb-0">Carousel</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Manage Sliding Images</p>

                    <div class="mb-3">
                        <label class="text-muted"><strong>ID:</strong> {{ $Id }}</label>
                    </div>

                    <form wire:submit.prevent="Save">
                        <!-- Title Selection -->
                        <div class="mb-3">
                            <label for="Tittle" class="form-label">Title</label>
                            <select class="form-control" id="Tittle" wire:model.lazy="Tittle">
                                <option value="">---Select---</option>
                                @foreach ($Services as $item)
                                    <option value="{{ $item->Name }}">{{ $item->Name }}</option>
                                @endforeach
                            </select>
                            @error('Tittle') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="Description" class="form-label">Description</label>
                            <textarea class="form-control" placeholder="Enter description..." rows="4" wire:model.lazy="Description" id="Description"></textarea>
                            @error('Description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="Image" class="form-label">Upload Image</label>
                            <input class="form-control" type="file" id="ImageUpload" accept="image/jpeg, image/png" wire:model="Image">
                            @error('Image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Image Preview -->
                        <div class="mb-3 text-center">
                            @if ($Image)
                                <div wire:loading wire:target="Image" class="text-info fw-bold">
                                    <i class="fas fa-spinner fa-spin"></i> Uploading...
                                </div>
                                <img class="rounded img-thumbnail mt-2"
                                    src="{{ $Image->temporaryUrl() }}"
                                    alt="Uploaded Image" style="max-width: 100%; height: auto;">
                            @elseif($Old_Image)
                                <img class="rounded img-thumbnail mt-2"
                                    src="{{ asset('storage/' . $Old_Image) }}"
                                    alt="Existing Image" style="max-width: 100%; height: auto;">
                            @endif
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-3 justify-content-center">
                            @if ($Update == 0 && $Count < 4)
                                <button type="submit" class="btn btn-primary px-4 shadow">
                                    <i class="fas fa-save"></i> Save
                                </button>
                                <button type="button" class="btn btn-warning text-white px-4 shadow" wire:click.prevent="ResetFields()">
                                    <i class="fas fa-redo"></i> Reset
                                </button>
                            @elseif($Update == 1)
                                <button type="button" class="btn btn-success px-4 shadow" wire:click.prevent="Update()">
                                    <i class="fas fa-edit"></i> Update
                                </button>
                                <button type="button" class="btn btn-warning text-white px-4 shadow" wire:click.prevent="ResetFields()">
                                    <i class="fas fa-redo"></i> Reset
                                </button>
                            @endif
                            <a href="{{ route('admin.home') }}" class="btn btn-danger px-4 shadow">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->

        <!-- Carousel Table Section -->
        <div class="col-lg-7">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white d-flex align-items-center">
                    <i class="fas fa-table me-2"></i> <h5 class="mb-0">Carousel Images</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <p class="text-muted">Manage carousel images for advertising purposes.</p>
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sl No</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Banner</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($Records as $index => $key)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $key->Tittle ?? 'N/A' }}</td>
                                        <td>{{ Str::limit($key->Description, 50) }}</td>
                                        <td>
                                            <img class="avatar-sm rounded shadow-sm" src="{{ url('storage/' . $key->Image) }}"
                                                 alt="{{ $key->Tittle ?? 'Carousel Image' }}"
                                                 onerror="this.onerror=null; this.src='/default-image.jpg';">
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-light dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-cogs"></i> Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item text-primary" id="editRecord" funName="edit" recId="{{ $key->Id }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item text-danger" id="deleteRecord" funName="delete" recId="{{ $key->Id }}">
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
