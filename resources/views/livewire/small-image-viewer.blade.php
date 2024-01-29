<style>
    .full-screen-modal {
        width: 10vw;
        height: 10vh;
        object-fit: cover;  // This ensures the image covers the full area
    }
</style>

<div>
    <img src="{{ asset($image) }}" class="full-screen-modal" alt="Image Viewer">
</div>
