<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Status Manager</h4>

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
                        <li class="breadcrumb-item active">Status</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.application') }}">New Application</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Add New Status</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="Save">
                        @csrf

                        <div class="mb-3">
                            <label for="Statusfor" class="form-label">Status For</label>
                            <select class="form-select" id="Statusfor" wire:model="Relation">
                                <option value="">---Select---</option>
                                <option value="General">General</option>
                                <option value="Callback">Callback</option>
                                @foreach ($MainServices as $item)
                                    <option value="{{ $item->Name }}">{{ $item->Name }}</option>
                                @endforeach
                            </select>
                            @error('Relation') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Name" class="form-label">Status Name</label>
                            <input type="text" class="form-control" placeholder="Enter status name" wire:model="Name" id="Name">
                            @error('Name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Order" class="form-label">Order By</label>
                            <select class="form-select" id="Order" wire:model="Order">
                                <option value="">---Select---</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                            @error('Order') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Thumbnail" class="form-label">Thumbnail</label>
                            <input class="form-control" type="file" wire:model="Thumbnail" id="Thumbnail{{ $iteration }}" accept="image/*">
                            @error('Thumbnail') <span class="text-danger">{{ $message }}</span> @enderror

                            <!-- Show Uploading Status -->
                            <div wire:loading wire:target="Thumbnail" class="text-muted mt-1">Uploading...</div>

                            <!-- Preview Image -->
                            <div class="mt-3">
                                @if ($Thumbnail)
                                    <img class="rounded border border-primary shadow-lg img-fluid mt-2" src="{{ $Thumbnail->temporaryUrl() }}" alt="Preview" style="max-width: 100%; height: 100%;">
                                @elseif($Old_Thumbnail)
                                    <img class="rounded border border-primary shadow-lg img-fluid mt-2" src="{{ asset('storage/' . $Old_Thumbnail) }}" alt="Existing Image" style="max-width: 100%; height: 100%;">
                                @endif
                            </div>
                        </div>


                        <div class="mb-3 text-center">
                            @if ($Update == 0)
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
                            @elseif($Update == 1)
                            <br>
                            <br>
                                <button type="button" wire:click.prevent="Update()" class="btn btn-warning"><i class="fas fa-edit"></i> Update</button>
                            @endif
                            <a href="{{ route('new.status') }}" class="btn btn-secondary"><i class="fas fa-redo"></i> Reset</a>
                            <a href="{{ route('admin.home') }}" class="btn btn-danger"><i class="fas fa-times"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        @if (count($Existing_st) > 0)
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Existing Status ({{ $Existing_st->total() }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Count</th>
                                    <th>Amount</th>
                                    <th>Thumbnail</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Existing_st as $key)
                                <tr>
                                    <td>{{ $Existing_st->firstItem() + $loop->index }}</td>
                                    <td>{{ ucfirst($key->Status) }}</td>
                                    <td>{{ number_format($key->Total_Count) }}</td>
                                    <td>&#8377; {{ number_format($key->Total_Amount, 2) }}</td>
                                    <td>
                                        <img class="rounded-circle avatar-sm" src="{{ asset('storage/' . $key->Thumbnail) }}" alt="Thumbnail">
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-primary" id="editRecord" title="Edit" funName="edit" recId="{{ $key->Id }}"
                                            <i class="mdi mdi-circle-edit-outline"></i>Edit
                                        </a>
                                        <a class="btn btn-sm btn-danger" id="deleteRecord" title="Delete" funName="delete" recId="{{ $key->Id }}"
                                            <i class="mdi mdi-trash-can"></i>Delete
                                        </a>
                                        <a  class="btn btn-sm btn-info" id="viewRecord" title="View" funName="view" recId="{{ $key->Status }}"
                                            <i class="mdi mdi-eye"></i>List
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted">Showing {{ count($Existing_st) }} of {{ $Existing_st->total() }} entries</p>
                            <div class="pagination pagination-rounded">
                                {{ $Existing_st->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @if ($list)
    <div class="row" id="list">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Header Section -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title text-primary mb-0">Search Results</h4>
                    </div>

                    <!-- Table Container with Responsive Scroll -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Received</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Application</th>
                                    <th>Services</th>
                                    <th>Ref No</th>
                                    <th>Document</th>
                                    <th>Status</th>
                                    <th>Profile</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($records as $data)
                                    <tr>
                                        <td>{{ $records->firstItem() + $loop->index }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->Received_Date)->format('d M Y') }}</td>
                                        <td>{{ ucwords(strtolower($data->Name)) }}</td>
                                        <td><strong>{{ $data->Mobile_No }}</strong></td>
                                        <td>{{ ucwords($data->Application) }}</td>
                                        <td>{{ ucwords($data->Application_Type) }}</td>
                                        <td><span class="badge bg-info">{{ $data->Ack_No }}</span></td>
                                        <td><span class="badge bg-secondary">{{ $data->Document_No }}</span></td>
                                        <td>
                                            <select class="form-select form-select-sm"
                                                wire:change="UpdateStatus('{{ $data->Id }}', event.target.value)">
                                                <option selected>{{ $data->Status }}</option>
                                                @foreach ($status_list as $status)
                                                    <option value="{{ $status->Status }}">{{ $status->Status }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <img src="{{ !empty($data->Applicant_Image) ? url('storage/' . $data->Applicant_Image) : url('storage/no_image.jpg') }}"
                                                 alt="Profile"
                                                 class="rounded-circle img-thumbnail"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <a href="{{ route('edit_application', $data->Id) }}" class="btn btn-sm btn-primary" target="_blank">
                                                <i class="mdi mdi-pencil"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center text-muted">
                                            <img src="{{ asset('storage/no_result.png') }}" class="img-fluid"
                                                 style="max-width: 150px;" alt="No Result">
                                            <p class="mt-2">No Results Found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination & Entry Count -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <p class="text-muted mb-0">Showing {{ count($records) }} of {{ $records->total() }} entries</p>
                        <nav>
                            {{ $records->links() }}
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>


    @endif



    <div>
