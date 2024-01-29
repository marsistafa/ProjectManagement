<div>
    @if($component->getState())
        <ul>
            @foreach($component->getState() as $attachment)
                <li>{{ $attachment->getClientOriginalName() ?? '' }}</li>
            @endforeach
        </ul>
    @endif
</div>
