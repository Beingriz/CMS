<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Whatsapp BlockList</h4>

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
                        <li class="breadcrumb-item active">BlockList</li>
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
                <div class="card-header d-sm-flex align-items-center justify-content-between"">
                    <h5>New BlockList</h5>
                    <h5><a href="{{ route('whatsapp.blocklist') }}" title="Click here for New Template">Refresh</a></h5>
                </div>
                <div class="card-body">

                    <p class="card-title-desc">Block Contacts from Bulk Messages </p>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-4 col-form-label">Block Id</label>
                        <label for="example-text-input" class="col-sm-7 col-form-label">{{ $blockId }}</label>

                    </div>
                    <!-- end row -->
                    <form wire:submit.prevent="BlockContact('{{ $clientId }}')">
                        @csrf

                        <div class="row mb-3">
                            <label for="mobile_no" class="col-sm-4 col-form-label">Phone No</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="number" placeholder="Phone No" wire:model.lazy="mobile_no"
                                    id="mobile_no">
                                <span class="error"> @error('mobile_no') {{ $message }} @enderror </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="clientId" class="col-sm-4 col-form-label">Client ID</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" placeholder="Client Id" disabled wire:model="clientId"
                                    id="clientId">
                                <span class="error"> @error('clientId') {{ $message }} @enderror </span>
                            </div>
                        </div>
                        <!-- end row -->
                        @if(!$unRegistered)
                        @if (!$isUnblock)
                        <div class="row mb-3">
                            <label for="reason" class="col-sm-4 col-form-label">Reason</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="reason" id="reason" wire:model="reason">
                                    <option value="">--Select Status--</option>
                                    <option value="opted out">Opt-Out</option>
                                    <option value="not intrested">Not Intrested</option>
                                    <option value="blocklisted">Blocklisted</option>
                                </select>
                            </div>
                        </div>
                        <!-- end row -->
                        @endif
                        @endif


                        <div class="form-data-buttons"> {{-- Buttons --}}
                            <div class="row">
                                <div class="col-100">
                                    @if(!$unRegistered)
                                        @if (!$isUnblock )

                                            <button type="submit" value="submit" name="submit"
                                                class="btn btn-danger btn-rounded btn-sm">Block</button>
                                                <a href="#" wire:click.prevent="ResetFields()"
                                                class="btn btn-info btn-rounded btn-sm">Reset</a>
                                        @else
                                            <a href="#" wire:click.prevent="unBlock('{{ $clientId }}')"class="btn btn-success btn-rounded btn-sm">Unblock</button>
                                                <a href="#" wire:click.prevent="ResetFields()"
                                                    class="btn btn-info btn-rounded btn-sm">Reset</a>
                                        @endif
                                        @else
                                        <a href='{{ route('whatsapp.blocklist') }}'
                                        class="btn btn-info btn-rounded btn-sm">Refres</a>
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

    @if (count($blocklist) > 0)
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">#{{ $blocklist->total() }} Blocklisted Contacts</h5>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <table id="datatable"
                        class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline text-wrap"role="grid"
                        aria-describedby="datatable_info">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Branch</th>
                                <th>Name</th>
                                <th>Mobile No</th>
                                <th>Reason</th>
                                <th>Profile</th>
                                <th>Edit Profile</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blocklist as $key)
                                <tr>
                                    <td>{{ $blocklist->firstItem() + $loop->index }}</td>
                                    <td>{{ ucwords($key->branch_name) }}</td>
                                    <td>{{ ucwords($key->Name) }}</td>
                                    <td class="text-wrap">{{ $key->Mobile_No }}</td>
                                    <td class="text-wrap">{{ ucwords($key->reason)}}
                                        <p>Added on: {{ $key->created_at->diffForHumans() }}</p></td>
                                    <td> <img
                                        src="{{ !empty($key['Profile_Image']) ? url('storage/' . $key['Profile_Image']) : url('storage/no_image.jpg') }} "
                                        alt="" class="rounded-circle avatar-md">
                                    </td>
                                    <td>
                                         <a class="dropdown-item btn-primary" id="update"
                                        title="Edit Applicaiton" href="{{ route('edit_profile', $key->Id) }}">Edit</a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-8">
                            <p class="text-muted">Showing {{ count($blocklist) }} of
                                {{ $blocklist->total() }} entries</p>
                        </div>
                        <div class="col-md-4">
                            <span class=" pagination pagination-rounded float-end">
                                {{ $blocklist->links() }}
                            </span>


                        </div>
                        <p class="card-text"><small class="text-muted">Last Contact Blocked :
                                {{ $created }}</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
</div>
