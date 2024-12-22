<div>
    <h1>Link Checker</h1>

    <div>
        <label for="url">URL to Check:</label>
        <input type="text" id="url" wire:model="url" class="form-control" />
    </div>

    <div>
        <label for="keyword">Keyword to Search:</label>
        <input type="text" id="keyword" wire:model="keyword" class="form-control" />
    </div>

    <div class="mt-3">
        <button wire:click="checkLink" class="btn btn-primary">Check Link</button>
    </div>

    <div class="mt-3">
        <h4>Status:</h4>
        <p>{{ $statusMessage }}</p>
    </div>

    <div class="mt-3">
        <label for="subscriber">Add Subscriber (Telegram ID):</label>
        <input type="text" id="subscriber" wire:model="newSubscriber" class="form-control" />
        <button wire:click="addSubscriber" class="btn btn-success mt-2">Add Subscriber</button>

        <h4 class="mt-3">Subscribers:</h4>
        <ul>
            @foreach($subscribers as $subscriber)
                <li>{{ $subscriber }}</li>
            @endforeach
        </ul>
    </div>
</div>
