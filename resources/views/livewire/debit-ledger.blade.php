<div> {{--Main Div--}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Debit Ledger</h4>

                @if (session('SuccessMsg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session('SuccessMsg')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('SuccessUpdate'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{session('SuccessUpdate')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('Error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{session('Error')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Digital Cyber</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('new.application')}}">New Form</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </div>{{-- End of Row --}}


    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('new.application')}}">New Application</a></li>
            <li class="breadcrumb-item"><a href="{{route('Credit')}}">Credit</a></li>
            <li class="breadcrumb-item"><a href="{{route('Debit')}}">Debit</a></li>
        </ol>
    </div>{{-- End of Page Tittle --}}

    {{-- Form Row --}}
    <div class="row">
        <div class="col-lg-5">{{--Start of Form Column --}}
            <div class="card">
                <form wire:submit.prevent="Save">
                    @csrf
                <div class="card-header d-sm-flex align-items-center justify-content-between"">
                    <h5>Debit Ledger</h5>
                    <h5><a href="{{route('Debit')}}" title="Click here for New Transaction">New Entry</a></h5>
                </div>
                <div class="card-body">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Debit Id</label>
                            <div class="col-sm-8">
                                <label for="example-text-input" class="col-sm-4 col-form-label">{{$transaction_id}}</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Date" class="col-sm-4 col-form-label">Date</label>
                            <div class="col-sm-8">
                                <input type="date" id="date" name="Date" wire:model="Date" value="{{ date('Y-m-d') }}"
                                    class="form-control" />
                                <span class="error">@error('Date'){{$message}}@enderror</span>
                            </div>
                        </div>

                            <div class="row mb-3">
                                <label for="example-search-input" class="col-sm-4 col-form-label">Category</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="Particular" wire:model="Category" name="Particular">
                                        <option value="">---Select---</option>
                                        <option value="Expenses">Expenses</option>
                                        <option value="Loan">Loan</option>
                                        <option value="Credit Card Loan">Credit Card Loan</option>
                                        <option value="CD Loan">CD Loan</option>
                                    </select>
                                    <span class="error">@error('Category'){{$message}}@enderror</span>
                                </div>
                            </div>

                                <div class="row mb-3">
                                    <label for="example-search-input" class="col-sm-4 col-form-label">Sub Category</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="Particular" wire:model="SubCategory" name="Particular">
                                            <option value="">---Select---</option>
                                            @if(!empty($Category))
                                                @foreach($DebitSource as $item)
                                                <option value="{{ $item->Id }}">{{ $item->Name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="error">@error('SubCategory'){{$message}}@enderror</span>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <label for="example-search-input" class="col-sm-4 col-form-label">Particular</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="Particular" wire:model="Particular" name="Particular">
                                            <option value="">---Select---</option>
                                            @if(!empty($SubCategory))
                                                @foreach($DebitSources as $item)
                                                <option value="{{ $item->Id }}">{{ $item->Name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="error">@error('Particular'){{$message}}@enderror</span>
                                    </div>
                                </div>



                            <div class="row mb-3">
                                <label for="Date" class="col-sm-4 col-form-label">Payment Details</label>
                                <div class="col-sm-3">
                                    <input type="number"  wire:model="Unit_Price"  name="Unit_Price" class="form-control"
                                        placeholder="Amount" pattern="[0-9]" readonly>
                                    <span class="error">@error('Unit_Price'){{$message}}@enderror</span>
                                    <p><small class="text-muted">Per Exps. Cost</small></p>
                                </div>
                                <div class="col-sm-2">
                                    <input type="number" id=""  wire:model="Quantity"  name="Total_Amount" class="form-control"
                                        placeholder="Quantity" pattern="[0-9]">
                                    <span class="error">@error('Quantity'){{$message}}@enderror</span>
                                    <p><small class="text-muted">Quantity</small></p>
                                </div>
                                <div class="col-sm-3">
                                    <input type="number" id="amount"  value="{{$Total_Amount}}"  name="Total_Amount" class="form-control"
                                    placeholder="Total" pattern="[0-9]" readonly>
                                    <p><small class="text-muted">Amount Payable</small></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="Date" class="col-sm-4 col-form-label">Paid / Bal </label>
                                <div class="col-sm-4">
                                    <input type="number" id="paid" wire:model="Amount_Paid" name="Amount_Paid" class="form-control" placeholder="Paid">
                                    <span class="error">@error('Amount_Paid'){{$message}}@enderror</span>
                                    <p><small class="text-muted">to Pay Now</small></p>
                                </div>
                                <div class="col-sm-4">
                                    <input type="number" id="bal" name="Balance" wire:model="Balance" class="form-control" placeholder="Bal" readonly>
                                    <p><small class="text-muted">Balance</small></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="Date" class="col-sm-4 col-form-label">Description</label>
                                <div class="col-sm-8">
                                    <textarea id="Description" wire:model="Description" name="Description" class="form-control"
                                        placeholder="Debit Description" rows="3" resize="none"></textarea>
                                    <span class="error">@error('Description'){{$message}}@enderror</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="example-search-input" class="col-sm-4 col-form-label">Payment</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="Payment_mode" wire:model="Payment_Mode" name="Payment_mode" wire:change="Change($event.target.value)">
                                        <option value="">---Select---</option>
                                        @foreach ($PaymentMode as $item)
                                        <option value="{{$item->Payment_Mode}}">
                                            {{$item->Payment_Mode}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error">@error('Payment_mode'){{$message}}@enderror</span>
                                </div>
                            </div>
                            @if ($Payment_Mode!="Cash")
                                <div class="row mb-3">
                                    <label for="example-search-input" class="col-sm-4 col-form-label">Payment</label>
                                    <div class="col-sm-8">
                                        <div class="md-form">
                                            <input type="file" id="Attachment{$itteration}" wire:model="Attachment" name="Attachment" class="form-control" accept="image/*">
                                            <span class="error">@error('Attachment'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                </div>

                                <div wire:loading wire:target="Attachment">Uploading...</div>                            @if (!is_Null($Attachment))
                                    <div class="row">
                                        <div class="col-45">
                                            <img class="col-75" src="{{ $Attachment->temporaryUrl() }}"" alt="Thumbnail" />
                                        </div>
                                    </div>

                                @elseif(!is_Null($Old_Attachment))
                                <div class="row">
                                    <div class="col-45">
                                        <img class="col-75" src="{{ url('storage/'.$Old_Attachment) }}"" alt="Existing Thumbnail" />
                                    </div>
                                </div>
                                @endif
                            @endif

                            <div class="form-data-buttons"> {{--Buttons--}}
                                <div class="row">
                                    <div class="col-100">
                                        @if (!$update)
                                            <button type="submit" value="submit" name="submit"
                                            class="btn btn-primary btn-rounded btn-sm">Save</button>
                                            <a href="{{route('Debit')}}" class="btn btn-info btn-rounded btn-sm">Reset</a>
                                        @elseif($update)
                                            <a  href="#" class="btn btn-success btn-rounded btn-sm" wire:click.prevent="UpdateLedger('{{$transaction_id}}')">Update</button>
                                            <a href="{{route('Debit')}}" class="btn btn-info btn-rounded btn-sm">Reset</a>
                                        @endif

                                        <a href="{{route('dashboard')}}" class="btn btn-warning btn-rounded btn-sm">Cancel</a>
                                    </div>
                                </div>
                            </div>
                            </form>
                    </div>
            </div>
        </div> {{-- End of Form Column --}}

    {{-- Daily Transaction Display Panel --}}
        {{-- Daily Transaction Display Panel --}}
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between"">
                    <h5>Debit Transactions</h5>
                    <h5>&#x20B9 {{$total}}</h5>
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                    Expeneses on
                    @if (empty($Select_Date)) {{ \Carbon\Carbon::parse($today)->format('d-M-Y'); }} is &#x20B9 {{$total}} @endif
                    @if (!empty($Select_Date))
                        {{ \Carbon\Carbon::parse($Select_Date)->format('d-M-Y'); }}
                        <strong>
                            {{ \Carbon\Carbon::parse($Select_Date)->diffForHumans() }} is &#x20B9
                        </strong>
                        {{$total}}
                    @endif
                    </h5>
                    @if (session('Error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{session('Error')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @if ($clearButton)

                        @endif
                    @endif
                    @if ($clearButton)
                       {{-- <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-tittle">
                                    <h5>Balance Update</h5>
                                </div>
                            </div>
                            <span class="info-text">Balance Due Found for {{count($balCollection)}} Records!.</span>
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Description</th>
                                    <th>Total Amount</th>
                                    <th>Amount Paid</th>
                                    <th>Balance</th>
                                    <th>Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($balCollection as $item)
                                <tr>
                                    <td style="width:25%">{{$item['Id']}}</td>
                                    <td style="width:25%">{{$item['Description']}}</td>
                                    <td style="width:25%">&#x20B9; {{$item['Total_Amount']}}</td>
                                    <td style="width:25%">&#x20B9; {{$item['Amount_Paid']}}</td>
                                    <td style="width:25%">&#x20B9; {{$item['Balance']}}</td>
                                    <td style="width:25%">
                                        <a class="btn-sm btn-primary" href="#" title="Clear Balance" wire:click="UpdateBalance('{{$item['Id']}}')" style = "color: white">Clear</a>
                                    </td>
                                </tr>
                                @endforeach
                                <span class="info-text">Total Balance Due : &#x20B9;{{
                                    $balCollection->sum('Balance') }}</span>
                            </tbody>
                        </table>
                        </div>
                       </div> --}}

                    @endif
                    <div class="d-flex flex-wrap gap-2">
                        <div class="row">
                            <div class="col-sm-5">
                                <label class="form-label" for="paginate">Pages</label>
                            </div>
                            <div class="col-sm-7">
                                <select name="datatable_length"  wire:model="paginate" aria-controls="datatable" class="custom-select custom-select-sm form-control form-control-sm form-select form-select-sm">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="form-label" for="paginate">Filter By</label>
                            </div>
                            <div class="col-sm-6">
                                <input  type="text"  wire:model="filterby" class="form-control form-control-sm" placeholder="Filter">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="form-label" for="paginate">Search By Date</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="date" id="date" name="Select_Date" wire:model="Select_Date" class="form-control form-control-sm"/>
                            </div>
                        </div>
                        @if ($clearButton)
                        <div class="row">
                         <div class="card">
                             <div class="card-body">
                                 <div class="card-tittle">
                                     <h5>Balance Update</h5>
                                 </div>
                             </div>
                             <span class="info-text">Balance Due Found for {{count($balCollection)}} Records!.</span>
                         <table class="table table-hover mb-0">
                             <thead class="table-light">
                                 <tr>
                                     <th>ID</th>
                                     <th>Description</th>
                                     <th>Total Amount</th>
                                     <th>Amount Paid</th>
                                     <th>Balance</th>
                                     <th>Update</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach ($balCollection as $item)
                                 <tr>
                                     <td style="width:25%">{{$item['Id']}}</td>
                                     <td style="width:25%">{{$item['Description']}}</td>
                                     <td style="width:25%">&#x20B9; {{$item['Total_Amount']}}</td>
                                     <td style="width:25%">&#x20B9; {{$item['Amount_Paid']}}</td>
                                     <td style="width:25%">&#x20B9; {{$item['Balance']}}</td>
                                     <td style="width:25%">
                                         <a class="btn-sm btn-primary" href="#" title="Clear Balance" wire:click="UpdateBalance('{{$item['Id']}}')" style = "color: white">Clear</a>
                                     </td>
                                 </tr>
                                 @endforeach
                                 <span class="info-text">Total Balance Due : &#x20B9;{{
                                     $balCollection->sum('Balance') }}</span>
                             </tbody>
                         </table>
                         </div>
                        </div>

                     @endif

                    </div>
                    @if (count($Transactions)>0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>SL.No</th>
                                <th>Particular</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($Transactions as $data)
                            <tr>
                                <td>{{$Transactions->firstItem()+$loop->index}}</td>
                                <td>{{ $data->Category }}| {{ $data->Source }}</td>
                                <td> {{$data->Name}}</td>
                                <td>{{ $data->Amount_Paid }}</td>
                                <td>{{ $data->Description }}</td>
                                <td>
                                    <a href="{{route('edit.debit',$data->Id)}}" title="Edit" class="btn btn-sm btn-primary font-size-15" id="editData"><i class="mdi mdi-circle-edit-outline" ></i></a>

                                    <a href="{{route('delete.debit',$data->Id)}}" title="Delete" class="btn btn-sm btn-danger font-size-15" id="delete"><i class=" mdi mdi-trash-can"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11">
                                    <img class=" avatar-xl" alt="No Result" src="{{asset('storage/no_result.png')}}">
                                    <p>No Result Found</p>
                                </td>
                            </tr>
                        @endforelse()
                        </tbody>
                    </table>
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-8">
                            <p class="text-muted">Showing {{count($Transactions)}} of {{$Transactions->total()}} entries</p>
                            </div>
                            <div class="col-md-4">
                                <span class=" pagination pagination-rounded float-end" >
                                    {{$Transactions->links()}}
                                </span>
                            </div>
                        </div>

                    </div>
                    <p class="card-text"><small class="text-bold">Last Entry at  {{$lastRecTime}} </small></p>
                </div>
                <span> {{$Transactions->links()}} </span>
                @endif
            </div>
        </div>

    </div>

</div>
