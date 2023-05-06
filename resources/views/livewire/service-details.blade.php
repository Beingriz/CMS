<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
     <!-- Page Header Start -->
     <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">{{$ServiceName}}</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="{{route('user.home',Auth::user()->id)}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="{{route('about.us')}}">About Us</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Services</li>
                </ol>
            </nav>
        </div>
    </div>
<!-- Page Header End -->

<div class="container">
    <div class="row">
        @foreach ($subservices as $item )
        <div class="col-lg-4">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        @if($Image == 'Not Available')
                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{ url('storage/no_image.jpg') }}" alt="">
                        @else
                        <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg" src="{{asset('storage/'.$item['Thumbnail'])}}" alt="">
                        @endif
                        <div class="flex-grow-1">
                            <h5 class="mt-0 font-size-18 mb-1">{{$item['Name']}}</h5>
                            <p class="text-muted font-size-14">{{$ServiceName}}</p>

                            <ul class="social-links list-inline mb-0">
                                <li class="list-inline-item">
                                    <a role="button" class="text-reset" title="" data-bs-placement="top" data-bs-toggle="tooltip" href="#details" wire:click="GetDetails('{{$item->Id}}')" data-bs-original-title="Details" aria-label="Info"><i class="fas fa-info"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a role="button" class="text-reset" title="" data-bs-placement="top" data-bs-toggle="tooltip" href="#showDoc" wire:click="GetDocuments('{{$item->Id}}')" data-bs-original-title="Required Documents" aria-label="File-Archive"><i class="fas fa-file-archive"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a role="button" class="text-reset" title="" data-bs-placement="top" data-bs-toggle="tooltip" href="{{route('apply.now',$item->Id)}}" data-bs-original-title="Apply Now" aria-label="ApplyNow"><i class="far fa-address-card"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a role="button" class="text-reset" title="" data-bs-placement="top" data-bs-toggle="tooltip" href="" data-bs-original-title="Submit" aria-label="@skypename"><i class="fas fa-arrow-right"></i></a>
                                </li>
                            </ul>

                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
        @endforeach
    </div>
</div>
<div class="container" id="details">
    @if($display)
    @foreach ($SubServices as $item)
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <h1 class="card-title mb-4">{{$item['Name']}} Details</h1>
            </div>
            <div class="row no-gutters align-items-center">
                <div class="col-md-4">
                    @if($Image != 'Not Available')
                        <img class="card-img img-fluid" src="{{asset('storage/'.$item['Thumbnail'])}}" alt="Card image">
                        @else
                        <img class="card-img img-fluid" src="{{asset('storage/'.$Image)}}" alt="Card image">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{$item['Name']}}</h5>
                        <p class="card-text">{{$item['Description']}}
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa neque, delectus illum, perspiciatis porro accusamus temporibus a voluptatem molestiae id architecto animi recusandae, quam eaque praesentium maiores. Quidem, magni officia!

                        </p>
                        <div class="row g-4 mb-4 pb-2">
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white" style="width: 60px; height: 60px;">
                                        <i class="fa fa-users fa-2x text-primary"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h2 class="text-primary mb-1" data-toggle="counter-up">{{$item['Total_Count']}}</h2>
                                        <p class="fw-medium mb-0">Applied</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white" style="width: 60px; height: 60px;">
                                        <i class="fa fa-check fa-2x text-primary"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h2 class="text-primary mb-1" data-toggle="counter-up">{{$delivered}}</h2>
                                        <p class="fw-medium mb-0">Delivered</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white" style="width: 60px; height: 60px;">
                                        <i class="fa fa-check fa-2x text-primary"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h2 class="text-primary mb-1" data-toggle="counter-up">{{$delivered}}</h2>
                                        <p class="fw-medium mb-0">Delivered</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white" style="width: 60px; height: 60px;">
                                        <i class="fa fa-check fa-2x text-primary"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h2 class="text-primary mb-1" data-toggle="counter-up">{{$delivered}}</h2>
                                        <p class="fw-medium mb-0">Delivered</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-lg-5 pe-lg-0">
                                <a href="#showDoc" wire:click="GetDocuments('{{$item['Id']}}')" class="btn btn-primary py-3 px-3">View Documents</a>
                                <a href="" class="btn btn-primary py-3 px-3">Apply Now</a>
                                <a href="{{route('contact_us')}}" class="btn btn-primary py-3 px-3">Get Callback</a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>
@if ($showDoc)
<div class="container mb-5" id="showDoc" >


    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">List of Documents Required for {{$item['Name']}}</h4>
                    <p class="card-title-desc">Identity Theft -- Protect Yourself with These Must-Have Documents</p>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Document Name</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($documents as $doc)
                                <tr class="table-success">
                                    <th scope="row">{{$documents->firstItem()+$loop->index }}</th>
                                    <td>{{$doc['Name']}}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td >--</td>
                                    <td>
                                        <img class=" avatar-xl" alt="No Result" src="{{asset('storage/no_result.png')}}">
                                        <p>No Documents Suggested for this Service</p>

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
@endif

</div>
