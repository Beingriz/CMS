<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Whatsapp Templates</h4>

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
                        <li class="breadcrumb-item active">Templates</li>
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
                    <h5>New Template</h5>
                    <h5><a href="{{ route('whatsapp.templates') }}" title="Click here for New Template">Create New</a></h5>
                </div>
                <div class="card-body">

                    <p class="card-title-desc">Customised Whatsapp Templates</p>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-4 col-form-label">Temp Id</label>
                        <label for="example-text-input" class="col-sm-7 col-form-label">{{ $templateId }}</label>

                    </div>
                    <!-- end row -->
                    <form wire:submit.prevent="createTemplate">
                        @csrf

                        <div class="row mb-3">
                            <label for="Name" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" placeholder="Temp Name" wire:model="template_name"
                                    id="Template Name">
                                <span class="error"> @error('template_name') {{ $message }} @enderror </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="example-url-input" class="col-sm-4 col-form-label">Body</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" type="text" wire:model="template_body"
                                    placeholder="Template Body" rows="3" cols="5" id="example-url-input"></textarea>
                                <span class="error"> @error('template_body') {{ $message }} @enderror </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="googlemap" class="col-sm-4 col-form-label">Media Url</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" placeholder="Media Url (Optional)" wire:model="media_url"
                                    id="media_url">
                                <span class="error"> @error('media_url') {{ $message }} @enderror </span>
                            </div>
                        </div>
                        <!-- end row -->
                        <!-- end row -->
                        <div class="row mb-3">
                            <label for="googlemap" class="col-sm-4 col-form-label">Status</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="media_url" id="media_url" wire:model="status">
                                    <option value="">--Select Status--</option>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                </select>

                                <span class="error"> @error('media_url') {{ $message }} @enderror </span>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="form-data-buttons"> {{-- Buttons --}}
                            <div class="row">
                                <div class="col-100">
                                    @if (!$isEdit)
                                        <button type="submit" value="submit" name="submit"
                                            class="btn btn-primary btn-rounded btn-sm">Save</button>
                                        <a href="#" wire:click.prevent="ResetFields()"
                                            class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    @else
                                        <a href="#" wire:click.prevent="updateTemplate({{ $templateId }})"class="btn btn-success btn-rounded btn-sm">Update</button>
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

    @if (count($templates) > 0)
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">#{{ $templates->total() }} Templates Available</h5>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <table id="datatable"
                        class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline text-wrap"role="grid"
                        aria-describedby="datatable_info">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Body</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($templates as $key)
                                <tr>
                                    <td>{{ $templates->firstItem() + $loop->index }}</td>
                                    <td>{{ $key->template_name }}</td>
                                    <td class="text-wrap">{{ $key->template_body }}</td>
                                    <td class="text-wrap">{{ ucwords($key->status) }}</td>

                                    <td>
                                        <button wire:click.prevent="editTemplate({{ $key->id }})"
                                            class="btn btn-sm btn-primary font-size-15" ><i
                                                class="mdi mdi-circle-edit-outline"></i></button>

                                        <a wire:click.prevent="deleteTemplate('{{ $templateId }}')"class="btn btn-sm btn-danger font-size-15"
                                            id="delete"><i class="mdi mdi-delete-alert-outline"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-8">
                            <p class="text-muted">Showing {{ count($templates) }} of
                                {{ $templates->total() }} entries</p>
                        </div>
                        <div class="col-md-4">
                            <span class=" pagination pagination-rounded float-end">
                                {{ $templates->links() }}
                            </span>


                        </div>
                        <p class="card-text"><small class="text-muted">Last Template created
                                {{ $created }}</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
</div>
