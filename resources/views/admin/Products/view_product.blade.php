@extends('Layouts.main')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
    <div class="container">
        <section class="work-area">
            <div class="sub-nav-menu">
                <ul>
                    <li><a href="{{ url('debit_entry') }}">New Debit Entry</a></li><span class="span">|</span>
                </ul>
            </div>
            <div class="pages">
                <div class="border">
                    <div class="data-form">
                        <div class="data-form-header">
                            <!-- <img src="img/income.png" alt="Application_image" class="header-image"> -->
                            <p class="heading">Update Product</p>
                        </div>
                        @if (session('SuccessUpdate'))
                        <span class="success">{{session('SuccessUpdate')}}</span>

                        @endif
                        @if (session('SuccessMsg'))
                        <span class="success">{{session('SuccessMsg')}}</span>

                        @endif
                        <form action="{{ url('/update_product') }}/{{ $id }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Name -->
                            <div class="row">
                                <div class="col-25">
                                    <label class="label" for="Name">Name</label>
                                    <span class="important">*</span>
                                </div>
                                <div class="col-75">
                                    <div class="md-form">
                                        <input type="text" id="Name" name="Name" class="form-control"
                                            value="{{ $product_view->Name }}">
                                        <span class="error">@error('Name'){{$message}}@enderror</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Description -->
                            <div class="row">
                                <div class="col-25">
                                    <label for="Description">Description</label> <span class="important">*</span>
                                </div>
                                <div class="col-75">
                                    <div class="md-form">
                                        <textarea id="Description" name="Description" class="form-control"
                                            placeholder="Product Description" rows="4"
                                            resize="none">{{ $product_view->Description }}</textarea>
                                        <span class="error">@error('Description'){{$message}}@enderror</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Details -->
                            <div class="row">
                                <div class="col-25">
                                    <label class="label" for="Details">Details</label> <span class="important">*</span>
                                </div>
                                <div class="col-75">
                                    <div class="md-form">
                                        <textarea id="Details" name="Details" class="form-control"
                                            placeholder="Product Details" rows="4"
                                            resize="none">{{ $product_view->Details }}</textarea>
                                        <span class="error">@error('Details'){{$message}}@enderror</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Features -->
                            <div class="row">
                                <div class="col-25">
                                    <label class="label" for="Features">Features</label> <span
                                        class="important">*</span>
                                </div>
                                <div class="col-75">
                                    <div class="md-form">
                                        <textarea id="Features" name="Features" class="form-control"
                                            placeholder="Product Features" rows="4"
                                            resize="none">{{ $product_view->Features }}</textarea>
                                        <span class="error">@error('Features'){{$message}}@enderror</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Specification -->
                            <div class="row">
                                <div class="col-25">
                                    <label class="label" for="Specification">Specification</label> <span
                                        class="important">*</span>
                                </div>
                                <div class="col-75">
                                    <div class="md-form">
                                        <textarea id="Specification" name="Specification" class="form-control"
                                            placeholder="Product Specification" rows="4"
                                            resize="none">{{ $product_view->Specification }}</textarea>
                                        <span class="error">@error('Specification'){{$message}}@enderror</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Image -->
                            <div class="row">
                                <div class="col-25">
                                    <label class="label" for="Image">Image</label> <span class="important">*</span>
                                </div>
                                <div class="col-75">
                                    <div class="md-form">
                                        <input type="file" id="Image" name="Image" class="form-control" accept="image/*"
                                            onchange="loadFile(event)" class="form-control">
                                        <span class="error">@error('Image'){{$message}}@enderror</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-75">
                                    <img class="col-75" id="output"" src=" ../{{ $product_view->Image }}"
                                        alt="Product image" />
                                </div>
                            </div>
                            <!-- Button -->
                            <div class="row">
                                <div class="col-75">
                                    <button type="submit" value="submit" name="submit"
                                        class="btn btn-success btn-rounded">Update Product</button>
                                    <a href="{{ url('add_product') }}" class="btn btn-rounded">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="data-table">
                        <div class="data-table-header">
                            <!-- <img src=" img/income.png" alt="Application_image" class="header-image"> -->
                            <p class="heading">Total Product List</p>


                        </div>
                        <span class="info-text">Total Available Products are {{$products->total()}}</span>
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
                                    <td style="width:20%"><img src="../{{ $product->Image }}" alt="Product Image"></td>
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
                                                            href='/digital/cyber/view_product/{{ $product->Id }}'>Edit</a>
                                                    </li>
                                                    <li><a class=" dropdown-item"
                                                            href='/digital/cyber/delete_product/{{ $product->Id }}'>Delete</a>
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