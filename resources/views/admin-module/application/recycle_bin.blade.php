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

                        <!-- Table List Code  -->
                        <div class="search-table">
                            <div class="data-table-header">
                                <img src="./photo_gallery/recyclebin.png" alt="Application_image" class="header-image">
                                <p class="heading">Recycle Bin</p>
                            </div>
                            <span class="info-text">Applications Avaialble in Recycble Bin are {{ $count }}
                                &#x20B9;{{ $total }}
                                @if (session('RecycleMsg'))
                                    <span class="error">{{ session('RecycleMsg') }}</span>
                                @endif
                            </span>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Application</th>
                                        <th>Ack_No</th>
                                        <th>Document_No</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recycle_data as $data)
                                        @while ($sl_no > 0)
                                            <tr>
                                                <td>
                                                    {{ $n++ }}
                                                    @if ($sl_no == $sl_no)
                                                    @break
                                                @endif
                                            </td>
                                    @endwhile
                                    <td style="width:15%">{{ $data->Name }}</td>
                                    <td style="width:15%">{{ $data->Mobile_No }}</td>
                                    <td style="width:30%">{{ $data->Application_Type }}</td>
                                    <td style="width:15%">{{ $data->Ack_No }}</td>
                                    <td style="width:15%">{{ $data->Document_No }}</td>
                                    <td style="width:20%">{{ $data->Status }}</td>
                                    <td style="width:5%">{{ $data->Amount_Paid }}</td>
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
                                                            href='/digital/cyber/restore_app/{{ $data->Id }}'>Restore</a>
                                                    </li>
                                                    <li><a class=" dropdown-item"
                                                            href='/digital/cyber/delete_app_per/{{ $data->Id }}'>Delete</a>
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
                            {{ $recycle_data->links() }}
                        </span>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>

</body>

</html>
@endsection
