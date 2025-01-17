<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Bookmark</h4>

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
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('app.home') }}">Application</a></li>
            <li class="breadcrumb-item"><a href="{{ route('new.application') }}">New Application</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    {{-- ---------------------------------------------------------------------------------------------------- --}}
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> Favourite Bookmark</h4>
                    <p class="card-title-desc">Add New Bookmarks</p>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Bookmark Id</label>
                        <label for="example-text-input" class="col-sm-3 col-form-label">{{ $Bm_Id }}</label>

                    </div>
                    <!-- end row -->
                    <form wire:submit.prevent="Save">
                        @csrf
                        <div class="row mb-3">
                            <label for="example-search-input" class="col-sm-2 col-form-label">Bookmark for</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="Main_Services" wire:model="Relation" name="Relation"
                                    wire:change="Change(event.target.value)">
                                    <option value="">---Select---</option>
                                    <option value="General">General</option>
                                    @foreach ($MainServices as $item)
                                        <option value="{{ $item->Name }}">{{ $item->Name }}</option>
                                    @endforeach

                                </select>
                                <span class="error">@error('Relation'){{ $message }}@enderror</span>
                            </div>
                        </div>
                        <!-- end row -->

                        @if ($Update == 1)
                            <div class="row mb-3"> {{-- Change Relation --}}
                                <label for="example-email-input" class="col-sm-2 col-form-label">Change Relation</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="ChangeRelation" wire:model="ChangeRelation"
                                        name="ChangeRelation">
                                        <option value="">---Select---</option>
                                        <option value="General">General</option>
                                        @foreach ($MainServices as $item)
                                            <option value="{{ $item->Name }}">{{ $item->Name }}</option>
                                        @endforeach

                                    </select>
                                    <span class="error">
                                        @error('ChangeRelation')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        @endif
                        <div class="row mb-3">
                            <label for="Name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Bookmark Name" wire:model="Name"
                                    id="Name">
                                <span class="error">
                                    @error('Name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="example-url-input" class="col-sm-2 col-form-label">URL</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" wire:model="Hyperlink"
                                    placeholder="https:/cyberpe.epizy.com" id="example-url-input">
                                <span class="error">
                                    @error('Hyperlink')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="example-tel-input" class="col-sm-2 col-form-label">Thumbnail</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="file" wire:model="Thumbnail"
                                    id="Thumbnail{{ $iteration }}">
                                <span class="error">
                                    @error('Thumbnail')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- end row -->

                        <div wire:loading wire:target="Thumbnail">Uploading...</div>
                        @if (!is_Null($Thumbnail))
                            <div class="row">
                                <div class="col-45">
                                    <img class="col-75" src="{{ $Thumbnail->temporaryUrl() }}"" alt="Thumbnail" />
                                </div>
                            </div>
                        @elseif(!is_Null($Old_Thumbnail))
                            <div class="row">
                                <div class="col-45">
                                    <img class="col-75" src="{{ url('storage/' . $Old_Thumbnail) }}""
                                        alt="Existing Thumbnail" />
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


        @if (count($Existing_Bm) > 0)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">#{{ $Existing_Bm->total() }} Bookmarks for {{ $Relation }}
                            Category</h5>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <table id="datatable"
                                class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"role="grid"
                                aria-describedby="datatable_info">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Thumnnail</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Existing_Bm as $key)
                                        <tr>
                                            <td>{{ $Existing_Bm->firstItem() + $loop->index }}</td>
                                            <td>{{ $key->Name }}</td>
                                            <td>
                                                <img class="avatar-sm" src="{{ url('storage/' . $key->Thumbnail) }}"
                                                    alt="Bookmark">
                                            </td>
                                            <td>
                                                <a href="{{ route('edit.bookmark', $key->BM_Id) }}"
                                                    class="btn btn-sm btn-primary font-size-15" id="editData"><i
                                                        class="mdi mdi-circle-edit-outline"></i></a>

                                                <a href ="{{ route('delete.bookmark', $key->BM_Id) }}"class="btn btn-sm btn-danger font-size-15"
                                                    id="delete"><i class="mdi mdi-delete-alert-outline"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                    <p class="text-muted">Showing {{ count($Existing_Bm) }} of
                                        {{ $Existing_Bm->total() }} entries</p>
                                </div>
                                <div class="col-md-4">
                                    <span class=" pagination pagination-rounded float-end">
                                        {{ $Existing_Bm->links() }}
                                    </span>


                                </div>
                                <p class="card-text"><small class="text-muted">Last Bookmarked
                                        {{ $created }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
