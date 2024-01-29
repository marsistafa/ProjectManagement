{{-- Be like water. --}}
<style>
    .file-list div {
        background-color: #f2f2f2; /* Light gray background */
        border: 1px solid #ddd; /* Light gray border */
        padding: 10px;
        margin-bottom: 5px; /* Spacing between list items */
        border-radius: 5px; /* Rounded corners */
    }

    .file-list div a {
        color: #0275d8; /* Bootstrap primary color for links */
        text-decoration: none; /* No underline */
        display: block; /* Each link on a new line */
        margin-bottom: 5px; /* Spacing between links */
    }

    .file-list div a:last-child {
        margin-bottom: 0; /* No bottom margin for last link */
    }

    .file-list h4 {
        color: black; /* Black color for headings */
        margin-top: 0; /* No top margin for headings */
    }

    .file-list div a:hover {
        text-decoration: underline; /* Underline on hover for better UX */
    }
</style>

<div class="file-list">
    <h4>Datasheet</h4>
    <div>
        @foreach ($files as $file)
            @if($file->datasheet)
                <a href="{{ Storage::url($file->datasheet) }}" target="_blank">{{ basename($file->datasheet) }}</a>
            @endif
        @endforeach
    </div>
    
    <h4>Manual</h4>
    <div>
        @foreach ($files as $file)
            @if($file->manual)
                <a href="{{ Storage::url($file->manual) }}" target="_blank">{{ basename($file->manual) }}</a>
            @endif
        @endforeach
    </div>
    
    <h4>DOC</h4>
    <div>
        @foreach ($files as $file)
            @if($file->DOC)
                <a href="{{ Storage::url($file->DOC) }}" target="_blank">{{ basename($file->DOC) }}</a>
            @endif
        @endforeach
    </div>
    
    <h4>Other</h4>
    <div>
        @foreach ($files as $file)
            @if($file->other)
                <a href="{{ Storage::url($file->other) }}" target="_blank">{{ basename($file->other) }}</a>
            @endif
        @endforeach
    </div>
    
</div>
