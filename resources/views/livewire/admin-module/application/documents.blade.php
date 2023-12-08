<div>
    <div class="form-container">
        <div class="form-header">
            <p class="heading">Add Required Documents </p>
        </div>
        @if (session('SuccessMsg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('SuccessMsg') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form wire:submit.prevent="SaveDocument()">
            @csrf
            <div class="form-data-container">
                {{-- Form Data 1 --}}
                <div class="form-data">
                    <div class="row"> {{-- Credit Source ID --}}
                        <div class="col-45">
                            <label class="label" for="Transaction_Id">Document ID</label>
                            <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <label class="label" for="Transaction_Id">{{ $Doc_Id }}</label>
                        </div>
                    </div>


                    <div class="row"> {{-- Select Type --}}
                        <div class="col-45">
                            <label for="Mainservice">Select Service</label> <span class="important">*</span>
                        </div>
                        <div class="col-55">
                            <div class="md-form">
                                <select name="Mainservice" id="Mainservice" wire:model="MainserviceId"
                                    class="form-control">
                                    <option value="" selected>Select Service </option>
                                    @foreach ($MainServices as $service)
                                        <option value="{{ $service->Id }}" selected>{{ $service->Name }}</option>
                                    @endforeach
                                </select>
                                <span class="error">
                                    @error('MainserviceId')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                    </div>
                    @if (!is_null($Subservices))
                        <div class="row"> {{-- Category Name --}}
                            <div class="col-45">
                                <label for="SubServie">Service Type</label> <span class="important">*</span>
                            </div>
                            <div class="col-55">
                                <div class="md-form">
                                    <select name="SubServie" id="SubServie" wire:model="SubService"
                                        class="form-control">
                                        <option value="" selected>Select Service </option>
                                        @foreach ($Subservices as $service)
                                            <option value="{{ $service->Id }}" selected>{{ $service->Name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error">
                                        @error('SubService')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row"> {{-- Thumbnail --}}
                        <div class="col-45">
                            <label for="Document_Name">Name</label> <span class="important">*</span>
                        </div>
                        <div class="col-45">
                            <div class="md-form">
                                <input type="text" wire:model="Document_Name" name="Document_Name"
                                    class="form-control" placeholder="Document Name">

                                <span class="error">
                                    @error('Document_Name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="col-0">
                            <div class="md-form">
                                <a href="#" wire:click.prevent="AddNewText({{ $i }})" name="add"
                                    class="btn btn-primary btn-rounded btn-sm">Add</a>
                            </div>
                        </div>

                    </div>
                    @foreach ($NewTextBox as $item => $value)
                        <div class="row"> {{-- Thumbnail --}}
                            <div class="col-45">
                                <label for="Document_Name">Document : {{ $n++ }} </label> <span
                                    class="important">*</span>
                            </div>
                            <div class="col-45">
                                <div class="md-form">
                                    <input type="text" wire:model="Document_Names.{{ $value }}"
                                        name="Document_Names" class="form-control" placeholder="Enter Document  Name">
                                    <span class="error">
                                        @error('Document_Names')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-0">
                                <div class="md-form">
                                    <a href="#" wire:click.prevent="Remove('{{ $value }}')" name="add"
                                        class="btn btn-danger btn-rounded btn-sm">Remove</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="form-data-buttons"> {{-- Buttons --}}
                        <div class="row">
                            <div class="col-100">
                                <button type="submit" value="submit" name="submit"
                                    class="btn btn-primary btn-rounded btn-sm">Save Document</button>
                                <a href="{{ url('/') }}" class="btn btn-rounded btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-data">

                    @if (count($Existing_Documents) > 0)
                        <div class="row"> {{-- Category List --}}
                            <div class="md-form">
                                <span class="info-text">{{ count($Existing_Documents) }} Existing Document List </span>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Sl.No</th>
                                            <th>Document Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($Existing_Documents as $key)
                                            <tr>
                                                <td style="width: 10%">{{ $n++ }}</td>
                                                <td style="width: 25%">{{ $key->Name }}</td>
                                                <td style="width: 10%"><a href="#"
                                                        onclick="confirm('Do You Want to Edit ?')|| event.stopImmediatePropagation"
                                                        wire:click.prevent="Edit('{{ $key->Id }}')"
                                                        class="btn btn-sm btn-rounded">Edit</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <span></span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
    </div>
    </form>
</div>
