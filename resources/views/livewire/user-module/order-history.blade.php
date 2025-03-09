<div>
    {{-- The whole world belongs to you. --}}
    <div class="row">{{-- Messages / Notification Row --}}
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Welcome, {{ Auth::user()->name }} <span class="text-primary"></span></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('service.list') }}">Services</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('history', Auth::user()->mobile_no) }}">Orders</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>{{-- End of Row --}}

    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">My Order History</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('user.home', Auth::user()->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('service.list') }}">Orders</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">My Service Requests</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">{{-- Start of Search Result Details Row --}}
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">📜 {{ $service_count }} Orders Applied</h4>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Applied</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Service</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Consent</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($Services as $data)
                                    <tr>
                                        <td>{{ $Services->firstItem() + $loop->index }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->mobile_no }}</td>
                                        <td>{{ $data->application }}</td>
                                        <td>{{ $data->application_type }}</td>
                                        <td>
                                            <span class="badge bg-{{ $data->status == 'Approved' ? 'success' : ($data->status == 'Pending' ? 'warning' : 'danger') }}">
                                                {{ $data->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ !empty($data->user_consent) ? 'info' : 'secondary' }}">
                                                {{ !empty($data->user_consent) ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        {{-- <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    Actions <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('view.user.application', $data->id) }}">📂 Open</a></li>
                                                    @if (!empty($data->Consent))
                                                        <li><a class="dropdown-item" href="{{ route('view.document', $data->id) }}">📄 View Document</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <img class="avatar-xl" alt="No Result" src="{{ asset('storage/no_result.png') }}">
                                            <p class="mt-2 text-muted">No results found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <p class="text-muted">Showing {{ count($Services) }} of {{ $Services->total() }} entries</p>
                            <div>{{ $Services->links('pagination::bootstrap-5') }}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
