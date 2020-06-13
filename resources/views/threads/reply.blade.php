<div class="card-header">
    <div class="level">
        <h5 class="flex"><a href='#'> {{ $reply->owner->name }} </a>
            said
            ({{ $reply->created_at->diffForHumans() }})
        </h5>
        <div>
            <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                @csrf
                <button type="submit" class="btn btn-info "{{ $reply->isFavorited()? 'disabled': '' }}>
                    {{ $reply->favorites_count }} {{ \Illuminate\Support\Str::plural('Favorite', $reply->favorites_count) }}
                </button>
            </form>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
