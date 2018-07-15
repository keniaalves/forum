
<div class="alert alert-default">
    {{ $reply->created_at->diffForHumans() }} |
    <a href="#">{{$reply->owner->name}}</a>
    {{ $reply->favorites->count() }}
    <form method="POST" action="/replies/{{ $reply->id }}/favorites">
    {{ csrf_field() }}
        <button type="submit" class="btn btn-success" {{ $reply->isFavorited() ? 'disabled' : '' }}>
        {{ $reply->favorites->count() }} {{ str_plural ('Favorite', $reply->favorites->count() )}} 
        
        </button>
    </form>
    <hr>
    {{ $reply->body}}
</div>