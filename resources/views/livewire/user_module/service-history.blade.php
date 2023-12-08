<div>
    {{-- The whole world belongs to you. --}}
    <div class="row">{{-- Messags / Notification Row --}}
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Welcome {{ Auth::user()->name }}<span class="text-primary"></span> </h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('services') }}">Services</a></li>
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
                        <table class="table table-bordered mb-0">

                            <thead class="table-light text-center">
                                <tr>
                                    <th>SlNo</th>
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
                            <tbody>
                                @forelse($Services as $data)
                                    <tr>
                                        <td>{{ $Services->firstItem() + $loop->index }}</td>
                                        <td class="text-wrap">
                                            {{ \Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</td>
                                        <td>{{ $data->Name }}</td>
                                        <td>{{ $data->Mobile_No }}</td>
                                        <td>{{ $data->Application }}</td>
                                        <td>{{ $data->Application_Type }}</td>
                                        <td>{{ $data->Message }}</td>
                                        <td>{{ !empty($data->Consent) ? 'Yes' : 'No' }}</td>
                                        <td>
                                            <div class="btn-group-vertical" role="group"
                                                aria-label="Vertical button group">
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupVerticalDrop1" type="button"
                                                        class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        Action <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1"
                                                        style="">
                                                        <a class="dropdown-item" title="Open Applicatin"
                                                            href="{{ route('view.applicaiton', $data->Id) }}"id="editData">Open</a>
                                                        @if (!empty($data->Consent))
                                                            <a class="dropdown-item" title="Open Applicatin"
                                                                href="{{ route('view.document', $data->Id) }}"id="open">View
                                                                Document</a>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11">
                                            <img class=" avatar-xl" alt="No Result"
                                                src="{{ asset('storage/no_result.png') }}">
                                            <p>No Result Found</p>
                                        </td>
                                    </tr>
                                @endforelse()
                            </tbody>

                        </table>
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-8">
                                <p class="text-muted">Showing {{ count($Services) }} of {{ $Services->total() }}
                                    entries</p>
                            </div>
                            {{-- <span>{{$services->links()}}</span> --}}
                            <div class="col-md-4">
                                <span class="pagination pagination-rounded float-end">
                                    {{ $Services->links() }}
                                </span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
