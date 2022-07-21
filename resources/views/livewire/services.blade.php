<div>

    <div class="row"><!-- Applicaiton -->
        <div class="col-45">
            <label class="label" for="Service">Application </label> <span
                class="important">*</span>
        </div>
        <div class="col-55">
            <select class="form-control" id="Service" name="Service"  wire:model="MainSelected">
                <option value="">--Select Service--</option>
                @foreach ($main_service as $service)
                <option value="{{ $service->Id }} ">
                    {{ $service->Name }}</option>
                @endforeach
            </select>
            @error('MainSelected') <span class="error">{{ $message }}</span> @enderror

        </div>
    </div>
    @if (!empty($this->sub_service))

        <div class="row"><!--Applicaiton Type -->
            <div class="col-45">
                <label class="label" for="Application_Type">Application Type </label> <span
                    class="important">*</span>
            </div>
            <div class="col-55">
                <select class="form-control" id="Application_Type" name="Application_Type"  wire:model="SubSelected">
                    <option value="">--Sub Category--</option>
                    @foreach ($sub_service as $service)
                    <option value="{{ $service->Name }} ">
                        {{ $service->Name }}</option>
                    @endforeach
                </select>
                @error('Application_Type') <span class="error">{{ $message }}</span> @enderror

            </div>
        </div>
    @endif

</div>
