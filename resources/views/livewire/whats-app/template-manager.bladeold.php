<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <!-- resources/views/livewire/template-manager.blade.php -->
<div>
    <form wire:submit.prevent="{{ $isEdit ? 'updateTemplate' : 'createTemplate' }}">
        @csrf
        <input type="text" wire:model="template_name" placeholder="Template Name">
        <textarea wire:model="template_body" placeholder="Template Body"></textarea>
        <input type="text" wire:model="media_url" placeholder="Media URL (Optional)">
        <select wire:model="status">
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
        </select>
        {{ $template_name }}
        {{ $template_body }}
        {{ $media_url }}
        <button type="submit" value="submit" name="submit">{{ $isEdit ? 'Update' : 'Create' }}</button>
    </form>

    <table>
        <tr>
            <th>Name</th>
            <th>Body</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        @foreach($templates as $template)
        <tr>
            <td>{{ $template->template_name }}</td>
            <td>{{ $template->template_body }}</td>
            <td>{{ $template->status }}</td>
            <td>
                <button wire:click="editTemplate({{ $template->id }})">Edit</button>
                <button wire:click="deleteTemplate({{ $template->id }})">Delete</button>
            </td>
        </tr>
        @endforeach
    </table>
</div>

</div>
