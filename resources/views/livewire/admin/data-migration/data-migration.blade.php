<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
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

    <div class="row">
        <div class="col-lg-5">{{--Start of Form Column --}}
            <div class="card">
                <form wire:submit.prevent="Migrate">
                    @csrf
                <div class="card-header d-sm-flex align-items-center justify-content-between"">
                    <h5>Debit Ledger</h5>
                    <h5><a href="{{route('data.migration')}}" title="Click here for New Transaction">Data Migation</a></h5>
                </div>
                <div class="card-body">


                        {{$App_Id}}
                            <div class="row mb-3">
                                <label for="Table" class="col-sm-4 col-form-label">Table</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="Table" wire:model="Table" name="Table">
                                        <option value="">---Select---</option>
                                        <option value="old_digial_cyber_db">Digtial Cyber</option>
                                        <option value="old_credit_source">Credit Source</option>
                                        <option value="old_debit_source">Debit Source</option>
                                        <option value="old_credit_ledger">Credit Ledger</option>
                                        <option value="old_debit_ledger">Debit Ledger</option>
                                        <option value="old_bookmark">Bookmarks</option>
                                    </select>
                                </div>
                            </div>
                            @if ($digitalcyber)

                                <div class="row mb-3">
                                    <label for="OldServiceList" class="col-sm-4 col-form-label">Service List</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="OldServiceList" wire:model="OldServiceList" name="OldServiceList">
                                            <option value="">---Select---</option>
                                           @foreach ($old_servicelist as $item)
                                           <option value="{{$item->service_name}}">{{$item->service_name}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Application" class="col-sm-4 col-form-label">Application</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="Application" wire:model="Application" name="Application">
                                            <option value="">---Select---</option>
                                           @foreach ($mainservices as $item)
                                           <option value="{{$item->Id}}">{{$item->Name}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Application_Type" class="col-sm-4 col-form-label">Application Type</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="Application_Type" wire:model="Application_Type" name="Application_Type">
                                            <option value="">---Select---</option>
                                           @foreach ($subservices as $item)
                                           <option value="{{$item->Name}}">{{$item->Name}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>

                            @elseif ($creditsource)
                                {{-- Yet to Design --}}
                                <div class="row mb-3">
                                    <label for="OldServiceList" class="col-sm-4 col-form-label">Service List</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="OldServiceList" wire:model="OldServiceList" name="OldServiceList">
                                            <option value="">---Select---</option>
                                           @foreach ($old_creditsources as $item)
                                           <option value="{{$item->sl_no}}">{{$item->particular}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Application" class="col-sm-4 col-form-label">Application</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="Application" wire:model="Application" name="Application">
                                            <option value="">---Select---</option>
                                           @foreach ($newSources as $item)
                                           <option value="{{$item->Id}}">{{$item->Name}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Application_Type" class="col-sm-4 col-form-label">Application Type</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="Application_Type" wire:model="Application_Type" name="Application_Type">
                                            <option value="">---Select---</option>
                                           @foreach ($subSources as $item)
                                           <option value="{{$item->CS_Id}}">{{$item->Source}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                            @elseif ($debitsource)
                            {{-- yet to Design --}}
                            @elseif ($creditledger)
                            <div class="row mb-3">
                                <label for="OldServiceList" class="col-sm-4 col-form-label">Credit Source</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="OldServiceList" wire:model="OldServiceList" name="OldServiceList">
                                        <option value="">---Select---</option>
                                       @foreach ($old_creditsources as $item)
                                       <option value="{{$item->particular}}">{{$item->particular}}</option>
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="Application" class="col-sm-4 col-form-label">New Source</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="Application" wire:model="Application" name="Application">
                                        <option value="">---Select---</option>
                                       @foreach ($newSources as $item)
                                       <option value="{{$item->Id}}">{{$item->Name}}</option>
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="Application_Type" class="col-sm-4 col-form-label">Sub Sources</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="Application_Type" wire:model="Application_Type" name="Application_Type">
                                        <option value="">---Select---</option>
                                       @foreach ($subSources as $item)
                                       <option value="{{$item->Source}}">{{$item->Source}}</option>
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            @elseif ($debitledger)
                            {{-- Yet to Design --}}
                            @elseif ($bookmarks)
                                {{-- Yet to Deign --}}
                                <div class="row mb-3">
                                    <label for="OldServiceList" class="col-sm-4 col-form-label">Bookmarks</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="OldServiceList" wire:model="OldServiceList" name="OldServiceList">
                                            <option value="">---Select---</option>
                                           @foreach ($old_bookmarks as $item)
                                           <option value="{{$item->sl_no}}">{{$item->name}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Application" class="col-sm-4 col-form-label">Relation</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="Application" wire:model="Application" name="Application">
                                            <option value="">---Select---</option>
                                            <option value="General">General</option>
                                           @foreach ($mainservices as $item)
                                           <option value="{{$item->Id}}">{{$item->Name}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif




                            <div class="form-data-buttons"> {{--Buttons--}}
                                <div class="row">
                                    <div class="col-100">
                                        <button type="submit" value="submit" name="submit"
                                            class="btn btn-primary btn-rounded btn-sm">Save</button>
                                            <a href="{{route('Debit')}}" class="btn btn-info btn-rounded btn-sm">Reset</a>
                                        <a href="{{route('dashboard')}}" class="btn btn-warning btn-rounded btn-sm">Cancel</a>
                                    </div>
                                </div>
                            </div>
                            </form>
                    </div>
            </div>
        </div> {{-- End of Form Column --}}
    </div>


</div>
