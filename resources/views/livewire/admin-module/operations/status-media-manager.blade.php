<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Status Media Manager</h4>

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
                        <li class="breadcrumb-item active">Status Media</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('app.home') }}">Application</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.application') }}">New Application</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    {{-- ---------------------------------------------------------------------------------------------------- --}}
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> Manager Status Media Files</h4>
                    <p class="card-title-desc">Add New Media</p>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-4 col-form-label">Media Id</label>
                        <label for="example-text-input" class="col-sm-8 col-form-label">{{ $media_id }}</label>

                    </div>
                    <!-- end row -->
                    <form wire:submit.prevent="Save">
                        @csrf
                        <div class="row mb-3">
                            <label for="Service" class="col-sm-4 col-form-label">Service</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="Service" wire:model="Service" name="Service" {{ $disabled }}>>
                                    <option value="">---Select---</option>
                                    @foreach ($Services as $Service)
                                        <option value="{{ $Service->Id }}">{{ $Service->Name }}</option>
                                    @endforeach

                                </select>
                                <span class="error">@error('Service'){{ $message }}@enderror</span>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row mb-3">
                            <label for="Service_Type" class="col-sm-4 col-form-label">Service Type</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="Service_Type" wire:model="Service_Type" name="Service_Type" {{ $disabled }}>
                                    <option value="">---Select---</option>
                                    @foreach ($sub_service as $service)
                                    <option value="{{ $service->Name }}">{{ $service->Name }}</option>
                                    @endforeach
                                </select>
                                <span class="error">@error('Service_Type'){{ $message }}@enderror</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Status" class="col-sm-4 col-form-label">Status</label>
                            <div class="col-sm-8">
                                <select class="form-control"  wire:model="Status" name="" id=""  {{ $disabled }}>
                                    <option value="">--Select Status--</option>
                                    @foreach ($status as $status)
                                        <option value="{{ $status->Status }}">{{ $status->Status }}</option>
                                    @endforeach
                                </select>
                                <span class="error">@error('Status'){{ $message }}@enderror</span>
                            </div>
                        </div>

                        <!-- end row -->

                        <div class="row mb-3">
                            <label for="Media" class="col-sm-4 col-form-label">Media</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="file" wire:model="Media" name="Media" id="Media{{ $iteration }}">
                                <span class="error">@error('Media'){{ $message }}@enderror</span>
                            </div>
                        </div>
                        <!-- end row -->

                        <div wire:loading wire:target="Media">Uploading...</div>
                        @if (!is_Null($Media))
                            <div class="row">
                                <div class="col-45">
                                    <img class="col-75" src="{{ $Media->temporaryUrl() }}"" alt="Thumbnail" />
                                </div>
                            </div>
                        @elseif(!is_Null($Old_Media))
                            <div class="row">
                                <div class="col-45">
                                    <img class="col-75" src="{{ url('storage/' . $Old_Media) }}""
                                        alt="Existing Media" />
                                </div>
                            </div>
                        @endif
                        <div class="form-data-buttons"> {{-- Buttons --}}
                            <div class="row">
                                <div class="col-100">
                                    @if ($Update == 0)
                                        <button type="submit" value="submit" name="submit"
                                            class="btn btn-primary btn-rounded btn-sm">Save</button>
                                        <a href="#" wire:click.prevent="ResetFields()"
                                            class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    @elseif($Update == 1)
                                        <a href="#" wire:click.prevent="Update()"
                                            class="btn btn-success btn-rounded btn-sm">Update</button>
                                            <a href="#" wire:click.prevent="ResetFields()"
                                                class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    @endif

                                    <a href='{{ route('admin.home') }}'
                                        class="btn  btn-warning btn-rounded btn-sm ">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->


            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">#{{ $Existing_Media }} Existing Media</h5>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <table id="datatable"
                                class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"role="grid"
                                aria-describedby="datatable_info">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Service</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Media</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($Existing_Media as $key)
                                        <tr>
                                            <td>{{ $Existing_Media->firstItem() + $loop->index }}</td>
                                            <td>{{ $key->service }}</td>
                                            <td>{{ $key->service_type }}</td>
                                            <td>{{ $key->status }}</td>
                                            <td>
                                                <img class="avatar-sm" src="{{ url('storage/' . $key->media) }}"
                                                    alt="media">
                                            </td>
                                            <td>
                                                <a href="{{ route('edit.status.media', $key->id) }}"
                                                    class="btn btn-sm btn-primary font-size-15" id="editData"><i
                                                        class="mdi mdi-circle-edit-outline"></i></a>

                                                <a href ="{{ route('delete.status.media', $key->id) }}"class="btn btn-sm btn-danger font-size-15"
                                                    id="delete"><i class="mdi mdi-delete-alert-outline"></i></a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="11" class="text-center">
                                                <img class="avatar-xl" alt="No Result" src="{{ asset('storage/no_result.png') }}">
                                                <p>No Result Found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                    <p class="text-muted">Showing {{ count($Existing_Media) }} of
                                        {{ $Existing_Media->total() }} entries</p>
                                </div>
                                <div class="col-md-4">
                                    <span class=" pagination pagination-rounded float-end">
                                        {{ $Existing_Media->links() }}
                                    </span>


                                </div>
                                <p class="card-text"><small class="text-muted">Last media added on
                                        {{ $created }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
