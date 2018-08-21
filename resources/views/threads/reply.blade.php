
<div class="alert alert-default">
    {{ $reply->created_at->diffForHumans() }} |
    <a href="{{ route('profile', $reply->owner) }}">{{$reply->owner->name}}</a>
    <form method="POST" action="/replies/{{ $reply->id }}/favorites">
    {{ csrf_field() }}
        <button type="submit" class="btn btn-success" {{ $reply->isFavorited() ? 'disabled' : '' }}>
        {{ $reply->favorites_count }} {{ str_plural ('Favorite', $reply->favorites_count )}} 
        
        </button>
    </form>
    <hr>
    {{ $reply->body}}
</div>