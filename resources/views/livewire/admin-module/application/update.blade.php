<div>
    <div class="form-container">
        <div class="form-header">
            <p class="heading">Credit Credit </p>
        </div>
        @if (session('SuccessUpdate'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>{{ session('SuccessUpdate') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('Error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('Error') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('SuccessMsg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('SuccessMsg') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form wire:submit.prevent="Update">
            @csrf
            <div class="form-data-container">
                {{-- Form Data 1 --}}
                <div class="form-data">

                    <div class="row"> {{-- Sources --}}
                        <div class="col-45">
                            <label class="label" for="Source">Old Services</label>
                            <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <select class="form-control" id="Particular" wire:model="Source" name="Source">
                                <option value="">---Select---</option>
                                @foreach ($Sources as $Source)
                                    <option value="{{ $Source->Service_Name }}">
                                        {{ $Source->Service_Name }}</option>
                                @endforeach
                            </select>

                            <span class="error">
                                @error('Source')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>

                    <div class="row"> {{-- Main Service --}}
                        <div class="col-45">
                            <label class="label" for="Source">Main Services</label>
                            <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <select class="form-control" id="Particular" wire:model="MainServiceId" name="Particular">
                                <option value="">---Select---</option>
                                @foreach ($MainServices as $Servie)
                                    <option value="{{ $Servie->Id }}">
                                        {{ $Servie->Name }}</option>
                                @endforeach
                            </select>

                            <span class="error">
                                @error('MainServiceId')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    @if (!empty($MainServices))
                        <div class="row"> {{-- Sub Services --}}
                            <div class="col-45">
                                <label class="label" for="Particular">Sub Services</label>
                                <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <select class="form-control" id="Particular" wire:model="SubService" name="Particular">
                                    <option value="">---Select---</option>
                                    @foreach ($SubServices as $Servie)
                                        <option value="{{ $Servie->Name }}">
                                            {{ $Servie->Name }}</option>
                                    @endforeach
                                </select>

                                <span class="error">
                                    @error('SubService')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
            <div class="form-data-buttons"> {{-- Buttons --}}
                <div class="row">
                    <div class="col-100">
                        <button type="submit" value="submit" name="submit"
                            class="btn btn-primary btn-rounded btn-sm">Update</button>
                        <a href='admin_home' class="btn btn-rounded btn-sm">Cancel</a>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-container"> {{-- Table Container --}}
            <div class="form-header">
                <p class="heading"> Credit List</p>
            </div>
            <div class="table-information">

                <!-- Quick List Button -->
                <div class="d-flex justify-content-between align-content-center mb-2">
                    <div class="d-flex">
                        <div>
                            <div class="d-flex align-items-center ml-4">
                                <label for="paginate" class="text-nowrap mr-2 mb-0">Per Page</label>
                                <select wire:model="paginate" name="paginate" id="paginate"
                                    class="form-control form-control-sm">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                </select>
                                <div class="row"></div>
                                <label for="paginate" class="text-nowrap mr-2 mb-0">Sort By</label>
                                <input type="text" wire:model="filterby" class="form-control form-control-sm"
                                    placeholder="Filter">
                                <div class="row"></div>
                                <label for="paginate" class="text-nowrap mr-2 mb-0">Search By Date</label>

                                <input type="date" id="date" name="Select_Date" wire:model="Select_Date"
                                    class="form-control form-control-sm" />

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>SL.No</th>
                        <th>Check</th>
                        <th>Particular</th>
                        <th>Amount &#x20B9;</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Sources as $data)
                        <tr>
                            <td>{{ $n++ }}</td>
                            <td style="width:30%">{{ $data->Service_Name }}</td>
                            <td style="width:14%">{{ $data->Total_Amount }}</td>
                            <td style="width:50%">{{ $data->Total_Applications }}</td>
                            <td style="width:15%">
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <div class="btn-group btn-group-sm " role="group">
                                        <button id="btnGroupDrop2" type="button"
                                            class="btn btn-info dropdown-toggle" data-mdb-toggle="dropdown"
                                            aria-expanded="false">
                                            Edit
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                                            <li>
                                                <a class="dropdown-item "
                                                    href='/digital/cyber/view_credit_entry/{{ $data->Id }}'>Edit</a>
                                            </li>
                                            <li>
                                                <a class=" dropdown-item"
                                                    onclick="confirm('Are you sure you want to Delete this Recored Permanently!!') || event.stopImmediatePropagation()"
                                                    wire:click="Delete('{{ $data->Id }}')">Delete</a>
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
            </span>
        </div>

    </div>
</div>
