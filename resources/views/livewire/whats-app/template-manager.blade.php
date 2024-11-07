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
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between">
                    <h5>New Template</h5>
                    <h5><a href="{{ route('whatsapp.templates') }}" title="Click here for New Template">Create New</a></h5>
                </div>
                <div class="card-body">
                    <p class="card-title-desc">Customised Whatsapp Templates</p>
                    <form wire:submit.prevent="createTemplate">
                        @csrf

                        <div class="row mb-3">
                            <label for="template_name" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" placeholder="Temp Name" wire:model="template_name">
                                <span class="error"> @error('template_name') {{ $message }} @enderror </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="template_content_sid" class="col-sm-4 col-form-label">Content SID</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" placeholder="Template SID" wire:model="template_content_sid">
                                <span class="error"> @error('template_content_sid') {{ $message }} @enderror </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="template_body" class="col-sm-4 col-form-label">Body</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" placeholder="Template Body" rows="3" wire:model="template_body"></textarea>
                                <span class="error"> @error('template_body') {{ $message }} @enderror </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="media_url" class="col-sm-4 col-form-label">Media Url</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" placeholder="Media Url (Optional)" wire:model="media_url">
                                <span class="error"> @error('media_url') {{ $message }} @enderror </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="status" class="col-sm-4 col-form-label">Status</label>
                            <div class="col-sm-8">
                                <select class="form-control" wire:model="status">
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                </select>
                                <span class="error"> @error('status') {{ $message }} @enderror </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="whatsapp_category" class="col-sm-4 col-form-label">Category</label>
                            <div class="col-sm-8">
                                <select class="form-control" wire:model="whatsapp_category">
                                    <option value="utility">Utility</option>
                                    <option value="marketing">Marketing</option>
                                    <option value="transactional">Transactional</option>
                                </select>
                                <span class="error"> @error('whatsapp_category') {{ $message }} @enderror </span>
                            </div>
                        </div>

                        <div class="form-data-buttons">
                            <div class="row">
                                <div class="col-100">
                                    <button type="submit" class="btn btn-primary btn-rounded btn-sm">Save</button>
                                    <a href="#" wire:click.prevent="resetFields()" class="btn btn-info btn-rounded btn-sm">Reset</a>
                                    <a href="{{ route('admin.home') }}" class="btn btn-warning btn-rounded btn-sm">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
{{--
        @if ($templates->count() > 0)
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">#{{ $templates->total() }} Templates Available</h5>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered dt-responsive nowrap">
                                <thead>
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
                                                <button wire:click.prevent="editTemplate({{ $key->id }})" class="btn btn-sm btn-primary">
                                                    <i class="mdi mdi-circle-edit-outline"></i>
                                                </button>
                                                <button wire:click.prevent="deleteTemplate({{ $key->id }})" class="btn btn-sm btn-danger">
                                                    <i class="mdi mdi-delete-alert-outline"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                    <p class="text-muted">Showing {{ count($templates) }} of {{ $templates->total() }} entries</p>
                                </div>
                                <div class="col-md-4">
                                    <div class="pagination pagination-rounded float-end">
                                        {{ $templates->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif --}}
    </div>
</div>
