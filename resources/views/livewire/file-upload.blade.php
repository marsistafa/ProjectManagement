<div>
    <form wire:submit.prevent="uploadFile">
        <input type="file" wire:model="datasheet">
        @error('datasheet') <span class="error">{{ $message }}</span> @enderror
        <button type="submit">Upload</button>
    </form>
</div>
