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
        @if (!empty($templates))
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">#{{ $templates->total() }} Templates Available</h5>
                        <h6><a href="#" title="Click here to synch available template"  wire:click.prevent="fetchAndSyncApprovedTemplates()">Sync Templates</a></h6>

                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Content Type</th>
                                        <th>Category</th>
                                        <th>Body</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($templates as $key)
                                        <tr>
                                            <td>{{ $templates->firstItem() + $loop->index }}</td>
                                            <td>{{ ucwords(str_replace('_', ' ', $key->template_name)) }}</td>
                                            <td>{{ ucwords(str_replace('/', ' ', $key->content_type)) }}</td>
                                            <td class="text-wrap ">{{ ucwords($key->category) }}</td>
                                             <td class="text-wrap w-25">{{ $key->body }}</td>
                                            <td class="text-wrap">{{ ucwords($key->status) }}</td>
                                            <td class="text-wrap">{{ \Carbon\Carbon::parse($key->last_created_at)->format('F j, Y') }}</td>
                                            <td>
                                                <a href={{ route('whatsapp.template.delete', $key->template_sid) }} id="delete" class="btn btn-sm btn-danger">
                                                    <i class="mdi mdi-delete-alert-outline"></i>
                                                </a>
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
        @endif
    </div>
</div>
