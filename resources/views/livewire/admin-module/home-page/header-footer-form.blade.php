<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">User Top Bar</h4>

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
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('app.home')}}">Application</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.application') }}">New Application</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    {{-- ---------------------------------------------------------------------------------------------------- --}}

    <div class="row">
        <!-- User Top Bar Form Section -->
        <div class="col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-user-cog me-2"></i> <h5 class="mb-0">Update User Top Bar</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Update the user view page top bar details.</p>

                    <div class="mb-3">
                        <label class="text-muted"><strong>ID:</strong> {{ $Id }}</label>
                    </div>

                    <form wire:submit.prevent="Save">
                        <!-- Company Name -->
                        <div class="mb-3">
                            <label for="Company_Name" class="form-label fw-bold">Company Name</label>
                            <input class="form-control" type="text" placeholder="Enter Company Name" wire:model.lazy="Company_Name" id="Company_Name">
                            @error('Company_Name') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="Address" class="form-label fw-bold">Address</label>
                            <input class="form-control" type="text" placeholder="Enter Address" wire:model.lazy="Address" id="Address">
                            @error('Address') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Phone No -->
                        <div class="mb-3">
                            <label for="Phone_No" class="form-label fw-bold">Phone No</label>
                            <input class="form-control" type="number" placeholder="Enter Phone No" wire:model="Phone_No" id="Phone_No">
                            @error('Phone_No') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Time Inputs -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="Time_From" class="form-label fw-bold">Time From</label>
                                <input class="form-control" type="time" wire:model="Time_From" id="Time_From">
                                @error('Time_From') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
                            </div>
                            <div class="col">
                                <label for="Time_To" class="form-label fw-bold">Time To</label>
                                <input class="form-control" type="time" wire:model="Time_To" id="Time_To">
                                @error('Time_To') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Social Media Links -->
                        @foreach (['Facebook', 'Twitter', 'Instagram', 'LinkedIn', 'Youtube'] as $social)
                            <div class="mb-3">
                                <label for="{{ $social }}" class="form-label fw-bold"><i class="fab fa-{{ strtolower($social) }}"></i> {{ $social }}</label>
                                <input class="form-control" type="url" placeholder="Enter {{ $social }} URL" wire:model="{{ $social }}" id="{{ $social }}">
                                @error($social) <span class="text-danger fw-bold">{{ $message }}</span> @enderror
                            </div>
                        @endforeach

                        <!-- Buttons -->
                        <div class="d-flex gap-3 justify-content-center">
                            @if ($Update == 0)
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

        <!-- Desktop View Table Section -->
        <div class="col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-dark text-white d-flex align-items-center">
                    <i class="fas fa-table me-2"></i> <h5 class="mb-0">Header & Footer Details</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Phone No</th>
                                    <th>Email</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Records as $key)
                                    <tr class="{{ $key->Selected == 'Yes' ? 'table-success' : '' }}">
                                        <td>{{ $key['Company_Name'] }}</td>
                                        <td>{{ $key['Address'] }}</td>
                                        <td>{{ $key['Phone_No'] }}</td>
                                        <td>{{ $key['Email_Id'] }}</td>
                                        <td>{{ $key['Time_From'] }}</td>
                                        <td>{{ $key['Time_To'] }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                                                    <i class="fas fa-cogs"></i> Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item text-primary" id="editRecord" funName="edit" recId="{{ $key->Id }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item text-success" id="selectRecord" funName="select" recId="{{ $key->Id }}">
                                                        <i class="fas fa-check"></i> Select
                                                    </a>
                                                    <a class="dropdown-item text-danger" id="deleteRecord" funName="delete" recId="{{ $key->Id }}">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

</div>

</div>
