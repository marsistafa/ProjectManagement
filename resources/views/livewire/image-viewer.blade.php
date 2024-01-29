<style>
    .full-screen-modal {
        width: 100vw;
        height: 80vh;
        object-fit: cover; 
    }
</style>

<div>
<a href="{{ asset($image) }}" target="_blank">
    <img src="{{ asset($image) }}" class="full-screen-modal" alt="Image Viewer">
</a>
</div>
