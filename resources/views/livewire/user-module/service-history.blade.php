<div>
    {{-- The whole world belongs to you. --}}
    <div class="row">{{-- Messags / Notification Row --}}
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Welcome {{ Auth::user()->name }}<span class="text-primary"></span> </h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('service.list') }}">Services</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('history', Auth::user()->mobile_no) }}">My
                                History</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>{{-- End of Row --}}
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">My Service History</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white"
                            href="{{ route('user.home', Auth::user()->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('service.list') }}">Services</a>
                    </li>
                    <li class="breadcrumb-item text-white active" aria-current="page">My History</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row"> {{-- Start of Search Result Details Row --}}
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title"> {{ $service_count }} Services Applied </h4>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Applied</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Service</th>
                                    <th>Category</th>
                                    <th>Message</th>
                                    <th>Consent</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($Services as $data)
                                    <tr>
                                        <td>{{ $Services->firstItem() + $loop->index }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</td>
                                        <td>{{ $data->Name }}</td>
                                        <td>{{ $data->Mobile_No }}</td>
                                        <td>{{ $data->Application }}</td>
                                        <td><span class="badge bg-info">{{ $data->Application_Type }}</span></td>
                                        <td class="text-truncate" style="max-width: 150px;" title="{{ $data->Message }}">
                                            {{ Str::limit($data->Message, 30) }}
                                        </td>
                                        <td>
                                            <span class="badge {{ !empty($data->Consent) ? 'bg-success' : 'bg-danger' }}">
                                                {{ !empty($data->Consent) ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('view.user.application', $data->Id) }}">
                                                            <i class="fas fa-folder-open"></i> Open Application
                                                        </a>
                                                    </li>
                                                    @if (!empty($data->Consent))
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('view.document', $data->Id) }}">
                                                                <i class="fas fa-file-alt"></i> View Document
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <img class="img-fluid" width="200" alt="No Result" src="{{ asset('storage/no_result.png') }}">
                                            <p class="mt-2 text-muted">No Results Found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
