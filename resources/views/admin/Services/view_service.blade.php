@extends('Layouts.main')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
    <div class="container-fluid">
        <section class="work-area">
            <div class="sub-nav-menu">
                <ul>
                    <li><a href="{{ url('add_product') }}">Product</a></li><span class="span">|</span>
                    <li><a href="{{ url('add_service') }}">Service</a></li><span class="span">|</span>
                </ul>
            </div>
            <div class="pages">
                <div class="layout">
                    <div class="left-menu">
                        <div class="left-menu-section">
                            <div class="left-menu-sec-heading">
                                <img src="\digital/cyber/photo_gallery\home-menu.jpg" alt="heading-icon">
                                <p>Admin</p>
                        </div>
                        <div class="left-menu-link">
                                <a href="{{url('add_product')}}">Products</a>
                                <a href="{{url('add_service')}}">Add Service</a>
                                <a href="">Add Status</a>
                                <a href="">Bookmark</a>
                                <a href="">Status</a>
                            </div>
                        </div>
                        <div class="left-menu-section">
                            <div class="left-menu-sec-heading">
                            <img src="\digital/cyber/photo_gallery\sub-menu.jpg" alt="heading-icon">
                                <p>Sub Menu</p>
                            </div>
                            <div class="left-menu-link">
                                <a href="">Reports</a>
                                <a href="">Filter</a>
                            </div>
                        </div>
                    </div>

                    <div class="middle-container">
                        <div class="form-container">
                            <div class="form-header">
                                <p class="heading">Update Service</p>
                            </div>
                            <div class="form-data-container">
                                <div class="form-data">
                                            @if (session('SuccessUpdate'))
                                            <span class="success">{{session('SuccessUpdate')}}</span>

                                            @endif
                                            @if (session('SuccessMsg'))
                                            <span class="success">{{session('SuccessMsg')}}</span>

                                            @endif
                                        <form action="{{ url('/update_service') }}/{{ $id }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                            <!-- Name -->
                                            <div class="row">
                                                <div class="col-45">
                                                    <label class="label" for="Name">Name</label>
                                                    <span class="important">*</span>
                                                </div>
                                                <div class="col-55">
                                                    <div class="md-form">
                                                        <input type="text" id="Name" name="Name" class="form-control"
                                                            value="{{ $service_view->Service_Name }}">
                                                        <span class="error">@error('Name'){{$message}}@enderror</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Product Image -->
                                            <div class="row">
                                                <div class="col-45">
                                                    <label class="label" for="Thumbnail">Thumbnail</label> <span
                                                        class="important">*</span>
                                                </div>
                                                <div class="col-55">
                                                    <div class="md-form">
                                                        <input type="file" id="Thumbnail" name="Thumbnail" class="form-control"
                                                            accept="image/*" onchange="loadFile(event)" class="form-control">
                                                        <span class="error">@error('Thumbnail'){{$message}}@enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                                <div class="form-data">
                                    <div class="row">
                                        <div class="col-45">
                                            <img class="col-55" id="output"" src="../{{ $service_view->Thumbnail }}"
                                                alt="Thumbnail" />
                                        </div>
                                    </div>
                                </div>
                            </div>



                                <!-- Button -->
                                <div class="form-data-buttons">
                                    <div class="row">
                                        <div class="col-100">
                                            <button type="submit" value="submit" name="submit"
                                                class="btn btn-success btn-rounded btn-sm">Update Service</button>
                                            <a href="{{ url('add_service') }}" class="btn btn-rounded btn-sm">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-container">
                                <div class="data-table-header">
                                    <p class="heading">Available Services</p>
                                    <div class="table-information">
                                        <span class="info-text">Available Service's are {{$services->total()}}</span>
                                    </div>

                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Service</th>
                                                <th>Total Amount</th>
                                                <th>Total Applications</th>
                                                <th>Thumbnail</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($services as $service)
                                            @while ($sl_no>0)
                                            <tr>
                                                <td>
                                                    {{ $n++ }}
                                                    @if($sl_no==$sl_no)
                                                    @break
                                                    @endif
                                                </td>
                                                @endwhile
                                                <td style="width:35%">{{ $service->Service_Name }}</td>
                                                <td style="width:10%">{{ $service->Total_Amount }}</td>
                                                <td style="width:10%">{{ $service->Total_Applications }}</td>
                                                <td style="width:35%"><img class="icon" src="../{{ $service->Thumbnail }}"
                                                        alt="Thumnail"></td>
                                                <td style="width:10%">
                                                    <div class="btn-group" role="group"
                                                        aria-label="Button group with nested dropdown">
                                                        <div class="btn-group btn-group-sm " role="group">
                                                            <button id="btnGroupDrop1" type="button"
                                                                class="btn btn-info dropdown-toggle" data-mdb-toggle="dropdown"
                                                                aria-expanded="false">
                                                                Edit
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                <li><a class="dropdown-item "
                                                                        href='/digital/cyber/view_service/{{ $service->Id }}'>Edit</a>
                                                                </li>
                                                                <li><a class=" dropdown-item"
                                                                        href='/digital/cyber/delete_service/{{ $service->Id }}'>Delete</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                        <!-- <tfoot>
                                            <tr>
                                                <th>Name
                                                </th>
                                                <th>Position
                                                </th>
                                                <th>Office
                                                </th>
                                                <th>Age
                                                </th>
                                                <th>Start date
                                                </th>
                                                <th>Salary
                                                </th>
                                            </tr>
                                        </tfoot> -->
                                    </table>
                                    <span>
                                        {{$services->links()}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right Menu Insight Section -->
                    <div class="right-menu">
                        <p class="heading">Insight</p>
                        <div class="right-menu-section">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Applications Served</p>
                                <p class="section-value">Total </p>
                                <p class="section-pre-values">Yesterday </p>
                            </div>
                        </div>
                        <div class="right-menu-section">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Applications Deliverd</p>
                                <p class="section-value">Delivered : }</p>
                                <p class="section-pre-values">Yesterday </p>
                            </div>
                        </div>
                        <div class="right-menu-section">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Revenue Generated</p>
                                <p class="section-value">Gross &#x20B9; /-</p>
                                <p class="section-pre-values">Yesterday &#x20B9; <span></span></p>
                            </div>
                        </div>
                        <div class="right-menu-section">
                            <img src="\digital/cyber/photo_gallery\insight.jpg" alt="" >
                            <div class="sec-data">
                                <p class="section-heading">Balance Due Amount</p>
                                <a class="section-value" href="{{url('balance_list')}}">Gross Bal: &#x20B9; /-</a>
                                <a class="section-pre-values" href="#">Yesterday &#x20B9; <span></span></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
</body>
<script>
var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
    }
};
</script>

</html>










@endsection
