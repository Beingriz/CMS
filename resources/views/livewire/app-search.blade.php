<div>
    <!-- Mobile No -->
    <div class="row">
        <!-- Material input -->
        <div class="col-45">
            <label for="Mobile_No">Mobile_No</label> <span class="important">*</span>
        </div>
        <div class="col-55">
            <div class="md-form">
                <input type="number" id="Mobile_No" name="Mobile_No" class="form-control"
                    placeholder="Mobile No" wire:model.debounce.500ms="Mobile_No" onkeydown="mobile(this)">
                <span class="error">@error('mobile_no'){{$message}}@enderror</span>
                @if(!is_null($user_type))
                <span class="success">{{$user_type}}</span>
                @endif
            </div>
        </div>
    </div>
</div>
