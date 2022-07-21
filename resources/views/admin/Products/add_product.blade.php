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
                    <li><a href="{{ url('debit_entry') }}">New Debit Entry</a></li><span class="span">|</span>
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
                                <p>Application Menu</p>
                            </div>
                            <div class="left-menu-link">
                                <a href="{{url('app_home')}}">Home</a>
                                <a href="{{url('app_form')}}">New Applicaitn</a>
                            </div>
                        </div>
                    </div>

                    <div class="middle-container">
                        <div class="form-container">
                            <div class="form-header">
                            <p class="heading">New Products</p>
                        </div>
                        <div class="form-data-container">
                            <div class="form-data">
                                @if (session('SuccessUpdate'))
                                <span class="success">{{session('SuccessUpdate')}}</span>

                                @endif
                                @if (session('SuccessMsg'))
                                <span class="success">{{session('SuccessMsg')}}</span>

                                @endif
                                <form action="{{url('add_product')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Name -->
                                <div class="row">
                                    <div class="col-45">
                                        <label class="label" for="Name">Name</label>
                                        <span class="important">*</span>
                                    </div>
                                    <div class="col-55">
                                        <div class="md-form">
                                            <input type="text" id="Name" name="Name" class="form-control"
                                                placeholder="Enter Product Name">
                                            <span class="error">@error('Name'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Description -->
                                <div class="row">
                                    <div class="col-45">
                                        <label for="Description">Description</label> <span class="important">*</span>
                                    </div>
                                    <div class="col-55">
                                        <div class="md-form">
                                            <textarea id="Description" name="Description" class="form-control"
                                                placeholder="Product Description" rows="4" resize="none"></textarea>
                                            <span class="error">@error('Description'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Details -->
                                <div class="row">
                                    <div class="col-45">
                                        <label class="label" for="Details">Details</label> <span class="important">*</span>
                                    </div>
                                    <div class="col-55">
                                        <div class="md-form">
                                            <textarea id="Details" name="Details" class="form-control"
                                                placeholder="Product Details" rows="4" resize="none"></textarea>
                                            <span class="error">@error('Details'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-data">
                                <!-- Features -->
                                <div class="row">
                                    <div class="col-45">
                                        <label class="label" for="Features">Features</label> <span
                                            class="important">*</span>
                                    </div>
                                    <div class="col-55">
                                        <div class="md-form">
                                            <textarea id="Features" name="Features" class="form-control"
                                                placeholder="Product Features" rows="4" resize="none"></textarea>
                                            <span class="error">@error('Features'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Specification -->
                                <div class="row">
                                    <div class="col-45">
                                        <label class="label" for="Specification">Specification</label> <span
                                            class="important">*</span>
                                    </div>
                                    <div class="col-55">
                                        <div class="md-form">
                                            <textarea id="Specification" name="Specification" class="form-control"
                                                placeholder="Product Specification" rows="4" resize="none"></textarea>
                                            <span class="error">@error('Specification'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Product Image -->
                                <div class="row">
                                    <div class="col-45">
                                        <label class="label" for="Image">Image</label> <span class="important">*</span>
                                    </div>
                                    <div class="col-55">
                                        <div class="md-form">
                                            <input type="file" id="Image" name="Image" accept="image/*"
                                                onchange="loadFile(event)" class="form-control">
                                            <span class="error">@error('Image'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-45">
                                        <img class="col-75" id="output"" src=" #" alt="Product image" />
                                    </div>
                                </div>
                            </div>
                        </div>

                                    <!-- Button -->
                                    <div class="form-data-buttons">
                                        <div class="row">
                                            <div class="col-100">
                                                <button type="submit" value="submit" name="submit"
                                                    class="btn btn-primary btn-rounded btn-sm">Save Product</button>
                                                <a href="{{ url('/') }}" class="btn btn-rounded btn-sm">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                    </form>

                        <div class="table-container">
                            <p class="heading">Total Product List</p>
                            <div class="table-information">
                                <span class="info-text">Total Available Products are {{$products->total()}}</span>
                            </div>
                            <table>
                            <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Product</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    @while ($sl_no>0)
                                    <tr>
                                        <td>
                                            {{ $n++ }}
                                            @if($sl_no==$sl_no)
                                            @break
                                            @endif
                                        </td>
                                        @endwhile
                                        <td style="width:15%">{{ $product->Name }}</td>
                                        <td style="width:55%">{{ $product->Description }}</td>
                                        <td style="width:20%"><img src="{{ $product->Image }}" alt="Product Image"></td>
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
                                                                href='view_product/{{ $product->Id }}'>Edit</a>
                                                        </li>
                                                        <li><a class=" dropdown-item"
                                                                href='delete_product/{{ $product->Id }}'>Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <span>
                                {{$products->links()}}
                            </span>
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
